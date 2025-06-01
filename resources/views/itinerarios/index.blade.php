@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

<form method="GET" action="{{ route('itinerarios.listar') }}" class="container mt-4">
    <div class="row g-3 align-items-end">

        {{-- Ciudad --}}
        <div class="col-md-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <select name="ciudad" id="ciudad" class="form-select">
                <option value="">Todas</option>
                @foreach ($ciudades as $id => $nombre)
                    <option value="{{ $id }}" {{ request('ciudad') == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Días --}}
        <div class="col-md-2">
            <label for="dias" class="form-label">Días</label>
            <select name="dias" id="dias" class="form-select">
                <option value="">Todos</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ request('dias') == $i ? 'selected' : '' }}>
                        {{ $i }} día{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- Fecha --}}
        <div class="col-md-3">
            <label for="fecha" class="form-label">Fecha de creación</label>
            <select name="fecha" id="fecha" class="form-select">
                <option value="">Todas</option>
                <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                <option value="7dias" {{ request('fecha') == '7dias' ? 'selected' : '' }}>Últimos 7 días</option>
                <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Último mes</option>
            </select>
        </div>

        {{-- Creador --}}
        <div class="col-md-3">
            <label for="creador" class="form-label">Creador</label>
            <input type="text" name="creador" id="creador" class="form-control" value="{{ request('creador') }}">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </div>
</form>

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
