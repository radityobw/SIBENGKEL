<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\PublicPageController;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;

// Public Pages (Static -> Dynamic)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/p/{slug}', [PublicPageController::class, 'show'])->name('public.page');

// Contact Us
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/', function () {
    $testimonials = \App\Models\Testimonial::where('is_active', true)->latest()->take(10)->get();
    $spareparts = \App\Models\SparePart::where('stock', '>', 0)->latest()->take(8)->get();
    
    // Dynamic Stats
    $stats = [
        'servis_selesai' => \App\Models\ServiceTransaction::where('status', 'selesai')->count(),
        'pelanggan' => \App\Models\Customer::count(),
        'mekanik' => \App\Models\Mechanic::count(),
    ];
    
    // Calculate satisfaction (percentage of 4 and 5 star ratings)
    $totalReviews = \App\Models\Testimonial::count();
    if ($totalReviews > 0) {
        $goodReviews = \App\Models\Testimonial::whereIn('rating', [4, 5])->count();
        $stats['kepuasan'] = round(($goodReviews / $totalReviews) * 100);
    } else {
        $stats['kepuasan'] = 100; // Default if no reviews
    }
    
    // Real-time Hero UI Data
    $recentCompleted = \App\Models\ServiceTransaction::with('vehicle')->where('status', 'selesai')->latest()->first();
    $recentActive = \App\Models\ServiceTransaction::with('vehicle')->whereIn('status', ['pending', 'sedang dikerjakan'])->latest()->first();

    return view('landing', compact('testimonials', 'stats', 'spareparts', 'recentCompleted', 'recentActive'));
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicStatusController;

// Halaman Cek Status Servis (Publik)
Route::get('/cek-status', [PublicStatusController::class, 'index'])->name('public.status.index');
Route::get('/cek-status/cari', [PublicStatusController::class, 'search'])->name('public.status.search');
Route::get('/cek-status/hasil/{id}', [PublicStatusController::class, 'result'])->name('public.status.result');

use App\Http\Controllers\CustomerAuthPortalController;
use App\Http\Controllers\BookingPortalController;

// Portal Pelanggan (Guest)
Route::middleware('guest:customer')->group(function () {
    Route::get('/masuk', [CustomerAuthPortalController::class, 'showLoginForm'])->name('public.login');
    Route::post('/masuk', [CustomerAuthPortalController::class, 'login'])->name('public.login.submit');
    Route::get('/daftar', [CustomerAuthPortalController::class, 'showRegisterForm'])->name('public.register');
    Route::post('/daftar', [CustomerAuthPortalController::class, 'register'])->name('public.register.submit');
    Route::get('/lupa-password', [CustomerAuthPortalController::class, 'showForgotPasswordForm'])->name('public.forgot_password');
    Route::post('/lupa-password/send-otp', [CustomerAuthPortalController::class, 'sendResetOtp'])
        ->middleware('throttle:5,1')
        ->name('public.forgot_password.send_otp');
    Route::get('/lupa-password/verifikasi', [CustomerAuthPortalController::class, 'showVerifyOtpForm'])->name('public.forgot_password.verify');
    Route::post('/lupa-password/reset', [CustomerAuthPortalController::class, 'resetPasswordWithOtp'])
        ->middleware('throttle:5,1')
        ->name('public.forgot_password.reset');
});

