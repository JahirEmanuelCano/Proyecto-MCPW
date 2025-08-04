<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portfolio Details - Strategy Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Strategy
  * Template URL: https://bootstrapmade.com/strategy-bootstrap-agency-template/
  * Updated: Jun 06 2025 with Bootstrap v5.3.6
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="portfolio-details-page">


  <header id="header" class="header d-flex align-items-center fixed-top">
    <div
      class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <h1 class="sitename">Construcciones Cano</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php?#hero" class="active">Inicio</a></li>
          <li><a href="index.php?#about">Nosotros</a></li>
          <li><a href="index.php?#services">Servicios</a></li>
          <li><a href="index.php?#portfolio">Proyectos</a></li>
          <li><a href="index.php?#contact">Contactanos</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="inicioSesion.php">Inicia Sesion</a>

    </div>
  </header>

    <main class="main">


        <br>
        <br>
        <?php
        include("conexion.php");

        $query = "SELECT * FROM trabajos";
        $resultado = $conexion->query($query);

        while ($fila = $resultado->fetch_assoc()) {
            $trabajo_id = $fila['id'];

            // Obtener todas las imágenes de este trabajo
            $imagenesQuery = "SELECT ruta FROM imagenes WHERE trabajo_id = $trabajo_id";
            $imagenesResultado = $conexion->query($imagenesQuery);
            ?>

            <section id="trabajo-<?= htmlspecialchars($fila['id']) ?>" class="portfolio-details section">

                <div class="container" data-aos="fade-up" data-aos-delay="100">

                    <div class="row gy-4">
                        <div class="col-lg-6" data-aos="fade-right">
                            <div class="portfolio-details-media">
                                <div class="main-image">
                                    <div class="portfolio-details-slider swiper init-swiper" data-aos="zoom-in">
                                        <script type="application/json" class="swiper-config">
                        {
                          "loop": true,
                          "speed": 1000,
                          "autoplay": {
                            "delay": 6000
                          },
                          "effect": "creative",
                          "creativeEffect": {
                            "prev": {
                              "shadow": true,
                              "translate": [0, 0, -400]
                            },
                            "next": {
                              "translate": ["100%", 0, 0]
                            }
                          },
                          "slidesPerView": 1,
                          "navigation": {
                            "nextEl": ".swiper-button-next",
                            "prevEl": ".swiper-button-prev"
                          }
                        }
                      </script>

                      
                                        <div class="swiper-wrapper">
                                            <?php while ($img = $imagenesResultado->fetch_assoc()): ?>
                                            <div class="swiper-slide">
                                                <img src="<?= htmlspecialchars($img['ruta']) ?>"
                                                    alt="Portfolio Image" class="img-fluid">
                                            </div>
                                           <?php endwhile; ?>
                                        </div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>


                                <div class="thumbnail-grid" data-aos="fade-up" data-aos-delay="200">
                                    <div class="row g-2 mt-3">

                                    </div>
                                </div>
                                <!---->
                                <div class="tech-stack-badges" data-aos="fade-up" data-aos-delay="300">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6" data-aos="fade-left">
                            <div class="portfolio-details-content">
                                <div class="project-meta">
                                    <div class="badge-wrapper">
                                        <span class="project-badge"><?= htmlspecialchars($fila['categoria']) ?></span>
                                    </div>
                                    <div class="date-client">
                                        <div class="meta-item">
                                            <i class="bi bi-calendar-check"></i>
                                            <span><?= htmlspecialchars($fila['fecha']) ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="bi bi-buildings"></i>
                                            <span>Construcciones Cano</span>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="project-title"><?= htmlspecialchars($fila['titulo']) ?></h2>

                                <div class="project-overview">
                                    <p class="lead">
                                        <?= htmlspecialchars($fila['descripcion']) ?>
                                    </p>



                                    <div class="accordion project-accordion"
                                        id="portfolio-details-projectAccordion-<?= $fila['id'] ?>">
                                        <div class="accordion-item" data-aos="fade-up">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#portfolio-details-collapse-1-<?= $fila['id'] ?>"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="bi bi-clipboard-data me-2"></i> Project Overview
                                                </button>
                                            </h2>
                                            <div id="portfolio-details-collapse-1-<?= $fila['id'] ?>"
                                                class="accordion-collapse collapse show"
                                                data-bs-parent="#portfolio-details-projectAccordion-<?= $fila['id'] ?>">
                                                <div class="accordion-body">
                                                    <p><?= htmlspecialchars($fila['overview']) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#portfolio-details-collapse-2-<?= $fila['id'] ?>"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <i class="bi bi-exclamation-diamond me-2"></i> The Challenge
                                                </button>
                                            </h2>
                                            <div id="portfolio-details-collapse-2-<?= $fila['id'] ?>"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#portfolio-details-projectAccordion-<?= $fila['id'] ?>">
                                                <div class="accordion-body">
                                                    <p><?= htmlspecialchars($fila['reto']) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#portfolio-details-collapse-3-<?= $fila['id'] ?>"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <i class="bi bi-award me-2"></i> The Solution
                                                </button>
                                            </h2>
                                            <div id="portfolio-details-collapse-3-<?= $fila['id'] ?>"
                                                class="accordion-collapse collapse"
                                                data-bs-parent="#portfolio-details-projectAccordion-<?= $fila['id'] ?>">
                                                <div class="accordion-body">
                                                    <p><?= htmlspecialchars($fila['solucion']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section><!-- /Portfolio Details Section -->
        <?php } ?>

    </main>


    <footer id="footer" class="footer">

      <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Construcciones Cano</span>
          </a>
          <p>texto faltante</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Links</h4>
          <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Proyectos</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Nuestros Servicios</h4>
          <ul>
            <li><a href="#">Remodelaciones</a></li>
            <li><a href="#">Instalaciones Electricas</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contactanos</h4>
          <p>La Ceiba, Atlantida</p>
          <p>Honduras</p>
          <p class="mt-4"><strong>Telefono:</strong> <span>+504 3179-9572</span></p>
          <p><strong>Correo Electronico:</strong> <span>jahircano076@gmail.com</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Construcciones Cano</strong> <span>All Rights
          Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
      </div>
    </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>