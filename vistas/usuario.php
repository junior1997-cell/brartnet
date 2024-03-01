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
        
        <?php $title_page = "Inicio"; include("template/head.php"); ?>    

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
                    <button class="btn-modal-effect btn btn-primary label-btn m-r-10px" onclick="limpiar_form();" data-bs-effect="effect-super-scaled" data-bs-toggle="modal"  data-bs-target="#modal-agregar-usuario"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                    <div>
                      <p class="fw-semibold fs-18 mb-0">Lista de usuarios del sistema!</p>
                      <span class="fs-semibold text-muted">Adminstra de manera eficiente tus usuarios.</span>
                    </div>                
                  </div>
                </div>
                
                <div class="btn-list mt-md-0 mt-2">              
                  <nav>
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="javascript:void(0);">Usuario</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Administracion</li>
                    </ol>
                  </nav>
                </div>
              </div>          
              <!-- End::page-header -->

              <!-- Start::row-1 -->
              <div class="row">
                <div class="col-xxl-12 col-xl-12">
                  <div class="">
                    <div class="card custom-card">                  
                      <div class="card-body table-responsive">
                        
                        <table id="tabla-usuario" class="table table-bordered w-100" style="width: 100%;">
                          <thead>
                            <tr>
                              <th>Opciones</th>                          
                              <th>Nombre</th>
                              <th>Usuario</th>
                              <th>Cargo</th>                          
                              <th>Teléfono</th>
                              <th>Email</th>
                              <th>Estado</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>Opciones</th>                          
                              <th>Nombre</th>
                              <th>Usuario</th>
                              <th>Cargo</th>                          
                              <th>Teléfono</th>
                              <th>Email</th>
                              <th>Estado</th>
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

          <div class="modal fade modal-effect" id="modal-agregar-usuario" tabindex="-1" aria-labelledby="modal-agregar-usuarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-usuarioLabel1">Modal title</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-usuario" id="form-agregar-usuario" method="POST" class="row g-3 needs-validation" novalidate>
                    <ul class="nav nav-tabs tab-style-2 mb-3"  role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dato-usuario" data-bs-toggle="tab" data-bs-target="#dato-usuario-pane" type="button" role="tab" aria-selected="true"><i class="ri-gift-line me-1 align-middle"></i>Datos del usuario</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rol-acceso" data-bs-toggle="tab" data-bs-target="#rol-acceso-pane" type="button" role="tab" aria-selected="false"><i class="ri-check-double-line me-1 align-middle"></i>Roles de acceso</button>
                      </li>                  
                    </ul>
                    <div class="tab-content" >
                      <div class="tab-pane fade show active text-muted" id="dato-usuario-pane" role="tabpanel" tabindex="0">
                        <div class="row gy-2" id="cargando-1-fomulario">
                          <!-- id usuario -->
                          <input type="hidden" name="idusuario" id="idusuario" />

                          <!-- Imgen -->
                          <div class="col-md-4">
                            <div class="mb-4 d-sm-flex align-items-center">
                              <div class="mb-0 me-5">
                                <span class="avatar avatar-xxl avatar-rounded">
                                  <img src="../assets/images/faces/9.jpg" alt="" id="imagenmuestra" onerror="this.src='../assets/modulo/usuario/perfil/no-perfil.jpg';">
                                  <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge">
                                    <input type="file" class="position-absolute w-100 h-100 op-0" name="imagen" id="imagen">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <i class="fe fe-camera"></i>
                                  </a>
                                </span>
                              </div>
                              <div class="btn-group">
                                <a class="btn btn-primary" onclick="cambiarImagen()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                                <a class="btn btn-light" onclick="removerImagen()"><i class="bi bi-trash fs-6"></i> Remover</a>
                              </div>
                            </div>
                          </div>                      

                          <!-- Tipo doc -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="tipo_documento" class="form-label">Tipo documento(*):</label>
                              <select class="form-control"  name="tipo_documento" id="tipo_documento">
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                                <option value="CEDULA">CEDULA</option>
                              </select>
                            </div>                        
                          </div>
                          <!--  Nro Doc -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="num_documento" class="form-label">Número(*):</label>
                              
                              <div class="input-group mb-3">                            
                                <input type="text" class="form-control" name="num_documento" id="num_documento" required>
                                <button class="btn btn-primary" type="button" onclick="consultaDniSunat();" id="icon-search-sr"><i class='bx bx-search-alt fs-5'></i></button>
                              </div>
                            </div>                                         
                          </div>
                          <!-- Nombre -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nombre" class="form-label">Nombres(*):</label>
                              <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>                                         
                          </div>
                          <!-- Apellidos -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="apellidos" class="form-label">Apellidos(*):</label>
                              <input type="text" class="form-control" name="apellidos" id="apellidos" required>       
                            </div>                                  
                          </div>
                        
                          <!-- Direccion -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="direccion" class="form-label">Dirección :</label>
                              <input type="text" class="form-control" name="direccion" id="direccion" required>
                            </div>                                            
                          </div>
                          <!-- Correo -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="email" class="form-label">Correo :</label>
                              <input type="email" class="form-control" name="email" id="email" required>  
                            </div>                                       
                          </div>
                          <!-- Celular -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="telefono" class="form-label">Celular:</label>
                              <input type="text" class="form-control" name="telefono" id="telefono"  required> 
                            </div>                        
                          </div>
                        
                          <!-- Cargo -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cargo" class="form-label">Cargo:</label>
                              <select class="form-control" name="cargo" id="cargo">                                
                                <option value="0">Administrador</option>
                                <option value="1">Ventas</option>
                                <option value="2">Logistica</option>
                                <option value="3">Contabilidad</option>
                              </select>
                            </div>                                            
                          </div>
                          <!-- Usuario -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="login" class="form-label">Usuario:</label>
                              <input type="text" class="form-control" name="login" id="login" required>
                            </div>                                         
                          </div>
                          <!--  Contraseña -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="clave" class="form-label">Contraseña:</label>
                              <div class="input-group mb-3">                            
                                <input type="password" class="form-control" name="clave" id="clave" required placeholder="Contraseña" aria-describedby="icon-view-password">
                                <button class="btn btn-primary" type="button" onclick="ver_password(this);" id="icon-view-password"><i class="fa-solid fa-eye"></i></button>
                              </div>
                            </div>                        
                          </div>

                        </div>
                        <div class="row" id="cargando-2-fomulario" style="display: none;" >
                          <div class="col-lg-12 text-center">                         
                            <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                            <h4 class="bx-flashing">Cargando...</h4>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade " id="rol-acceso-pane" role="tabpanel" tabindex="0">
                        <ul class="ps-3 mb-0">
                        <div class="row gy-2" id="cargando-3-fomulario">  

                          <div class="col-xl-12">                        
                            <div class="mail-notification-settings">
                              <p class="fs-14 mb-1 fw-semibold text-primary">Roles de Módulo</p>
                              <p class="fs-12 mb-0 text-muted">Escoje los módulos correspondientes al menú</p>
                            </div>                        
                            <div  id="permisos"> </div>
                          </div>    

                          <div class="col-xl-12">                          
                            <div class="mail-notification-settings">
                              <p class="fs-14 mb-1 fw-semibold text-primary">Rol Correlativos</p>
                              <p class="fs-12 mb-0 text-muted">Selecciona el correlativo de los comprobantes.</p>
                            </div>                        
                            <div id="series"> </div>                        
                          </div>

                          <div class="col-xl-12">                        
                            <div class="mail-notification-settings">
                              <p class="fs-14 mb-1 fw-semibold text-primary">Rol para empresa</p>
                              <p class="fs-12 mb-0 text-muted">Asigna al usuario a la empresa correcta</p>
                            </div>                        
                            <div id="empresas"> </div>                                           
                          </div>

                        </div>
                        <div class="row" id="cargando-4-fomulario" style="display: none;" >
                          <div class="col-lg-12 text-center">                         
                            <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                            <h4 class="bx-flashing">Cargando...</h4>
                          </div>
                        </div>
                        </ul>
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
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary" id="guardar_registro_usuario" ><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="scripts/usuario.js"></script>
        <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>

      
      </body>

    </html>
  <?php  
  }
  ob_end_flush();

?>
