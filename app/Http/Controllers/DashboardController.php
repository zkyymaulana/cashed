<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order; // Jika Anda menggunakan model Order untuk menghitung transaksi
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data yang diperlukan
        $totalSales = Order::sum('total'); // Total semua penjualan
        $transactionCount = Order::count(); // Hitung jumlah transaksi
        $averageTransactionValue = $transactionCount > 0 ? Order::sum('total') / $transactionCount : 0; // Nilai transaksi rata-rata
        $recentTransactions = Order::latest()->take(5)->get(); // Ambil transaksi terbaru
        $lowStockItemsCount = Product::where('stock', '<', 5)->count(); // Item yang stoknya hampir habis
        $totalInventoryItems = Product::count(); // Total item di inventaris
        $totalRevenue = Order::sum('total'); // Total pendapatan

        // Hitung total item terjual
        $totalItemsSold = Order::with('details')->get()->sum(function ($order) {
            return $order->details->sum('qty'); // Jumlahkan qty dari setiap detail transaksi
        });

        // Hitung jumlah kategori dan produk
        $availableCount = Product::where('stock', '>', 5)->count(); // Produk tersedia
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count(); // Produk hampir habis
        $outOfStockCount = Product::where('stock', 0)->count(); // Produk habis
        $categoryCount = Category::count(); // Hitung jumlah kategori
        $productCount = Product::count(); // Hitung jumlah produk

        // Ambil produk dengan diskon terbesar
        $topDiscountedProduct = Product::orderBy('discount', 'desc')->first(); // Ambil produk dengan diskon terbesar

        return view('dashboard', compact(
            'totalSales', // Total semua penjualan
            'transactionCount',
            'averageTransactionValue',
            'recentTransactions',
            'lowStockItemsCount',
            'totalInventoryItems',
            'totalRevenue',
            'availableCount',
            'lowStockCount',
            'outOfStockCount',
            'categoryCount',
            'productCount',
            'topDiscountedProduct', // Kirim produk dengan diskon terbesar
            'totalItemsSold' // Kirim total item terjual
        ));
    }
}