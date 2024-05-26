<?php
//Activamos el almacenamiento en el buffer
ob_start();
date_default_timezone_set('America/Lima');
require "../config/funcion_general.php";
session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>

    <?php $title_page = "Clientes";
    include("template/head.php"); ?>

  </head>
  <style>
    .style_tabla_datatable td,
    tr {
      font-size: 11px;
      /* Reducir el tamaño de la fuente */
      padding: 5px;
      /* Ajustar el padding */
    }
  </style>

  <body id="body-usuario">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if ($_SESSION['cliente'] == 1) { ?>

        <!-- Start::app-content -->
        <div class="main-content app-content">
          <div class="container-fluid">

            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
              <div>
                <div class="d-md-flex d-block align-items-center ">
                  <div>
                    <p class="fw-semibold fs-18 mb-0">Lista de Cobros!</p>
                    <span class="fs-semibold text-muted">Reporte de Cobros por trabajador.</span>
                  </div>
                </div>
              </div>

              <div class="btn-list mt-md-0 mt-2">
                <nav>
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Cobros</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row-1 -->
            <div class="row">
              <div class="col-xxl-12 col-xl-12 ">
                <div class="card custom-card">
                  <div class="card-header div-filtro row" style="gap: 0px !important;">

                    <!-- ::::::::::::::::::::: FILTRO TRABAJADOR :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_trabajador" class="form-label">
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_trabajador');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Trabajador
                          <span class="charge_filtro_trabajador"></span>
                        </label>
                        <select class="form-control" name="filtro_trabajador" id="filtro_trabajador" onchange="cargando_search(); delay(function(){filtros()}, 50 );"> <!-- lista de categorias --> </select>
                      </div>
                    </div>
                    <!-- ::::::::::::::::::::: FILTRO AÑO DE PAGO :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_p_all_anio_pago" class="form-label">
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_anio_pago');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Año de Pago
                          <span class="charge_filtro_p_all_anio_pago"></span>
                        </label>
                        <select class="form-control" name="filtro_p_all_anio_pago" id="filtro_p_all_anio_pago" onchange="cargando_search(); delay(function(){filtros()}, 50 );"> <!-- lista de categorias --> </select>
                      </div>
                    </div>

                    <!-- ::::::::::::::::::::: FILTRO MES :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_p_all_mes_pago" class="form-label">
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_p_all_mes_pago');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Mes de Pago
                          <span class="charge_filtro_p_all_mes_pago"></span>
                        </label>
                        <select class="form-control" name="filtro_p_all_mes_pago" id="filtro_p_all_mes_pago" onchange="cargando_search(); delay(function(){filtros()}, 50 );"> </select>
                      </div>
                    </div>
                    <!-- ::::::::::::::::::::: FILTRO TIPO COMPROBANTE :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_tipo_comprob" class="form-label">
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_tipo_comprob');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Tipo Comprobante
                          <span class="charge_filtro_tipo_comprob"></span>
                        </label>
                        <select class="form-control" name="filtro_tipo_comprob" id="filtro_tipo_comprob" onchange="cargando_search(); delay(function(){filtros()}, 50 );"> <!-- lista de categorias --> </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <!--Tabla reporte-->
                    <div class="col-12 col-lg-7 col-xxl-7">
                      <div class="card-body">
                        <div id="div-tabla" class="table-responsive">
                          <table id="tabla-cliente" class="table table-bordered w-100 style_tabla_datatable" style="width: 100%;">
                            <thead class="buscando_tabla">
                              <tr id="id_buscando_tabla">
                                <th colspan="20" class="bg-danger " style="text-align: center !important;"><i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando... </th>
                              </tr>
                              <tr>
                                <th class="text-center">#</th>
                                <th>Cliente</th>
                                <th>Correlativo</th>
                                <th>Total</th>
                                <th>Trabajador Asignado</th>
                                <th>Trabajador Cobro</th>
                                <th>Periodo</th>
                                <th>F. Creación</th>

                              </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                              <tr>
                                <th class="text-center">#</th>
                                <th>Cliente</th>
                                <th>Correlativo</th>
                                <th>Total</th>
                                <th>Trabajador Asignado</th>
                                <th>Trabajador Cobro</th>
                                <th>Periodo</th>
                                <th>F. Creación</th>

                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!--Graficos del reporte-->
                    <div class="col-12 col-xl-5 col-xxl-5 ">
                      <div class="row">
                        <!-- card de montos -->
                        <div class="col-xl-12 col-xxl-12">
                          <div class="row">
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                              <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                  <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                      <span class="avatar avatar-md avatar-rounded bg-primary">
                                        <i class="ti ti-users fs-16"></i>
                                      </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                          <p class="text-muted mb-0">Total Customers</p>
                                          <h4 class="fw-semibold mt-1">1,02,890</h4>
                                        </div>
                                        <div id="crm-total-customers"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                              <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                  <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                      <span class="avatar avatar-md avatar-rounded bg-secondary">
                                        <i class="ti ti-wallet fs-16"></i>
                                      </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                          <p class="text-muted mb-0">Total Revenue</p>
                                          <h4 class="fw-semibold mt-1">$56,562</h4>
                                        </div>
                                        <div id="crm-total-revenue"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                              <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                  <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                      <span class="avatar avatar-md avatar-rounded bg-success">
                                        <i class="ti ti-wave-square fs-16"></i>
                                      </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                          <p class="text-muted mb-0">Conversion Ratio</p>
                                          <h4 class="fw-semibold mt-1">12.08%</h4>
                                        </div>
                                        <div id="crm-conversion-ratio"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                              <div class="card custom-card overflow-hidden">
                                <div class="card-body">
                                  <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                      <span class="avatar avatar-md avatar-rounded bg-warning">
                                        <i class="ti ti-briefcase fs-16"></i>
                                      </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                      <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                          <p class="text-muted mb-0">Total Deals</p>
                                          <h4 class="fw-semibold mt-1">2,543</h4>
                                        </div>
                                        <div id="crm-total-deals"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Graficos de pastel-->
                        <div class="col-xl-12 col-xxl-12">
                          <div class="card custom-card">
                            <div class="card-header justify-content-between">
                              <div class="card-title">
                                Leads By Source
                              </div>
                              <div class="dropdown">
                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                                  <i class="fe fe-more-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="javascript:void(0);">Week</a></li>
                                  <li><a class="dropdown-item" href="javascript:void(0);">Month</a></li>
                                  <li><a class="dropdown-item" href="javascript:void(0);">Year</a></li>
                                </ul>
                              </div>
                            </div>
                            <div class="card-body p-0 overflow-hidden">
                              <div class="leads-source-chart d-flex align-items-center justify-content-center">
                                <canvas id="leads-source" class="chartjs-chart w-100 p-4"></canvas>
                                <div class="lead-source-value">
                                  <span class="d-block fs-14">Total</span>
                                  <span class="d-block fs-25 fw-bold">4,145</span>
                                </div>
                              </div>
                              <div class="row row-cols-12 border-top border-block-start-dashed">
                                <div class="col p-0">
                                  <div class="ps-4 py-3 pe-3 text-center border-end border-inline-end-dashed">
                                    <span class="text-muted fs-12 mb-1 crm-lead-legend mobile d-inline-block">Mobile
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,624</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col p-0">
                                  <div class="p-3 text-center border-end border-inline-end-dashed">
                                    <span class="text-muted fs-12 mb-1 crm-lead-legend desktop d-inline-block">Desktop
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,267</span></div>
                                  </div>
                                </div>
                                <div class="col p-0">
                                  <div class="p-3 text-center border-end border-inline-end-dashed">
                                    <span class="text-muted fs-12 mb-1 crm-lead-legend laptop d-inline-block">Laptop
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,153</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col p-0">
                                  <div class="p-3 text-center">
                                    <span class="text-muted fs-12 mb-1 crm-lead-legend tablet d-inline-block">Tablet
                                    </span>
                                    <div><span class="fs-16 fw-semibold">679</span></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- End::row-1 -->

          </div>
        </div>
        <!-- End::app-content -->

      <?php } else {
        $title_submodulo = 'Clientes';
        $descripcion = 'Lista de Clientes del sistema!';
        $title_modulo = 'Ventas';
        include("403_error.php");
      } ?>


      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>


    <script src="scripts/reporte_x_trabajador.js?version_jdl=1.3"></script>
    <script>
      $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
      });
    </script>


  </body>

  </html>
<?php
}
ob_end_flush();
?>