// Portal Pelanggan (Authenticated)
Route::middleware('auth:customer')->group(function () {
    Route::post('/keluar', [CustomerAuthPortalController::class, 'logout'])->name('public.logout');

    // Notifications
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('public.notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('public.notifications.readAll');

    Route::get('/portal', [BookingPortalController::class, 'dashboard'])->name('public.dashboard');
    Route::get('/profil', [CustomerAuthPortalController::class, 'editProfile'])->name('public.profile');
    Route::put('/profil', [CustomerAuthPortalController::class, 'updateProfile'])->name('public.profile.update');
    Route::get('/booking', [BookingPortalController::class, 'showBookingForm'])->name('public.booking.form');
    Route::post('/booking', [BookingPortalController::class, 'submitBooking'])->name('public.booking.submit');

    // Katalog & Order Sparepart
    Route::get('/cart', [\App\Http\Controllers\SparePartPortalController::class, 'cart'])->name('public.cart');
    Route::post('/cart/add', [\App\Http\Controllers\SparePartPortalController::class, 'addToCart'])->name('public.cart.add');
    Route::delete('/cart/{id}', [\App\Http\Controllers\SparePartPortalController::class, 'removeFromCart'])->name('public.cart.remove');
    
    Route::get('/checkout', [\App\Http\Controllers\SparePartPortalController::class, 'checkoutForm'])->name('public.checkout');
    Route::post('/checkout', [\App\Http\Controllers\SparePartPortalController::class, 'checkoutProcess'])->name('public.checkout.process');
    
    Route::get('/pesanan', [\App\Http\Controllers\SparePartPortalController::class, 'orders'])->name('public.orders.index');
    Route::get('/pesanan/{order}', [\App\Http\Controllers\SparePartPortalController::class, 'showOrder'])->name('public.orders.show');
});

// Katalog Sparepart Publik
Route::get('/sparepart', [\App\Http\Controllers\SparePartPortalController::class, 'index'])->name('public.sparepart.index');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\AdminBookingController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('mechanics', MechanicController::class);
    
    // Customers (Edit, Update, Destroy)
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Transactions (Edit, Update, Destroy)
    Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');


    // Admin Spareparts (Create, Store, Edit, Update, Destroy - Admin Only)
    Route::get('spareparts/create', [\App\Http\Controllers\AdminSparePartController::class, 'create'])->name('admin.spareparts.create');
    Route::post('spareparts', [\App\Http\Controllers\AdminSparePartController::class, 'store'])->name('admin.spareparts.store');
    Route::get('spareparts/{sparepart}/edit', [\App\Http\Controllers\AdminSparePartController::class, 'edit'])->name('admin.spareparts.edit');
    Route::put('spareparts/{sparepart}', [\App\Http\Controllers\AdminSparePartController::class, 'update'])->name('admin.spareparts.update');
    Route::delete('spareparts/{sparepart}', [\App\Http\Controllers\AdminSparePartController::class, 'destroy'])->name('admin.spareparts.destroy');

    // Admin Orders
    Route::get('orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::patch('orders/{order}/status', [\App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Pages Management
    Route::resource('pages', \App\Http\Controllers\AdminPageController::class)->except(['create', 'store', 'show', 'destroy']);
    
    // Testimonials Management
    Route::resource('testimonials', \App\Http\Controllers\TestimonialController::class, ['as' => 'admin'])->except('show');

    // Notifications
    Route::post('admin/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::post('admin/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.readAll');

    // System Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    // Contact Messages
    Route::get('messages', [ContactController::class, 'adminIndex'])->name('admin.messages.index');
    Route::post('messages/{message}/read', [ContactController::class, 'adminMarkAsRead'])->name('admin.messages.read');
    Route::delete('messages/{message}', [ContactController::class, 'adminDestroy'])->name('admin.messages.destroy');
});

Route::middleware(['auth', 'role:admin,mekanik'])->group(function () {
    // Bookings (View List for Admin & Mekanik)
    Route::get('admin-bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::patch('admin-bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');

    // Spareparts (View Stock & Catalog for Admin & Mekanik)
    Route::get('spareparts', [\App\Http\Controllers\AdminSparePartController::class, 'index'])->name('admin.spareparts.index');

    // Customers (Index, Create, Store)
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');

    // Vehicles (Full CRUD)
    Route::resource('vehicles', VehicleController::class);

    // Transactions (Index, Create, Store, Update Status, Invoice)
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::patch('transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    Route::get('transactions/{transaction}/invoice', [TransactionController::class, 'printInvoice'])->name('transactions.invoice');
});

require __DIR__.'/auth.php';
