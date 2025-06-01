@extends('layouts.guest')

@section('title', 'Preferencias de viaje')
@push('styles')
@push('styles')
<style>
    .question {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.5s ease-in-out;
        position: absolute;
        width: 100%;
        z-index: 1;
    }

    .question.active {
        opacity: 1;
        transform: translateY(0);
        position: relative;
        z-index: 2;
    }

    #questionCard {
        position: relative;
        min-height: 420px;
        background: #fffefc;
        border-radius: 1rem;
    }

    .btn-custom {
        transition: all 0.3s ease;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
    }

    .btn-outline-primary {
        border-color: #FF7F50;
        color: #FF7F50;
    }

    .btn-outline-primary:hover {
        background-color: #FF7F50;
        color: #fff;
    }

    .btn-outline-success {
        border-color: #4CAF50;
        color: #4CAF50;
    }

    .btn-outline-success:hover {
        background-color: #4CAF50;
        color: #fff;
    }

    .btn-outline-secondary {
        border-color: #6C757D;
        color: #6C757D;
    }

    .btn-outline-secondary:hover {
        background-color: #6C757D;
        color: #fff;
    }

    .btn-outline-info {
        border-color: #17A2B8;
        color: #17A2B8;
    }

    .btn-outline-info:hover {
        background-color: #17A2B8;
        color: #fff;
    }

    h2 {
        font-weight: bold;
        color: #444;
    }

    h5 {
        margin-bottom: 1rem;
        color: #333;
    }
</style>
@endpush

@endpush

@section('content')
<div style="min-height: 70vh;" class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4 w-100" style="max-width: 600px;" id="questionCard">
        <div class="card-body text-center">
            <h2 class="mb-4">🎒 Descubre tus preferencias de viaje</h2>
            <form id="preferenceForm" action="{{ route('guardar.preferencia') }}" method="POST">
                @csrf
                <input type="hidden" name="preferencias" id="preferencias">

                <div class="question active">
                    <h5>1. ¿Qué es lo primero que haces al llegar a una ciudad nueva?</h5>
                    <button type="button" class="btn btn-outline-primary w-100 my-2" data-cat="Restaurante">🍽️ Comer algo local</button>
                    <button type="button" class="btn btn-outline-success w-100 my-2" data-cat="Parque">🌳 Pasear por los alrededores</button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-2" data-cat="Monumento">🏛️ Ver lo emblemático</button>
                    <button type="button" class="btn btn-outline-info w-100 my-2" data-cat="Museo">🖼️ Buscar museos curiosos</button>
                </div>

                <div class="question d-none">
                    <h5>2. ¿Qué sueles subir más a redes cuando viajas?</h5>
                    <button type="button" class="btn btn-outline-primary w-100 my-2" data-cat="Restaurante">🍽️ La comida que pruebo</button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-2" data-cat="Monumento">📸 Selfies en lugares icónicos</button>
                    <button type="button" class="btn btn-outline-success w-100 my-2" data-cat="Parque">🌄 Paisajes naturales</button>
                    <button type="button" class="btn btn-outline-info w-100 my-2" data-cat="Museo">🖼️ Cosas raras en museos</button>
                </div>

                <div class="question d-none">
                    <h5>3. ¿Qué plan te apetece un domingo por la mañana?</h5>
                    <button type="button" class="btn btn-outline-success w-100 my-2" data-cat="Parque">🌳 Perderme en un parque</button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-2" data-cat="Monumento">🏛️ Visitar un castillo</button>
                    <button type="button" class="btn btn-outline-info w-100 my-2" data-cat="Museo">🖼️ Ir a una exposición</button>
                    <button type="button" class="btn btn-outline-primary w-100 my-2" data-cat="Restaurante">☕ Brunch en algún sitio guay</button>
                </div>

                <div class="question d-none">
                    <h5>4. ¿Con cuál de estos souvenirs te quedarías?</h5>
                    <button type="button" class="btn btn-outline-primary w-100 my-2" data-cat="Restaurante">🧃 Bebida o especia local</button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-2" data-cat="Monumento">📷 Postal de un monumento</button>
                    <button type="button" class="btn btn-outline-success w-100 my-2" data-cat="Parque">🌿 Flor o piedra del parque</button>
                    <button type="button" class="btn btn-outline-info w-100 my-2" data-cat="Museo">🎨 Mini obra de arte</button>
                </div>

                <div class="question d-none">
                    <h5>5. Si alguien visita tu ciudad, ¿qué le recomiendas?</h5>
                    <button type="button" class="btn btn-outline-success w-100 my-2" data-cat="Parque">🌳 Un rincón natural tranquilo</button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-2" data-cat="Monumento">🏛️ Lo histórico imprescindible</button>
                    <button type="button" class="btn btn-outline-info w-100 my-2" data-cat="Museo">🖼️ Museo curioso</button>
                    <button type="button" class="btn btn-outline-primary w-100 my-2" data-cat="Restaurante">🍷 Restaurante local secreto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const questions = document.querySelectorAll('.question');
    const form = document.getElementById('preferenceForm');
    const categorias = {
        'Parque': 0,
        'Monumento': 0,
        'Museo': 0,
        'Restaurante': 0
    };
    let current = 0;

    questions[current].classList.add('active');

    questions.forEach((q, index) => {
        q.querySelectorAll('button').forEach(btn => {
            btn.classList.add('btn-custom');
            btn.addEventListener('click', () => {
                const cat = btn.getAttribute('data-cat');
                categorias[cat]++;

                if (current < questions.length - 1) {
                    // No es la última pregunta: animar salida y mostrar siguiente
                    questions[current].classList.remove('active');

                    setTimeout(() => {
                        questions[current].classList.add('d-none');

                        current++;

                        questions[current].classList.remove('d-none');
                        setTimeout(() => {
                            questions[current].classList.add('active');
                        }, 50);
                    }, 300);
                } else {
                    // Última pregunta: NO ocultar el div para evitar parpadeo
                    // Solo enviar el formulario después de asignar el valor
                    const preferencias = {
                        'Parque': 1,
                        'Monumento': 2,
                        'Museo': 3,
                        'Restaurante': 4
                    };
                    const max = Object.keys(categorias).reduce((a, b) => categorias[a] > categorias[b] ? a : b);
                    document.getElementById('preferencias').value = preferencias[max];
                    form.submit();
                }
            });
        });
    });
</script>

@endpush
