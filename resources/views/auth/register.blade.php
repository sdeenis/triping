@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
    <div>
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="Logo" />
            <span class="self-center text-4xl font-semibold whitespace-nowrap">triping</span>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                @error('email')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input id="password" type="password" name="password" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                @error('password')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                    contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                @error('password_confirmation')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                    href="{{ route('login') }}">¿Ya estás registrado?</a>

                <button type="submit"
                    class="ms-3 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:ring-indigo-500">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection