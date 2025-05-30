@extends('layouts.guest')

@section('title', $itinerario->titulo)

@section('content')

<section id="datos" class="d-flex flex-column align-items-center mt-5">
    <div class="w-75 bg-white rounded-3 shadow border border-secondary p-4" style="transition: box-shadow 0.3s;">
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold text-dark mb-2">{{ $itinerario->titulo }}</h1>
            <p class="fs-5 text-secondary fw-medium mb-3">
                {{ $itinerario->ciudad->nombre }} &middot; {{ $itinerario->dias }} días
            </p>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}"
                alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}"
                class="rounded-3 shadow-sm w-100" style="max-height: 320px; object-fit: cover;">
        </div>

        <p class="text-end text-muted small mb-4">
            {{ $itinerario->created_at->format('d/m/Y') }} | Creado por: <span class="fw-semibold text-dark">{{ $itinerario->usuario->name }}</span>
        </p>

        <div class="accordion" id="accordionItinerario">
            @for ($dia = 1; $dia <= $itinerario->dias; $dia++)
                @php
                    $lugaresDia = $itinerario->lugares->filter(fn($lugar) => $lugar->pivot->dia == $dia);
                @endphp

                <div class="accordion-item border-bottom border-secondary">
                    <h2 class="accordion-header" id="heading-{{ $dia }}">
                        <button class="accordion-button collapsed fw-semibold text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $dia }}" aria-expanded="false" aria-controls="collapse-{{ $dia }}">
                            Día {{ $dia }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $dia }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $dia }}" data-bs-parent="#accordionItinerario">
                        <div class="accordion-body px-4 pb-3">
                            @if ($lugaresDia->isEmpty())
                                <p class="fst-italic text-secondary">No hay lugares asignados para este día.</p>
                            @else
                                <ul class="list-unstyled mb-0">
                                    @foreach ($lugaresDia as $lugar)
                                    <li class="mb-3">
                                        <strong class="text-dark">{{ $lugar->nombre }}</strong><br>
                                        <span class="text-muted small">{{ $lugar->categoria }}</span><br>
                                        <span class="text-muted smaller">{{ $lugar->direccion }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- Bootstrap accordion no necesita JS extra, si tienes Bootstrap JS activo --}}
@endpush
