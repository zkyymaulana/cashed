<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = Order::query();

        if ($request->search) {
            $ordersQuery->where('customer', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%");
        }

        if ($request->start_date && $request->end_date) {
            $ordersQuery->where('created_at', '>=', $request->start_date)
                ->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $orders = $ordersQuery->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('order.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        return view('order.show', ['order' => $order]);
    }

    public function create(Request $request)
    {
        if (!session('order')) {
            $order = new Order();
            $order->customer = '-';
            $order->user_id = auth()->user()->id;

            session(['order' => $order]);
        }

        $categories = Category::query()->where('active', 1)->get();
        $productsQuery = Product::query()->where('active', 1);

        if ($request->category_id) {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->search) {
            $productsQuery->where('name', 'like', "%{$request->search}%");
        }

        $products = $productsQuery->get();

        return view('order.create', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function createDetail(Product $product)
    {
        $order = session('order');
        $detail = null;

        if (isset($order->details[$product->id])) {
            $detail = $order->details[$product->id];
        }

        return view('order.create-detail', [
            'product' => $product,
            'detail' => $detail,
        ]);
    }

    public function storeDetail(Request $request, Product $product)
{
    $order = session('order');

    if ($request->submit == 'destroy') {
        unset($order->details[$product->id]);
        // Tambahkan notifikasi sukses untuk penghapusan
        return redirect()->route('orders.create')->with('success', 'Produk berhasil dihapus dari summary!');
    }

    $request->validate([
        'qty' => 'required|numeric|min:1',
        'price' => 'required|numeric',
    ]);

    // Cek apakah stok mencukupi
    if ($request->qty > $product->stock) {
        return redirect()->back()->withErrors(['qty' => 'Tidak dapat melakukan pembelian karena stok telah habis.']);
    }

    $detail = new OrderDetail();
    $detail->product_id = $product->id;
    $detail->qty = $request->qty;
    $detail->price = $request->price;
    $detail->discount = $product->discount; // simpan diskon

    // Jika produk sudah ada, perbarui detailnya
    if (isset($order->details[$product->id])) {
        $order->details[$product->id]->qty = $request->qty;
        $order->details[$product->id]->price = $request->price;
        $order->details[$product->id]->discount = $product->discount; // Perbarui diskon
        // Tambahkan notifikasi sukses untuk pembaruan
        return redirect()->route('orders.create')->with('success', 'Summary berhasil diperbarui!');
    }

    // Jika produk baru, tambahkan ke detail
    $order->details[$product->id] = $detail;

    // Tambahkan notifikasi sukses untuk penambahan
    return redirect()->route('orders.create')->with('success', 'Produk berhasil ditambahkan ke summary!');
}

public function checkout(Request $request)
{
    // Validasi input
    $request->validate([
        'customer' => 'required',
        'payment' => 'required|numeric|min:0',
    ]);

    $order = session('order');

    // Cek apakah ada produk dalam order
    if (empty($order->details) || count($order->details) === 0) {
        return back()->withInput()->withErrors(['payment' => 'Silakan pilih produk sebelum melakukan checkout!']);
    } 

    $total = 0;

    foreach ($order->details as $detail) {
        // Hitung total dengan diskon
        $total += $detail->qty * $detail->price * (1 - $detail->discount / 100);
    }

    // Cek apakah payment mencukupi
    if ($request->payment < $total) {
        return back()->withInput()->withErrors(['payment' => 'Payment tidak mencukupi']);
    }

    $order->customer = $request->customer;
    $order->payment = $request->payment;
    $order->total = $total; // Simpan total yang sudah dikurangi diskon
    $order->save();
    $order->details()->saveMany($order->details);

    // Kurangi stok produk
    foreach ($order->details as $detail) {
        $product = Product::find($detail->product_id);
        $product->stock -= $detail->qty; // Kurangi stok
        $product->save();
    }

    $request->session()->forget('order');

    // Tambahkan notifikasi sukses
    return redirect()->route('orders.show', ['order' => $order->id])->with('success', 'Pembelian berhasil dilakukan!');
}

    public function addToOrder(Request $request, $productId)
    {
        $product = Product::find($productId);
        
        // Pastikan produk ditemukan
        if (!$product) {
            return redirect()->back()->with('error', 'Product tidak ditemukan.');
        }

        // Ambil order dari session atau buat baru
        $order = session('order', ['details' => []]);

        // Tambahkan detail produk ke order
        $order['details'][] = [
            'product_id' => $product->id,
            'qty' => $request->input('qty', 1), // Ambil qty dari request
            'price' => $product->price,
            'discount' => $product->discount,
        ];

        // Simpan kembali ke session
        session(['order' => $order]);

        return redirect()->route('orders.create');
    }
    
    public function destroy(Order $order)
{
    $order->delete();
    return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
}
}