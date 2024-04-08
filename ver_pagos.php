<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light" style="--primary-rgb: 58, 88, 146;">

<head>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Brartnet | Soy Cliente</title>
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

<body class="landing-body jobs-landing">

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
              <a href="sign-up-basic.html" class="btn btn-primary-light">
                Mis Datos
              </a>
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
            <div class="slide-left" id="slide-left">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
              </svg>
            </div>
            <ul class="main-menu">
              <!-- Start::slide -->
              <li class="slide">
                <a class="side-menu__item" href="index.php#home">
                  <span class="side-menu__label">Inicio</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#about" class="side-menu__item">
                  <span class="side-menu__label">Nosotros</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#testimonials" class="side-menu__item">
                  <span class="side-menu__label">Clientes</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#team" class="side-menu__item">
                  <span class="side-menu__label">Equipo</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#pricing" class="side-menu__item">
                  <span class="side-menu__label">Precios</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#faq" class="side-menu__item">
                  <span class="side-menu__label">Faq's</span>
                </a>
              </li>
              <!-- End::slide -->
              <!-- Start::slide -->
              <li class="slide">
                <a href="index.php#contact" class="side-menu__item">
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
                    <a href="index.php#statistics" class="side-menu__item">Ver Pagos</a>
                  </li>
                  <li class="slide">
                    <a href="index.php#our-mission" class="side-menu__item">Cotizar Precios</a>
                  </li>
                  <li class="slide">
                    <a href="index.php#features" class="side-menu__item">Cobertura</a>
                  </li>
                  <li class="slide">
                    <a href="index.php#testimonials" class="side-menu__item">Testimonios</a>
                  </li>
                </ul>
              </li>
              <!-- End::slide -->

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
              </svg></div>
            <div class="d-lg-flex d-none">
              <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                <a href="sign-up-basic.html" class="btn btn-wave btn-primary">
                  <i class="ti ti-user"></i> Mis Datos
                </a>
                <a href="job-post.html" class="btn btn-wave btn-secondary">
                   <i class="ri-logout-box-r-line"></i>
                </a>
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
    <div class="main-content p-0 landing-main">

      <!-- Start:: Section-1 -->
      <div class="landing-banner" id="home">
        <section class="section pb-0">
          <div class="container main-banner-container">
            <div class="row justify-content-center text-center">
              <div class="col-xxl-7 col-xl-7 col-lg-8">
                <div class="">
                  <h5 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">Bienvenido</span> Jorge Martín del Águila </h5>
                  <p class="fs-18 mb-5 op-8 fw-normal text-fixed-white">Explora los beneficios de tu servicio de internet con Brartnet. Revisa tus pagos, promociones y beneficios disponibles solo para ti</p>
                  <div class="mb-3 custom-form-group">
                    <input type="text" class="form-control form-control-lg shadow-sm" placeholder="Escribe un mensaje" aria-label="Recipient's username">
                    <div class="custom-form-btn bg-transparent">
                      <a href="javascript:void(0);" class="gps-location"><i class="ti ti-current-location"></i></a>
                      <button class="btn btn-primary border-0" type="button"><i class="bi bi-search me-sm-2"></i> <span>Contactar</span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- End:: Section-1 -->

      

      <!-- Start:: Section-3 -->
      <section class="section bg-light" id="steps">
        <div class="container text-center">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-xl-6">
              <p class="fs-12 fw-semibold mb-1"><span class="landing-section-heading">LISTA</span></p>
              <h3 class="fw-semibold mb-2">Mis Pagos Realizados</h3>
              <span class="text-muted fs-15 fw-normal d-block">Aquí se visualizan todos los pagos que realizaste cada mes</span>
            </div>
          </div>
          <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
              <div class="pb-1 table-responsive">                
              <table class="table table-striped table-bordered table-condensed">
                <thead>
                  <th >N°</th> <th >APELLIDOS Y NOMBRES</th> <th >CANCELACIÓN</th> <th >IMPORTE</th> <th >AÑO</th> <th >ENE</th> <th >FEB</th> <th >MAR</th> <th >ABR</th>
                  <th >MAY</th> <th >JUN</th> <th >JUL</th> <th >AGO</th> <th >SEP</th> <th >OCT</th> <th >SEP</th> <th >NOV</th> <th >DIC</th> <th >OBSERVACIONES</th>
                </thead>
                <tbody>
                  <tr>
                    <th class="py-2  text-center">1</th>
                    <td class="py-2  text-nowrap" rowspan="3" ><div class="d-flex flex-fill align-items-center">
                        <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                          <span class="avatar"> <img class="w-30px h-auto" src="assets/modulo/persona/perfil/no-perfil.jpg" alt="" onclick="ver_img()" alt="" > </span>
                        </div>
                        <div>
                          <span class="d-block fw-semibold text-primary">Jorge Martín del Águila</span>
                          <span class="text-muted fs-10 text-nowrap">DNI : 4563453</span> |
                          <span class="text-muted fs-10 text-nowrap"><i class="ti ti-fingerprint fs-12"></i> 00464</span>
                        </div>
                      </div></td>
                    <td class="py-2  text-center" rowspan="3">07/12/2022</td>                            
                    <td class="py-2  text-center" rowspan="3" >50</td>
                    <td class="py-2  text-nowrap" >2024</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2  text-center" ></td>
                    <td class="py-2 " rowspan="3"><textarea cols="30" rows="2" class="textarea_datatable  bg-light" readonly="">Deuda pendiente</textarea></td>
                  </tr>      
                  
                  <tr>
                    <th class="py-2  text-center">2</th>
                    <td class="py-2  text-nowrap" >2023</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                  </tr>      
                  <tr>
                    <th class="py-2  text-center">3</th>
                    <td class="py-2  text-nowrap" >2022</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                    <td class="py-2  text-center" >50</td>
                  </tr>      

                </tbody>
              </table>
              </div>
            </div>
            
          </div>
        </div>
      </section>
      <!-- End:: Section-3 -->

      <!-- Start:: Section-6 -->
      <section class="section ">
        <div class="container">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-xl-6">
              <h3 class="fw-semibold mb-2">Nuestros Metodos de Pago</h3>
              <span class="fs-15 fw-normal d-block op-8">Realize su pago y envienos el baucher a nuestro WhatsApp</span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card feature-style">
                <div class="card-body">
                  <a href="javascript:void(0);" class="stretched-link"></a>
                  <div class="feature-style-icon bg-primary-transparent">
                    <svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                      <g data-name="Working-Home-Online-Work From Home-Computer">
                        <path d="M28 29h2v2h-2zM34 29h2v2h-2z" />
                        <circle cx="32" cy="52" r="2" />
                        <path d="M60.99 25.89h-.01L33.93 3.31a2.981 2.981 0 0 0-3.85 0L3.1 25.95a3.071 3.071 0 0 0-.74 3.89 2.976 2.976 0 0 0 2.08 1.43 2.921 2.921 0 0 0 .5.05 2.986 2.986 0 0 0 1.93-.71l4.13-3.5V61a1 1 0 0 0 1 1h40a1 1 0 0 0 1-1V27.01l4.13 3.48a3 3 0 0 0 3.86-4.6ZM40 59a1 1 0 0 1-1 1H25a1 1 0 0 1-1-1v-1h16Zm.09-3H23.9l-.69-6.9a1.022 1.022 0 0 1 .26-.77.985.985 0 0 1 .74-.33h15.58a.985.985 0 0 1 .74.33 1.022 1.022 0 0 1 .26.77ZM45 60h-3.18a3 3 0 0 0 .18-1v-1.95l.78-7.75a3.009 3.009 0 0 0-.77-2.31 2.97 2.97 0 0 0-2.22-.99H24.21a2.97 2.97 0 0 0-2.22.99 3.009 3.009 0 0 0-.77 2.31l.78 7.75V59a3 3 0 0 0 .18 1H19V49.87a5.018 5.018 0 0 1 2.93-4.56l6.76-3.07a3.993 3.993 0 0 0 6.62 0l6.76 3.07A5.018 5.018 0 0 1 45 49.87ZM24.07 31.99c-.02 0-.05.01-.07.01a2 2 0 0 1 0-4v3a7.954 7.954 0 0 0 .07.99ZM24 26a4.091 4.091 0 0 0-1 .14V26a9 9 0 0 1 18 0v.14a4.091 4.091 0 0 0-1-.14c-.02 0-.05.01-.07.01a7.99 7.99 0 0 0-15.86 0c-.02 0-.05-.01-.07-.01Zm18 4a2.006 2.006 0 0 1-2 2c-.02 0-.05-.01-.07-.01A7.954 7.954 0 0 0 40 31v-3a2.006 2.006 0 0 1 2 2Zm-4.09-4h-.5l-1.7-1.71a1 1 0 0 0-1.16-.18L30.76 26h-4.67a5.993 5.993 0 0 1 11.82 0ZM26 28h5a1 1 0 0 0 .45-.11l3.35-1.67 1.49 1.49A1.033 1.033 0 0 0 37 28h1v3a6 6 0 0 1-12 0Zm8 10.74V40a2 2 0 0 1-4 0v-1.26a7.822 7.822 0 0 0 4 0ZM51 60h-4V49.87a7.025 7.025 0 0 0-4.11-6.38L36 40.36v-2.44a8.066 8.066 0 0 0 3.43-3.97A5.481 5.481 0 0 0 40 34a3.981 3.981 0 0 0 3-6.62V26a11 11 0 1 0-22 0v1.38A3.981 3.981 0 0 0 24 34a5.481 5.481 0 0 0 .57-.05A8.066 8.066 0 0 0 28 37.92v2.45l-6.89 3.12A7.025 7.025 0 0 0 17 49.87V60h-4V25.42L32 9.31l19 16.01Zm8.82-31.17a.988.988 0 0 1-1.4.13L32.64 7.24a.987.987 0 0 0-1.29 0L5.58 29.08a.986.986 0 0 1-.81.22 1 1 0 0 1-.7-.49 1.083 1.083 0 0 1 .31-1.33L31.36 4.84a1.025 1.025 0 0 1 .64-.23 1 1 0 0 1 .64.23L59.7 27.43a.987.987 0 0 1 .12 1.4Z" />
                      </g>
                    </svg>
                  </div>
                  <h5 class="mb-1 fw-semibold text-default">In Home</h5>
                  <p class="text-muted">120 Jobs Available</p>
                  <a class="text-primary fw-semibold" href="javascript:void(0);">Explore Jobs<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card feature-style">
                <div class="card-body">
                  <a href="javascript:void(0);" class="stretched-link"></a>
                  <div class="feature-style-icon bg-primary-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-primary" viewBox="0 0 64 64">
                      <path d="M45 30h2v2h-2zM41 30h2v2h-2zM37 30h2v2h-2z" />
                      <path d="M62 13v-2H42V9c0-3.859-3.141-7-7-7h-6c-3.859 0-7 3.141-7 7v2h-8a1 1 0 0 0-1 1v19c0 .633.13 1.234.346 1.792L2.75 35.532a1 1 0 0 0 0 1.936L16 40.894V46H5v2h11v2H8v2h8v2h-5v2h5.839l14.845 4.948a1.006 1.006 0 0 0 .632 0l15-5A.998.998 0 0 0 48 55V40.894l10-2.586v14.455l-1.895 3.789a1 1 0 0 0 0 .895l2 4a1.001 1.001 0 0 0 1.79 0l2-4a1 1 0 0 0 0-.895L60 52.764V37.791l1.25-.323a1 1 0 0 0 0-1.936l-10.596-2.741A4.938 4.938 0 0 0 51 31V21h5v-2h-5v-2h8v-2h-8v-2h11zm-3 45.764L58.118 57 59 55.236 59.882 57 59 58.764zM24 9c0-2.757 2.243-5 5-5h6c2.757 0 5 2.243 5 5v2h-2V9c0-1.654-1.346-3-3-3h-6c-1.654 0-3 1.346-3 3v2h-2V9zm12 2h-8V9a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2zm-21 2h34v4c0 1.654-1.346 3-3 3H36v-3a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v3H18c-1.654 0-3-1.346-3-3v-4zm34 18c0 .68-.236 1.3-.618 1.804-.006.007-.015.012-.021.02a3.076 3.076 0 0 1-.497.508 3.016 3.016 0 0 1-.5.325c-.03.015-.058.034-.088.048-.161.078-.33.135-.503.182-.042.011-.081.029-.123.038A2.985 2.985 0 0 1 46 34H18c-.222 0-.439-.028-.651-.076-.043-.009-.082-.027-.123-.038a2.866 2.866 0 0 1-.502-.182c-.031-.014-.059-.033-.089-.048a3.002 3.002 0 0 1-.996-.832c-.006-.008-.014-.012-.021-.02A2.975 2.975 0 0 1 15 31V20.974A4.948 4.948 0 0 0 18 22h1v3a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-3h14v3a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-3h1c1.13 0 2.162-.391 3-1.026V31zm-28-9h2v2h-2v-2zm13-2h-4v-2h4v2zm7 2h2v2h-2v-2zm5 32.279-14 4.667-14-4.667V41.412l13.75 3.556a1.008 1.008 0 0 0 .5 0L46 41.412v12.867zM32 42.967 6.993 36.5l7.504-1.941c.457.45.998.811 1.599 1.06.111.046.23.069.343.107.19.063.376.134.575.174.321.065.651.1.986.1h28c.335 0 .665-.035.986-.1.199-.04.385-.112.575-.174.114-.038.233-.061.343-.107a5 5 0 0 0 1.599-1.06l7.504 1.941L32 42.967z" />
                    </svg>
                  </div>
                  <h5 class="mb-1 fw-semibold text-default">Internship</h5>
                  <p class="text-muted">120 Jobs Available</p>
                  <a class="text-primary fw-semibold" href="javascript:void(0);">Explore Jobs<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card feature-style">
                <div class="card-body">
                  <a href="javascript:void(0);" class="stretched-link"></a>
                  <div class="feature-style-icon bg-primary-transparent">
                    <svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 66">
                      <g data-name="Layer 2">
                        <path d="M66 40.88a13 13 0 0 0-25.91-1.45c-1.51-.19-3.18-.34-5-.46v-2.09a15.25 15.25 0 0 0 5.42-8.51 5.34 5.34 0 0 0 3.21-4.91c0-2.18-.68-3.89-1.78-4.67 0-7.2-.63-11.65-3.24-14.25C34.15 0 23.87 4.17 20.75.36A1 1 0 0 0 19.4.18C13 4.7 10.73 13 12.92 19.3a6.55 6.55 0 0 0-1.21 4.15 5.33 5.33 0 0 0 3.21 4.92 15.26 15.26 0 0 0 5.44 8.53V39C13.3 39.42 0 40.23 0 53.93V65a1 1 0 0 0 1 1h53.44a1 1 0 0 0 1-1V53.64A13 13 0 0 0 66 40.88ZM44.75 58.36V64h-16V52.82l6-11.87c8.62.52 16.9 1.44 18.57 10.85h-2.01a6.56 6.56 0 0 0-6.56 6.56Zm-17-8-2.3-4.59.92-2.92h2.77l.86 2.89ZM19.9 2.3c4.61 3.49 13.92.19 17.4 3.7 2.19 2.18 2.64 6.61 2.65 13.5l-.39.64c-.28-2.22-.45-3.37-.61-4v-.06c-.86-5.94-7.47-6.07-12.59-2.41-2.89 1.8-5.67 1.44-8.73-1.12a1 1 0 0 0-1.63.65l-.78 6.48C12.86 14.76 14.18 6.82 19.9 2.3Zm-3.16 25.05a1 1 0 0 0-.89-.79 3.2 3.2 0 0 1-2.14-3.1 6.59 6.59 0 0 1 .29-1.94A5.18 5.18 0 0 0 15.37 23a1 1 0 0 0 1.54-.72l.86-7.13a8.42 8.42 0 0 0 9.69.19c3.63-2.59 8.85-3.46 9.5 1 0 .27.72 4.83 1 6.86a1 1 0 0 0 1.85.4l1.52-2.5a5.67 5.67 0 0 1 .44 2.36 3.23 3.23 0 0 1-2.15 3.1 1 1 0 0 0-.88.79c-1.25 5.95-5.77 10.1-11 10.1s-9.74-4.15-11-10.1Zm11 12.1a11.8 11.8 0 0 0 5.38-1.3v1.47l-1.78 3.56-.53-1.65a1 1 0 0 0-.95-.7h-4.25a1 1 0 0 0-1 .7l-.52 1.66-1.77-3.52v-1.51a11.87 11.87 0 0 0 5.4 1.29Zm-7 1.5 5.95 11.84V64h-16v-5.64a6.56 6.56 0 0 0-6.56-6.56H2.19C3.86 42.37 12.24 41.46 20.76 41ZM2 53.93a.57.57 0 0 1 0-.13h2.13a4.56 4.56 0 0 1 4.56 4.56V64H2ZM53.44 64h-6.69v-5.64a4.56 4.56 0 0 1 4.56-4.56h2.12c.01.69.01-2.66.01 10.2Zm1.81-12.35c-1-6.06-5-10.62-13.18-11.94a11 11 0 1 1 13.18 11.94Z" />
                        <path d="M57.54 39.87H54v-5.25a1 1 0 0 0-2 0v6.25a1 1 0 0 0 1 1h4.54a1 1 0 0 0 0-2Z" />
                      </g>
                    </svg>
                  </div>
                  <h5 class="mb-1 fw-semibold text-default">Part Time</h5>
                  <p class="text-muted">120 Jobs Available</p>
                  <a class="text-primary fw-semibold" href="javascript:void(0);">Explore Jobs<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card feature-style">
                <div class="card-body">
                  <a href="javascript:void(0);" class="stretched-link"></a>
                  <div class="feature-style-icon bg-primary-transparent">
                    <svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                      <path d="M21 28h-5v-.93a1 1 0 0 1 .445-.832l3.774-2.515A3.993 3.993 0 0 0 22 20.4V20a4 4 0 0 0-8 0 1 1 0 0 0 2 0 2 2 0 0 1 4 0v.4a2 2 0 0 1-.891 1.664l-3.773 2.515A2.993 2.993 0 0 0 14 27.07V29a1 1 0 0 0 1 1h6a1 1 0 0 0 0-2Z" />
                      <path d="M31 26h-1v-9a1 1 0 0 0-1.857-.515l-6 10A1 1 0 0 0 23 28h5v1a1 1 0 0 0 2 0v-1h1a1 1 0 0 0 0-2zm-3 0h-3.233L28 20.61zm15 5a1 1 0 0 0 1-1v-1a1 1 0 0 0-2 0v1a1 1 0 0 0 1 1zm6 0a1 1 0 0 0 1-1v-1a1 1 0 0 0-2 0v1a1 1 0 0 0 1 1z" />
                      <path d="M53 42h-3v-2.08A8.028 8.028 0 0 0 53.93 34H55a3.009 3.009 0 0 0 3-3v-1a2.986 2.986 0 0 0-1-2.22V21a5 5 0 0 0-5-5h-1a2.994 2.994 0 0 0-1.67.51 4.712 4.712 0 0 0-.8-1.05A5.005 5.005 0 0 0 45 14h-3.04a21 21 0 1 0-3.05 22.69A8.071 8.071 0 0 0 42 39.92V42h-3a9.014 9.014 0 0 0-9 9v10a1 1 0 0 0 1 1h30a1 1 0 0 0 1-1V51a9.014 9.014 0 0 0-9-9Zm3-12v1a1 1 0 0 1-1 1h-1v-3h1a1 1 0 0 1 1 1ZM23 42a19 19 0 1 1 16.91-27.66 7.16 7.16 0 0 0-1.81.86 17 17 0 1 0-2.01 18.64A2.764 2.764 0 0 0 37 34h1.07c.02.15.04.3.07.45A19.011 19.011 0 0 1 23 42Zm11.48-9.39a15.049 15.049 0 0 1-3.13 2.85l-.48-.84a1 1 0 0 0-1.74 1l.49.84A14.821 14.821 0 0 1 24 37.94V37a1 1 0 0 0-2 0v.95a14.915 14.915 0 0 1-5.61-1.5l.48-.83a1 1 0 0 0-1.74-1l-.48.84a15.165 15.165 0 0 1-4.11-4.11l.84-.48a1 1 0 0 0-1-1.74l-.83.48A14.915 14.915 0 0 1 8.05 24H9a1 1 0 0 0 0-2h-.95a14.915 14.915 0 0 1 1.5-5.61l.83.48a1 1 0 0 0 1.36-.37 1.007 1.007 0 0 0-.36-1.37l-.84-.48a15.165 15.165 0 0 1 4.11-4.11l.48.84a.993.993 0 0 0 1.37.36 1 1 0 0 0 .37-1.36l-.48-.83A14.915 14.915 0 0 1 22 8.05V9a1 1 0 0 0 2 0v-.96a14.83 14.83 0 0 1 5.61 1.5l-.48.84a1 1 0 0 0 .37 1.36.993.993 0 0 0 1.37-.36l.48-.84a14.891 14.891 0 0 1 4.1 4.12l-.83.47a1.007 1.007 0 0 0-.36 1.37 1 1 0 0 0 1.36.37l.83-.48a2 2 0 0 1 .1.21A6.984 6.984 0 0 0 35 21v6.78A2.986 2.986 0 0 0 34 30v1a2.933 2.933 0 0 0 .48 1.61ZM36 30a1 1 0 0 1 1-1h1v3h-1a1 1 0 0 1-1-1Zm2-4v1h-1v-6a4.938 4.938 0 0 1 1.45-3.52 5.007 5.007 0 0 1 3.04-1.45A4.361 4.361 0 0 1 42 16h3a2.988 2.988 0 0 1 3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h1a3.009 3.009 0 0 1 3 3v6h-1v-1a3.009 3.009 0 0 0-3-3H41a3.009 3.009 0 0 0-3 3Zm2 7v-7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7a6 6 0 0 1-12 0Zm9.5 11h.5v3.52l-2.42-.96ZM46 45.33l-2-2.66v-1.93a7.822 7.822 0 0 0 4 0v1.93ZM42 44h.5l1.92 2.56-2.42.96Zm18 16h-4v-7a1 1 0 0 0-2 0v7H38v-7a1 1 0 0 0-2 0v7h-4v-9a7.008 7.008 0 0 1 7-7h1v5a1 1 0 0 0 1 1 .937.937 0 0 0 .37-.07L46 48.08l4.63 1.85A.937.937 0 0 0 51 50a1 1 0 0 0 1-1v-5h1a7.008 7.008 0 0 1 7 7Z" />
                      <path d="M46 50a1 1 0 0 0-1 1v1a1 1 0 0 0 2 0v-1a1 1 0 0 0-1-1zm0 5a1 1 0 0 0-1 1v1a1 1 0 0 0 2 0v-1a1 1 0 0 0-1-1zm3.706-21.706a1 1 0 0 0-1.413 0 3.318 3.318 0 0 1-4.582 0 1 1 0 0 0-1.411 1.415 5.239 5.239 0 0 0 7.41 0 1 1 0 0 0-.004-1.415z" />
                    </svg>
                  </div>
                  <h5 class="mb-1 fw-semibold text-default">Full Time</h5>
                  <p class="text-muted">120 Jobs Available</p>
                  <a class="text-primary fw-semibold" href="javascript:void(0);">Explore Jobs<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-6 -->

      <!-- Start:: Section-4 -->
      <section class="section bg-banner-2 text-fixed-white py-0">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-5 col-xl-4 text-center mt-4 d-lg-block d-none">
              <img src="assets/images/media/jobs-landing/8.png" width="350" alt="">
            </div>
            <div class="col-md-7 col-xl-8">
              <div class="my-4">
                <h2 class="fw-semibold mb-3 text-fixed-white">No olvide apagar sus equipos en  <a href="javascript:void(0);" class="text-fixed-white text-decoration-line"> <u>epoca de lluvia.</u> </a></h2>
                <p class="mb-4 fs-15 op-8 fw-normal">
                Es fundamental recordar la importancia de apagar los equipos durante la temporada de lluvias. 
                La humedad y la lluvia pueden representar un riesgo considerable para la integridad de los dispositivos electrónicos, 
                aumentando la posibilidad de cortocircuitos y daños irreparables. Por lo tanto, 
                es una medida de precaución indispensable para preservar la funcionalidad y prolongar la vida útil de los equipos. 
                Además, desconectarlos de la corriente eléctrica no solo protege los dispositivos, 
                sino que también contribuye a la seguridad del entorno al reducir el riesgo de descargas eléctricas. 
                En resumen, apagar los equipos durante la época de lluvias no solo es una práctica prudente, 
                sino también una forma efectiva de salvaguardar tanto los dispositivos como a quienes los utilizan.
                </p>
                <a href="javascript:void(0);" class="btn btn-light btn-lg"><i class="ti ti-upload"></i> Más información</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-4 -->      

      <!-- Start:: Section-2 -->
      <section class="section section-bg " id="jobs">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
            <div>
              <p class="fs-12 fw-semibold mb-1">+ SERVICIOS</p>
              <h3 class="fw-semibold mb-0">Conoce nuestros servicios disponibles</h3>
              <span class="text-muted fs-15 fw-normal d-block">Estos servicios son exclusivos para clientes registrados</span>
            </div>
            <div>
              <a href="javascript:void(0);" class="btn btn-wave btn-primary">
                Ver Todos <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
              <div class="card custom-card border">
                <div class="row g-0">
                  <div class="col-md-3 col-4">
                    <img src="assets/images/media/jobs-landing/1.jpg" class="img-fluid rounded-start h-100 browse-jobs-image" alt="...">
                  </div>
                  <div class="col-md-9 col-8 my-auto">
                    <div class="card-body">
                      <h5 class="card-title fw-semibold">Consulta en línea</h5>
                      <p><span class="text-default fw-semibold">50 operadoras</span> en línea</p>
                      <a class="text-primary fw-semibold" href="javascript:void(0);">Consultar<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="card custom-card border">
                <div class="row g-0">
                  <div class="col-md-3 col-4">
                    <img src="assets/images/media/jobs-landing/2.jpg" class="img-fluid rounded-start h-100 browse-jobs-image" alt="...">
                  </div>
                  <div class="col-md-9 col-8 my-auto">
                    <div class="card-body">
                      <h5 class="card-title fw-semibold">Soporte Técnico</h5>
                      <p><span class="text-default fw-semibold">50 Técnicos en Redes</span> disponibles</p>
                      <a class="text-primary fw-semibold" href="javascript:void(0);">Solicitar<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>            
            <div class="col-lg-4 col-md-6 col-12">
              <div class="card custom-card border">
                <div class="row g-0">
                  <div class="col-md-3 col-4">
                    <img src="assets/images/media/jobs-landing/4.jpg" class="img-fluid rounded-start h-100 browse-jobs-image" alt="...">
                  </div>
                  <div class="col-md-9 col-8 my-auto">
                    <div class="card-body">
                      <h5 class="card-title fw-semibold">Equipo Brartnet</h5>
                      <p>Conoce a nuestro equipo</p>
                      <a class="text-primary fw-semibold" href="javascript:void(0);">Consultar<i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-2 -->      

      <!-- Start:: Section-9 -->
      <section class="section bg-banner" id="employers">
        <div class="container">
          <div class="row">
            <div class="col-lg-9">
              <h2 class="fw-semibold text-fixed-white">Pague a tiempo sus recibos!</h2>
              <span class="d-block fw-normal fs-15 op-8">
                Es esencial pagar a tiempo los recibos para mantener un historial crediticio positivo, 
                evitar cargos por mora y asegurar la continuidad de los servicios. El pago puntual refleja fiabilidad y compromiso financiero, 
                fortaleciendo la confianza con proveedores y acreedores, y contribuyendo a una estabilidad económica a largo plazo.
              </span>
            </div>
            <div class="col-lg-3 text-end my-auto">
              <a href="javascript:void(0);" class="btn btn-lg btn-danger">Más información</a>
            </div>
          </div>
        </div>
      </section>
      <!-- End:: Section-9 -->      

      <!-- Start:: Section-11 -->
      <section class="section landing-testimonials">
        <div class="container text-center">
          <div class="row mb-5 justify-content-center text-center">
            <p class="fs-12 fw-semibold mb-1"><span class="landing-section-heading">TESTIMONIIOS</span> </p>
            <h3 class="fw-semibold mb-2">Nunca dejamos de alcanzar las expectativas</h3>
            <div class="col-xl-9">
              <span class="b-block fw-normal fs-15 text-muted">Algunas de las reseñas que nuestros clientes dieron, las cuales nos brindan motivación para mejorar nuestros servicios.</span>
            </div>
          </div>
          <div class="swiper pagination-dynamic text-start">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/11.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Json Taylor</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CEO OF NORJA</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/1.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Melissa Blue</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">MANAGER CHO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/14.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Kiara Advain</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CEO OF EMPIRO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/8.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Jhonson Smith</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CHIEF SECRETARY MBIO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/4.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Dwayne Stort</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CEO ARMEDILLO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/9.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Jasmine Kova</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">AGGENT AMIO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/10.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Dolph MR</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CEO MR BRAND</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/13.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Brenda Simpson</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">CEO AIBMO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="card custom-card featured-card-1 border shadow-none">
                  <div class="card-body p-4">
                    <span class="review-quote">
                      <i class="bi bi-quote"></i>
                    </span>
                    <div class="d-flex mb-2 align-items-center">
                      <span class="avatar avatar-lg avatar-rounded me-2">
                        <img src="assets/images/faces/6.jpg" alt="">
                      </span>
                      <div>
                        <p class="mb-0 fw-semibold fs-16 text-primary">Melissa Blue</p>
                        <p class="fs-10 mb-0 fw-semibold text-muted">MANAGER CHO</p>
                      </div>
                    </div>
                    <span>- Est amet sit vero sanctus labore no sed ipsum ipsum nonumy. Sit ipsum sanctus ea magna est. Aliquyam sed amet. Kasd diam rebum sit ipsum ipsum erat et kasd.Est amet sit vero sanctus labor</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
      <!-- End:: Section-11 -->      

      <!-- Start:: Footer -->
      <div class="landing-main-footer py-3">
        <div class="container">
          <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
            <div>
              <span class="text-fixed-white op-7 fs-14"> © Copyright <span id="year"></span> <a href="javascript:void(0);" class="text-primary fs-15 fw-semibold">Ynex</a>.
              </span>
            </div>
            <div>
              <ul class="list-unstyled fw-normal landing-footer-list mb-0">
                <li>
                  <a href="javascript:void(0);" class="text-fixed-white op-8">Terms Of Service</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="text-fixed-white op-8">Privacy Policy</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="text-fixed-white op-8">Legal</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="text-fixed-white op-8">Contact</a>
                </li>
                <li>
                  <a href="javascript:void(0);" class="text-fixed-white op-8">Report Abuse</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- End:: Footer -->

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
  <script src="assets/js/landing_pagos.js"></script>

  <!-- Node Waves JS-->
  <script src="assets/libs/node-waves/waves.min.js"></script>

  <!-- Sticky JS -->
  <script src="assets/js/sticky.js"></script>

</body>

</html>