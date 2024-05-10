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
  <html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close" loader="enable">

  <head>

    <?php $title_page = "Landing pages";
    include("template/head.php"); ?>

    <!-- Quill Editor CSS -->
    <link rel="stylesheet" href="../assets/libs/quill/quill.snow.css">
    <link rel="stylesheet" href="../assets/libs/quill/quill.bubble.css">
  </head>

  <body id="body-usuario">

    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>
    

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>

      <?php if ($_SESSION['configuracion'] == 1) { ?>
        <!-- Start::app-content -->
        <div class="main-content app-content">
          <div class="container-fluid">
            <div class="row">

              <div class="col-12 col-sm-12 mt-4">
                <div class="card card-primary card-outline card-tabs mb-0">
                  <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs tab-style-2 mb-1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cliente" data-bs-toggle="tab" data-bs-target="#cliente-pane" type="button" role="tab" aria-selected="true"><i class="ri-user-line me-1 align-middle"></i>CLIENTE</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="equipo" data-bs-toggle="tab" data-bs-target="#equipo-pane" type="button" role="tab" aria-selected="true"><i class="fas fa-user-tie"></i>EQUIPO</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="precio" data-bs-toggle="tab" data-bs-target="#precio-pane" type="button" role="tab" aria-selected="false"><i class="ri-tools-line me-1 align-middle"></i>PRECIO</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="faqs" data-bs-toggle="tab" data-bs-target="#faqs-pane" type="button" role="tab" aria-selected="false"><i class="ri-dashboard-line me-1 align-middle"></i>FAQ'S</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-12 col-lg-12 col-xl-12 p-0">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="equipo-pane" role="tabpanel" tabindex="0">
                    <div class="row">

                      

                      <!-- :::::::::::::::: Z O N A :::::::::::::::: -->
                      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6 col-xxl-6">
                        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 mt-2 page-header-breadcrumb">
                          <div>
                            <div class="d-md-flex d-block align-items-center ">
                              <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_zona();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-zona"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                              <div>
                                <p class="fw-semibold fs-18 mb-0"><b>Zonas</b></p>
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

                      <!-- :::::::::::::::: C E N T R O    P O B L A D O :::::::::::::::: -->
                      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6 col-xxl-6">
                        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 mt-2 page-header-breadcrumb">
                          <div>
                            <div class="d-md-flex d-block align-items-center ">
                              <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_centro_poblado();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-centro-poblado"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                              <div>
                                <p class="fw-semibold fs-18 mb-0">Centro Poblado</p>
                                <span class="fs-semibold text-muted">Administra de manera eficiente tus lugares.</span>
                              </div>
                            </div>
                          </div>
                          <div class="btn-list mt-md-0 mt-2">
                            <nav>
                              <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Centro Poblado</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                              </ol>
                            </nav>
                          </div>
                        </div>
                        <div class="card custom-card">
                          <div class="card-body table-responsive">
                            <table id="tabla-centro-poblado" class="table table-bordered w-100" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Nombre</th>
                                  <th>Descripción</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Nombre</th>
                                  <th>Descripción</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="tab-pane fade" id="precio-pane" role="tabpanel" tabindex="0">
                    <div class="row">

                    <!-- :::::::::::::::: P L A N E S :::::::::::::::: -->
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6 col-xxl-6">
                      <div class="d-md-flex d-block align-items-center justify-content-between mb-4 mt-2 page-header-breadcrumb">
                        <div>
                          <div class="d-md-flex d-block align-items-center ">
                          
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
                      <div class="card custom-card">
                        <div class="card-body">
                          <div class="table-responsive" id="div-tabla-plan">                            
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
                          <div id="div-form-plan" style="display: none;"> 
                            <form name="form-agregar-plan" id="form-agregar-plan" method="POST" class="needs-validation" novalidate>
                              <div class="row" id="cargando-1-fomulario">
                                <input type="hidden" name="idplan" id="idplan">

                                <div class="col-md-8">
                                  <div class="form-label">
                                    <label for="nombre_plan" class="form-label">Nombre del Plan(*)</label>
                                    <input class="form-control" name="nombre_plan" id="nombre_plan" readonly />
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="costo_plan" class="form-label">Monto(*)</label>
                                    <input type="number" class="form-control" name="costo_plan" id="costo_plan" readonly />
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div id="editor">
                                    
                                  </div>
                                  <textarea name="caracteristicas" id="caracteristicas" class="hidden"></textarea>
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
                        </div>
                        <div id="footer-plan" name="footer-plan" class="card-footer d-flex justify-content-end d-none">
                          <button id="cancelar_plan" name="cancelar_plan" class="btn-modal-effect btn btn-danger label-btn btn-cancelar m-r-10px" style="display: none;" onclick="show_hide_form_plan(1);"><i class="ri-close-line label-btn-icon me-2"> </i> Cancelar</button>
                          <button id="guardar_plan" name="guardar_plan" class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"> <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                        </div>
                      </div>
                    </div>
                    
                    </div>
                  </div>

                  <div class="tab-pane fade" id="faqs-pane" role="tabpanel" tabindex="0">
                    <div class="row">

                      <!-- :::::::::::::::: P R E G U N T A S   F R E C U E N T E S :::::::::::::::: -->
                      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6 col-xxl-6">
                        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 mt-2 page-header-breadcrumb">
                          <div>
                            <div class="d-md-flex d-block align-items-center ">
                              <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form_preguntas();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" data-bs-target="#modal-agregar-preguntas"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                              <div>
                                <p class="fw-semibold fs-18 mb-0">Preguntas Frecuentes</p>
                                <span class="fs-semibold text-muted">Administra las preguntas y respuestas.</span>
                              </div>
                            </div>
                          </div>

                          <div class="btn-list mt-md-0 mt-2">
                            <nav>
                              <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Preguntas</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                              </ol>
                            </nav>
                          </div>
                        </div>
                        <div class="card custom-card">
                          <div class="card-body table-responsive">
                            <table id="tabla-preguntas-frecuentes" class="table table-bordered w-100" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Pregunta</th>
                                  <th>Respuesta</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Pregunta</th>
                                  <th>Respuesta</th>
                                  <th class="text-center">Estado</th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- MODAL:: REGISTRAR ZONA - charge 3 -->
            <div class="modal fade modal-effect" id="modal-agregar-zona" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-zonaLabel" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-scrollabel">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title" id="modal-agregar-zonaLabel">Zona</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form name="form-agregar-zona" id="form-agregar-zona" method="POST" class="needs-validation" novalidate>
                      <div class="row" id="cargando-3-fomulario">
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
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="limpiar_zona();"><i class="las la-times"></i> Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar_registro_zona"><i class="bx bx-save bx-tada"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End::modal-registrar-zona -->

            <!-- MODAL::REGISTRAR CENTRO POBLADO - charge 5 -->
            <div class="modal fade modal-effect" id="modal-agregar-centro-poblado" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-centro-poblado" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-scrollabel">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title" id="modal-agregar-centro-poblado">Centro poblado</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form name="form-agregar-centro-poblado" id="form-agregar-centro-poblado" method="POST" class="needs-validation" novalidate>
                      <div class="row" id="cargando-5-fomulario">
                        <input type="hidden" name="idcentro_poblado" id="idcentro_poblado">

                        <div class="col-12">
                          <div class="form-label">
                            <label for="nombre_cp" class="form-label">Nombre(*)</label>
                            <input class="form-control" name="nombre_cp" id="nombre_cp" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="descripcion_cp" class="form-label">Descripcion</label>
                            <textarea class="form-control" name="descripcion_cp" id="descripcion_cp" cols="30" rows="2"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="cargando-6-fomulario" style="display: none;">
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>
                      <button type="submit" style="display: none;" id="submit-form-cp">Submit</button>
                    </form>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="limpiar_centro_poblado();"><i class="las la-times"></i> Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar_registro_cp"><i class="bx bx-save bx-tada"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End::modal-registrar-zona -->

            <!-- MODAL :: preguntas frecuentes - charge 7 -->
            <div class="modal fade modal-effect" id="modal-agregar-preguntas" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-preguntas" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Pregunta Frecuente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <!-- form start -->
                    <form id="form-agregar-preguntas" name="form-agregar-preguntas" method="POST" autocomplete="off">
                      <div class="card-body">
                        <div class="row" id="cargando-9-fomulario">
                          <!-- id	preguntas_frecuentes -->
                          <input type="hidden" name="	idpreguntas_frecuentes" id="	idpreguntas_frecuentes" />

                          <!-- Pregunta -->
                          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label class="form-label" for="pregunta_pf">Pregunta</label>
                              <input type="text" name="pregunta_pf" id="pregunta_pf" class="form-control" placeholder="preguntas." />
                            </div>
                          </div>

                          <!-- Respuesta -->
                          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                              <label class="form-label" for="respuesta_pf">Respuesta</label>
                              <textarea name="respuesta_pf" id="respuesta_pf" class="form-control" placeholder="respuesta"></textarea>
                            </div>
                          </div>

                        <div class="row" id="cargando-10-fomulario" style="display: none;">
                          <div class="col-lg-12 text-center">
                            <i class="fas fa-spinner fa-pulse fa-6x"></i><br />
                            <br />
                            <h4>Cargando...</h4>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <button type="submit" style="display: none;" id="submit-form-preguntas">Submit</button>
                    </form>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="limpiar_preguntas();"><i class="las la-times"></i> Close</button>
                    <button type="submit" class="btn btn-sm btn-success" id="guardar_registro_preguntas"><i class="bx bx-save bx-tada"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End::modal-preguntas -->

            <!-- MODAL:: REGISTRAR CARGO TRABAJADOR- charge 1 -->
            <div class="modal fade modal-effect" id="modal-agregar-c-t" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-c-tLabel" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-scrollabel">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title">Cargo Trabajador</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form name="form-agregar-c-t" id="form-agregar-c-t" method="POST" class="row needs-validation" novalidate>
                      <div class="row gy-2" id="cargando-9-fomulario">
                        <input type="hidden" name="idcargo_trabajador" id="idcargo_trabajador">

                        <div class="col-md-12">
                          <div class="form-label">
                            <label for="nombre_plan" class="form-label">Nombre:</label>
                            <input class="form-control" name="nombre_ct" id="nombre_ct" onkeyup="mayus(this);" />
                          </div>
                        </div>
                      </div>
                      <div class="row" id="cargando-10-fomulario" style="display: none;">
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>
                      <button type="submit" style="display: none;" id="submit-form-ct">Submit</button>
                    </form>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="limpiar_form_ct();"><i class="las la-times"></i> Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar_registro_ct"><i class="bx bx-save bx-tada"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End::modal-registrar-cargo-trabajador -->

            <!-- MODAL:: REGISTRAR CARGO TRABAJADOR- charge 1 -->
            <div class="modal fade modal-effect" id="modal-agregar-cat-inc" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-cat-tLabel" aria-hidden="true">
              <div class="modal-dialog modal-md modal-dialog-scrollabel">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title">Categoría Incidencia</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form name="form-agregar-inc" id="form-agregar-inc" method="POST" class="row needs-validation" novalidate>
                      <div class="row gy-2" id="cargando-11-fomulario">
                        <input type="hidden" name="idincidencia_categoria" id="idincidencia_categoria">

                        <div class="col-md-12">
                          <div class="form-label">
                            <label for="nombre_plan" class="form-label">Nombre:</label>
                            <input class="form-control" name="nombre_inc" id="nombre_inc" onkeyup="mayus(this);" />
                          </div>
                        </div>
                      </div>
                      <div class="row" id="cargando-12-fomulario" style="display: none;">
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>
                      <button type="submit" style="display: none;" id="submit-form-inc">Submit</button>
                    </form>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="limpiar_form_cat_inc();"><i class="las la-times"></i> Close</button>
                    <button type="button" class="btn btn-sm btn-primary" id="guardar_registro_inc"><i class="bx bx-save bx-tada"></i> Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End::modal-categoria_incidencia -->



          </div>
        </div>
        <!-- End::app-content -->
      <?php } else {
        $title_submodulo = 'General';
        $descripcion = 'Lista de General del sistema!';
        $title_modulo = 'Configuracion';
        include("403_error.php");
      } ?>

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <!-- Quill Editor JS -->
    <script src="../assets/libs/quill/quill.min.js"></script>
    <!-- Internal Quill JS -->
    <script src="../assets/js/quill-editor.js"></script>

    <script src="scripts/landing_page.js"></script>

    <!-- <script src="scripts/plan.js"></script> -->
    <script src="scripts/zona.js"></script>
    <script src="scripts/centro_poblado.js"></script>
    <script src="scripts/cargo_trabajador.js"></script>


  </body>

  </html>
<?php
}
ob_end_flush();
?>