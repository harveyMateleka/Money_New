@extends('layoutAccueil.header')
@section('content')
<!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
      <div class="carousel-inner" role="listbox">
        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(assets/img/slide/slide-1.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Bienvenu(e)<span> à LA COLOMBE MONEY </span></h2>
              <p style="font-size: 30px;" class="animate__animated animate__fadeInUp">Une agence de messagerie fincanciere en R.D.Congo</p>
            </div>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url(assets/img/money2.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Transfert le plus rapide en R.D.Congo</h2>
              <p style="font-size: 30px;" class="animate__animated animate__fadeInUp">La rapidité et la fiabilite dans le transfert de fonds sont nos qualités de pouvoir mettre nos clients dans les meilleures conditions</p>
            </div>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url(assets/img/money3.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Un Transfert en toute Securité </h2>
              <p style="font-size: 30px;" class="animate__animated animate__fadeInUp">Votre argent sera bien securisé de l'expedition jusqu'à la destination</p>
            </div>
          </div>
        </div>
        <div class="carousel-item" style="background-image: url(assets/img/money4.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Nous sommes sur toute l'etendue de la R.D.Congo</h2>
              <p style="font-size: 30px;" class="animate__animated animate__fadeInUp">La colombe money vous rapproche de votre famille. Envoyez de l'argent partout en R.D.Congo.</p>
            </div>
          </div>
        </div>
        <div class="carousel-item" style="background-image: url(assets/img/money1.png)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">La colombe money proche de Vous</h2>
              <p style="font-size: 30px;" class="animate__animated animate__fadeInUp"> Un sourire vous est donné </p> 
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </section><!-- End Hero -->
  <main id="main">
    <!-- ======= About Section ======= -->
    
    <!-- ======= Clients Section ======= -->
   

    <!-- ======= Services Section ======= -->
    <!-- End Services Section -->

    <section id="clients" class="clients section-bg">
      <div class="container">
      <div class="section-title">
          <p>Nos Partenaires </p>
        </div>

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/Equity.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/Access-Bank-Logo-1.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/logoz.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
          </div>

        </div>

      </div>
    </section><!-- End Clients Section -->

    <!-- ======= Portfolio Section ======= -->
   <!-- End Portfolio Section -->

  </main><!-- End #main -->
  <hr>
  <!-- ======= Footer ======= -->
  @endsection
  