@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-5">
    <div>
        <a href="/" class="d-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="height: 64px;" alt="Logo" />
            <span class="fs-2 fw-semibold text-dark">triping</span>
        </a>
    </div>

    <div class="w-100 mt-4 p-4 shadow rounded bg-white" style="max-width: 400px;">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" name="password" required
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="form-control @error('password_confirmation') is-invalid @enderror">
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a class="text-decoration-underline small text-muted" href="{{ route('login') }}">
                    ¿Ya estás registrado?
                </a>

                <button type="submit" class="btn btn-primary ms-3">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
