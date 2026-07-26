<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SparePartPortalController extends Controller
{
    /**
     * Tampilkan katalog sparepart
     */
    public function index(Request $request)
    {
        $query = SparePart::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $spareparts = $query->paginate(12);
        
        // Ambil kategori unik untuk filter
        $categories = SparePart::select('category')->distinct()->pluck('category');

        return view('public.sparepart.index', compact('spareparts', 'categories'));
    }

    private function getCart()
    {
        $cart = session()->get('cart');

        if ($cart === null) {
            $cookieCart = request()->cookie('sibengkel_cart');
            if ($cookieCart) {
                $cart = json_decode($cookieCart, true);
            }

            if (empty($cart) && $customer = Auth::guard('customer')->user()) {
                if ($customer->cart_data) {
                    $cart = json_decode($customer->cart_data, true);
                }
            }

            $cart = $cart ?: [];
            session()->put('cart', $cart);
        }

        return $cart;
    }

    private function saveCart(array $cart)
    {
        session()->put('cart', $cart);
        cookie()->queue('sibengkel_cart', json_encode($cart), 60 * 24 * 30);

        if ($customer = Auth::guard('customer')->user()) {
            $customer->cart_data = json_encode($cart);
            $customer->save();
        }
    }

    /**
     * Tampilkan keranjang belanja
     */
    public function cart(Request $request)
    {
        $cart = $this->getCart();
        
        // Ambil detail sparepart dari DB berdasarkan isi keranjang
        $cartItems = [];
        $total = 0;
        
        if (!empty($cart)) {
            $spareParts = SparePart::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $id => $qty) {
                if (isset($spareParts[$id])) {
                    $item = $spareParts[$id];
                    $subtotal = $item->price * $qty;
                    $total += $subtotal;
                    
                    $cartItems[] = [
                        'sparepart' => $item,
                        'qty' => $qty,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }

        return view('public.sparepart.cart', compact('cartItems', 'total'));
    }

    /**
     * Tambah item ke keranjang (AJAX atau Form POST)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'qty' => 'required|integer|min:1'
        ]);

        $id = $request->spare_part_id;
        $qty = $request->qty;

        $sparepart = SparePart::findOrFail($id);

        if ($sparepart->stock < $qty) {
            return back()->withErrors(['stok' => 'Stok tidak mencukupi']);
        }

        $cart = $this->getCart();

        if (isset($cart[$id])) {
            $cart[$id] += $qty;
        } else {
            $cart[$id] = $qty;
        }

        // Cek stok kembali
        if ($sparepart->stock < $cart[$id]) {
            return back()->withErrors(['stok' => 'Stok tidak mencukupi untuk jumlah tersebut']);
        }

        $this->saveCart($cart);

        return redirect()->back()->with('success', 'Berhasil menambahkan "' . $sparepart->name . '" ke keranjang.');
    }

    /**
     * Hapus item dari keranjang
     */
    public function removeFromCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveCart($cart);
        }

        return redirect()->route('public.cart')->with('success', 'Barang dihapus dari keranjang.');
    }

    /**
     * Tampilkan halaman checkout
     */
    public function checkoutForm()
    {
        $cart = $this->getCart();
        
        if (empty($cart)) {
            return redirect()->route('public.sparepart.index')->withErrors(['cart' => 'Keranjang belanja Anda kosong.']);
        }

        $cartItems = [];
        $total = 0;
        
        $spareParts = SparePart::whereIn('id', array_keys($cart))->get()->keyBy('id');
        foreach ($cart as $id => $qty) {
            if (isset($spareParts[$id])) {
                $item = $spareParts[$id];
                $subtotal = $item->price * $qty;
                $total += $subtotal;
                
                $cartItems[] = [
                    'sparepart' => $item,
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('public.sparepart.checkout', compact('cartItems', 'total'));
    }

    /**
     * Proses checkout
     */
    public function checkoutProcess(Request $request)
    {
        $cart = $this->getCart();
        
        if (empty($cart)) {
            return redirect()->route('public.sparepart.index');
        }

        $customer = Auth::guard('customer')->user();
        
        // Validasi stok sekali lagi
        $spareParts = SparePart::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total = 0;
        $orderItemsData = [];

        foreach ($cart as $id => $qty) {
            if (!isset($spareParts[$id]) || $spareParts[$id]->stock < $qty) {
                return redirect()->route('public.cart')->withErrors(['stok' => 'Maaf, salah satu produk kehabisan stok.']);
            }
            
            $item = $spareParts[$id];
            $total += $item->price * $qty;
            
            $orderItemsData[] = [
                'spare_part_id' => $item->id,
                'qty' => $qty,
                'price_at_purchase' => $item->price
            ];
        }

        // Buat Order
        $order = Order::create([
            'customer_id' => $customer->id,
            'status' => 'menunggu_pembayaran',
            'total' => $total
        ]);

        foreach ($orderItemsData as $data) {
            $order->orderItems()->create($data);
            
            // Kurangi stok
            $part = SparePart::find($data['spare_part_id']);
            $part->decrement('stock', $data['qty']);
        }

        // Kosongkan keranjang
        session()->forget('cart');
        cookie()->queue(cookie()->forget('sibengkel_cart'));
        if ($customer) {
            $customer->cart_data = null;
            $customer->save();
        }

        return redirect()->route('public.orders.show', $order->id)->with('success', 'Pesanan #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' berhasil dibuat! Silakan ambil barang di lokasi bengkel.')->with('confetti', true);
    }

    /**
     * Tampilkan riwayat pesanan pelanggan
     */
    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->orderBy('created_at', 'desc')->get();
        return view('public.sparepart.orders', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan pelanggan
     */
    public function showOrder(Order $order)
    {
        if ($order->customer_id != Auth::guard('customer')->id()) {
            abort(403);
        }
        
        $order->load('orderItems.sparePart');
        return view('public.sparepart.order_detail', compact('order'));
    }
}
