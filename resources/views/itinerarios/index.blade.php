@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

@foreach ($itinerarios as $itinerario)
<section id="datos" class="d-flex flex-column align-items-center mt-5">
    <a href="{{ route('itinerarios.mostrar', $itinerario->id) }}" class="w-100 d-flex justify-content-center text-decoration-none">
        <div class="w-75 bg-white rounded-3 shadow border border-secondary p-4 hover-shadow transition" style="transition: box-shadow 0.3s;">
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

            <p class="text-end text-muted small">
                {{ $itinerario->created_at->format('d/m/Y') }} | Creado por: <span class="fw-semibold text-dark">{{ $itinerario->usuario->name }}</span>
            </p>
        </div>
    </a>
</section>

@endforeach

@endsection

@push('scripts')

@endpush
