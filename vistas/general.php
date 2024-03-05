<?php
//Activamos el almacenamiento en el buffer
ob_start();

session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>

    <?php $title_page = "Gastos";
    include("template/head.php"); ?>

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
          <div class="row">
            <div class="col-6">
              <!-- Start::page-header -->
              <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                  <div class="d-md-flex d-block align-items-center ">
                    <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-plan"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Planes</p>
                      <span class="fs-semibold text-muted">Administra los planes de manera eficiente.</span>
                    </div>
                  </div>
                </div>

                <div class="btn-list mt-md-0 mt-2">
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Planes</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- End::page-header -->

              <!-- Start::row-1 -->
              <section id="Planes">
                <div class="row">
                  <div class="col-xxl-12 col-xl-12">
                    <div>
                      <div class="card custom-card">
                        <div class="card-body table-responsive">
                          <table id="tabla-plan" class="table table-bordered w-100" style="width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Acciones</th>
                                <th>Descripción</th>
                                <th>Costo</th>
                                <th class="text-center">Estado</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Acciones</th>
                                <th>Descripción</th>
                                <th>Costo</th>
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
            </div>

            <div class="col-6">
              <!-- Start::page-header -->
              <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                  <div class="d-md-flex d-block align-items-center ">
                    <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_zona();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-zona"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Zonas</p>
                      <span class="fs-semibold text-muted">Administra de manera eficiente las zonas.</span>
                    </div>
                  </div>
                </div>

                <div class="btn-list mt-md-0 mt-2">
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Zonas</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- End::page-header -->

              <!-- Start::row-1 -->
              <section id="zona">
                <div class="row">
                  <div class="col-xxl-12 col-xl-12">
                    <div>
                      <div class="card custom-card">
                        <div class="card-body table-responsive">
                          <table id="tabla-zona" class="table table-bordered w-100" style="width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Acciones</th>
                                <th>Descripción</th>
                                <th>Ip Zona</th>
                                <th class="text-center">Estado</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Acciones</th>
                                <th>Descripción</th>
                                <th>Ip Zona</th>
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
            </div>
          </div>

          <!-- Start::modal-registrar-plan -->
          <div class="modal fade modal-effect" id="modal-agregar-plan" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-pagoLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollabel">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-pagoLabel1">Planes</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-plan" id="form-agregar-plan" method="POST" class="row needs-validation" novalidate>
                    <div class="row gy-2" id="cargando-1-fomulario">
                      <input type="hidden" name="idplan" id="idplan">

                      <div class="col-md-8">
                        <div class="form-label">
                          <label for="nombre_plan" class="form-label">Nombre del Plan(*)</label>
                          <input class="form-control" name="nombre_plan" id="nombre_plan" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="costo_plan" class="form-label">Monto(*)</label>
                          <input type="number" class="form-control" name="costo_plan" id="costo_plan" />
                        </div>
                      </div>
                    </div>
                    <div class="row" id="cargando-2-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>
                    <button type="submit" style="display: none;" id="submit-form-plan">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary btn-guardar" id="guardar_registro_plan"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::modal-registrar-plan -->

          <!-- Start::modal-registrar-zona -->
          <div class="modal fade modal-effect" id="modal-agregar-zona" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-zonaLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollabel">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-pagoLabel1">Zona</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-zona" id="form-agregar-zona" method="POST" class="row needs-validation" novalidate>
                    <div class="row gy-2" id="cargando-3-fomulario">
                      <input type="hidden" name="idzona_antena" id="idzona_antena">

                      <div class="col-12">
                        <div class="form-label">
                          <label for="nombre_zona" class="form-label">Nombre del Zona(*)</label>
                          <input class="form-control" name="nombre_zona" id="nombre_zona" />
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="ip_antena" class="form-label">Ip Zona(*)</label>
                          <input type="text" class="form-control" name="ip_antena" id="ip_antena" />
                        </div>
                      </div>
                    </div>
                    <div class="row" id="cargando-4-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>
                    <button type="submit" style="display: none;" id="submit-form-zona">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_zona();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary btn-guardarzona" id="guardar_registro_zona"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::modal-registrar-zona -->




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

    <script src="scripts/plan.js"></script>
    <script src="scripts/zona.js"></script>
    


  </body>

  </html>
<?php
}
ob_end_flush();
?>