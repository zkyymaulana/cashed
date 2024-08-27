<x-layout>
    <x-slot:title>Dashboard Kasir</x-slot:title>

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body d-flex align-items-center gap-2 mx-auto">
                        <img src="{{ Storage::url('assets/87936963_9815552.jpg') }}" alt="logo-penjualan" class="bg-cover "
                            width="60px" height="60px" />
                        <div class="ms-3">
                            <h6 class="card-title">Total Pendapatan</h6>
                            <h5 class="card-text">Rp{{ number_format($totalSales ?? 0) }}</h5>
                            <!-- Mengubah total penjualan hari ini menjadi total semua penjualan -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body d-flex align-items-center gap-2 mx-auto">
                        <img src="{{ Storage::url('assets/11518988_4758003.jpg') }}" alt="logo-penjualan"
                            class="bg-cover " width="60px" height="60px" />
                        <div class="ms-3">
                            <h6 class="card-title">Jumlah Semua Transaksi</h6>
                            <h5 class="card-text">{{ $transactionCount ?? 0 }} Transaksi</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body d-flex align-items-center gap-2 mx-auto ">
                        <img src="{{ Storage::url('assets/7245734_3556180.jpg') }}" alt="logo-penjualan"
                            class="bg-cover d-flex align-items-center" width="60px" height="60px" />
                        <div class="ms-3">
                            <h6 class="card-title">Nilai Transaksi Rata-rata</h6>
                            <h5 class="card-text">Rp{{ number_format($averageTransactionValue ?? 0) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-2">Transaksi Terbaru</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 15%;">No</th> <!-- Kolom untuk nomor transaksi -->
                            <th style="width: 25%;">Tanggal dan Waktu</th>
                            <!-- Kolom untuk tanggal dan waktu -->
                            <th style="width: 20%;">Customer</th>
                            <!-- Mengganti User dengan Customer -->
                            <th style="width: 25%;">Item Terjual</th> <!-- Kolom Item Terjual -->
                            <th style="width: 15%;">Total Jumlah</th> <!-- Kolom Total Jumlah -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentTransactions as $transaction)
                            <tr>
                                <td>Order #{{ $transaction->id }}</td>
                                <!-- Menampilkan nomor transaksi dari ID order -->
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <!-- Menggabungkan tanggal dan waktu -->
                                <td>{{ $transaction->customer }}</td>
                                <!-- Menampilkan nama customer -->
                                <td>
                                    @foreach ($transaction->details as $detail)
                                        {{ $detail->qty }} {{ $detail->product->name }}<br>
                                        <!-- Menampilkan item terjual -->
                                    @endforeach
                                </td>
                                <td>Rp{{ number_format($transaction->total) }}</td>
                                <!-- Menampilkan total jumlah -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <h4>Manajemen Penjualan</h4>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row card-body d-flex">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <img src="{{ Storage::url('assets/stock.png') }}" alt="Pemberitahuan Stok"
                                            width="132em">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <a href="{{ route('products.index') }}" class="text-decoration-none">
                                    <!-- Tautan ke rute produk -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Pemberitahuan Stock</h5>
                                            <p class="card-text mt-3">{{ $availableCount }} item tersedia.</p>
                                            <p class="card-text mt-3">{{ $lowStockCount }} item hampir habis.</p>
                                            <p class="card-text mt-3">{{ $outOfStockCount }} item habis.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-4">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Item Terjual</h5> <!-- Ubah judul -->
                                    <p class="card-text">{{ $totalItemsSold ?? 0 }} item terjual.</p> <!-- Tampilkan total item terjual -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mt-4">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            <!-- Tautan ke rute produk -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Produk</h5>
                                    <p class="card-text">{{ $productCount ?? 0}} produk tersedia.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h4>Produk dengan Diskon Terbesar</h4>
                <div class="row mb-4">
                    @if ($topDiscountedProduct)
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <img src="{{ Storage::url($topDiscountedProduct->image) }}" class="card-img-top"
                                    alt="{{ $topDiscountedProduct->name }}" style="object-fit: cover; height:12.6em;">
                                <div class="card-body d-flex">
                                    <div>
                                        <h5 class="card-title">{{ $topDiscountedProduct->name }}</h5>
                                        <p class="card-text">Diskon: {{ $topDiscountedProduct->discount }}%</p>
                                    </div>
                                    <div class="ms-auto mt-auto">
                                        <a href="{{ route('orders.create.detail', $topDiscountedProduct->id) }}"
                                            class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 mt-2">
                            <div class="card d-flex justify-content-center align-items-center" style="height: 18.25em;">
                                <!-- Tambahkan kelas Flexbox -->
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <!-- Flexbox untuk card-body -->
                                    <h5 class="text-center">Tidak ada produk dengan diskon.</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layout>