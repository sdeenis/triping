@extends('layouts.guest')

@section('title', 'Panel de administración')

@section('content')
<div class="container mt-5">
    <h2>Panel de Administración</h2>
    <form action="{{ route('admin.llamar-api') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Llamar a la API</button>
    </form>
</div>
@endsection

@push('scripts')

@endpush