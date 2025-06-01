@extends('layouts.guest')

@section('title', 'Inicio')

@section('content')

    <section id="datos" class="d-flex flex-column align-items-center">
        <div class="d-flex flex-column align-items-center pt-4 text-center w-75">
            <h1 class="h3 fw-bold text-dark">{{ $itinerario->titulo }}</h1>
            <p><span class="fw-semibold text-secondary">{{ $itinerario->ciudad->nombre }} - {{ $itinerario->dias }}
                    días</span></p>
            <p class="align-self-end pe-3">creado por: {{ $autor }}</p>
        </div>
    </section>

    <section id="img">
        <div class="d-flex justify-content-center mt-4">
            <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}"
                alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}" class="rounded shadow w-75"
                style="height: 320px; object-fit: cover;">
        </div>
    </section>

    <section id="acordeon">

        <div class="accordion accordion-flush w-75 mx-auto mt-4" id="accordionFlushExample">
            @for ($i = 1; $i <= $itinerario->dias; $i++)
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="flush-heading-{{ $i }}">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $i }}"
                            aria-expanded="false" aria-controls="flush-collapse-{{ $i }}">
                            Día {{ $i }}
                        </button>
                    </h2>
                    <div id="flush-collapse-{{ $i }}" class="accordion-collapse collapse"
                        aria-labelledby="flush-heading-{{ $i }}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body p-3 border-top">

                            <ul id="lista-lugares-dia-{{ $i }}" class="mb-3 list-unstyled text-secondary">
                                <!-- Aquí aparecerán los lugares añadidos para este día -->
                            </ul>

                            <ul class="list-unstyled">
                                <li>
                                    <button data-dia="{{ $i }}" data-bs-toggle="modal"
                                        data-bs-target="#authentication-modal" class="btn btn-primary btn-sm"
                                        type="button">
                                        Añadir sitio turístico...
                                    </button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <section id="mapa" class="d-flex flex-column align-items-center mt-4">
        <button type="submit" id="btn-guardar-itinerario" class="btn btn-success">
            Actualizar mapa
        </button>
        <div id="map"
            style="height: 400px; width: 75%; margin: 0 auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        </div>

    </section>

    <section id="guardar-el-itinerario">
        <div class="d-flex justify-content-center mt-4 mb-5">
            <form id="form-itinerario" method="POST" action="{{ route('itinerario.guardar-lugares') }}"
                class="w-100 d-flex justify-content-center">
                @csrf
                <input type="hidden" name="itinerario_id" value="{{ $itinerario->id }}">
                <div id="inputs-lugares"></div>
                <button type="submit" id="btn-guardar-itinerario" class="btn btn-success"
                    data-dias="{{ $itinerario->dias }}">
                    Guardar Itinerario
                </button>
            </form>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="authentication-modal" tabindex="-1" aria-labelledby="authenticationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authenticationModalLabel">Lugares turísticos de
                        {{ $itinerario->ciudad->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form class="row gy-3" action="#">
                        @foreach ($lugares as $lugar)
                            @if (substr($lugar->categoria, 0, 5) !== 'Otros')
                                <div
                                    class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start p-3 border rounded mb-3">
                                    <div class="mb-2 mb-md-0">
                                        <h6 class="mb-1 fw-semibold text-dark">{{ $lugar->nombre }}</h6>
                                        <p class="mb-0 small text-muted">{{ $lugar->categoria }}</p>
                                        <p class="mb-0 small text-muted">{{ $lugar->direccion }}</p>
                                    </div>
                                    <button type="button" data-lugar-id="{{ $lugar->id }}"
                                        data-lugar-nombre="{{ $lugar->nombre }}"
                                        data-lugar-direccion="{{ $lugar->direccion }}" data-lat="{{ $lugar->latitud }}"
                                        data-lng="{{ $lugar->longitud }}" class="btn btn-primary btn-sm align-self-start"
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
    <style>
        #map {
            height: 400px;
            width: 75%;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            min-height: 300px;
            min-width: 300px;
            max-width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


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
                const lat = this.getAttribute('data-lat');
                const lng = this.getAttribute('data-lng');

                const lista = document.getElementById(`lista-lugares-dia-${diaSeleccionado}`);

                const li = document.createElement('li');

                li.dataset.lugarId = lugarId;
                li.dataset.dia = diaSeleccionado;
                li.dataset.lat = lat;
                li.dataset.lng = lng;
                li.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center');

                li.innerHTML = `
                <div>
                    <strong>${lugarNombre}</strong><br>
                    <small class="text-muted">${lugarDireccion}</small>
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-2 btn-eliminar-lugar">Eliminar</button>
            `;

                lista.appendChild(li);

                const container = document.getElementById('inputs-lugares');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = diaSeleccionado + '-' + lugarId;
                input.value = diaSeleccionado + '-' + lugarId;
                input.dataset.lugarId = lugarId;
                input.dataset.dia = diaSeleccionado;

                container.appendChild(input);

                // Añadir funcionalidad al botón eliminar
                li.querySelector('.btn-eliminar-lugar').addEventListener('click', function() {
                    li.remove(); // elimina el <li>

                    // elimina el input correspondiente
                    const inputToRemove = container.querySelector(
                        `input[data-lugar-id="${lugarId}"][data-dia="${diaSeleccionado}"]`);
                    if (inputToRemove) {
                        inputToRemove.remove();
                    }
                });
            });
        });




        const apiKey = "5b3ce3597851110001cf6248d1ee8add6423439c8b2c8d37f22305e0"; // Tu API key OpenRouteService
        const url = "https://api.openrouteservice.org/v2/directions/foot-walking/geojson";

        // Colores para días, usa tantos como días tengas o más
        const colors = ['blue', 'red', 'green', 'orange', 'purple', 'brown', 'cyan', 'magenta'];

        // Inicializar mapa solo 1 vez en variable global
        let map;
        let polylines = [];
        let markers = [];

        function initMap() {
            map = L.map("map").setView([40.4168, -3.7038], 13);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: "&copy; OpenStreetMap contributors",
            }).addTo(map);

            setTimeout(() => map.invalidateSize(), 400);

            // Ajustar mapa en acordeón abierto
            document.querySelectorAll('.accordion-button').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTimeout(() => map.invalidateSize(), 400);
                });
            });
        }

        // Borrar rutas dibujadas
        function clearMapLayers() {
            polylines.forEach(poly => map.removeLayer(poly));
            polylines = [];

            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

        // Obtener coordenadas de cada día leyendo el DOM
        function getCoordsPorDia() {
            const coordsPorDia = {};
            const dias = {{ $itinerario->dias }};

            for (let dia = 1; dia <= dias; dia++) {
                coordsPorDia[dia] = [];

                // Selector para todos los <li> con data-lat y data-lng en cada día
                const lugares = document.querySelectorAll(`#lista-lugares-dia-${dia} li`);

                lugares.forEach(li => {
                    const lat = parseFloat(li.dataset.lat);
                    const lng = parseFloat(li.dataset.lng);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        coordsPorDia[dia].push([lng, lat]); // NOTA: OpenRouteService espera [lng, lat]
                    }
                });
            }

            return coordsPorDia;
        }

        // Petición OpenRouteService para un array de coords, devuelve Promise con GeoJSON ruta
        async function fetchRoute(coords) {
            const body = {
                coordinates: coords
            };
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Authorization: apiKey,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(body),
            });
            if (!response.ok) throw new Error(`HTTP error ${response.status}`);
            return await response.json();
        }

        // Dibujar todas las rutas en el mapa con colores
