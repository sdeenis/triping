@extends('layouts.guest')

@section('title', 'Inicio')

@push('styles')
.card-img-top {
  height: 500px;       /* altura fija */
  object-fit: cover;   /* recorta para llenar el área sin deformar */
  width: 100%;         /* que ocupe todo el ancho del card */
  border: 3px solid #ddd; /* borde opcional */
    border-radius: 0.5rem; /* bordes redondeados */
}
  .carousel-inner img {
    height: 400px;
    object-fit: cover;
  }


  .carousel-caption {
    background-color: rgba(0, 0, 0, 0.7) !important; /* Más opaco */
    color: #fff; /* Asegura texto blanco */
  }

  .carousel-caption h5,
  .carousel-caption p {
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8); /* Mejor lectura sobre imágenes claras */
  }


@endpush

@section('content')
<section class="py-5 ">
    <div id="sticky-parallax-header" class="container d-flex flex-row justify-content-evenly align-items-start">
        <div class="col-md-6 pt-5">
            <p class="display-3 fw-bold mb-4">Explora <br>sin límites.</p>
            <p class="fs-4 text-muted mb-4">Elige, personaliza y viaja a tu ritmo.</p>
            <p class="fs-4 text-muted mb-4">Cada itinerario, tan único como tú.</p>
            <a href="#first" class="btn btn-primary btn-lg">Saber más</a>
        </div>
        <div class="col-md-5 pt-5">
            <img src="{{ asset('images/viajar.jpg') }}" alt="Viajar" class="img-fluid rounded shadow">
        </div>
    </div>
</section>

<section id="first" class="py-5">
    <p class="text-center fs-1 fw-bold mb-4">¿Cómo funciona?</p>
   <div class="container py-5">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100">
        <img src="{{ asset('images/paso1alt.png') }}" class="card-img-top" alt="Captura 1">
        <div class="card-body">
          <h5 class="card-title">Elige ciudad y duración</h5>
          <p class="card-text">Elige los datos iniciales de tu itinerario de entre todas las ciudades posibles.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <img src="{{ asset('images/paso2alt2.png') }}" class="card-img-top" alt="Captura 2">
        <div class="card-body">
          <h5 class="card-title">Añade los destinos a tu itinerario</h5>
          <p class="card-text">Incluye los sitios que vas a visitar en tu viaje y observa la ruta en el mapa.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <img src="{{ asset('images/paso3.png') }}" class="card-img-top" alt="Captura 3">
        <div class="card-body">
          <h5 class="card-title">Comparte tu itinerario</h5>
          <p class="card-text">Haz público tu itinerario para que lo pueda ver el resto del mundo</p>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section>
<section id="ejemplos" class="py-5">
<div class="container">
  <p class="text-center fs-1 fw-bold mb-4">Itinerarios de muestra</p>

  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <a href="#">
          <img src="{{ asset('images/ciudades/madrid.jpg') }}" class="d-block w-100" alt="Itinerario 1">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-3">
            <h5>Madrid en 3 días</h5>
            <p>Un recorrido por los sitios más emblemáticos de la capital.</p>
          </div>
        </a>
      </div>

      <div class="carousel-item">
        <a href="#">
          <img src="{{ asset('images/ciudades/barcelona.jpg') }}" class="d-block w-100" alt="Itinerario 2">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-3">
            <h5>Barcelona cultural</h5>
            <p>Arte, arquitectura y mar en un itinerario de 2 días.</p>
          </div>
        </a>
      </div>

      <div class="carousel-item">
        <a href="#">
          <img src="{{ asset('images/ciudades/málaga.jpg') }}" class="d-block w-100" alt="Itinerario 3">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-3">
            <h5>Málaga al atardecer</h5>
            <p>Rincones únicos para disfrutar del sur con encanto.</p>
          </div>
        </a>
      </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
</div>

</section>

</section>

<!-- Modal para crear itinerario -->

@endsection

@push('scripts')

@endpush
