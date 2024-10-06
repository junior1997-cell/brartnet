<?php
//Activamos el almacenamiento en el buffer
ob_start();
date_default_timezone_set('America/Lima');
session_start();

if (!isset($_SESSION['cliente_nombre'])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
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
    <!-- Font Awesome 6.2 -->
    <link rel="stylesheet" href="assets/libs/fontawesome-free-6.2.0/css/all.min.css" />


    <script>
      if (localStorage.ynexlandingdarktheme) {
        document.querySelector("html").setAttribute("data-theme-mode", "dark")
      }
      if (localStorage.ynexlandingrtl) {
        document.querySelector("html").setAttribute("dir", "rtl")
        document.querySelector("#style")?.setAttribute("href", "assets/libs/bootstrap/css/bootstrap.rtl.min.css");
      }
    </script>
    <style>

    </style>

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
                <a href="ver_pagos.php" class="header-logo">
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
                  <a href="ver_pagos.php" class="header-logo">
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
                  <a class="side-menu__item" href="ver_pagos.php#home">
                    <span class="side-menu__label">Inicio</span>
                  </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide -->
                <li class="slide">
                  <a href="ver_pagos.php#mis_pagos" class="side-menu__item">
                    <span class="side-menu__label">Comprobantes</span>
                  </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide -->
                <li class="slide">
                  <a href="ver_pagos.php#metodos" class="side-menu__item">
                    <span class="side-menu__label">Métodos de Pago</span>
                  </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide -->
                <li class="slide">
                  <a href="ver_pagos.php#recomendaciones" class="side-menu__item">
                    <span class="side-menu__label">Recomendaciones</span>
                  </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide -->
                <li class="slide">
                  <a href="ver_pagos.php#servicios" class="side-menu__item">
                    <span class="side-menu__label">Servicios</span>
                  </a>
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

                  <a class="btn btn-wave btn-secondary" href="ajax_client/usuario_cliente.php?op=salir_ver_pagos"><i class="ri-logout-box-r-line"></i></a>

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
                    <h5 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">Bienvenido </span><?php echo $_SESSION['cliente_nombre']; ?></h5>
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
        <section class="section bg-light " id="mis_pagos">
          <div class="container text-center">
            <div class="row justify-content-center text-center mb-5">
              <div class="col-xl-6">
                <p class="fs-12 fw-semibold mb-1"><span class="landing-section-heading">LISTA</span></p>
                <h3 class="fw-semibold mb-2">Mis Pagos Realizados</h3>
                <span class="text-muted fs-15 fw-normal d-block">Aquí se visualizan todos los pagos que realizaste cada mes</span>
              </div>
            </div>
            <div class="row">
              <div class="col-xxl-4 col-xl-3 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <div class="card-header">
                    <div class="card-title me-1">Filtro</div><span class="badge bg-primary-transparent rounded-pill">02</span>
                  </div>
                  <div class="card-body p-0">
                    <div class="p-3 border-bottom border-block-end-dashed">
                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="text-primary fw-semibold">Año</div>
                      </div>
                    </div>
                    <div class="p-1 border-bottom border-block-end-dashed list_year">
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2023</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2024</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2025</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2026</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2026</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">2026</button>
                    </div>

                    <div class="p-3 border-bottom border-block-end-dashed">
                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="text-primary fw-semibold">Mes</div>
                      </div>
                    </div>
                    <div class="p-1 border-bottom border-block-end-dashed list_month">
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Enero</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Febrero</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Marzo</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Abril</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Mayo</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Junio</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Julio</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Agosto</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Setiembre</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Octubre</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Noviembre</button>
                      <button type="button" class="btn btn-secondary-light rounded-pill btn-wave btn-sm m-1">Diciembre</button>
                    </div>
                    <div class="p-3 border-bottom border-block-end-dashed">
                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="text-primary fw-semibold">Pagos Pendientes </div>
                        <div>
                          <div class="toggle toggle-dark on">
                            <span></span>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="p-3 border-bottom border-block-end-dashed">
                      
                      <div class="d-grid gap-2 mb-4">
                      <button class="btn btn-secondary btn-wave" type="button">Filtrar</button>
                    </div>
                    </div>



                  </div>
                </div>
              </div>
              <div class="col-xxl-8 col-xl-9 col-lg-12 col-md-12 col-sm-12">
                <div class="card custom-card">
                  <div class="card-header">
                    <div class="card-title me-1">Mis Comprobantes</div><span class="badge bg-primary-transparent rounded-pill">02</span>
                  </div>
                  <div class="card-body p-0 " style="max-height: 600px; overflow-y: auto;">
                    <ul class="timeline list-unstyled list_data_pagos">

                      <li style="padding:0px">
                        <div class="timeline-time text-end">
                          <span class="date">2024</span>
                          <span class="time d-inline-block" style=" font-size: small; ">Setiembre</span>
                        </div>
                        <div class="timeline-icon">
                          <a href="javascript:void(0);"></a>
                        </div>
                        <div class="timeline-body">
                          <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                            <div class="avatar avatar-md online me-3 mt-sm-0 mt-4">
                              <img alt="avatar" src="assets/icons_pgos_c/alegre.png">
                            </div>
                            <div class="flex-fill">
                              <div class="d-flex">
                                <div class="mt-sm-0 mt-2">
                                  <p class="mb-0 fs-14 fw-semibold" style="text-align: left;">Factura</p>
                                  <p class="mb-0 text-muted" style="text-align: left;">Tipo Servicio : Basico</p>

                                </div>
                                <div class="ms-auto">
                                  <div class="card custom-card shadow-none bg-light">
                                    <div class="card-body p-2">
                                      <a href="javascript:void(0);">
                                        <div class="d-flex justify-content-between flex-wrap">
                                          <div class="file-format-icon mt-2">
                                            <i class="fa-solid fa-download fa-2xl" style="color: #1de125;"></i>
                                          </div>
                                          <div>
                                            <span class="fw-semibold mb-1"> Descargar </span>
                                            <span class="fs-8 d-block text-muted text-end">
                                              FT F001-456
                                            </span>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>

                      <li style="padding:0px">
                        <div class="timeline-time text-end">
                          <span class="date">2024</span>
                          <span class="time d-inline-block" style=" font-size: small; ">Setiembre</span>
                        </div>
                        <div class="timeline-icon">
                          <a href="javascript:void(0);"></a>
                        </div>
                        <div class="timeline-body mb-6">
                          <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                            <div class="avatar avatar-md online me-3 mt-sm-0 mt-4">
                              <img alt="avatar" src="assets/icons_pgos_c/triste.png">
                            </div>
                            <div class="flex-fill">
                              <div class="d-flex">
                                <div class="mt-sm-0 mt-2">
                                  <p class="mb-0 fs-14 fw-semibold" style="text-align: left;">Sin Facturar</p>
                                  <p class="mb-0 text-muted" style="text-align: left;">Tipo Servicio : Basico</p>
                                </div>
                                <div class="ms-auto">
                                  <div class="card custom-card shadow-none bg-light">
                                    <div class="card-body p-2">
                                      <a href="javascript:void(0);">
                                        <div class="d-flex justify-content-between flex-wrap">
                                          <div class="file-format-icon mt-2">
                                            <i class="fa-solid fa-download fa-2xl" style="color: #f04747;"></i>
                                          </div>
                                          <div>
                                            <span class="fw-semibold mb-1"> Descargar </span>
                                            <span class="fs-8 d-block text-muted text-end">
                                              - - - - - - - -
                                            </span>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>

                    </ul>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
        <!-- End:: Section-3 -->

        <!-- Start:: Section-6 -->
        <section class="section bg-light" id="metodos">
          <div class="container">
            <div class="row justify-content-center text-center mb-5">
              <div class="col-xl-6">
                <h3 class="fw-semibold mb-2">Nuestros Métodos de Pago</h3>
                <span class="fs-15 fw-normal d-block op-8">Realize su pago y envienos el baucher a nuestro WhatsApp</span>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/caja-huancayo.png" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">Caja Huancayo</h5>
                    <p class="mb-1 text-muted">107072211000007005</p>
                    <p class="text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/icono-caja-piura.svg" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">Caja Piura</h5>
                    <p class="mb-1 text-muted">210-01-1585385</p>
                    <p class="text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/icono-banco-nacion.svg" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">Banco de la Nación</h5>
                    <p class="mb-1 text-muted">04-498-168057</p>
                    <p class="text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/icono-coopact.png" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">COOPACT</h5>
                    <p class="text-muted">DNI: 44685134</p>
                    <p class="mb-1 text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 mx-auto">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/logo-bbva.svg" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">BBVA Continental</h5>
                    <p class=" mb-1 text-muted">0011-0318-0200748173</p>
                    <p class="text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 mx-auto">
                <div class="card feature-style">
                  <div class="card-body">
                    <div class="feature-style-icon bg-primary-transparent">
                      <img src="assets/modulo/bancos/logo-yape2.png" alt="">
                    </div>
                    <h5 class="mb-1 fw-semibold text-default">Yape</h5>
                    <p class=" mb-1 text-muted">976 097 096</p>
                    <p class="text-muted">RONALD NIGEL ARTEAGA SEVILLANO</p>
                    <a class="text-primary fw-semibold" href="https://api.whatsapp.com/send?phone=+51929676935&text=*Hola buenos dias, vengo de tu pagina web!!*">Contáctanos<i class="ti ti-brand-whatsapp ms-2 align-middle"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End:: Section-6 -->

        <!-- Start:: Section-4 -->
        <section class="section bg-banner-2 text-fixed-white py-0" id="recomendaciones">
          <div class="container">
            <div class="row align-items-center justify-content-center">
              <div class="col-md-5 col-xl-4 text-center mt-4 d-lg-block d-none">
                <img src="assets/images/media/jobs-landing/8.png" width="350" alt="">
              </div>
              <div class="col-md-7 col-xl-8">
                <div class="my-4">
                  <h2 class="fw-semibold mb-3 text-fixed-white">No olvide apagar sus equipos en <a href="javascript:void(0);" class="text-fixed-white text-decoration-line"> <u>epoca de lluvia.</u> </a></h2>
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
        <section class="section section-bg " id="servicios">
          <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
              <div>
                <p class="fs-12 fw-semibold mb-1">+ SERVICIOS</p>
                <h3 class="fw-semibold mb-0">Conoce nuestros servicios disponibles</h3>
                <span class="text-muted fs-15 fw-normal d-block">Estos servicios son exclusivos para clientes registrados</span>
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
                        <p><span class="text-default fw-semibold">Operadoras</span> en línea</p>
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
                        <p><span class="text-default fw-semibold">Técnicos en Redes</span> disponibles</p>
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


        <!-- Start:: Footer -->
        <div class="landing-main-footer py-3">
          <div class="container">
            <div class="d-flex flex-wrap gap-2 align-items-end ">
              <span class="text-muted">
                Copyright
                <span id="copyright"> © 2024 -
                  <script>
                    var currentYear = new Date().getFullYear();
                    if (currentYear > 2024) {
                      document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()));
                    }
                  </script>
                </span>
                Diseñado con
                <span class="bi bi-heart-fill text-danger"></span> por
                <a href="https://www.jdl.pe/" target="_blank" class="text-primary-soft"> <span class="fw-semibold text-warning text-decoration-underline">
                    JDL Technology</span> </a>
                Todos los derechos reservados
              </span>

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
    <!-- jQuery 3.6.0 -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
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

    <!-- Node Waves JS-->
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="assets/js/sticky.js"></script>

    <!-- Internal Landing JS -->
    <script src="assets/js/landing_pagos.js?version_jdl=1.29"></script>

    <script src="scripts_client/ver_pagos.js?version_jdl=1.29"></script>

  </body>

  </html>

<?php

}
ob_end_flush();

?>