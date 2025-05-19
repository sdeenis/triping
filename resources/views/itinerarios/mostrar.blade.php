@extends('layouts.guest')

@section('title', $itinerario->titulo)

@section('content')

<section id="datos" class="flex flex-col items-center mt-10">
    <div class="w-3/4 bg-white rounded-2xl shadow-xl p-8 border border-gray-200 hover:shadow-2xl transition duration-300">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $itinerario->titulo }}</h1>
            <p class="text-lg text-gray-600 font-medium mb-4">
                {{ $itinerario->ciudad->nombre }} &middot; {{ $itinerario->dias }} días
            </p>
        </div>

        <div class="flex justify-center">
            <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}"
                alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}"
                class="rounded-xl shadow-md w-full h-80 object-cover mb-6">
        </div>

        <p class="text-sm text-right text-gray-500">{{$itinerario->created_at->format('d/m/Y')}} | Creado por: <span class="font-semibold text-gray-700">{{ $itinerario->usuario->name }}</span></p>


        <div id="accordion-itinerario" class="w-full">
            @for ($dia = 1; $dia <= $itinerario->dias; $dia++)
                <div class="border-b border-gray-200">
                    <button type="button" class="w-full flex justify-between items-center py-4 text-left text-gray-700 font-semibold hover:bg-gray-100 focus:outline-none" data-accordion-toggle="dia-{{ $dia }}">
                        Día {{ $dia }}
                        <svg class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="dia-{{ $dia }}" class="hidden pl-4 pb-6">
                        @php
                        // Filtrar los lugares del día $dia
                        $lugaresDia = $itinerario->lugares->filter(function($lugar) use ($dia) {
                        return $lugar->pivot->dia == $dia;
                        });
                        @endphp

                        @if ($lugaresDia->isEmpty())
                        <p class="text-gray-500 italic">No hay lugares asignados para este día.</p>
                        @else
                        <ul class="list-disc list-inside text-gray-700 space-y-3">
                            @foreach ($lugaresDia as $lugar)
                            <li>
                                <strong>{{ $lugar->nombre }}</strong><br>
                                <span class="text-sm text-gray-500">{{ $lugar->categoria }}</span><br>
                                <span class="text-sm text-gray-400">{{ $lugar->direccion }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                @endfor
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-accordion-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-accordion-toggle');
            const content = document.getElementById(targetId);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                button.querySelector('svg').classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                button.querySelector('svg').classList.remove('rotate-180');
            }
        });
    });
</script>
@endpush