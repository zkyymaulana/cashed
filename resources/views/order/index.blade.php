<x-layout>
    <x-slot:title>Orders</x-slot:title>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex mb-2 justify-content-between">
            <form class="d-flex align-items-center gap-2" method="get">
                <input type="date" class="form-control w-auto" placeholder="Pilih periode awal" name="start_date"
                    value="{{ request()->start_date ?? date('Y-m-01') }}">
                -
                <input type="date" class="form-control w-auto" placeholder="Pilih periode akhir" name="end_date"
                    value="{{ request()->end_date ?? date('Y-m-d') }}">
                <input type="text" class="form-control w-auto" placeholder="Cari order" name="search"
                    value="{{ request()->search }}">
                <button type="submit" class="btn btn-dark">Cari</button>
            </form>

            <a href="{{ route('orders.create') }}" class="btn btn-dark">Buat Order Baru</a>
        </div>

        <div class="card mb-2 overflow-hidden">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Item Terjual</th> <!-- Tambahkan kolom Item Terjual -->
                        <th>Payment</th>
                        <th>Total</th>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>Order #{{ $order->id }}</td>
                            <td>{{ $order->customer }}</td>
                            <td>
                                @php
                                    $totalItemsSold = $order->details->sum('qty'); // Hitung total item terjual untuk order ini
                                @endphp
                                {{ $totalItemsSold }} <!-- Tampilkan total item terjual -->
                            </td>
                            <td>{{ number_format($order->payment) }}</td>
                            <td>{{ number_format($order->total) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->formatted_created_at }}</td> <!-- Tanggal dalam format WIB -->
                            <td class="text-end">
                                <a href="{{ route('orders.show', ['order' => $order->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    Lihat
                                </a>
                                <form action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada order</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- navigasi pagination -->
        <div class="d-flex justify-content-between mt-3">
            {{ $orders->links('vendor.pagination.bootstrap-5') }} <!-- Menggunakan tampilan kustom -->
        </div>
    </div>
    
</x-layout>