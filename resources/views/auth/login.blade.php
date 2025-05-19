@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
    <div>
        <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse">
            <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="Logo" />
            <span class="self-center text-4xl font-semibold whitespace-nowrap">triping</span>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg">
        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                    href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif

                <button type="submit"
                    class="ms-3 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:ring-indigo-500">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection