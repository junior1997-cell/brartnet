<?php
  //Activamos el almacenamiento en el buffer
  ob_start();

  session_start();
  if (!isset($_SESSION["user_nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{

    ?>
      <!DOCTYPE html>
      <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

        <head>
          
          <?php $title_page = "Gastos"; include("template/head.php"); ?>    

        </head> 

        <body id="body-usuario">

          <?php include("template/switcher.php"); ?>
          <?php include("template/loader.php"); ?>

          <div class="page">
            <?php include("template/header.php") ?>
            <?php include("template/sidebar.php") ?>

            <!-- Start::app-content -->
            <div class="main-content app-content">
              <div class="container-fluid">

                <!-- Start::page-header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                  <div>
                    <div class="d-md-flex d-block align-items-center ">
                      <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal"  data-bs-target="#modal-registrar-pago"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                      <div>
                        <p class="fw-semibold fs-18 mb-0">Gastos del Trabajador</p>
                        <span class="fs-semibold text-muted">Administra los gastos del trabajador.</span>
                      </div>                
                    </div>
                  </div>
                  
                  <div class="btn-list mt-md-0 mt-2">              
                    <nav>
                      <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Trabajadores</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administracion</li>
                      </ol>
                    </nav>
                  </div>
                </div>          
                <!-- End::page-header -->

                <!-- Start::row-1 -->
                <section id="gasto-trabajador">
                  <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                      <div>
                        <div class="card custom-card">
                          <div class="card-body table-responsive">
                            <table id="tabla-pagos" class="table table-bordered w-100" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Fecha Ingreso</th>
                                  <th>Trabajador</th>
                                  <th>Monto</th>
                                  <th>Descripción</th>
                                  <th>Comprobante</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Fecha Pago</th>
                                  <th>Trabajador</th>
                                  <th>Monto</th>
                                  <th>Descripción</th>
                                  <th>Comprobante</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <!-- End::row-1 -->


                <!-- Start::modal-registrar-pago -->
                <div class="modal fade modal-effect" id="modal-registrar-pago" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-pagoLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-dialog-scrollabel">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="modal-agregar-pagoLabel1">Pago del Trabajador</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form name="form-agregar-pago" id="form-agregar-pago" method="POST" class="row needs-validation" novalidate>
                            <div class="row gy-2">
                              <!-- id gasto trabajador -->
                              <input type="hidden" name="idgasto_de_trabajador" id="idgasto_de_trabajador">

                              <!-- imagen usuario -->
                              <div class="col-md-1">
                                <div class="mb-4 d-sm-flex align-items-center">
                                  <div class="mb-0 me-5">
                                    <span class="avatar avatar-xxl avatar-rounded">
                                      <img src="../assets/images/faces/9.jpg" alt="foto" id="imagenmuestra" onerror="this.src='../assets/modulo/usuario/perfil/no-perfil.jpg';">
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-label">
                                  <label for="trabajador" class="form-label">Nombre del Trabajador(*)</label>
                                  <select class="form-control" name="trabajador" id="trabajador"> <!-- lista de trabajadores --> </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="monto" class="form-label">Monto(*)</label>
                                  <input type="number" class="form-control" name="monto" id="monto"/>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="fecha_ingreso" class="form-label">Fecha Ingreso(*)</label>
                                  <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso"/>
                                </div>
                              </div>
                            </div>




                          <!-- Chargue -->
                          <div class="p-l-25px col-lg-12" id="barra_progress_usuario_div" style="display: none;" >
                            <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                              <div id="barra_progress_usuario" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                            </div>
                          </div>
                          <!-- Submit -->
                          <button type="submit" style="display: none;" id="submit-form-pago">Submit</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form();"><i class="las la-times fs-lg"></i> Close</button>
                        <button type="button" class="btn btn-primary" id="guardar_registro_pago" ><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End::modal-registrar-pago -->


                

              </div>
            </div>
            <!-- End::app-content -->

                     

            <?php include("template/search_modal.php"); ?>
            <?php include("template/footer.php"); ?>

          </div>

          <?php include("template/scripts.php"); ?>
          <?php include("template/custom_switcherjs.php"); ?>    

          <!-- Select2 Cdn -->
          <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

          <script src="scripts/gasto_de_trabajador.js"></script>
          <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>

        
        </body>

      </html>
    <?php
  }
  ob_end_flush();
?>