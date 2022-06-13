<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>LA COLOMBE MONEY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="icon" type="text/css" href="../abt_app/public/colombelogo.jpeg">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
       <!--<h1 class="logo"><a href="{{route('route_index')}}">ABT-Colombe</a></h1>-->
       <a href="{{route('route_index')}}" class="">
        <img src="{{ URL::to('../abt_app/public/colombelogo.jpeg') }}" style=" border: 1px ;
  border-radius: 4px;
  padding: 0px;
  width:100px;"  alt="Brand Logo" class="img-fluid">
        </a>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="{{route('index')}}">Accueil</a></li>
          <li class=""><a href="{{route('apropos')}}">Apropos</a> 
          </li>
          <li><a href="{{route('service')}}">Services</a></li>
          <li><a href="{{route('contact')}}">Contact</a></li>
        </ul>
      </nav><!-- .nav-menu -->
       <!--<a href="{{route('route_index')}}" class="get-started-btn ml-auto">Connexion</a>-->
    </div>
  </header>
  @yield('content')
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>La Colombe Money</h3>
              <p>
                Mandela <br>
                N° 535022, Congo-Kinshasa<br><br>
                <strong>Tel:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Nos services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> Transfert de fonds</li>
              <li><i class="bx bx-chevron-right"></i>Reservation</li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Nos Partenaires</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>Colombe Hotel</li>
              <li><i class="bx bx-chevron-right"></i>Rawbank</li>
              <li><i class="bx bx-chevron-right"></i>Equity Bank</li>
              <li><i class="bx bx-chevron-right"></i>TMBank</li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Plus proche de vous </h4>
            <p>Besoin d'avoir plus d'information laissez nous votre Email</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Soumettre">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>La Colombe Money</span></strong>. Tout droit reservé
      </div>
      <div class="credits">
          Designed by <a href="lacolombes.com">La Colombe Money</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>