<?php
  //Activamos el almacenamiento en el buffer
  ob_start();

  session_start();
  if (!isset($_SESSION["user_nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{

    ?>
      <!DOCTYPE html>
      <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close" loader="enable">

        <head>
          
          <?php $title_page = "Gastos"; include("template/head.php"); ?>    

        </head> 

        <body id="body-gastos-trab">

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
                      <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="show_hide_form(2);limpiar_form();"><i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                      <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="show_hide_form(1);limpiar_form();" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                      <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
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
                <div class="row">
                  <div class="col-xxl-12 col-xl-12">
                    <div>
                      <div class="card custom-card">
                        <div class="card-body">
                          <!-- ------------- Tabla Gastos del Trabajador ---------------- -->
                          <div id="div-tabla" class="table-responsive">
                            <table id="tabla-gastos" class="table table-bordered w-100" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Fecha</th>
                                  <th>Trabajador</th>
                                  <th >Comprobante</th>
                                  <th style="background-color: #D2ACFB;">Total</th>
                                  <th>Descripción</th>
                                  <th>CFDI</th>
                                  
                                </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Acciones</th>
                                  <th>Fecha</th>
                                  <th>Trabajador</th>
                                  <th >Comprobante</th>
                                  <th>Total</th>
                                  <th>Descripción</th>
                                  <th>CFDI</th>
                                  
                                </tr>
                              </tfoot>
                            </table>
                          </div>

                          <!-- ------------- Formulario Gastos del Trabajador ---------------- -->
                          <div id="div-formulario" style="display: none;">
                            <form name="formulario-gasto" id="formulario-gasto" method="POST" class="row g-3 needs-validation" novalidate>
                              
                              <!-- :::::::::::::: DATOS GENERALES ::::::::::::::::: -->
                              <div class="row gy-2" id="cargando-1-formulario">
                                <!-- -------------- ID ------------- -->
                                <input type="hidden" name="idgasto_de_trabajador" id="idgasto_de_trabajador"/>

                                <!-- ------------ TRABAJADOR --------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="idtrabajador" class="form-label">Nombre del Trabajador(*)</label>
                                    <select class="form-select form-select-lg" name="idtrabajador" id="idtrabajador" ><!-- List de trabajadores --></select>
                                  </div>
                                </div>
                                <!-- --------- DESCRIPCION GASTO ------ -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="descr_gastos" class="form-label">Descripción de Gastos(*)</label>
                                    <textarea class="form-control" name="descr_gastos" id="descr_gastos" rows="1"></textarea>
                                  </div>
                                </div>
                                <!-- ----------------- TIPO COMPROBANTE --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="tp_comprobante" class="form-label">Tipo Comprobante</label>
                                    <select class="form-select form-select-lg" name="tp_comprobante" id="tp_comprobante">
                                      <option value="NINGUNO">NINGUNO</option>
                                      <option value="BOLETA">BOLETA</option>
                                      <option value="FACTURA">FACTURA</option>
                                      <option value="NOTA_DE_VENTA">NOTA DE VENTA</option>
                                    </select>
                                  </div>
                                </div>
                                <!-- ----------------- SERIE COMPROBANTE --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="serie_comprobante" class="form-label">Serie Comprobante</label>
                                    <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" onkeyup="mayus(this);"/>
                                  </div>
                                </div>
                                <!-- ------------------ FECHA EMISION ------------------ -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="fecha" class="form-label">Fecha Emisión(*)</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha"/>
                                  </div>
                                </div>
                              
                                <!-- ----------------- PROVEEDOR --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="idproveedor" class="form-label">Proveedor</label>
                                    <select class="form-select" name="idproveedor" id="idproveedor"></select>
                                  </div>
                                </div>
                              
                                <!-- ----------------- SUB TOTAL --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="sub_total" class="form-label">Sub Total</label>
                                    <input type="number" class="form-control" name="sub_total" id="sub_total" readonly/>
                                  </div>
                                </div>
                                <!-- ----------------- IGV --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-2 col-xxl-4">
                                  <div class="form-group">
                                    <label for="igv" class="form-label">IGV</label>
                                    <input type="number" class="form-control" name="igv" id="igv" placeholder="" value="0.00"/>
                                  </div>
                                </div>
                                <!-- -------------- VALOR IGV ------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-2 col-xxl-4">
                                  <div class="form-group">
                                    <label for="val_igv" class="form-label">Val. IGV</label>
                                    <input type="number" class="form-control" name="val_igv" id="val_igv" readonly value="0.00"/>
                                  </div>
                                </div>
                                <!-- ----------------- TOTAL --------------- -->
                                <div class="col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <div class="form-group">
                                    <label for="total_gasto" class="form-label">Total(*)</label>
                                    <input type="number" class="form-control" name="total_gasto" id="total_gasto" onkeyup="calcularigv();"  onchange="calcularigv();"/>
                                  </div>
                                </div>
                                <!-- --------- DESCRIPCION COMPROBANTE ------ -->
                                <div class="col-md-6 col-lg-4 col-xl-12 col-xxl-8">
                                  <div class="form-group">
                                    <label for="descr_comprobante" class="form-label">Descripción del Comprobante</label>
                                    <textarea class="form-control" name="descr_comprobante" id="descr_comprobante" rows="1"></textarea>
                                  </div>
                                </div>
                              
                                <div class="p-3 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                  <h6 class="card-title text-center">Comprobante</h6>
                                  <div class="col-md-12 border-top p-3">

                                    <div class="my-2 text-center">
                                      <div class="btn-group edit_img">
                                        <button type="button" class="btn btn-primary py-1" id="doc1_i"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</button>
                                        <input type="hidden" id="doc_old_1" name="doc_old_1" />
                                        <input style="display: none;" id="doc1" type="file" name="doc1" accept="application/pdf, image/*" class="docpdf" />
                                        <button type="button" class="btn btn-info py-1" onclick="re_visualizacion(1, 'assets/modulo/gasto_de_trabajador', '60%'); reload_zoom();"><i class='bx bx-refresh bx-spin fs-5'></i>Refrescar</button>
                                      </div>
                                    </div>

                                    <!-- imagen -->
                                    <div id="doc1_ver" class="text-center ">
                                      <img id="img_defect" src="../assets/images/default/img_defecto3.png" alt="" width="60%" />
                                    </div>
                                    <div  id="doc1_nombre" ><!-- aqui va el nombre del pdf --></div>
                                  </div>
                                </div>
                              </div>

                              <!-- ::::::::::: CARGANDO ... :::::::: -->
                              <div class="row" id="cargando-5-fomulario" style="display: none;" >
                                <div class="col-lg-12 text-center">                         
                                  <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                                  <h4 class="bx-flashing">Cargando...</h4>
                                </div>
                              </div>

                              <!-- Chargue -->
                              <div class="p-l-25px col-lg-12" id="barra_progress_gasto_div" style="display: none;" >
                                <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                                  <div id="barra_progress_gasto" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                                </div>
                              </div>
                              <!-- Submit -->
                              <button type="submit" style="display: none;" id="submit-form-gasto">Submit</button>
                            </form>
                          </div>
                        </div>
                        <div class="card-footer border-top-0">
                          <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1);" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                          <button type="button" class="btn btn-success btn-guardar" id="guardar_registro_gasto" style="display: none;"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End::row-1 -->
              </div>
            </div>
            <!-- End::app-content -->

            <!-- Start::Modal-Comprobante -->
            <div class="modal fade modal-effect" id="modal-ver-comprobante" tabindex="-1" aria-labelledby="modal-ver-comprobanteLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h6 class="modal-title" id="modal-ver-comprobanteLabel1">COMPROBANTE</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div id="comprobante-container" class="text-center"> <!-- archivo --> </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                  </div>
                </div>
              </div>
            </div> 
            <!-- End::Modal-Comprobante -->


            <!-- Start::Modal-VerDetalles -->
            <div class="modal fade modal-effect" id="modal-ver-detalle" tabindex="-1" aria-labelledby="modal-ver-detalleLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="modal-ver-detalleLabel1"><b>Detalles</b> - Gasto de Trabajador</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <label for="trabajador" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="trabajador" id="trabajador" readonly>
                      </div>
                      <div class="col-lg-6"> </div>
                      <div class="col-lg-4 mt-3">
                        <label for="tipo_comb" class="form-label">Tip. comprobante:</label>
                        <input type="text" class="form-control" name="tipo_comb" id="tipo_comb" readonly>
                      </div>
                      <div class="col-lg-4 mt-3">
                        <label for="d_serie" class="form-label">Serie:</label>
                        <input type="text" class="form-control" name="d_serie" id="d_serie" readonly>
                      </div>
                      <div class="col-lg-4 mt-3">
                        <label for="fecha_emision" class="form-label">Fecha Emisión:</label>
                        <input type="text" class="form-control" name="fecha_emision" id="fecha_emision" readonly>
                      </div>
                      <div class="col-lg-6 mt-3 proveedor_s" style="display: none;">
                        <label for="s_proveedor" class="form-label">Proveedor:</label>
                        <input type="text" class="form-control" name="s_proveedor" id="s_proveedor" readonly>
                      </div>
                      <div class="col-lg-6 mt-3 proveedor_s" style="display: none;"></div>
                      <div class="col-lg-3 mt-3">
                        <label for="p_sin_igv" class="form-label">Precio:</label>
                        <input type="text" class="form-control" name="p_sin_igv" id="p_sin_igv" readonly>
                      </div>
                      <div class="col-lg-3 mt-3">
                        <label for="p_igv" class="form-label">IGV:</label>
                        <input type="text" class="form-control" name="p_igv" id="p_igv" readonly>
                      </div>
                      <div class="col-lg-3 mt-3">
                        <label for="v_igv" class="form-label">Val IGV:</label>
                        <input type="text" class="form-control" name="v_igv" id="v_igv" readonly>
                      </div>
                      <div class="col-lg-3 mt-3">
                        <label for="p_con_igv" class="form-label">Total:</label>
                        <input type="text" class="form-control" name="p_con_igv" id="p_con_igv" readonly>
                      </div>
                      <div class="col-lg-6 mt-3">
                        <label for="d_gasto" class="form-label">Descripción de gasto:</label>
                        <textarea class="form-control" name="d_gasto" id="d_gasto"></textarea>
                      </div>
                      <div class="col-lg-6 mt-3">
                        <label for="d_compb" class="form-label">Descripción de comprobante:</label>
                        <textarea class="form-control" name="d_compb" id="d_compb"></textarea>
                      </div>
                      <div class="col-lg-12 mt-5">
                        <h6>Comprobante:</h6>
                        <div class="imagen_comb"></div>
                      </div>


                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                  </div>
                </div>
              </div>
            </div> 
            <!-- End::Modal-VerDetalles -->

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