<?php
//Activamos el almacenamiento en el buffer
ob_start();
date_default_timezone_set('America/Lima'); require "../config/funcion_general.php";
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

  <body id="body-usuario">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if($_SESSION['cliente']==1) { ?>

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
                        <select class="form-control" name="filtro_trabajador" id="filtro_trabajador" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > <!-- lista de categorias --> </select>
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
                        <select class="form-control" name="filtro_p_all_anio_pago" id="filtro_p_all_anio_pago" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > <!-- lista de categorias --> </select>
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
                        <select class="form-control" name="filtro_p_all_mes_pago" id="filtro_p_all_mes_pago" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > </select>
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
                        <select class="form-control" name="filtro_tipo_comprob" id="filtro_tipo_comprob" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > <!-- lista de categorias --> </select>
                      </div>
                    </div>                    
                </div>
                <div class="card-body">
                  <div id="div-tabla" class="table-responsive">
                    <table id="tabla-cliente" class="table table-bordered w-100" style="width: 100%;">
                      <thead class="buscando_tabla">
                        <tr id="id_buscando_tabla"> 
                          <th colspan="20" class="bg-danger " style="text-align: center !important;"><i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando... </th>
                        </tr>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Cliente</th>
                          <th>Tipo Comprobante</th>
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
                          <th>Tipo Comprobante</th>
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
            </div>
          </div>          
          <!-- End::row-1 --> 
          
        </div>
      </div>
      <!-- End::app-content -->

      <?php } else { $title_submodulo ='Clientes'; $descripcion ='Lista de Clientes del sistema!'; $title_modulo = 'Ventas'; include("403_error.php"); }?>   


      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>


    <script src="scripts/reporte_x_trabajador.js"></script>
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