<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font Onest -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Onest', sans-serif;
        }

        #map {
            height: 400px;
            width: 100px;
            border-radius: 8px;
        }
    </style>

    @stack('head')
</head>

<body class="min-vh-100 overflow-x-hidden">
    <section>
        <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('images/logo.png') }}" class="me-2" height="64" alt="Logo">
                    <span class="fs-3 fw-semibold">triping</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#">¿Cómo funciona?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Itinerarios de muestra</a>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        </li>
                        @endguest

                        @auth
                        <li class="nav-item">
                            <button data-bs-toggle="modal" data-bs-target="#crudModal" class="btn btn-success me-2">Crear itinerario</button>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 d-flex align-items-center">
                    <img src="{{ asset('images/logo.png') }}" class="me-2" height="32" alt="triping Logo">
                    <span class="fs-5 fw-semibold">triping</span>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <ul class="list-unstyled d-flex justify-content-end mb-0">
                        <li><a href="#" class="text-decoration-none text-muted me-3">Acerca de</a></li>
                        <li><a href="#" class="text-decoration-none text-muted me-3">Política de privacidad</a></li>
                        <li><a href="#" class="text-decoration-none text-muted me-3">Licencia</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center py-3 text-muted border-top">
            © 2023 <a href="#" class="text-decoration-none">triping™</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>