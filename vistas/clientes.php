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

            <div class="col-12">
              <!-- Start::page-header -->
              <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                  <div class="d-md-flex d-block align-items-center ">
                    <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="wiev_tabla_formulario(2); reload_usr_trab(); limpiar_form(); reload_ps();"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="wiev_tabla_formulario(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                    <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"> <i class="ri-save-2-line label-btn-icon me-2"></i> Guardar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Lista de Trabajadores del sistema!</p>
                      <span class="fs-semibold text-muted">Adminstra de manera eficiente tus trabajadores.</span>
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
              <section id="seccion_cliente">
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

              <!-- Start FORMULARIO::row-1 -->
              <section id="seccion_form" style="display: none;">
                <div class="row">
                  <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card">
                      <div class="card-body">

                        <form name="form-empresa" id="form-empresa" method="POST">

                          <div class="row" id="cargando-1-fomulario">

                            <div class="col-12">

                              <div class="row">
                                <!-- Grupo -->
                                <div class="col-12 pl-0">
                                  <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>DATOS DEL CLIENTE</b></label></div>
                                </div>
                              </div>

                              <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%);">

                                <div class="row ">

                                  <input type="hidden" id="idpersona" name="idpersona">
                                  <input type="hidden" id="idtipo_persona" name="idtipo_persona" value="3">
                                  <input type="hidden" id="idbancos" name="idbancos" value="1">
                                  <input type="hidden" id="idcargo_trabajador" name="idcargo_trabajador" value="1">


                                  <!-- TIPO PERSONA -->
                                  <div class="col-12 col-sm-6 col-md-3 col-lg-2" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="nombre_razonsocial">Tipo Persona <sup class="text-danger">*</sup></label>
                                      <select name="tipo_persona_sunat" id="tipo_persona_sunat" class="form-control" placeholder="Tipo Persona">
                                        <option value="Nacional">Nacional</option>
                                        <option value="Juridica">Juridica</option>
                                      </select>
                                    </div>
                                  </div>

                                  <!-- Tipo Doc -->
                                  <div class="col-12 col-sm-6 col-md-3 col-lg-2" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="nombre_razonsocial">Tipo Doc. <sup class="text-danger">*</sup></label>
                                      <select name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo de documento" onchange="view_names();"></select>
                                    </div>
                                  </div>

                                  <!-- N° de documento -->
                                  <div class="col-12 col-sm-6 col-md-3 col-lg-2" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="num_documento">N° de documento <sup class="text-danger">*</sup></label>
                                      <div class="input-group">
                                        <input type="number" name="num_documento" class="form-control inpur_edit" id="num_documento" placeholder="N° de documento" />
                                        <span class="input-group-text" style="cursor: pointer;" data-bs-toggle="tooltip" title="Buscar Reniec/SUNAT" onclick="buscar_sunat_reniec('');">
                                          <i class="fas fa-search text-primary" id="search"></i>
                                          <i class="fa fa-spinner fa-pulse fa-fw fa-lg text-primary" id="charge" style="display: none;"></i>
                                        </span>
                                      </div>
                                    </div>
                                  </div>

                                  <!-- Nombre -->
                                  <div class="col-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label nombre_razon" for="nombre">Nombre <sup class="text-danger">*</sup></label>
                                      <input type="text" name="nombre" class="form-control inpur_edit" id="nombre" />
                                    </div>
                                  </div>

                                  <!-- Apellidos -->
                                  <div class="col-12 col-sm-6 col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label apellidos_nombrecomer" for="nombre">Apellidos <sup class="text-danger">*</sup></label>
                                      <input type="text" name="nombre" class="form-control inpur_edit" id="nombre" />
                                    </div>
                                  </div>
                                  <!-- Fecha cumpleaño -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-2" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="direccion">Fecha nacimiento <sup class="text-danger">*</sup></label>
                                      <input type="date" name="direccion" class="form-control inpur_edit" id="direccion" />
                                    </div>
                                  </div>
                                  <!-- Edad -->
                                  <div class="col-6 col-sm-6 col-md-1 col-lg-1" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="Distrito">Edad <sup class="text-danger">*</sup></label>
                                      <input type="text" name="edad" class="form-control" id="edad" readonly />
                                    </div>
                                  </div>
                                  <!-- Celular  -->
                                  <div class="col-6 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="celular">Celular <sup class="text-danger">*</sup></label>
                                      <input type="number" name="celular" class="form-control inpur_edit" id="celular" />
                                    </div>
                                  </div>

                                  <!-- Dirección -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-7" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="direccion">Dirección <sup class="text-danger">*</sup></label>
                                      <input type="text" name="direccion" class="form-control inpur_edit" id="direccion" />
                                    </div>
                                  </div>
                                  
                                  <!-- Distrito -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-7" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="Distrito">Distrito <sup class="text-danger">*</sup></label>
                                      <select name="distrito" id="distrito" class="form-control" placeholder="Selec. Distrito"></select>
                                    </div>
                                  </div>

                                  <!-- mapa -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="mapa"><span class="badge rounded-pill bg-outline-info cursor-pointer" data-bs-toggle="tooltip" title="Previsualizar" onclick="view_mapa();"><i class="las la-eye fa-lg"></i></span> Mapa Link <sup class="text-danger">*</sup></label>
                                      <textarea class="form-control inpur_edit" name="mapa" id="mapa" id="" cols="30" rows="2"></textarea>
                                    </div>
                                  </div>

                                  <!-- Horario-->
                                  <div class="col-12 col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="horario">Horario <sup class="text-danger">*</sup> </label>
                                      <textarea name="horario" id="horario" class="form-control inpur_edit" rows="2" readonly></textarea>
                                    </div>
                                  </div>

                                </div>

                              </div>

                            </div>

                            <div class="col-12 ">

                              <div class="row">
                                <!-- Grupo -->
                                <div class="col-12 pl-0">
                                  <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>CONTACTO</b></label></div>
                                </div>
                              </div>

                              <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%);">
                                <div class="row">
                                  <!-- Correo -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="correo">Correo <sup class="text-danger">*</sup></label>
                                      <input type="text" name="correo" class="form-control inpur_edit" id="correo" readonly />
                                    </div>
                                  </div>

                                  <!-- celular -->
                                  <div class="col-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="celular">Celular WhatsApp</label>
                                      <div class="input-group">
                                        <span class="input-group-text"><i class="ri-whatsapp-line text-success fa-lg"></i></span>
                                        <input type="tel" name="celular" class="form-control inpur_edit" id="celular" placeholder="Celular" readonly />
                                      </div>
                                    </div>
                                  </div>

                                  <!-- Teléfono -->
                                  <div class="col-6 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="telefono">Teléfono Fijo<sup class="text-danger">*</sup></label>
                                      <input type="text" name="telefono" class="form-control inpur_edit" id="telefono" readonly />
                                    </div>
                                  </div>

                                  <!-- Grupo WhatsApp -->
                                  <div class="col-12 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px;">
                                    <div class="form-group">
                                      <label class="form-label" for="link_grupo_whats">Link Grupo WhatsApp</label>
                                      <div class="input-group">
                                        <span class="input-group-text"><i class="ri-group-line text-success fa-lg"></i></span>
                                        <input type="url" name="link_grupo_whats" id="link_grupo_whats" class="form-control inpur_edit" placeholder="Celular" readonly />
                                      </div>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>

                            <!-- Chargue -->
                            <div class="p-l-25px col-lg-12" id="barra_progress_usuario_div" style="display: none;">
                              <div class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div id="barra_progress_usuario" class="progress-bar" style="width: 0%">
                                  <div class="progress-bar-value">0%</div>
                                </div>
                              </div>
                            </div>

                          </div>

                          <div class="row" id="cargando-2-fomulario" style="display: none;">
                            <div class="col-lg-12 text-center">
                              <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                              <h4 class="bx-flashing">Cargando...</h4>
                            </div>
                          </div>


                          <!-- Submit -->
                          <button type="submit" style="display: none;" id="submit-form-usuario">Submit</button>
                        </form>

                      </div>
                      <div class="card-footer border-top-0">
                        <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1);" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                        <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"> <i class="ri-save-2-line label-btn-icon me-2"></i> Guardar </button>

                      </div>

                    </div>
                  </div>
                </div>
              </section>
              <!-- End FORMULARIO::row-1 -->


            </div>


          </div>


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

    <script src="scripts/persona_cliente.js"></script>
    <script>
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