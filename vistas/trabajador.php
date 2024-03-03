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
        
        <?php $title_page = "Trabajadores"; include("template/head.php"); ?>    

      </head> 

      <body id="body-usuario" idusuario="<?php echo $_SESSION['idusuario']; ?>"  > 

        <?php include("template/switcher.php"); ?>
        <?php include("template/loader.php"); ?>

        <div class="page">
          <?php include("template/header.php") ?>
          <?php include("template/sidebar.php") ?>
          <?php if($_SESSION['registrar_trabajador']==1) { ?>

          <!-- Start::app-content -->
          <div class="main-content app-content">
            <div class="container-fluid">

              <!-- Start::page-header -->
              <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                  <div class="d-md-flex d-block align-items-center ">
                    <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="show_hide_form(2); reload_usr_trab(); limpiar_form(); reload_ps();"  > <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="show_hide_form(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                    <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Lista de Trabajadores del sistema!</p>
                      <span class="fs-semibold text-muted">Adminstra de manera eficiente tus trabajadores.</span>
                    </div>                
                  </div>
                </div>
                
                <div class="btn-list mt-md-0 mt-2">              
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Planilla</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Trabajador</li>
                    </ol>
                  </nav>
                </div>
              </div>          
              <!-- End::page-header -->

              <!-- Start::row-1 -->
              <div class="row">
                <div class="col-xxl-12 col-xl-12">
                  
                  <div class="card custom-card">                  
                    <div class="card-body">
                      <div id="div-tabla" class="table-responsive">
                        <table id="tabla-usuario" class="table table-bordered w-100" style="width: 100%;">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Opciones</th>                          
                              <th>Nombre</th>
                              <th>Usuario</th>
                              <th>Cargo</th>                          
                              <th>Teléfono</th>
                              <th>Sesión</th>
                              <th>Estado</th> 
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Opciones</th>                          
                              <th>Nombre</th>
                              <th>Usuario</th>
                              <th>Cargo</th>                          
                              <th>Teléfono</th>
                              <th>Sesión</th>
                              <th>Estado</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>    
                      <div id="div-form" style="display: none;">
                        <form name="form-agregar-usuario" id="form-agregar-usuario" method="POST" class="row g-3 needs-validation" novalidate>                          
                           
                          <div class="row gy-2" id="cargando-1-fomulario">
                            <!-- idpersona -->
                            <input type="hidden" name="idpersona" id="idpersona" />   

                            <!-- Tipo documento -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="nombre_razonsocial" class="form-label">Tipo documento:  </label></label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo de documento">
                                  
                                </select>
                              </div>                                         
                            </div>
                            
                            <!--  Contraseña -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="numero_documento" class="form-label">Numero Documento:</label>
                                <div class="input-group mb-3">                            
                                  <input type="text" class="form-control" name="numero_documento" id="numero_documento" placeholder="Contraseña" aria-describedby="icon-view-password">
                                  <button class="btn btn-primary" type="button" onclick="buscar_sunat_reniec('_t', '#tipo_documento', '#numero_documento', '#nombre_razonsocial', '#apellidos_nombrecomercial', '#direccion', '#distrito' );" >
                                    <i class='bx bx-search-alt' id="search_t"></i>
                                    <div class="spinner-border spinner-border-sm" role="status" id="charge_t" style="display: none;"></div>
                                  </button>
                                </div>
                              </div>                        
                            </div>
                            <!-- CArgo -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="ruc" class="form-label">RUC:  </label></label>
                                <input type="text" class="form-control" name="ruc" id="ruc" >
                              </div>                                         
                            </div>

                            <!-- CArgo -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="idcargo_trabajador" class="form-label">Cargo:  </label></label>
                                <select name="idcargo_trabajador" id="idcargo_trabajador" class="form-control" >   </select>
                              </div>                                         
                            </div>
                          
                            <!-- CArgo -->
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="nombre_razonsocial" class="form-label">Nombres:  </label></label>
                                <input type="text" class="form-control" name="nombre_razonsocial" id="nombre_razonsocial" >
                              </div>                                         
                            </div>
                            <!-- CArgo -->
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="apellidos_nombrecomercial" class="form-label">Apellidos:  </label></label>
                                <input type="text" class="form-control" name="apellidos_nombrecomercial" id="apellidos_nombrecomercial" >
                              </div>                                         
                            </div>
                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-6 col-xl-6">
                              <div class="form-group">
                                <label for="direccion" class="form-label">Direccion:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion">
                              </div>                                         
                            </div>
                            <!-- Distrito -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="distrito" class="form-label">Distrito:  </label></label>
                                <select name="distrito" id="distrito" class="form-control" placeholder="Seleccionar" onchange="llenar_dep_prov_ubig(this);">                                  
                                </select>
                              </div>                                         
                            </div>
                            <!-- Usuario -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="departamento" class="form-label">Departamento: <span class="chargue-pro"></span></label>
                                <input type="text" class="form-control" name="departamento" id="departamento">
                              </div>                                         
                            </div>
                            <!-- Usuario -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="provincia" class="form-label">Provincia: <span class="chargue-dep"></span></label>
                                <input type="text" class="form-control" name="provincia" id="provincia">
                              </div>                                         
                            </div>
                            <!-- Usuario -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="ubigeo" class="form-label">Ubigeo: <span class="chargue-ubi"></span></label>
                                <input type="text" class="form-control" name="ubigeo" id="ubigeo">
                              </div>                                         
                            </div>
                            <!-- CArgo -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="fecha_nacimiento" class="form-label">Nacimiento:  </label></label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" >
                              </div>                                         
                            </div>
                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="edad" class="form-label">Edad:</label>
                                <input type="text" class="form-control" name="edad" id="edad" >
                              </div>                                         
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" name="celular" id="celular" >
                              </div>                                         
                            </div>                            

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="correo" class="form-label">Correo:</label>
                                <input type="text" class="form-control" name="correo" id="correo">
                              </div>                                         
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="login" class="form-label">Sueldo mes:</label>
                                <input type="text" class="form-control" name="login" id="login" required>
                              </div>                                         
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="login" class="form-label">Sueldo dia:</label>
                                <input type="text" class="form-control" name="login" id="login" required>
                              </div>                                         
                            </div>

                            <!-- Banco -->
                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="idbanco" class="form-label">Banco:  </label></label>
                                <select name="idbanco" id="idbanco" class="form-control" placeholder="Seleccionar">                                  
                                </select>
                              </div>                                         
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="cuenta_bancaria" class="form-label">Cuenta Bancaria:</label>
                                <input type="text" class="form-control" name="cuenta_bancaria" id="cuenta_bancaria" required>
                              </div>                                         
                            </div>

                            <!-- Usuario -->
                            <div class="col-md-6 col-lg-3 col-xl-3">
                              <div class="form-group">
                                <label for="cci" class="form-label">CCI:</label>
                                <input type="text" class="form-control" name="cci" id="cci" required>
                              </div>                                         
                            </div>
                            

                          </div>
                          <div class="row" id="cargando-2-fomulario" style="display: none;" >
                            <div class="col-lg-12 text-center">                         
                              <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                              <h4 class="bx-flashing">Cargando...</h4>
                            </div>
                          </div>                                     
                          
                          <!-- Chargue -->
                          <div class="p-l-25px col-lg-12" id="barra_progress_usuario_div" style="display: none;" >
                            <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                              <div id="barra_progress_usuario" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                            </div>
                          </div>
                          <!-- Submit -->
                          <button type="submit" style="display: none;" id="submit-form-usuario">Submit</button>
                        </form>
                      </div>                    
                    </div>  
                    <div class="card-footer border-top-0">
                      <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1);" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                      <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>

                    </div>                
                  </div> <!-- /.card -->              
                </div> <!-- /.col -->           
              </div>
              <!-- End::row-1 -->

            </div>
          </div>
          <!-- End::app-content -->
          <?php } else { $title_submodulo ='Usuario'; $descripcion ='Lista de Usuarios del sistema!'; $title_modulo = 'Administracion'; include("403_error.php"); }?>   

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
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div>    
          
          <div class="modal fade modal-effect" id="modal-ver-historial-sesion" tabindex="-1" aria-labelledby="modal-agregar-usuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-modal-img" id="modal-agregar-usuarioLabel1">Imagen</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                  <table id="tabla-historial-sesion" class="table table-bordered w-100" style="width: 100%;">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>                          
                        <th>Fecha</th>
                        <th>Dia</th>
                        <th>Mes</th>     
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">#</th>                          
                        <th>Fecha</th>
                        <th>Dia</th>
                        <th>Mes</th>   
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div>    

          <?php include("template/search_modal.php"); ?>
          <?php include("template/footer.php"); ?>

        </div>

        <?php include("template/scripts.php"); ?>
        <?php include("template/custom_switcherjs.php"); ?>    

        <!-- Select2 Cdn -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

        <script src="scripts/trabajador.js"></script>
        <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>

      
      </body>

    </html>
  <?php  
  }
  ob_end_flush();

?>