async function actualizarMapa() {
    clearMapLayers();
    const coordsPorDia = getCoordsPorDia();

    let allBounds = [];

    for (const [dia, coords] of Object.entries(coordsPorDia)) {
        if (coords.length < 2) continue;

        try {
            const data = await fetchRoute(coords);
            const color = colors[(dia - 1) % colors.length];

            // Dibujar ruta
            const polyline = L.geoJSON(data, {
                style: {
                    color: color,
                    weight: 5
                },
            }).addTo(map);
            polylines.push(polyline);
            allBounds.push(polyline.getBounds());

            // Añadir marcadores para cada destino
            coords.forEach((coord, index) => {
    const latlng = [coord[1], coord[0]];

    // Crear un divIcon con número de orden dentro de círculo con contorno negro
    const markerHtml = `
        <div style="
            background-color: ${color};
            color: white;
            font-weight: bold;
            border: 2px solid black;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 1px 1px 2px black;
            font-size: 16px;
            ">
            ${index + 1}
        </div>
    `;

    const markerIcon = L.divIcon({
        className: '',
        html: markerHtml,
        iconSize: [28, 28],
        iconAnchor: [14, 28], // centra horizontalmente, ancla abajo del círculo
        popupAnchor: [0, -28]
    });

    const marker = L.marker(latlng, { icon: markerIcon }).addTo(map);
    markers.push(marker);
});

        } catch (error) {
            console.error(`Error ruta día ${dia}:`, error);
            alert(`Error obteniendo ruta para el día ${dia}. Revisa consola.`);
        }
    }

    if (allBounds.length) {
        let combinedBounds = allBounds[0];
        for (let i = 1; i < allBounds.length; i++) {
            combinedBounds = combinedBounds.extend(allBounds[i]);
        }
        map.fitBounds(combinedBounds);
    }
}

        // Inicializar mapa al cargar
        window.addEventListener("load", () => {
            initMap();

            document.getElementById('btn-guardar-itinerario').addEventListener('click', () => {
                actualizarMapa();
            });
        });
    </script>
@endpush
