<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class CustomerAuthPortalController extends Controller
{
    /**
     * Tampilkan form registrasi pelanggan.
     */
    public function showRegisterForm()
    {
        return view('public.auth.register');
    }

    /**
     * Proses registrasi pelanggan.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('public.dashboard');
    }

    /**
     * Tampilkan form login pelanggan.
     */
    public function showLoginForm()
    {
        return view('public.auth.login');
    }

    /**
     * Proses login pelanggan.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $customer = Auth::guard('customer')->user();
            $sessionCart = session()->get('cart', []);
            $cookieCart = json_decode($request->cookie('sibengkel_cart'), true) ?: [];
            $dbCart = json_decode($customer->cart_data, true) ?: [];

            // Gabungkan cart dari session, cookie, dan DB
            $mergedCart = array_replace($dbCart, $cookieCart, $sessionCart);
            session()->put('cart', $mergedCart);
            cookie()->queue('sibengkel_cart', json_encode($mergedCart), 60 * 24 * 30);
            $customer->cart_data = json_encode($mergedCart);
            $customer->save();

            return redirect()->intended(route('public.dashboard'));
        }

        throw ValidationException::withMessages([
            'login' => trans('auth.failed'),
        ]);
    }

    /**
     * Proses logout pelanggan.
     */
    public function logout(Request $request)
    {
        $cart = session()->get('cart', []);
        $cookieCart = json_decode($request->cookie('sibengkel_cart'), true) ?: [];
        $activeCart = !empty($cart) ? $cart : $cookieCart;

        if ($customer = Auth::guard('customer')->user()) {
            if (!empty($activeCart)) {
                $customer->cart_data = json_encode($activeCart);
                $customer->save();
            }
        }

        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tetap simpan keranjang di session/cookie setelah logout
        if (!empty($activeCart)) {
            session()->put('cart', $activeCart);
            cookie()->queue('sibengkel_cart', json_encode($activeCart), 60 * 24 * 30);
        }

        return redirect('/');
    }

    /**
     * Tampilkan form profil pelanggan.
     */
    public function editProfile()
    {
        $customer = Auth::guard('customer')->user();
        return view('public.auth.profile', compact('customer'));
    }

    /**
     * Update data profil pelanggan.
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone,' . $customer->id],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
            'address' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($customer->profile_photo && Storage::disk('public')->exists('avatars/' . $customer->profile_photo)) {
                Storage::disk('public')->delete('avatars/' . $customer->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_c_' . $customer->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');
            $data['profile_photo'] = $filename;
        }

        $customer->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Tampilkan form lupa password pelanggan (Input No HP).
     */
    public function showForgotPasswordForm()
    {
        return view('public.auth.forgot_password');
    }

    /**
     * Kirim Kode OTP Verifikasi Lupa Password.
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:customers,email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Alamat email ini tidak terdaftar dalam sistem SIBENGKEL.',
        ]);

        $otp = (string) rand(100000, 999999);
        session([
            'reset_email' => $request->email,
            'reset_otp' => $otp,
            'reset_otp_expires' => now()->addMinutes(10),
        ]);

        // Kirim email OTP
        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('public.forgot_password.verify')
            ->with('success', "Kode OTP telah berhasil dikirim ke alamat email Anda.");
    }

    /**
     * Tampilkan form verifikasi OTP & Set Password Baru.
     */
    public function showVerifyOtpForm()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('public.forgot_password');
        }
        return view('public.auth.verify_otp', compact('email'));
    }

    /**
     * Verifikasi OTP dan perbarui password pelanggan.
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit angka.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $sessionEmail = session('reset_email');
        $sessionOtp = session('reset_otp');
        $expiresAt = session('reset_otp_expires');

        if (!$sessionEmail || !$sessionOtp || (now()->greaterThan($expiresAt))) {
            return redirect()->route('public.forgot_password')->withErrors(['email' => 'Sesi verifikasi telah kadaluarsa. Silakan ajukan ulang kode OTP.']);
        }

        if ($request->otp !== $sessionOtp) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali.']);
        }

        $customer = Customer::where('email', $sessionEmail)->first();
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Clear session reset
        session()->forget(['reset_phone', 'reset_otp', 'reset_otp_expires']);

        return redirect()->route('public.login')->with('success', 'Verifikasi berhasil! Password akun Anda telah diperbarui. Silakan masuk dengan password baru.');
    }
}
