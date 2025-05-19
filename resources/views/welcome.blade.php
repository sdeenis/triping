@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

<section>
    <div id="sticky-parallax-header" class="flex flex-row justify-between left-0 w-full px-60 py-10 text-black">
        <div class="w-1/3 px-2 pt-40">
            <p class="text-6xl font-extrabold mb-4">Explora <br>sin límites.</p><br>
            <p class="text-black text-2xl font-medium py-8 text-left">Deja que el viaje se adapte a ti</p>
            <p class="text-black text-2xl font-medium py-8 text-left">Encuentra destinos que realmente encajan contigo</p>
            <button class="my-8 cursor-pointer flex items-center justify-center w-1/2 h-16 bg-blue-500 text-white text-2xl font-bold rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">
                <a href="#first">Saber más</a>
            </button>
        </div>
        <div class="w-1/2 pt-40"><a href="#first">Ir a la sección 1</a></div>
    </div>
</section>

<section>
    <div class="mx-auto max-w-7xl">
        <div class="flex flex-col gap-8 pt-24 pb-40 py-72">
            <div class="flex gap-0 flex-row justify-between">
                <div class="max-w-sm">
                    <p class="text-3xl font-bold pb-4">Visualiza el itinierario en un mapa</p>
                    <p class="text-xl">Organizado por días, ten todo tu itinerario en un mismo sitio en una misma web.</p>
                </div>
                <div>
                    <p>hola</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para crear itinerario -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg">
            <!-- Encabezado del modal -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t">
                <h3 class="text-2xl font-bold text-gray-900">Crear nuevo itinerario</h3>
                <button type="button" data-modal-toggle="crud-modal"
                    class="text-gray-500 hover:text-red-500 rounded-lg text-sm w-8 h-8 flex justify-center items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <form action="{{ route('itinerarios.create') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <div>
                    <label for="titulo" class="block text-lg font-medium text-gray-700">Título del itinerario</label>
                    <input type="text" name="titulo" id="titulo" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="ciudad_id" class="block text-lg font-medium text-gray-700">Ciudad destino</label>
                    <select name="ciudad_id" id="ciudad_id" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona una ciudad</option>
                    </select>
                </div>

                <div>
                    <label for="dias" class="block text-lg font-medium text-gray-700">Cantidad de días</label>
                    <input type="number" name="dias" id="dias" min="1" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 transition">
                        Crear itinerario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('crud-modal');
        const select = document.getElementById('ciudad_id');
        let ciudadesCargadas = false;

        const observer = new MutationObserver(() => {
            const isVisible = modal.classList.contains('flex') || modal.classList.contains('block');
            if (isVisible && !ciudadesCargadas) {
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

        observer.observe(modal, {
            attributes: true
        });
    });
</script>

@endpush