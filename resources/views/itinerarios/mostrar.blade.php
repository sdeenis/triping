@extends('layouts.guest')

@section('title', $itinerario->titulo)

@section('content')

<section id="datos" class="d-flex flex-column align-items-center mt-5">
    <div class="w-75 bg-white rounded-3 shadow border border-secondary p-4" style="transition: box-shadow 0.3s;">
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold text-dark mb-2">{{ $itinerario->titulo }}</h1>
            <p class="fs-5 text-secondary fw-medium mb-3">
                {{ $itinerario->ciudad->nombre }} &middot; {{ $itinerario->dias }} días
            </p>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('images/ciudades/' . strtolower($itinerario->ciudad->nombre) . '.jpg') }}"
                alt="Imagen de {{ strtolower($itinerario->ciudad->nombre) }}"
                class="rounded-3 shadow-sm w-100" style="max-height: 320px; object-fit: cover;">
        </div>

        <p class="text-end text-muted small mb-4">
            {{ $itinerario->created_at->format('d/m/Y') }} | Creado por: <span class="fw-semibold text-dark">{{ $itinerario->usuario->name }}</span>
        </p>

        <div class="accordion" id="accordionItinerario">
            @for ($dia = 1; $dia <= $itinerario->dias; $dia++)
                @php
                $lugaresDia = $itinerario->lugares->filter(fn($lugar) => $lugar->pivot->dia == $dia);
                @endphp

                <div class="accordion-item border-bottom border-secondary">
                    <h2 class="accordion-header" id="heading-{{ $dia }}">
                        <button class="accordion-button collapsed fw-semibold text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $dia }}" aria-expanded="false" aria-controls="collapse-{{ $dia }}">
                            Día {{ $dia }}
                        </button>
                    </h2>
                    <div id="collapse-{{ $dia }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $dia }}" data-bs-parent="#accordionItinerario">
                        <div class="accordion-body px-4 pb-3">
                            @if ($lugaresDia->isEmpty())
                            <p class="fst-italic text-secondary">No hay lugares asignados para este día.</p>
                            @else
                            <ul id="lista-lugares-dia-{{ $dia }}" class="list-unstyled mb-0">
                                @foreach ($lugaresDia as $lugar)
                                <li class="mb-3" data-lat="{{ $lugar->latitud }}" data-lng="{{ $lugar->longitud }}">
                                    <strong class="text-dark">{{ $lugar->nombre }}</strong><br>
                                    <span class="text-muted small">{{ $lugar->categoria }}</span><br>
                                    <span class="text-muted smaller">{{ $lugar->direccion }}</span>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

   <section id="mapa" class="d-flex flex-column align-items-center mt-4">
        <div id="map"
            style="height: 400px; width: 75%; margin: 0 auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        </div>
        <div id="map-legend" class="mt-3 w-75 d-flex flex-wrap justify-content-center gap-3"></div>
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

    function generarLeyenda() {
    const legendContainer = document.getElementById("map-legend");
    const dias = {{ $itinerario->dias }};

    for (let dia = 1; dia <= dias; dia++) {
        const color = colors[(dia - 1) % colors.length];
        const legendItem = document.createElement("div");
        legendItem.classList.add("d-flex", "align-items-center", "gap-2");

        legendItem.innerHTML = `
            <span style="
                display: inline-block;
                width: 20px;
                height: 20px;
                border-radius: 4px;
                background-color: ${color};
                border: 1px solid #000;
            "></span>
            <span class="text-secondary small" style="font-style: italic;">Día ${dia}</span>
        `;
        legendContainer.appendChild(legendItem);
    }
}
    const apiKey = "5b3ce3597851110001cf6248d1ee8add6423439c8b2c8d37f22305e0"; // Tu API key OpenRouteService
    const url = "https://api.openrouteservice.org/v2/directions/foot-walking/geojson";

    // Colores para días, usa tantos como días tengas o más
    const colors = ['blue', 'red', 'green', 'orange', 'purple', 'brown', 'cyan', 'magenta'];

    // Inicializar mapa solo 1 vez en variable global
    let map;
    let polylines = [];
    let markers = [];

    function initMap() {
        const ciudadLat = {{ $itinerario->ciudad->latitud }};
        const ciudadLng = {{ $itinerario->ciudad->longitud }};
        map = L.map("map").setView([ciudadLat, ciudadLng], 13);

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
                    console.log(`Día ${dia}: lat=${li.dataset.lat}, lng=${li.dataset.lng}`);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        coordsPorDia[dia].push([lng, lat]); // NOTA: OpenRouteService espera [lng, lat]
                    }
                });
            }
            console.log("Coordenadas por día:", coordsPorDia);

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


        function clearMapLayers() {
    polylines.forEach(polyline => map.removeLayer(polyline));
    polylines = [];

    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
}
        // Dibujar todas las rutas en el mapa con colores
async function actualizarMapa() {
    clearMapLayers();
    const coordsPorDia = getCoordsPorDia();

    let allBounds = [];

    for (const [dia, coords] of Object.entries(coordsPorDia)) {
        const color = colors[(dia - 1) % colors.length];
                if (coords.length === 1) {
            // Solo un punto: crear marcador con color correspondiente
            const coord = coords[0];
            const latlng = [coord[1], coord[0]];

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
                    1
                </div>
            `;

            const markerIcon = L.divIcon({
                className: '',
                html: markerHtml,
                iconSize: [28, 28],
                iconAnchor: [14, 28],
                popupAnchor: [0, -28]
            });

            const marker = L.marker(latlng, { icon: markerIcon }).addTo(map);
            markers.push(marker);

            // Ajustar vista para que muestre ese punto
            const bounds = L.latLngBounds(latlng, latlng);
            allBounds.push(bounds);

            continue; // saltar al siguiente día
        }

        try {
            const data = await fetchRoute(coords);
            

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

            actualizarMapa()
            generarLeyenda()
        });
    </script>

@endpush