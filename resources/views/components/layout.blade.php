<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cashed</title>

    <link rel="icon" type="image/svg" href="{{ Storage::url('assets/icon.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            height: 100%;
            /* Pastikan body mengisi tinggi penuh */
            display: flex;
            flex-direction: column;
            /* Mengatur arah flex menjadi kolom */
        }

        .content {
            flex: 1;
            /* Membuat konten mengisi ruang yang tersedia */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-black navbar-dark sticky-top"> <!-- Tambahkan kelas sticky-top -->
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Cashed</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}"
                        href="{{ route('orders.index') }}">
                        Orders
                    </a>
                    <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">
                        Categories
                    </a>
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                        Products
                    </a>
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        Users
                    </a>
                </div>
            </div>

            <div class="text-white me-4" id="user-name" style="cursor: pointer;">
                {{ auth()->user()->name }}
                <img src="{{ Storage::url('assets/Group.svg') }}" alt="" width="40em" class="ms-3">
            </div>
            <div id="logout-form"
                style="display: none; opacity: 0; transform: translateX(20px); transition: opacity 0.5s, transform 0.5s;">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
    </nav>

    @isset($title)
        <div class="border-bottom mb-3">
            <h4 class="container py-4 fw-bold">{{ $title }}</h4>
        </div>
    @endisset

    <div class="content"> <!-- Tambahkan div dengan kelas content -->
        {{ $slot }}
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">© {{ date('Y') }} Cashed. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('user-name').addEventListener('click', function() {
            var logoutForm = document.getElementById('logout-form');
            if (logoutForm.style.display === 'none' || logoutForm.style.opacity === '0') {
                logoutForm.style.display = 'block';
                setTimeout(function() {
                    logoutForm.style.opacity = '1';
                    logoutForm.style.transform = 'translateX(0)';
                }, 30); // Slight delay to ensure display property is applied before opacity transition
            } else {
                logoutForm.style.opacity = '0';
                logoutForm.style.transform = 'translateX(20px)';
                setTimeout(function() {
                    logoutForm.style.display = 'none';
                }, 30); // Duration should match the CSS transition time
            }
        });
    </script>
</body>

</html>
