@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')
<section class="py-5 bg-light">
    <div id="sticky-parallax-header" class="container d-flex flex-row justify-content-between align-items-start">
        <div class="col-md-6 pt-5">
            <p class="display-3 fw-bold mb-4">Explora <br>sin límites.</p>
            <p class="fs-4 text-muted mb-4">Deja que el viaje se adapte a ti</p>
            <p class="fs-4 text-muted mb-4">Encuentra destinos que realmente encajan contigo</p>
            <a href="#first" class="btn btn-primary btn-lg">Saber más</a>
        </div>
        <div class="col-md-5 pt-5">
            <a href="#first" class="text-decoration-none">Ir a la sección 1</a>
        </div>
    </div>
</section>

<section id="first" class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-6">
                <h2 class="fw-bold">Visualiza el itinerario en un mapa</h2>
                <p class="fs-5">Organizado por días, ten todo tu itinerario en un mismo sitio en una misma web.</p>
            </div>
            <div class="col-md-6">
                <p>hola</p>
            </div>
        </div>
    </div>
</section>

<!-- Modal para crear itinerario -->
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalLabel">Crear nuevo itinerario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('itinerarios.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del itinerario</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ciudad_id" class="form-label">Ciudad destino</label>
                        <select name="ciudad_id" id="ciudad_id" class="form-select" required>
                            <option value="">Selecciona una ciudad</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dias" class="form-label">Cantidad de días</label>
                        <input type="number" name="dias" id="dias" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear itinerario</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('ciudad_id');
        let ciudadesCargadas = false;

        const modal = document.getElementById('crudModal');
        modal.addEventListener('shown.bs.modal', () => {
            if (!ciudadesCargadas) {
                fetch('/api/ciudades')
                    .then(response => response.json())
                    .then(data => {
                        select.innerHTML = '<option value="">Selecciona una ciudad</option>';
                        data.forEach(ciudad => {
                            const option = document.createElement('option');
                            option.value = ciudad.id;
                            option.textContent = ciudad.nombre;
                            select.appendChild(option);
                        });
                        ciudadesCargadas = true;
                    });
            }
        });
    });
</script>
@endpush
