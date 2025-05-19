@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

<section id="datos" class="flex flex-col items-center ">
    <div class="flex flex-col items-center pt-10 leading-10 w-2/3">
        <h1 class="text-3xl font-bold text-gray-800">{{ $itinerario->titulo }}</h1>
        <p><span class="font-semibold text-gray-700"> {{ $itinerario->ciudad->nombre }} - {{ $itinerario->dias}} días</span></p>

        <p class="self-end pr-4">creado por: {{$autor}}</p>
    </div>
</section>

<section id="img">
    <div class="flex justify-center mt-10">
        <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}" alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}" class="rounded-lg shadow-lg w-2/3 h-80 object-cover">
    </div>
</section>

<section id="acordeon">

    <div id="accordion-flush" data-accordion="open" data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500" class="w-2/3 mx-auto mt-10">
        @for ($i = 1; $i <= $itinerario->dias; $i++)
            <h2 id="accordion-flush-heading-{{ $i }}">
                <button type="button"
                    class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3"
                    data-accordion-target="#accordion-flush-body-{{ $i }}"
                    aria-expanded="false"
                    aria-controls="accordion-flush-body-{{ $i }}">
                    <span>Día {{ $i }}</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-flush-body-{{ $i }}" class="hidden" aria-labelledby="accordion-flush-heading-{{ $i }}">
                <div class="py-5 border-b border-gray-200">

                    <ul id="lista-lugares-dia-{{ $i }}" class="mb-4 list-disc list-inside text-gray-700">
                        <!-- Aquí aparecerán los lugares añadidos para este día -->
                    </ul>

                    <ul>
                        <li>
                            <button data-dia="{{ $i }}" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                Añadir sitio turístico...
                            </button>
                        </li>
                    </ul>

                </div>
            </div>
            @endfor

            <div class="flex justify-center mt-8">
                <form id="form-itinerario" method="POST" action="{{ route('itinerario.guardar-lugares') }}">
                    @csrf
                    <input type="hidden" name="itinerario_id" value="{{ $itinerario->id }}">
                    <div id="inputs-lugares"></div>
                    <button type="submit" id="btn-guardar-itinerario" class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg px-6 py-3 focus:outline-none focus:ring-4 focus:ring-green-300" data-dias="{{ $itinerario->dias }}">
                        Guardar Itinerario
                    </button>
            </div>
    </div>


    <!-- Modal toggle -->


    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Lugares turísticos de {{ $itinerario->ciudad->nombre }}
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="#">
                        <div class="space-y-4">
                            @foreach ($lugares as $lugar)
                            @if (substr($lugar->categoria, 0, 5) !== 'Otros')
                            <div class="rounded-md p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-3 md:mb-0">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $lugar->nombre }}</h4>
                                    <p class="text-sm text-gray-500">{{ $lugar->categoria }}</p>
                                    <p class="text-sm text-gray-500">{{ $lugar->direccion }}</p>
                                </div>
                                <button type="button" data-lugar-id="{{ $lugar->id }}" data-lugar-nombre="{{ $lugar->nombre }}" data-lugar-direccion=" {{ $lugar->direccion }} "
                                    class="self-start md:self-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                                    id="btn-agregar-lugar">
                                    Añadir
                                </button>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>

<script>
    let diaSeleccionado = null;

    // Al abrir el modal guardamos qué día seleccionaste
    document.querySelectorAll('[data-modal-toggle="authentication-modal"]').forEach(button => {
        button.addEventListener('click', () => {
            diaSeleccionado = button.getAttribute('data-dia');
            console.log('Modal abierto para el día:', diaSeleccionado);
        });
    });

    // Ahora asignamos el evento para añadir lugares a todos los botones dentro del modal
    document.querySelectorAll('#authentication-modal button[id="btn-agregar-lugar"]').forEach(button => {
        button.addEventListener('click', function() {
            const lugarId = this.getAttribute('data-lugar-id');
            const lugarNombre = this.getAttribute('data-lugar-nombre');
            const lugarDireccion = this.getAttribute('data-lugar-direccion');

            const lista = document.getElementById(`lista-lugares-dia-${diaSeleccionado}`);

            const li = document.createElement('li');
            li.innerHTML = `<strong>${lugarNombre}</strong><br><small class="text-gray-500">${lugarDireccion}</small>`;
            li.dataset.lugarId = lugarId;
            li.classList.add('mb-5');

            lista.appendChild(li);

            const container = document.getElementById('inputs-lugares');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = diaSeleccionado + '-' + lugarId;
            input.value = diaSeleccionado + '-' + lugarId;

            container.appendChild(input);
            // Puedes cerrar el modal automáticamente si quieres
            // document.querySelector('[data-modal-hide="authentication-modal"]').click();
        });
    });

    // document.getElementById('form-itinerario').addEventListener('submit', function(e) {
    //     // Limpiamos inputs previos
    //     const container = document.getElementById('inputs-lugares');
    //     container.innerHTML = '';

    //     const dias = parseInt(form.getAttribute('data-dias'), 10);

    //     for (let dia = 1; dia <= dias; dia++) {
    //         const lista = document.getElementById(`lista-lugares-dia-${dia}`);
    //         if (!lista) continue;

    //         lista.querySelectorAll('li').forEach((li, index) => {
    //             const lugarId = li.dataset.lugarId;
    //             if (!lugarId) return;

    //             const input = document.createElement('input');
    //             input.type = 'hidden';
    //             input.name = `lugares[${dia}][${index}]`;
    //             input.value = lugarId;

    //             container.appendChild(input);
    //         });
    //     }
    // });
</script>
@endpush