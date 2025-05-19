<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

    @stack('head')
</head>

<body class="min-h-screen font-sans text-gray-900 antialiased overflow-x-hidden">
    <div class="fixed top-0 left-0 -z-10 w-full h-full min-h-screen bg-white bg-[radial-gradient(60%_120%_at_50%_50%,hsla(0,0%,100%,0)_0,rgba(252,205,238,.5)_100%)]"></div>
    <!-- <div class="absolute inset-0 -z-10 h-full w-full bg-white bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px]">
        <div class="absolute left-0 right-0 top-0 -z-10 m-auto h-[310px] w-[310px] rounded-full bg-fuchsia-400 opacity-20 blur-[100px]"></div>
    </div> -->
    <!-- <div class="absolute inset-0 -z-10 h-full w-full bg-white bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] bg-[size:6rem_4rem]">
        <div class="absolute bottom-0 left-0 right-0 top-0 bg-[radial-gradient(circle_500px_at_50%_200px,#C9EBFF,transparent)]"></div>
    </div> -->

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
                            <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700">¿Cómo funciona?</a>
                        </li>
                        <li class="flex items-center justify-center">
                            <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700">Itinerarios de muestra</a>
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


    @yield('content')


    <section class="mt-20">
        <footer class="rounded-lg  m-4">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="triping Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap">triping</span>
                    </a>
                    <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Acerca de</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Política de privacidad</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Licencia</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Contacto</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center">© 2023 <a href="#" class="hover:underline">triping™</a></span>
            </div>
        </footer>
    </section>



    @stack('scripts')
</body>

</html>