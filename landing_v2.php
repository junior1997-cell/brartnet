<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light">

<head>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Inicio | Corporación Brartnet </title>
  <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
  <meta name="Author" content="Spruko Technologies Private Limited">

  <!-- Favicon -->
  <link rel="icon" href="assets/images/brand-logos/ico-brartnet.svg" type="image/x-icon">

  <!-- Bootstrap Css -->
  <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Style Css -->
  <link href="assets/css/styles.css" rel="stylesheet">

  <!-- Icons Css -->
  <link href="assets/css/icons.css" rel="stylesheet">

  <!-- Node Waves Css -->
  <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet">

  <!-- SwiperJS Css -->
  <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">

  <!-- Color Picker Css -->
  <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
  <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">

  <!-- Choices Css -->
  <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">

  <script>
    if (localStorage.ynexlandingdarktheme) {
      document.querySelector("html").setAttribute("data-theme-mode", "dark")
    }
    if (localStorage.ynexlandingrtl) {
      document.querySelector("html").setAttribute("dir", "rtl")
      document.querySelector("#style")?.setAttribute("href", "assets/libs/bootstrap/css/bootstrap.rtl.min.css");
    }
  </script>


</head>

<body class="landing-body">

  <!-- Start Switcher -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Configuración de diseño</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="">
        <p class="switcher-style-head">Modo de color del tema:</p>
        <div class="row switcher-style">
          <div class="col-4">
            <div class="form-check switch-select">
              <label class="form-check-label" for="switcher-light-theme">
                Light
              </label>
              <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme" checked>
            </div>
          </div>
          <div class="col-4">
            <div class="form-check switch-select">
              <label class="form-check-label" for="switcher-dark-theme">
                Dark
              </label>
              <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
            </div>
          </div>
        </div>
      </div>
      <div class="">
        <p class="switcher-style-head">Direcciones:</p>
        <div class="row switcher-style">
          <div class="col-4">
            <div class="form-check switch-select">
              <label class="form-check-label" for="switcher-ltr">
                LTR
              </label>
              <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
            </div>
          </div>
          <div class="col-4">
            <div class="form-check switch-select">
              <label class="form-check-label" for="switcher-rtl">
                RTL
              </label>
              <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
            </div>
          </div>
        </div>
      </div>
      <div class="theme-colors">
        <p class="switcher-style-head">Tema Primario:</p>
        <div class="d-flex align-items-center switcher-style">
          <div class="form-check switch-select me-3">
            <input class="form-check-input color-input color-primary-1" type="radio" name="theme-primary" id="switcher-primary">
          </div>
          <div class="form-check switch-select me-3">
            <input class="form-check-input color-input color-primary-2" type="radio" name="theme-primary" id="switcher-primary1">
          </div>
          <div class="form-check switch-select me-3">
            <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary" id="switcher-primary2">
          </div>
          <div class="form-check switch-select me-3">
            <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary" id="switcher-primary3">
          </div>
          <div class="form-check switch-select me-3">
            <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary" id="switcher-primary4">
          </div>
          <div class="form-check switch-select me-3 ps-0 mt-1 color-primary-light">
            <div class="theme-container-primary"></div>
            <div class="pickr-container-primary"></div>
          </div>
        </div>
      </div>
      <div>
        <p class="switcher-style-head">Reiniciar:</p>
        <div class="text-center">
          <button id="reset-all" class="btn btn-danger mt-3">Restablecer</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Switcher -->

  <div class="landing-page-wrapper">

    <!-- app-header -->
    <header class="app-header">

      <!-- Start::main-header-container -->
      <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

          <!-- Start::header-element -->
          <div class="header-element">
            <div class="horizontal-logo">
              <a href="index.html" class="header-logo">
                <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
              </a>
            </div>
          </div>
          <!-- End::header-element -->

          <!-- Start::header-element -->
          <div class="header-element">
            <!-- Start::header-link -->
            <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
              <span class="open-toggle">
                <i class="ri-menu-3-line fs-20"></i>
              </span>
            </a>
            <!-- End::header-link -->
          </div>
          <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">

          <!-- Start::header-element -->
          <div class="header-element align-items-center">
            <!-- Start::header-link|switcher-icon -->
            <div class="btn-list d-lg-none d-block">
              <a href="https://api.whatsapp.com/send?phone=+51918740074&text=*Hola buenos dias, vengo de tu pagina web!!*" class="btn btn-primary-light"> <i class="ti ti-brand-whatsapp"></i> Contactanos</a>
              <button class="btn btn-icon btn-success switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                <i class="ri-settings-3-line"></i>
              </button>
            </div>
            <!-- End::header-link|switcher-icon -->
          </div>
          <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->

      </div>
      <!-- End::main-header-container -->

    </header>
    <!-- /app-header -->

    <!-- Start::app-sidebar -->
    <aside class="app-sidebar sticky" id="sidebar">

      <div class="container-xl">
        <!-- Start::main-sidebar -->
        <div class="main-sidebar">

          <!-- Start::nav -->
          <nav class="main-menu-container nav nav-pills sub-open">
            <div class="landing-logo-container">
              <div class="horizontal-logo">
                <a href="index.html" class="header-logo">
                  <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                  <img src="assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                </a>
              </div>
            </div>
            <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
              </svg></div>
            <ul class="main-menu">
              <!-- Start::slide -->
              <li class="slide">
                <a class="side-menu__item" href="#home">
                  <span class="side-menu__label">Inicio</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#about" class="side-menu__item">
                  <span class="side-menu__label">Nosotros</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#testimonials" class="side-menu__item">
                  <span class="side-menu__label">Clientes</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#team" class="side-menu__item">
                  <span class="side-menu__label">Equipo</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#pricing" class="side-menu__item">
                  <span class="side-menu__label">Precios</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#faq" class="side-menu__item">
                  <span class="side-menu__label">Faq's</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="#contact" class="side-menu__item">
                  <span class="side-menu__label">Contacto</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                  <span class="side-menu__label me-2">Más</span>
                  <i class="fe fe-chevron-right side-menu__angle op-8"></i>
                </a>
                <ul class="slide-menu child1">
                  <li class="slide">
                    <a href="#statistics" class="side-menu__item">Ver Pagos</a>
                  </li>
                  <li class="slide">
                    <a href="#our-mission" class="side-menu__item">Cotizar Precios</a>
                  </li>
                  <li class="slide">
                    <a href="#features" class="side-menu__item">Cobertura</a>
                  </li>
                  <li class="slide">
                    <a href="#testimonials" class="side-menu__item">Testimonios</a>
                  </li>                  
                </ul>
              </li>
              <!-- End::slide -->

            </ul>
            <div class="slide-right" id="slide-right">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
              </svg>
            </div>
            <div class="d-lg-flex d-none">
              <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                <a href="https://api.whatsapp.com/send?phone=+51918740074&text=*Hola buenos dias, vengo de tu pagina web!!*" class="btn btn-wave btn-primary"><i class="ti ti-brand-whatsapp"></i> Contactanos</a>
                <button class="btn btn-wave btn-icon btn-light switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                  <i class="ri-settings-3-line"></i>
                </button>
              </div>
            </div>
          </nav>
          <!-- End::nav -->

        </div>
        <!-- End::main-sidebar -->
      </div>

    </aside>
    <!-- End::app-sidebar -->

    <!-- Start::app-content -->
    <div class="main-content landing-main px-0">

      <!-- Start:: Section-1 -->
      <div class="landing-banner" id="home">
        <section class="section">
          <div class="container main-banner-container pb-lg-0">
            <div class="row">
              <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                <div class="py-lg-5">
                  <div class="mb-3">
                    <h5 class="fw-semibold text-fixed-white op-9">Únete a nosotros ahora</h5>
                  </div>
                  <p class="landing-banner-heading mb-3">Conexión rápida, navegación sin límites. <span class="text-secondary">Brartnet !</span></p>
                  <div class="fs-16 mb-5 text-fixed-white op-7">Brartnet - Conéctate con el mundo sin límites, con nuestra velocidad y fiabilidad. ¡Descubre un nuevo nivel de navegación con nosotros!</div>
                  <a href="https://api.whatsapp.com/send?phone=+51918740074&text=*Hola buenos dias, vengo de tu pagina web!!*" class="m-1 btn btn-primary"> 
                    Contactanos <i class="ti ti-brand-whatsapp ms-2 align-middle"></i> 
                  </a>
                </div>
              </div>
              <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
                <div class="text-end landing-main-image landing-heading-img">
                  <img src="assets/images/media/landing/1.png" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- End:: Section-1 -->

      <!-- Start:: Section-2 -->
      <section class="section section-bg " id="statistics">
        <div class="container text-center position-relative">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">OFERTAS</span></p>
          <h3 class="fw-semibold mb-2">Más de 500+ usuarios conectados.</h3>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-muted fs-15 mb-5 fw-normal">Estamos orgullosos de tener clientes y clientes de primera clase, lo que nos motiva a trabajar más.</p>
            </div>
          </div>
          <div class="row  g-2 justify-content-center d-flex align-items-stretch">
            <div class="col-xl-12">
              <div class="row d-flex justify-content-evenly">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3 ">
                  <div class="p-3 text-center bg-white border border-2 rounded-4 h-100">
                    <h1 class="fw-semibold mb-0 text-primary">INTERNET 100% FIBRA ÓPTICA</h1>
                    <p class="mb-1 fs-22 mt-4"><b>100 MBPS</b></p>
                    <p class="mb-1 fs-20">x 6 meses con pago puntual</p>
                    <p class="mb-1 fs-20"><s>Plan a S/ 64</s></p>
                    <h4><b>S/ 60</b></h4>
                    <button type="button" class="btn btn-primary rounded-pill btn-wave mt-4">Me Interesa</button>
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3 ">
                  <div class="p-3 text-center bg-white border border-2 rounded-4 h-100">
                    <h1 class="fw-semibold mb-0 text-primary">INTERNET 100% FIBRA ÓPTICA</h1>
                    <p class="mb-1 fs-22 mt-4"><b>200 MBPS</b></p>
                    <p class="mb-1 fs-20 ">x 6 meses con pago puntual</p>
                    <p class="mb-1 fs-20"><s>Plan a S/ 80</s></p>
                    <h4><b>S/ 70</b></h4>
                      <button type="button" class="btn btn-primary rounded-pill btn-wave mt-4">Me Interesa</button>
                  
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3 ">
                  <div class="p-3 text-center bg-white border border-2 rounded-4 h-100">
                    <h1 class="fw-semibold mb-0 text-primary">INTERNET 100% FIBRA ÓPTICA</h1>
                    <p class="mb-1 fs-20 mt-4"><s>400 MBPS</s></p>
                    <p class="mb-1 fs-22"><b>500 MBPS</b></p>
                    <p class="mb-1 fs-20">x 6 meses con pago puntual</p>
                    <p class="mb-1 fs-20"><s>Plan a S/ 120</s></p>
                    <h4><b>S/ 100</b></h4>
                    <div class="align-self-end">
                      <button type="button" class="btn btn-primary rounded-pill btn-wave mt-4">Me Interesa</button>
                    </div>
                    
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-2 -->

      <!-- Start:: Section-3 -->
      <section class="section " id="about">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">BENEFICIOS</span></p>
          <h2 class="fw-semibold mb-2">INTERNET PARA TODOS</h2>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-muted fs-15 mb-3 fw-normal">Conectando comunidades, compartiendo conocimiento y creando oportunidades para todos, Internet es el puente hacia un futuro más brillante y equitativo para cada persona en el planeta.</p>
            </div>
          </div>
          <div class="row justify-content-between align-items-center mx-0">
            <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
              <div class="text-lg-end">
              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="0" class="active" aria-current="true"
              aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
          <div class="carousel-item active">
              <img src="assets/images/media/landing/3.png" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
              <img src="assets/images/media/landing/2.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
              <img src="assets/images/media/landing/1.png" class="d-block w-100" alt="...">
          </div>
      </div>
      <button class="carousel-control-prev" type="button"
          data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button"
          data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </button>
  </div>
              </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 pt-5 pb-0 px-lg-2 px-5 text-start">
              <h5 class="text-lg-start fw-semibold mb-0">Descubre los Beneficios de Nuestro Servicio de Internet</h5>
              <br/>
              <div class="row">
                <div class="col-12 col-md-12">
                  <div class="d-flex">
                    <span>
                      <i class='bx bxs-badge-check text-primary fs-18'></i>
                    </span>
                    <div class="ms-2">
                      <h6 class="fw-semibold mb-0">Velocidades de descarga y carga ultrarrápidas</h6>
                      <p class=" text-muted">Nuestro servicio ofrece velocidades de internet ultrarrápidas que te permitirán descargar y cargar archivos grandes en cuestión de segundos.</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12">
                  <div class="d-flex">
                    <span>
                      <i class='bx bxs-badge-check text-primary fs-18'></i>
                    </span>
                    <div class="ms-2">
                      <h6 class="fw-semibold mb-0">Conexión estable y confiable</h6>
                      <p class=" text-muted">Nuestra red de internet está diseñada para ofrecer una conexión estable y confiable en todo momento. Esto significa que podrás disfrutar de una conexión sin cortes.</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12">
                  <div class="d-flex">
                    <span>
                      <i class='bx bxs-badge-check text-primary fs-18'></i>
                    </span>
                    <div class="ms-2">
                      <h6 class="fw-semibold mb-0">Atención al cliente excepcional</h6>
                      <p class=" text-muted">Nuestro equipo de atención al cliente está siempre disponible para ayudarte con cualquier consulta o problema que puedas tener.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-3 -->

      <!-- Start:: Section-4 -->
      <section class="section section-bg " id="our-mission">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">COBERTURA</span></p>
          <h2 class="fw-semibold mb-2">Cobertura en más de 8 ciudades del Perú</h2>
          <br/>
          <div class="row">

            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card custom-card overlay-card">
                <img src="assets/images/media/demo-tocache.jpg" class="card-img" alt="..." >
                <div class="card-img-overlay p-0 d-flex justify-content-center align-items-center" >
                  <div class="card-body">
                    <div class="card-text">
                      <h1 class="text-white"><b>TOCACHE</b></h1>
                      <p class="text-white"><b>Este - Suroeste</b></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card custom-card overlay-card">
                <img src="assets/images/media/demo-tarapoto.jpg" class="card-img" alt="...">
                <div class="card-img-overlay p-0 d-flex justify-content-center align-items-center">
                  <div class="card-body">
                    <div class="card-text">
                      <h1 class="text-white"><b>TARAPOTO</b></h1>
                      <p class="text-white"><b>De centro a Sur</b></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card custom-card overlay-card">
                <img src="assets/images/media/demo-lamas.jpg" class="card-img" alt="..." style="height: 100;">
                <div class="card-img-overlay p-0 d-flex justify-content-center align-items-center">
                  <div class="card-body">
                    <div class="card-text">
                      <h1 class="text-white"><b>LAMAS</b></h1>
                      <p class="text-white"><b>De centro a Sur</b></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card custom-card overlay-card">
                <img src="assets/images/media/demo-moyo.jpg" class="card-img" alt="..." style="height: 100;">
                <div class="card-img-overlay p-0 d-flex justify-content-center align-items-center">
                  <div class="card-body">
                    <div class="card-text">
                      <h1 class="text-white"><b>MOYOBAMBA</b></h1>
                      <p class="text-white"><b>De centro a Sur</b></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
      <!-- End:: Section-4 -->

      <!-- Start:: Section-5 -->
      <section class="section landing-Features" id="features">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">TIPO DE SERVICIO</span></p>
          <h2 class="fw-semibold mb-2 text-fixed-white ">PLANES DISPONIBLES SOLO PARA TI</h2>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-fixed-white op-8 fs-15 mb-3 fw-normal">Elije el plan de internet que deseas adquirir </p>
            </div>
          </div>
            <div class="row d-flex justify-content-evenly mt-3">
              <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="p-3 text-center rounded-4 bg-secondary">
                  <div class="btn btn-secondary">
                    <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                      <i class="las la-user-tie la-2x"></i>
                    </span>
                    <h5 class="fw-semibold mb-0 text-dark">INTERNET BASICO</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="p-3 text-center rounded-4 bg-secondary">
                  <div class="btn btn-secondary">
                    <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                      <i class="las la-home la-2x"></i>
                    </span>
                    <h5 class="fw-semibold mb-0 text-dark">INTERNET HOGAR</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                <div class="p-3 text-center rounded-4 bg-secondary">
                  <div class="btn btn-secondary">
                    <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                      <i class="las la-building la-2x"></i>
                    </span>
                    <h5 class="fw-semibold mb-0 text-dark">INTERNET EMPRESA</h5>
                  </div>
                </div>
              </div>
            </div>
          
        </div>
      </section>
      <!-- End:: Section-5 -->

      <!-- Start:: Section-6 -->
      <section class="section landing-testimonials section-bg" id="testimonials">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">TESTIMONIOS</span></p>
          <h3 class="fw-semibold mb-2">Jamás dejamos de cumplir las expectativas.</h3>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-muted fs-15 mb-5 fw-normal">Algunas de las reseñas que nuestros clientes dieron, las cuales nos motivan a trabajar en futuros proyectos.</p>
            </div>
          </div>
          <div class="swiper pagination-dynamic text-start">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/15.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Json Taylor</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Estudiante</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">¡Increíble! Desde que contraté el servicio de Internet de BrartNet, mi experiencia en línea ha sido impecable.</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-half-fill"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>hace 12 meses</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Json Taylor</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/4.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Melissa Blue</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Empresaria</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">Estoy impresionado con la calidad del servicio al cliente de BrartNet. Cada vez que he necesitado ayuda o asistencia técnica.</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-half-fill"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>hace 7 días</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Melissa Blue</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/2.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Kiara Advain</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Emprendedora</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">BrartNet ha superado mis expectativas en todos los aspectos. La instalación fue rápida y sencilla.</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-line"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>Hace 2 meses</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Kiara Advain</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/10.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Jhonson Smith</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Dueño de Restaurante</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">Me cambié a BrartNet hace unos meses y no podría estar más feliz con mi decisión. La velocidad de carga y descarga es impresionante.</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-half-fill"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>Hace 12 horas</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Jhonson Smith</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/12.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Dwayne Stort</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Universitario</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">He sido cliente de BrartNet durante más de un año, y hasta el día de hoy, no he tenido ni un solo problema con mi conexión a Internet.</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-line"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>Hace 10 memanas</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Dwayne Stort</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card testimonial-card">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span class="avatar avatar-md avatar-rounded me-3">
                        <img src="assets/images/faces/3.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-14">Jasmine Kova</p>
                        <p class="mb-0 fs-10 fw-semibold text-muted">Manager de ventas</p>
                      </div>
                    </div>
                    <div class="mb-3">
                      <span class="text-muted">BrartNet es simplemente fenomenal. La velocidad, la confiabilidad y el servicio al cliente son incomparables. </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="text-muted">Puntuación : </span>
                        <span class="text-warning d-block ms-1">
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-fill"></i>
                          <i class="ri-star-half-fill"></i>
                        </span>
                      </div>
                      <div class="float-end fs-12 fw-semibold text-muted text-end">
                        <span>Hace 1 año</span>
                        <span class="d-block fw-normal fs-12 text-success"><i>Jasmine Kova</i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-pagination mt-4"></div>
          </div>
        </div>
      </section>
      <!-- End:: Section-6 -->

      <!-- Start:: Section-7 -->
      <section class="section  section-bg" id="team">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">NUESTRO EQUIPO</span></p>
          <h3 class="fw-semibold mb-2">Grandes cosas en los negocios se hacen en equipo</h3>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-muted fs-15 mb-5 fw-normal">Nuestro equipo está compuesto por empleados altamente calificados que trabajan arduamente para ofrecer un servicio de calidad y excelencia.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card custom-card text-center team-card ">
                <div class="card-body p-5">
                  <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                    <img src="assets/images/faces/15.jpg" alt="">
                  </span>
                  <p class="fw-semibold fs-17 mb-0 text-default">Peter Parker</p>
                  <span class="text-muted fs-14 text-primary fw-semibold">Director</span>
                  <p class="text-muted mt-2 fs-13"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  <div class="mt-2">
                    <a href="profile.html" class="btn btn-light" target="_blank">Ver Portafolio</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card custom-card text-center team-card ">
                <div class="card-body p-5">
                  <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                    <img src="assets/images/faces/12.jpg" alt="">
                  </span>
                  <p class="fw-semibold fs-17 mb-0 text-default">Andre garfield</p>
                  <span class="text-muted fs-14 text-primary fw-semibold">Manager</span>
                  <p class="text-muted mt-2 fs-13"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  <div class="mt-2">
                    <a href="profile.html" class="btn btn-light" target="_blank">Ver Portafolio</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card custom-card text-center team-card ">
                <div class="card-body p-5">
                  <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                    <img src="assets/images/faces/5.jpg" alt="">
                  </span>
                  <p class="fw-semibold fs-17 mb-0 text-default">Lisa Taylor</p>
                  <span class="text-muted fs-14 text-primary fw-semibold">Recepcionista</span>
                  <p class="text-muted mt-2 fs-13"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  <div class="mt-2">
                    <a href="profile.html" class="btn btn-light" target="_blank">Ver Portafolio</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card custom-card text-center team-card ">
                <div class="card-body p-5">
                  <span class="avatar avatar-xxl avatar-rounded mb-3 team-avatar">
                    <img src="assets/images/faces/1.jpg" alt="">
                  </span>
                  <p class="fw-semibold fs-17 mb-0 text-default">Elizabeth Rose</p>
                  <span class="text-muted fs-14 text-primary fw-semibold">Ing Redes</span>
                  <p class="text-muted mt-2 fs-13"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  <div class="mt-2">
                    <a href="profile.html" class="btn btn-light" target="_blank">Ver Portafolio</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-7 -->

      <!-- Start:: Section-9 -->
      <section class="section section-bg" id="faq">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">PREGUNTAS</span></p>
          <h3 class="fw-semibold mb-2">Preguntas frecuentes</h3>
          <div class="row justify-content-center">
            <div class="col-xl-7">
              <p class="text-muted fs-15 mb-5 fw-normal">Hemos compartido algunas de las preguntas más frecuentes para ayudarle.</p>
            </div>
          </div>
          <div class="row text-start">
            <div class="col-xl-12">
              <div class="row gy-2">
                <div class="col-xl-6">
                  <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate" id="accordionFAQ1">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon1One">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1One" aria-expanded="true" aria-controls="collapsecustomicon1One">
                          ¿Qué tipos de conexiones de Internet están disponibles en San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon1One" class="accordion-collapse collapse show" aria-labelledby="headingcustomicon1One" data-bs-parent="#accordionFAQ1">
                        <div class="accordion-body">
                          En San Martín, puedes encontrar principalmente conexiones de Internet por fibra óptica, DSL (línea de abonado digital) y conexión inalámbrica (Wi-Fi) a través de proveedores locales.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon1Two">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Two" aria-expanded="false" aria-controls="collapsecustomicon1Two">
                          ¿Cuál es la velocidad promedio de Internet en la región?
                        </button>
                      </h2>
                      <div id="collapsecustomicon1Two" class="accordion-collapse collapse" aria-labelledby="headingcustomicon1Two" data-bs-parent="#accordionFAQ1">
                        <div class="accordion-body">
                        La velocidad promedio puede variar según la ubicación exacta y el proveedor, pero muchas áreas tienen acceso a velocidades que van desde 10 Mbps hasta 100 Mbps, e incluso más en algunas zonas urbanas.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon1Three">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Three" aria-expanded="false" aria-controls="collapsecustomicon1Three">
                          ¿Qué proveedores de Internet operan en San Martín y cuál es el mejor?
                        </button>
                      </h2>
                      <div id="collapsecustomicon1Three" class="accordion-collapse collapse" aria-labelledby="headingcustomicon1Three" data-bs-parent="#accordionFAQ1">
                        <div class="accordion-body">
                          Algunos de los proveedores de Internet más comunes en San Martín incluyen Movistar, Claro, y proveedores locales como Celerity Net. La elección del mejor proveedor depende de tus necesidades específicas de velocidad, confiabilidad y servicio al cliente.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon1Four">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Four" aria-expanded="false" aria-controls="collapsecustomicon1Four">
                          ¿Cuál es el costo promedio del servicio de Internet en San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon1Four" class="accordion-collapse collapse" aria-labelledby="headingcustomicon1Four" data-bs-parent="#accordionFAQ1">
                        <div class="accordion-body">
                          Los costos pueden variar según el proveedor y el plan seleccionado, pero en promedio, los paquetes de Internet suelen oscilar entre S/ 60 y S/ 150 al mes, dependiendo de la velocidad y los servicios adicionales incluidos.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon1Five">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Five" aria-expanded="false" aria-controls="collapsecustomicon1Five">
                          ¿Cómo puedo mejorar la velocidad de mi conexión a Internet?
                        </button>
                      </h2>
                      <div id="collapsecustomicon1Five" class="accordion-collapse collapse" aria-labelledby="headingcustomicon1Five" data-bs-parent="#accordionFAQ1">
                        <div class="accordion-body">
                        Algunas formas de mejorar la velocidad incluyen actualizar tu plan a uno con mayor velocidad, optimizar la configuración de tu red Wi-Fi, y asegurarte de que tu equipo esté libre de malware y programas no deseados que puedan afectar el rendimiento.
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="col-xl-6">
                  <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate" id="accordionFAQ2">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon2Five">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Five" aria-expanded="false" aria-controls="collapsecustomicon2Five">
                          ¿Qué debo hacer si experimento interrupciones frecuentes en mi conexión a Internet?
                        </button>
                      </h2>
                      <div id="collapsecustomicon2Five" class="accordion-collapse collapse" aria-labelledby="headingcustomicon2Five" data-bs-parent="#accordionFAQ2">
                        <div class="accordion-body">
                          Si experimentas interrupciones frecuentes, lo mejor es comunicarte con tu proveedor de servicios de Internet para informarles sobre el problema. Pueden realizar diagnósticos remotos o enviar técnicos para solucionar cualquier problema de conectividad.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon2Six">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Six" aria-expanded="false" aria-controls="collapsecustomicon2Six">
                          ¿Se ofrecen servicios de Internet para empresas en San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon2Six" class="accordion-collapse collapse" aria-labelledby="headingcustomicon2Six" data-bs-parent="#accordionFAQ2">
                        <div class="accordion-body">
                        Sí, varios proveedores ofrecen servicios de Internet específicamente diseñados para empresas en San Martín. Estos servicios suelen incluir velocidades más altas, opciones de seguridad avanzadas y soporte técnico especializado.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon2One">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2One" aria-expanded="true" aria-controls="collapsecustomicon2One">
                          ¿Cuál es la disponibilidad de cobertura de Internet en áreas rurales de San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon2One" class="accordion-collapse collapse " aria-labelledby="headingcustomicon2One" data-bs-parent="#accordionFAQ2">
                        <div class="accordion-body">
                          La disponibilidad de cobertura puede ser limitada en algunas áreas rurales de San Martín, pero muchos proveedores están expandiendo gradualmente su infraestructura para llegar a más comunidades. Se recomienda consultar con los proveedores locales para conocer la disponibilidad en áreas específicas.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon2Two">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Two" aria-expanded="false" aria-controls="collapsecustomicon2Two">
                          ¿Se requiere un contrato a largo plazo para obtener servicio de Internet en San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon2Two" class="accordion-collapse collapse" aria-labelledby="headingcustomicon2Two" data-bs-parent="#accordionFAQ2">
                        <div class="accordion-body">
                          Algunos proveedores pueden requerir contratos a largo plazo, mientras que otros ofrecen opciones más flexibles, como planes mensuales o anuales. Es importante revisar los términos y condiciones del contrato antes de comprometerse con un proveedor específico.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingcustomicon2Three">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Three" aria-expanded="false" aria-controls="collapsecustomicon2Three">
                          ¿Qué medidas de seguridad se ofrecen con el servicio de Internet en San Martín?
                        </button>
                      </h2>
                      <div id="collapsecustomicon2Three" class="accordion-collapse collapse" aria-labelledby="headingcustomicon2Three" data-bs-parent="#accordionFAQ2">
                        <div class="accordion-body">
                        Muchos proveedores ofrecen medidas básicas de seguridad, como firewalls y antivirus, junto con la opción de agregar servicios de seguridad adicionales, como protección contra ataques DDoS y filtrado de contenido, según sea necesario.
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-9 -->

      <!-- Start:: Section-10 -->
      <section class="section" id="contact">
        <div class="container text-center">
          <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">CONTÁCTENOS</span></p>
          <h3 class="fw-semibold mb-2">Tiene alguna pregunta ? Nos encantaría saber de usted.</h3>
          <div class="row justify-content-center">
            <div class="col-xl-9">
              <p class="text-muted fs-15 mb-5 fw-normal">Puede contactarnos en cualquier momento para cualquier consulta u oferta, no dude en aclarar sus dudas antes de probar nuestro servicio.</p>
            </div>
          </div>
          <div class="row text-start">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="card custom-card border shadow-none">
                <div class="card-body p-0">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d30444.274596168965!2d78.54114692513858!3d17.48198883339408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d17.4886524!2d78.5495041!4m5!1s0x3bcb9c7ec139a15d%3A0x326d1c90786b2ab6!2sspruko%20technologies!3m2!1d17.474805099999998!2d78.570258!5e0!3m2!1sen!2sin!4v1670225507254!5m2!1sen!2sin" height="365" style="border:0;width:100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
              </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="card custom-card  overflow-hidden section-bg border overflow-hidden shadow-none">
                <div class="card-body">
                  <div class="row gy-3 mt-2 px-3">
                    <div class="col-xl-6">
                      <div class="row gy-3">
                        <div class="col-xl-12">
                          <label for="contact-address-name" class="form-label ">Nombre Completo :</label>
                          <input type="text" class="form-control " id="contact-address-name" placeholder="ingrese su nombre">
                        </div>
                        <div class="col-xl-12">
                          <label for="contact-address-phone" class="form-label ">N° Teléfono :</label>
                          <input type="text" class="form-control " id="contact-address-phone" placeholder="ingrese su teléfono">
                        </div>
                        <div class="col-xl-12">
                          <label for="contact-address-address" class="form-label ">direccion :</label>
                          <textarea class="form-control " id="contact-address-address" rows="1"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-6">
                      <label for="contact-address-message" class="form-label ">Mensaje :</label>
                      <textarea class="form-control " id="contact-address-message" rows="8"></textarea>
                    </div>
                    <div class="col-xl-12">
                      <div class="d-flex  mt-4 ">
                        <div class="">
                          <div class="btn-list">
                            <button class="btn btn-icon btn-primary-light btn-wave">
                              <i class="ri-facebook-line fw-bold"></i>
                            </button>
                            <button class="btn btn-icon btn-primary-light btn-wave">
                              <i class="ri-twitter-line fw-bold"></i>
                            </button>
                            <button class="btn btn-icon btn-primary-light btn-wave">
                              <i class="ri-instagram-line fw-bold"></i>
                            </button>
                          </div>
                        </div>
                        <div class="ms-auto">
                          <button class="btn btn-primary  btn-wave">Enviar Mensaje</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-10 -->

      <!-- Start:: Section-11 -->
      <section class="section landing-footer text-fixed-white">
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12 mb-md-0 mb-3">
              <div class="px-4">
                <p class="fw-semibold mb-3"><a href="index.html"><img src="assets/images/brand-logos/desktop-dark.png" alt=""></a></p>
                <p class="mb-2 op-6 fw-normal">
                  Experimenta la velocidad y confiabilidad incomparables con BrartNet, tu proveedor de Internet de confianza en Perú! Con nuestra conexión de fibra óptica de alta velocidad, te ofrecemos una experiencia de navegación fluida y sin interrupciones. 
                </p>
                <p class="mb-0 op-6 fw-normal">Conéctate al futuro, hoy mismo.</p>
              </div>
            </div>
            <div class="col-md-2 col-sm-6 col-12">
              <div class="px-4">
                <h6 class="fw-semibold mb-3 text-fixed-white">PÁGINAS</h6>
                <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Email</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Protafolio</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Historia</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Proyectos</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Contactanos</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-2 col-sm-6 col-12">
              <div class="px-4">
                <h6 class="fw-semibold text-fixed-white">INFO</h6>
                <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Nuestro Equipo</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Contáctenos</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Acerca de</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Servicios</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white">Terminos y Condiciones</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="px-4">
                <h6 class="fw-semibold text-fixed-white">CONTACTOS</h6>
                <ul class="list-unstyled fw-normal landing-footer-list">
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white op-6"><i class="ri-home-4-line me-1 align-middle"></i> San Martín, Tarapoto, Jr. alfonso Ugarte 1909</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white op-6"><i class="ri-mail-line me-1 align-middle"></i> brartnet@gmail.com</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="text-fixed-white op-6"><i class="ri-phone-line me-1 align-middle"></i> +(51) 999 777 444</a>
                  </li>
                  <li>
                  <li>
                    <a href="index.php" class="text-fixed-white op-6"><i class="bi bi-box-arrow-in-right me-1 align-middle"></i> <b>INTRANET</b></a>
                  </li>
                  <li class="mt-3">
                    <p class="mb-2 fw-semibold op-8">SIGA CON NOSOTROS :</p>
                    <div class="mb-0">
                      <div class="btn-list">
                        <button class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                          <i class="ri-facebook-line fw-bold"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-secondary-light btn-wave waves-effect waves-light">
                          <i class="ri-twitter-line fw-bold"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-warning-light btn-wave waves-effect waves-light">
                          <i class="ri-instagram-line fw-bold"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-success-light btn-wave waves-effect waves-light">
                          <i class="ri-github-line fw-bold"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-danger-light btn-wave waves-effect waves-light">
                          <i class="ri-youtube-line fw-bold"></i>
                        </button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-11 -->

      <div class="text-center landing-main-footer py-3">
        <span class="text-muted fs-15"> Copyright © <span id="year"></span> <a href="javascript:void(0);" class="text-primary fw-semibold"><u>ynex</u></a>.
          Designed with <span class="fa fa-heart text-danger"></span> by <a href="javascript:void(0);" class="text-primary fw-semibold"><u>
              Spruko</u>
          </a> All
          rights
          reserved
        </span>
      </div>

    </div>
    <!-- End::app-content -->

  </div>

  <div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
  </div>
  <div id="responsive-overlay"></div>

  <!-- Popper JS -->
  <script src="assets/libs/@popperjs/core/umd/popper.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Color Picker JS -->
  <script src="assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

  <!-- Choices JS -->
  <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

  <!-- Swiper JS -->
  <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

  <!-- Defaultmenu JS -->
  <script src="assets/js/defaultmenu.min.js"></script>

  <!-- Internal Landing JS -->
  <script src="assets/js/landing.js"></script>

  <!-- Node Waves JS-->
  <script src="assets/libs/node-waves/waves.min.js"></script>

  <!-- Sticky JS -->
  <script src="assets/js/sticky.js"></script>

</body>

</html>