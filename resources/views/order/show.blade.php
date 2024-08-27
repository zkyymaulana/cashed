<x-layout title="Order #{{ $order->id }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
            @if (session('success'))  
                    <div class="alert alert-success" role="alert"> 
                        {{ session('success') }} 
                    </div>  
                @endif
                <div class="card mb-2">
                    <div class="card-body border-bottom">
                        <h5 class="mb-3">Terimaksih Sudah Melakukan Pembelian.</h5>
                        <div class="d-flex">
                            <div>Order ID:</div>
                            <div class="ms-auto">{{ $order->id }}</div>
                        </div>
                        <div class="d-flex">
                            <div>Admin:</div>
                            <div class="ms-auto">{{ auth()->user()->name }}</div>
                        </div>

                        <div class="d-flex">
                            <div>Customer:</div>
                            <div class="ms-auto">{{ $order->customer }}</div>
                        </div>

                        <div class="d-flex">
                            <div>Date:</div>
                            <div class="ms-auto">{{ $order->formatted_created_at }}</div>
                        </div>
                    </div>

                    <div class="card-body border-bottom">
                        <div class="d-grid gap-2">
                            @foreach ($order->details as $detail)
                                <div class="card">
                                    <div class="card-body">
                                        <div>{{ $detail->product->name }}</div>

                                        <div class="d-flex">
                                            <div class="form-text">
                                                {{ number_format($detail->qty) }} x {{ number_format($detail->price) }} (Diskon: {{ $detail->discount }}%)
                                            </div>
                                            <div class="ms-auto form-text">
                                                Rp{{ number_format($detail->qty * $detail->price * (1 - $detail->discount / 100)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <div>Total</div>
                            <div class="ms-auto mb-0 fw-bold">Rp{{ number_format($order->total) }}</div>
                        </div>

                        <div class="d-flex">
                            <div>Payment</div>
                            <div class="ms-auto mb-0">Rp{{ number_format($order->payment) }}</div>
                        </div>

                        <div class="d-flex">
                            <div>Kembalian</div>
                            <div class="ms-auto mb-0">Rp{{ number_format($order->payment - $order->total) }}</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('orders.index') }}" class="btn btn-dark no-print">Kembali</a>
                <button onclick="printPDF()" class="btn btn-primary no-print">Cetak PDF</button>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible; 
            }
            .no-print {
                display: none;
            }
            .container {
                position: absolute;
                left: 50%;
                top: 0;
                transform: translateX(-50%);
                width: 100%;
                padding: 0;
                margin: 0;
            }
            .col-8 {
                width: 100%;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            .card-body {
                padding: 1rem;
            }
            .d-flex {
                display: flex;
                justify-content: space-between;
            }
            .form-text {
                font-size: 1rem;
            }
        }
    </style>

    <script>
        function printPDF() {
            window.print();
        }
    </script>
</x-layout>