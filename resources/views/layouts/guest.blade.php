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

        .navbar .btn {
            border-radius: 30px;
            padding: 0.4rem 1rem;
            transition: all 0.2s ease-in-out;
        }

        .navbar .btn:hover {
            transform: scale(1.05);
        }

        .custom-user-btn {
            border: 2px solid #0d6efd;
            color: #0d6efd;
            background-color: #fff;
            border-radius: 30px;
            padding: 0.4rem 1rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .custom-user-btn:hover {
            background-color: #e9f2ff;
            transform: scale(1.05);
            text-decoration: none;
        }

        .dropdown-menu {
            border-radius: 12px;
            padding: 0.5rem 0;
        }
        .dropdown-menu .dropdown-item {
            transition: background-color 0.2s ease-in-out;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            text-decoration: underline;
        }


        @stack('styles')
    </style>

    @stack('head')
</head>

<body class="min-vh-100 overflow-x-hidden">
    <section>
        <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" class="me-2" height="64" alt="Logo">
                    <span class="fs-3 fw-semibold">triping</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a href="{{ route('itinerarios.listar') }}" class="btn btn-primary me-2">Itinerarios</a>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-outline-success">Register</a>
                        </li>
                        @endguest


                        @auth
                        <li class="nav-item me-2">
                            <button data-bs-toggle="modal" data-bs-target="#crudModal" class="btn btn-success">
                                Crear itinerario
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="custom-user-btn dropdown-toggle d-flex align-items-center" href="#" role="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('preferencias') }}">
                                        Preferencias
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
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

        <!-- Modal para crear itinerario -->
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="crudModalLabel">Crear nuevo itinerario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('itinerarios.create') }}" method="POST" class="p-4">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del itinerario</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ciudad_id" class="form-label">Ciudad destino</label>
                        <select name="ciudad_id" id="ciudad_id" class="form-select" required>
                            <option value="">Selecciona una ciudad</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dias" class="form-label">Cantidad de días</label>
                        <input type="number" name="dias" id="dias" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear itinerario</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 d-flex align-items-center">
                    <img src="{{ asset('images/logo.png') }}" class="me-2" height="32" alt="triping Logo">
                    <span class="fs-5 fw-semibold">triping</span>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <ul class="list-unstyled d-flex justify-content-end mb-0">
                        <li>Denis Ioan Savoiu</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center py-3 text-muted border-top">
            © 2025 <a href="#" class="text-decoration-none">triping™</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>

    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('ciudad_id');
        let ciudadesCargadas = false;

        const modal = document.getElementById('crudModal');
        modal.addEventListener('shown.bs.modal', () => {
            if (!ciudadesCargadas) {
                fetch('/api/ciudades')
                    .then(response => response.json())
                    .then(data => {
                        select.innerHTML = '<option value="">Selecciona una ciudad</option>';
                        data.forEach(ciudad => {
                            const option = document.createElement('option');
                            option.value = ciudad.id;
                            option.textContent = ciudad.nombre;
                            select.appendChild(option);
                        });
                        ciudadesCargadas = true;
                    });
            }
        });
    });

    </script>
    @stack('scripts')
</body>

</html>