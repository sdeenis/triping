<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        @keyframes sticky-parallax-header-move-and-size {
            from {
                /* Centra horizontalmente la imagen */
                height: 100vh;
                /* Altura inicial: 100% del alto de la pantalla */

                /* Tamaño de fuente grande */
                /* padding-top: 400px; */
            }

            to {
                /* padding-top: 0px; */
                /* Mantén la imagen centrada */
                background-color: #0b1584;
                /* Cambia el color de fondo */
                height: 10vh;
                /* Altura final: 10% del alto de la pantalla */
                font-size: 2em;
                /* Tamaño de fuente pequeño */
                filter: brightness(0.5) hue-rotate(200deg);
            }
        }


        #sticky-parallax-header {
            /* display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%; */
            /* La cabecera siempre ocupará todo el ancho de la pantalla */

            /* animation: sticky-parallax-header-move-and-size linear forwards;
            animation-timeline: scroll();
            animation-range: 0vh 90vh; */
        }


        body {

            /* Espacio inicial igual a la altura de la cabecera */

            /* background-color: white; */
            color: black;
        }
    </style>
</head>

<body class="overflow-x-hidden">
    <div class="relative">
        <div class="absolute top-0 z-[-2] h-full w-screen rotate-180 transform bg-white bg-[radial-gradient(60%_120%_at_50%_50%,hsla(0,0%,100%,0)_0,rgba(252,205,238,.5)_100%)]"></div>

        <section>

            <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
                    </a>
                    <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Iniciar sesión</button>
                        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                            </svg>
                        </button>
                    </div>
                    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <li>
                                <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </section>

        <section>
            <div id="sticky-parallax-header" class="flex flex-row justify-between top-0 left-0 w-full px-30 py-10 bg-white-500 text-black">
                <div class="w-1/3 px-2 pt-40 left-side">
                    <p class="text-6xl font-extrabold mb-4 text-wrap">Explora <br>sin límites.</p><br>
                    <p class="text-black text-2xl font-medium py-8 text-left">Deja que el viaje se adapte a ti</p>
                    <p class="text-black text-2xl font-medium py-8 text-left">Encuentra destinos que realmente encajan contigo</p>
                    <button class="my-8 cursor-pointer flex items-center justify-center w-1/2 h-16 bg-blue-500 text-white text-2xl font-bold rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"">
                <a href=" #first">Saber más</a>
                    </button>
                </div>
                <div class=" w-1/2"><a href="#first">Ir a la sección 1</a></div>
            </div>
        </section>

        <section>
            <div class="mx-auto max-w-7xl main-feature bg-amber-300">
                <div class="flex flex-col gap-8 pt-24 pb-40 py-72 bg-blue-400">
                    <div class="flex gap-0 flex-row justify-between bg-red-500">
                        <div class="izquierda bg-purple-500">
                            <p class="text-3xl font-bold max-w-xs pb-4">Visualiza el itinierario en un mapa</p>
                            <p class="text-xl max-w-sm text-wrap">Organizado por días, ten todo tu itinerario en un mismo sitio en una misma web.</p>
                        </div>
                        <div class="derecha bg-green-500">
                            <p>hola</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>
</body>

</html>