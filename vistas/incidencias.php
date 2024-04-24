<?php
//Activamos el almacenamiento en el buffer
ob_start();
require "../config/funcion_general.php";
session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
  <!DOCTYPE html>
  <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close" loader="enable">

  <head>

    <?php $title_page = "Gastos";
    include("template/head.php"); ?>
    <style>
      .choices {
        margin-bottom: 0px !important;
      }
    </style>

  </head>

  <body id="body-gastos-trab">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if ($_SESSION['gastos_trabajador'] == 1) { ?>

        <!-- Start::app-content -->
        <div class="main-content app-content">
          <div class="container-fluid">

            <!-- Start::row-1 -->
            <div class="row">
              <div class="col-xl-3">
                <div class="card custom-card">
                  <div class="card-body p-0">
                    <div class="p-3 d-grid border-bottom border-block-end-dashed">
                      <button class="btn btn-primary d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addtask" onclick="limpiar_form();">
                        <i class="ri-add-circle-line fs-16 align-middle me-1"></i>Crear Incidencia
                      </button>
                      <div class="modal fade" id="addtask" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h6 class="modal-title" id="mail-ComposeLabel">Crear Incidencia</h6>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4">
                              <form name="form-agregar-incidencia" id="form-agregar-incidencia" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" id="idincidencia" name="idincidencia">
                                <div class="row gy-2">
                                  <!-- Asunto -->
                                  <div class="col-xl-12">
                                    <div class="form-group">
                                      <label for="actividad" class="form-label">Asunto</label>
                                      <input type="text" class="form-control" name="actividad" id="actividad" placeholder=" Descripción Asunto">
                                    </div>
                                  </div>
                                  <!-- Trabajadores -->
                                  <div class="col-xl-12">
                                    <div class="form-group">
                                      <label class="form-label">Asignado a</label>
                                      <select class="form-control" name="id_trabajador[]" id="id_trabajador" multiple>
                                      </select>
                                    </div>
                                  </div>
                                  <!-- Fecha -->
                                  <div class="col-xl-6">
                                    <div class="form-group">
                                      <label class="form-label">Fecha</label>
                                      <div class="input-group">
                                        <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                        <input type="date" class="form-control" id="adDate" name="creacionfecha" placeholder="Elige fecha">
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Prioridad -->
                                  <div class="col-xl-6">
                                    <div class="form-group">
                                      <label class="form-label">Prioridad</label>
                                      <select class="form-select" id="prioridad" name="prioridad" data-trigger>
                                        <option value="">This is a placeholder </option>
                                        <option value="CRÍTICO">1 CRÍTICO</option>
                                        <option value="ALTO">2 ALTO</option>
                                        <option value="MEDIO">3 MEDIO</option>
                                        <option value="BAJO">4 BAJO</option>
                                      </select>
                                    </div>
                                  </div>
                                  <!-- Categoría -->
                                  <div class="mb-1 col-md-3 col-lg-3 col-xl-3 col-xxl-6">
                                    <div class="form-group">
                                      <label for="categoria" class="form-label">Tipo documento: </label>
                                      <select name="categoria" id="categoria" class="form-select" required>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xl-12">
                                    <div class="form-group">
                                      <label for="actividad_detalle" class="form-label">Detalle</label>
                                      <textarea class="form-control" id="actividad_detalle" name="actividad_detalle" cols="30" rows="3"></textarea>
                                    </div>
                                  </div>
                                </div>
                                <!-- Submit -->
                                <button type="submit" style="display: none;" id="submit-form-incidencia">Submit</button>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="limpiar_form();">Cancelar</button>
                              <button type="button" class="btn btn-primary btn-guardar">Crear</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- LISTA DE CATEOGRIAS -->
                    <div class="p-3 task-navigation border-bottom border-block-end-dashed">
                      <ul class="list-unstyled task-main-nav lista-items mb-0">
                        <li class="px-0 pt-0">
                          <span class="fs-11 text-muted op-7 fw-semibold">Categorías</span>
                        </li>
                      </ul>
                    </div>
                    <div class="p-3 text-center">
                      <img src="../assets/images/media/media-66.png" alt="">
                    </div>
                    <!-- FIN LISTA DE CATEOGRIAS -->

                  </div>
                </div>
              </div>
              <!-- LISTA DE INCIDENCIAS POR PRIORIDAD  -->

              <div class="col-xl-9">
                <div class="row">
                  <div class="col-xl-12">
                    <div class="card custom-card">
                      <div class="card-body p-0">
                        <div class="d-flex p-3 align-items-center justify-content-between">
                          <div>
                            <h6 class="fw-semibold mb-0">Prioridad</h6>
                          </div>
                          <!-- PRIORIDAD -->
                          <div>
                            <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block" role="tablist">
                              <li class="nav-item m-1">
                                <a class="nav-link active cursor-pointer" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true" onclick="prioridad('TODOS')">TODOS</a>
                              </li>
                              <li class="nav-item m-1">
                                <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true" onclick="prioridad('CRÍTICO')">CRÍTICO</a>
                              </li>
                              <li class="nav-item m-1">
                                <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true" onclick="prioridad('ALTO')">ALTO</a>
                              </li>
                              <li class="nav-item m-1">
                                <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true"  onclick="prioridad('MEDIO')">MEDIO</a>
                              </li>
                              <li class="nav-item m-1 ">
                                <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true" onclick="prioridad('BAJO')">BAJO</a>
                              </li>
                            </ul>
                          </div>
                          <!-- FIN PRIORIDAD -->

                          <div>
                            <div class="dropdown">
                              <button class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Select All</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Share All</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Delete All</a></li>
                              </ul>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-content task-tabs-container">
                    <div class="tab-pane show active p-0" id="all-tasks" role="tabpanel">
                      <div class="row list_incidencias" id="tasks-container">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <ul class="pagination justify-content-end">
                  <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">Next</a>
                  </li>
                </ul> -->
              </div>
              <!-- LISTA DE INCIDENCIAS POR PRIORIDAD  -->

            </div>
            <!--End::row-1 -->


          </div>
        </div>
        <!-- End::app-content -->
      <?php } else {
        $title_submodulo = 'Gasto de Trabajador';
        $descripcion = 'Lista de Gasto de Trabajador del sistema!';
        $title_modulo = 'Gasto';
        include("403_error.php");
      } ?>

      <!-- MODAL - VER COMPROBANTE -->
      <div class="modal fade modal-effect" id="modal-ver-comprobante" tabindex="-1" aria-labelledby="modal-ver-comprobanteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title title-modal-comprobante" id="modal-ver-comprobanteLabel1">COMPROBANTE</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="comprobante-container" class="text-center"> <!-- archivo -->
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                    <h4 class="bx-flashing">Cargando...</h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger py-1" data-bs-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End::Modal-Comprobante -->

      <!-- MODAL - VER DETALLE -->
      <div class="modal fade modal-effect" id="modal-ver-detalle" tabindex="-1" aria-labelledby="modal-ver-detalleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal-ver-detalleLabel1"><b>Detalles</b> - Gasto de Trabajador</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="html-detalle-compra"></div>
              <div class="text-center" id="html-detalle-comprobante"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End::Modal-VerDetalles -->

      <!-- MODAL - AGREGAR TRABAJADOR - charge 3 -->
      <div class="modal fade modal-effect" id="modal-agregar-proveedor" tabindex="-1" aria-labelledby="Modal-agregar-proveedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title title-modal-img" id="Modal-agregar-proveedorLabel1">Agregar Proveedor</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">

              <form name="form-agregar-proveedor" id="form-agregar-proveedor" method="POST" class="needs-validation" novalidate>

                <div class="row" id="cargando-3-fomulario">
                  <!-- idpersona -->
                  <input type="hidden" name="idpersona" id="idpersona" />
                  <input type="hidden" name="tipo_persona_sunat" id="tipo_persona_sunat" value="NATURAL" />
                  <input type="hidden" name="idtipo_persona" id="idtipo_persona" value="4" />

                  <div class="col-lg-12 col-xl-12 col-xxl-6">
                    <div class="row">
                      <!-- Grupo -->
                      <div class="col-12 pl-0">
                        <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2">DATOS GENERALES</b></label></div>
                      </div>
                    </div> <!-- /.row -->
                    <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                      <div class="row">

                        <!-- Tipo documento -->
                        <div class="mb-1 col-md-3 col-lg-3 col-xl-3 col-xxl-6">
                          <div class="form-group">
                            <label for="tipo_documento" class="form-label">Tipo documento: </label>
                            <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                            </select>
                          </div>
                        </div>

                        <!--  Numero Documento -->
                        <div class="mb-1 col-md-3 col-lg-3 col-xl-3 col-xxl-6">
                          <div class="form-group">
                            <label for="numero_documento" class="form-label">Numero Documento:</label>
                            <div class="input-group">
                              <input type="number" class="form-control" name="numero_documento" id="numero_documento" placeholder="" aria-describedby="icon-view-password">
                              <button class="btn btn-primary" type="button" onclick="buscar_sunat_reniec('_t', '#tipo_documento', '#numero_documento', '#nombre_razonsocial', '#apellidos_nombrecomercial', '#direccion', '#distrito', '#titular_cuenta' );">
                                <i class='bx bx-search-alt' id="search_t"></i>
                                <div class="spinner-border spinner-border-sm" role="status" id="charge_t" style="display: none;"></div>
                              </button>
                            </div>
                          </div>
                        </div>

                        <!-- Nombres -->
                        <div class="mb-1 col-md-6 col-lg-6 col-xl-4 col-xxl-6">
                          <div class="form-group">
                            <label for="nombre_razonsocial" class="form-label label-nom-raz">Nombres: </label></label>
                            <input type="text" class="form-control" name="nombre_razonsocial" id="nombre_razonsocial">
                          </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="mb-1 col-md-6 col-lg-6 col-xl-4 col-xxl-6 ">
                          <div class="form-group">
                            <label for="apellidos_nombrecomercial" class="form-label label-ape-come">Apellidos: </label></label>
                            <input type="text" class="form-control" name="apellidos_nombrecomercial" id="apellidos_nombrecomercial">
                          </div>
                        </div>

                        <!-- Correo -->
                        <div class="mb-1 col-md-6 col-lg-4 col-xl-4 col-xxl-6">
                          <div class="form-group">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" name="correo" id="correo">
                          </div>
                        </div>

                        <!-- Celular -->
                        <div class="col-md-6 col-lg-3 col-xl-4 col-xxl-6">
                          <div class="form-group">
                            <label for="celular" class="form-label">Celular:</label>
                            <input type="tel" class="form-control" name="celular" id="celular">
                          </div>
                        </div>

                      </div> <!-- /.row -->
                    </div> <!-- /.card-body -->
                  </div> <!-- /.col-lg-12 -->

                  <div class="col-lg-12 col-xl-12 col-xxl-6">
                    <div class="row">
                      <!-- Grupo -->
                      <div class="col-12 pl-0">
                        <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2">UBICACIÓN</b></label></div>
                      </div>
                    </div> <!-- /.row -->
                    <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                      <div class="row">

                        <!-- Direccion -->
                        <div class="mb-1 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-3">
                          <div class="form-group">
                            <label for="direccion" class="form-label">Direccion:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion">
                          </div>
                        </div>
                        <!-- Distrito -->
                        <div class="mb-1 col-md-3 col-lg-6 col-xl-6 col-xxl-6 mt-3">
                          <div class="form-group">
                            <label for="distrito" class="form-label">Distrito: </label>
                            <select name="distrito" id="distrito" class="form-select">

                            </select>
                          </div>
                        </div>
                        <!-- Departamento -->
                        <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                          <div class="form-group">
                            <label for="departamento" class="form-label">Departamento: <span class="chargue-pro"></span></label>
                            <input type="text" class="form-control" name="departamento" id="departamento" readonly>
                          </div>
                        </div>
                        <!-- Provincia -->
                        <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                          <div class="form-group">
                            <label for="provincia" class="form-label">Provincia: <span class="chargue-dep"></span></label>
                            <input type="text" class="form-control" name="provincia" id="provincia" readonly>
                          </div>
                        </div>
                        <!-- Ubigeo -->
                        <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                          <div class="form-group">
                            <label for="ubigeo" class="form-label">Ubigeo: <span class="chargue-ubi"></span></label>
                            <input type="text" class="form-control" name="ubigeo" id="ubigeo" readonly>
                          </div>
                        </div>
                      </div> <!-- /.row -->
                    </div> <!-- /.card-body -->
                  </div> <!-- /.col-lg-12 -->

                  <div class="mt-3 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="row">
                      <!-- Grupo -->
                      <div class="col-12 pl-0">
                        <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2">BANCO</b></label></div>
                      </div>
                    </div> <!-- /.row -->
                    <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                      <div class="row">

                        <!-- Banco -->
                        <div class="mb-1 col-md-3 col-lg-6 col-xl-6 col-xxl-4 mt-3">
                          <div class="form-group">
                            <label for="idbanco" class="form-label">Entidad Financiera: </label>
                            <select name="idbanco" id="idbanco" class="form-select" required>
                            </select>
                          </div>
                        </div>

                        <!-- Cuenta Bancaria -->
                        <div class="mb-1 col-md-6 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                          <div class="form-group">
                            <label for="cuenta_bancaria" class="form-label">Cuenta Bancaria:</label>
                            <input type="text" class="form-control" name="cuenta_bancaria" id="cuenta_bancaria">
                          </div>
                        </div>

                        <!-- CCI -->
                        <div class="mb-1 col-md-6 col-lg-3 col-xl-4 col-xxl-4 mt-3">
                          <div class="form-group">
                            <label for="cci" class="form-label">CCI:</label>
                            <input type="text" class="form-control" name="cci" id="cci">
                          </div>
                        </div>

                      </div> <!-- /.row -->
                    </div> <!-- /.card-body -->
                  </div> <!-- /.col-lg-12 -->

                  <!-- Imgen -->
                  <div class="col-md-4 col-lg-4 mt-4">
                    <span class=""> <b>Logo Proveedor</b> </span>
                    <div class="mb-4 mt-2 d-sm-flex align-items-center">
                      <div class="mb-0 me-5">
                        <span class="avatar avatar-xxl avatar-rounded">
                          <img src="../assets/images/default/default_proveedor.png" alt="" id="imagenmuestra" onerror="this.src='../assets/images/default/default_proveedor.png';">
                          <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge cursor-pointer">
                            <input type="file" class="position-absolute w-100 h-100 op-0" name="imagen" id="imagen" accept="image/*">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <i class="fe fe-camera  "></i>
                          </a>
                        </span>
                      </div>
                      <div class="btn-group">
                        <a class="btn btn-primary" onclick="cambiarImagen()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                        <a class="btn btn-light" onclick="removerImagen()"><i class="bi bi-trash fs-6"></i> Remover</a>
                      </div>
                    </div>
                  </div>

                </div> <!-- /.row -->

                <div class="row" id="cargando-4-fomulario" style="display: none;">
                  <div class="col-lg-12 text-center">
                    <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                    <h4 class="bx-flashing">Cargando...</h4>
                  </div>
                </div> <!-- /.row -->

                <!-- Chargue -->
                <div class="p-l-25px col-lg-12" id="barra_progress_proveedor_div" style="display: none;">
                  <div class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div id="barra_progress_proveedor" class="progress-bar" style="width: 0%">
                      <div class="progress-bar-value">0%</div>
                    </div>
                  </div>
                </div>
                <!-- Submit -->
                <button type="submit" style="display: none;" id="submit-form-proveedor">Submit</button>
              </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="las la-times"></i> Close</button>
              <button type="button" class="btn btn-sm btn-success label-btn" id="guardar_registro_proveedor"><i class="bx bx-save bx-tada"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End::Modal-Agregar-Proveedor -->

      <!-- MODAL - VER IMAGEN -->
      <div class="modal fade modal-effect" id="modal-ver-img" tabindex="-1" aria-labelledby="modal-agregar-usuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title title-modal-img" id="modal-agregar-usuarioLabel1">Imagen</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body html_ver_img">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
          </div>
        </div>
      </div>


      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>
    <!-- Flat Picker JS -->
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>

    <!-- Internal To-Do-List JS -->
    <!-- <script src="../assets/js/todolist.js"></script> -->

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

    <script src="scripts/incidencias.js"></script>

    <script>
      flatpickr("#adDate", {
        enableTime: false,
        dateFormat: "d-m-Y",
      });


      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>


  </body>

  </html>
<?php
}
ob_end_flush();
?>