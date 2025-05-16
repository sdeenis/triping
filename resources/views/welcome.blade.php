@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')
<section>
    <nav class="border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-2 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="Logo" />
                <span class="self-center text-4xl font-semibold whitespace-nowrap">triping</span>
            </a>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    <li class="flex items-center justify-center">
                        <a href="#" class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700">Home</a>
                    </li>
                    <li class="flex items-center justify-center">
                        <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700">Services</a>
                    </li>
                    <li class="flex items-center justify-center">
                        <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700">Pricing</a>
                    </li>
                    <li class="flex items-center justify-center">
                        <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700">Contact</a>
                    </li>

                    @guest
                    <!-- Mostrar esto si el usuario NO ha iniciado sesión -->
                    <li>
                        <a href="{{ route('login') }}" class="cursor-pointer flex items-center justify-center bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out px-3 py-2">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="cursor-pointer flex items-center justify-center bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 transition duration-300 ease-in-out px-3 py-2">
                            Register
                        </a>
                    </li>
                    @endguest

                    @auth
                    <!-- Mostrar esto si el usuario SÍ ha iniciado sesión -->
                    <li>
                        <!-- <a href="{{ route('home') }}" class="cursor-pointer flex items-center justify-center bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 ease-in-out px-3 py-2">
                            Crear itinerario
                        </a> -->
                        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Crear itinerario
                        </button>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="cursor-pointer flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 ease-in-out px-3 py-2">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>
</section>

<section>
    <div id="sticky-parallax-header" class="flex flex-row justify-between left-0 w-full px-60 py-10 text-black">
        <div class="w-1/3 px-2 pt-40">
            <p class="text-6xl font-extrabold mb-4">Explora <br>sin límites.</p><br>
            <p class="text-black text-2xl font-medium py-8 text-left">Deja que el viaje se adapte a ti</p>
            <p class="text-black text-2xl font-medium py-8 text-left">Encuentra destinos que realmente encajan contigo</p>
            <button class="my-8 cursor-pointer flex items-center justify-center w-1/2 h-16 bg-blue-500 text-white text-2xl font-bold rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">
                <a href="#first">Saber más</a>
            </button>
        </div>
        <div class="w-1/2 pt-40"><a href="#first">Ir a la sección 1</a></div>
    </div>
</section>

<section>
    <div class="mx-auto max-w-7xl">
        <div class="flex flex-col gap-8 pt-24 pb-40 py-72">
            <div class="flex gap-0 flex-row justify-between">
                <div class="max-w-sm">
                    <p class="text-3xl font-bold pb-4">Visualiza el itinierario en un mapa</p>
                    <p class="text-xl">Organizado por días, ten todo tu itinerario en un mismo sitio en una misma web.</p>
                </div>
                <div>
                    <p>hola</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para crear itinerario -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg">
            <!-- Encabezado del modal -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t">
                <h3 class="text-2xl font-bold text-gray-900">Crear nuevo itinerario</h3>
                <button type="button" data-modal-toggle="crud-modal"
                    class="text-gray-500 hover:text-red-500 rounded-lg text-sm w-8 h-8 flex justify-center items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form action="#" method="POST" class="p-6 space-y-6">
                @csrf
                <div>
                    <label for="titulo" class="block text-lg font-medium text-gray-700">Título del itinerario</label>
                    <input type="text" name="titulo" id="titulo" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="ciudad_id" class="block text-lg font-medium text-gray-700">Ciudad destino</label>
                    <select name="ciudad_id" id="ciudad_id" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona una ciudad</option>

                        <option value="1">Madrid</option>
                        <option value="2">Barcelona</option>
                        <option value="3">Valencia</option>
                    </select>
                </div>

                <div>
                    <label for="dias" class="block text-lg font-medium text-gray-700">Cantidad de días</label>
                    <input type="number" name="dias" id="dias" min="1" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 transition">
                        Crear itinerario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('crud-modal');

        // Observador para detectar clases en el modal
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const isVisible = modal.classList.contains('flex') || modal.classList.contains('block');

                    if (isVisible) {
                        // Añadir padding al body
                        document.body.style.paddingRight = '15px';
                    } else {
                        // Quitar el padding
                        document.body.style.paddingRight = '';
                    }
                }
            });
        });

        observer.observe(modal, {
            attributes: true
        });
    });
</script>

@endpush