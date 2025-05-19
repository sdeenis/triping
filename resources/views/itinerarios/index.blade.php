@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

@foreach ($itinerarios as $itinerario)
<section id="datos" class="flex flex-col items-center mt-20">
    <a href="{{ route('itinerarios.mostrar', $itinerario->id) }} " class="w-full flex justify-center">
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
        </div>
    </a>
</section>

@endforeach

@endsection

@push('scripts')

@endpush