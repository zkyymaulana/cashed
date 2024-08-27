<x-layout title="Orders">
    <div class="container">
    @if (session('success'))  
            <div class="alert alert-success" role="alert"> 
                {{ session('success') }}
            </div>  
        @endif 
        <div class="row">
            <div class="col">
                <div class="d-grid gap-4">
                    <form class="hstack gap-2" method="get">
                        <select name="category_id" id="category_id" class="form-control w-auto"
                            onchange="this.form.submit()">
                            <option value="">Semua kategori</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-group">
                            <input type="text" placeholder="Cari product" class="form-control" name="search"
                                value="{{ request()->search }}" autofocus>
                        </div>

                        <button type="submit" class="btn btn-dark">Cari</button>
                    </form>

                    <div class="row g-4">
                        @forelse ($products as $product)
                            <div class="col-3">
                                <a href="{{ route('orders.create.detail', ['product' => $product->id]) }}"
                                    class="text-decoration-none">
                                    <div class="card product-card">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                            class="card-img-top border-bottom">
                                        <div class="card-body">
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <div class="hstack mt-1">
                                                <small>{{ $product->category->name }}</small>
                                                <small class="ms-auto">
                                                    Rp{{ number_format($product->price) }}
                                                </small>
                                            </div>
                                            <div class="form-text">Stok: {{ $product->stock }}</div>
                                            <div class="form-text">Diskon: {{ $product->discount }}%</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col text-center">Belum ada products</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <form class="card" method="post" action="{{ route('orders.checkout') }}">
                    @csrf

                    <div class="card-body border-bottom fw-bold">Summary</div>

                    <div class="card-body border-bottom">
                        <x-text-input name="customer" label="Customer"
                            value="{{ session('order')->customer }}"></x-text-input>
                    </div>

                    @php
                        $total = 0; // Inisialisasi total
                        $total_discount = 0; // Inisialisasi total diskon
                    @endphp

                    <div class="card-body bg-body-tertiary border-bottom">
                        <div class="vstack gap-2">
                            @forelse (session('order')->details as $detail)
                                @php
                                    $total += $detail->qty * $detail->price; // Hitung total harga asli
                                    $total_discount += $detail->qty * $detail->price * ($detail->discount / 100); // Hitung total diskon
                                @endphp

                                <a href="{{ route('orders.create.detail', ['product' => $detail->product_id]) }}"
                                    class="text-decoration-none">
                                    <div class="card product-card">
                                        <div class="card-body">
                                            <div>{{ $detail->product->name }}</div>
                                            <div class="d-flex justify-content-between">
                                                <div class="form-text">{{ $detail->qty }} x
                                                    {{ number_format($detail->price) }} (Diskon:
                                                    {{ $detail->discount }}%)</div>
                                                <div class="ms-auto form-text">
                                                    Rp{{ number_format($detail->qty * $detail->price * (1 - $detail->discount / 100)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center">Belum ada product</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card-body border-bottom d-grid gap-2">
                        <div class="d-flex justify-content-between">
                            <div>Total</div>
                            <p class="ms-auto mb-0">Rp{{ number_format($total) }}</p>
                            <!-- Total harga asli -->
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <div>Total Diskon</div>
                                <p class="ms-auto mb-0">Rp{{ number_format($total_discount) }}</p>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total Bayar</h5>
                                <h5 class="ms-auto mb-0 font-black">Rp{{ number_format($total - $total_discount) }}</h5>
                                <!-- Total setelah diskon -->
                            </div>
                            <x-text-input name="payment" label="Payment" type="number"></x-text-input>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-row-reverse justify-content-between">
                        <button class="ms-auto btn btn-dark">Checkout</button>
                        <button name="cancel" class="btn btn-light">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>