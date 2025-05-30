@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

<section id="datos" class="d-flex flex-column align-items-center">
    <div class="d-flex flex-column align-items-center pt-4 text-center w-75">
        <h1 class="h3 fw-bold text-dark">{{ $itinerario->titulo }}</h1>
        <p><span class="fw-semibold text-secondary">{{ $itinerario->ciudad->nombre }} - {{ $itinerario->dias }} días</span></p>
        <p class="align-self-end pe-3">creado por: {{ $autor }}</p>
    </div>
</section>

<section id="img">
    <div class="d-flex justify-content-center mt-4">
        <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}" alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}" class="rounded shadow w-75" style="height: 320px; object-fit: cover;">
    </div>
</section>

<section id="acordeon">

    <div class="accordion accordion-flush w-75 mx-auto mt-4" id="accordionFlushExample">
        @for ($i = 1; $i <= $itinerario->dias; $i++)
        <div class="accordion-item border-bottom">
            <h2 class="accordion-header" id="flush-heading-{{ $i }}">
                <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $i }}" aria-expanded="false" aria-controls="flush-collapse-{{ $i }}">
                    Día {{ $i }}
                </button>
            </h2>
            <div id="flush-collapse-{{ $i }}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{ $i }}" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body p-3 border-top">

                    <ul id="lista-lugares-dia-{{ $i }}" class="mb-3 list-unstyled text-secondary">
                        <!-- Aquí aparecerán los lugares añadidos para este día -->
                    </ul>

                    <ul class="list-unstyled">
                        <li>
                            <button data-dia="{{ $i }}" data-bs-toggle="modal" data-bs-target="#authentication-modal" class="btn btn-primary btn-sm" type="button">
                                Añadir sitio turístico...
                            </button>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        @endfor

        <div class="d-flex justify-content-center mt-4 mb-5">
            <form id="form-itinerario" method="POST" action="{{ route('itinerario.guardar-lugares') }}" class="w-100 d-flex justify-content-center">
                @csrf
                <input type="hidden" name="itinerario_id" value="{{ $itinerario->id }}">
                <div id="inputs-lugares"></div>
                <button type="submit" id="btn-guardar-itinerario" class="btn btn-success" data-dias="{{ $itinerario->dias }}">
                    Guardar Itinerario
                </button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="authentication-modal" tabindex="-1" aria-labelledby="authenticationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authenticationModalLabel">Lugares turísticos de {{ $itinerario->ciudad->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form class="row gy-3" action="#">
                        @foreach ($lugares as $lugar)
                            @if (substr($lugar->categoria, 0, 5) !== 'Otros')
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start p-3 border rounded mb-3">
                                <div class="mb-2 mb-md-0">
                                    <h6 class="mb-1 fw-semibold text-dark">{{ $lugar->nombre }}</h6>
                                    <p class="mb-0 small text-muted">{{ $lugar->categoria }}</p>
                                    <p class="mb-0 small text-muted">{{ $lugar->direccion }}</p>
                                </div>
                                <button type="button" 
                                    data-lugar-id="{{ $lugar->id }}" 
                                    data-lugar-nombre="{{ $lugar->nombre }}" 
                                    data-lugar-direccion="{{ $lugar->direccion }}" 
                                    class="btn btn-primary btn-sm align-self-start"
                                    id="btn-agregar-lugar">
                                    Añadir
                                </button>
                            </div>
                            @endif
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let diaSeleccionado = null;

    // Al abrir el modal guardamos qué día seleccionaste
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', () => {
            diaSeleccionado = button.getAttribute('data-dia');
            console.log('Modal abierto para el día:', diaSeleccionado);
        });
    });

    // Añadir lugares al día correspondiente
    document.querySelectorAll('#authentication-modal button[id="btn-agregar-lugar"]').forEach(button => {
        button.addEventListener('click', function() {
            const lugarId = this.getAttribute('data-lugar-id');
            const lugarNombre = this.getAttribute('data-lugar-nombre');
            const lugarDireccion = this.getAttribute('data-lugar-direccion');

            const lista = document.getElementById(`lista-lugares-dia-${diaSeleccionado}`);

            const li = document.createElement('li');
            li.innerHTML = `<strong>${lugarNombre}</strong><br><small class="text-muted">${lugarDireccion}</small>`;
            li.dataset.lugarId = lugarId;
            li.classList.add('mb-2');

            lista.appendChild(li);

            const container = document.getElementById('inputs-lugares');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = diaSeleccionado + '-' + lugarId;
            input.value = diaSeleccionado + '-' + lugarId;

            container.appendChild(input);
        });
    });
</script>
@endpush
