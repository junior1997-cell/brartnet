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
  <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>
    <?php $title_page = "Emitir Comprobante";  include("template/head.php"); ?>

    <link rel="stylesheet" href="../assets/libs/filepond/filepond.min.css">
    <link rel="stylesheet" href="../assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet" href="../assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css">
    <link rel="stylesheet" href="../assets/libs/dropzone/dropzone.css">
  </head>

  <body id="body-ventas">
    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if($_SESSION['facturacion']==1) { ?>
      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="show_hide_form(2);  limpiar_form_venta(); "  > <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="show_hide_form(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Facturación</p>
                  <span class="fs-semibold text-muted">Administra tus comprobantes de pago.</span>
                </div>
              </div>
            </div>
            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Lista de comprobantes</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Facturación</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <div class="row">     

            <!-- TABLA - FACTURA -->
            <div class="col-xl-9" id="div-tabla">
              <div class="card custom-card">
                <!-- <div class="card-header justify-content-between">
                  <div class="card-title">
                    Manage Invoices
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-sm btn-primary btn-wave waves-light"><i class="ri-add-line fw-semibold align-middle me-1"></i> Create Invoice</button>
                    <div class="dropdown ms-2">
                      <button class="btn btn-icon btn-secondary-light btn-sm btn-wave waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:void(0);">All Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Paid Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Pending Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Overdue Invoices</a></li>
                      </ul>
                    </div>
                  </div>
                </div> -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered w-100" style="width: 100%;" id="tabla-ventas">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">OP</th>
                          <th>Fecha</th>
                          <th>Proveedor</th>
                          <th>Correlativo</th>
                          <th>Total</th> 
                          <th>SUNAT</th>                          
                        </tr>
                      </thead>
                      <tbody></tbody>
                      <tfoot>
                        <tr>
                        <th class="text-center">#</th>
                          <th class="text-center">OP</th>
                          <th>Fecha</th>
                          <th>Proveedor</th>
                          <th>Correlativo</th>
                          <th>Total</th>
                          <th>SUNAT</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>                
              </div>
            </div>

            <!-- REPORTE- MINI -->
            <div class="col-xl-3" id="div-mini-reporte">
              <div class="card custom-card">
                <div class="card-body p-0">
                  <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-primary-transparent me-4 cursor-pointer" onclick="mini_reporte();" data-bs-toggle="tooltip" title="Actualizar">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="svg-success">
                        <path d="M11.5,20h-6a1,1,0,0,1-1-1V5a1,1,0,0,1,1-1h5V7a3,3,0,0,0,3,3h3v5a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.29.29,0,0,0-.1,0A1.1,1.1,0,0,0,11.56,2H5.5a3,3,0,0,0-3,3V19a3,3,0,0,0,3,3h6a1,1,0,0,0,0-2Zm1-14.59L15.09,8H13.5a1,1,0,0,1-1-1ZM7.5,14h6a1,1,0,0,0,0-2h-6a1,1,0,0,0,0,2Zm4,2h-4a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Zm-4-6h1a1,1,0,0,0,0-2h-1a1,1,0,0,0,0,2Zm13.71,6.29a1,1,0,0,0-1.42,0l-3.29,3.3-1.29-1.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,21.21,16.29Z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Total Factura
                        <span class="badge bg-primary fw-semibold float-end"> 0 </span>
                      </h6>
                      <div class="pb-0 mt-0">
                        <div>
                          <h4 class="fs-18 fw-semibold mb-2">S/ <span class="vw_total_factura" data-count="0"><div class="spinner-border spinner-border-sm" role="status"></div></span></h4>
                          <p class="text-muted fs-11 mb-0 lh-1">
                            <span class="text-success me-1 fw-semibold vw_total_factura_p">
                              <i class="ri-arrow-up-s-line me-1 align-middle"></i>0%
                            </span>
                            <span>this month</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-success-transparent me-4 cursor-pointer" onclick="mini_reporte();" data-bs-toggle="tooltip" title="Actualizar">                      
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="svg-success">
                        <path d="M11.5,20h-6a1,1,0,0,1-1-1V5a1,1,0,0,1,1-1h5V7a3,3,0,0,0,3,3h3v5a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.29.29,0,0,0-.1,0A1.1,1.1,0,0,0,11.56,2H5.5a3,3,0,0,0-3,3V19a3,3,0,0,0,3,3h6a1,1,0,0,0,0-2Zm1-14.59L15.09,8H13.5a1,1,0,0,1-1-1ZM7.5,14h6a1,1,0,0,0,0-2h-6a1,1,0,0,0,0,2Zm4,2h-4a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Zm-4-6h1a1,1,0,0,0,0-2h-1a1,1,0,0,0,0,2Zm13.71,6.29a1,1,0,0,0-1.42,0l-3.29,3.3-1.29-1.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,21.21,16.29Z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Total Boleta
                        <span class="badge bg-success fw-semibold float-end">0  </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">S/ <span class="vw_total_boleta" data-count="0"><div class="spinner-border spinner-border-sm" role="status"></div></span></h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-success me-1 fw-semibold vw_total_boleta_p">
                            <i class="ri-arrow-down-s-line me-1 align-middle"></i>0%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-warning-transparent me-4 cursor-pointer" onclick="mini_reporte();" data-bs-toggle="tooltip" title="Actualizar">
                      <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" class="svg-primary">
                        <path d="M13,16H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2ZM9,10h2a1,1,0,0,0,0-2H9a1,1,0,0,0,0,2Zm12,2H18V3a1,1,0,0,0-.5-.87,1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0A1,1,0,0,0,2,3V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM5,20a1,1,0,0,1-1-1V4.73L6,5.87a1.08,1.08,0,0,0,1,0l3-1.72,3,1.72a1.08,1.08,0,0,0,1,0l2-1.14V19a3,3,0,0,0,.18,1Zm15-1a1,1,0,0,1-2,0V14h2Zm-7-7H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Total Ticket
                        <span class="badge bg-warning fw-semibold float-end">0 </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">S/ <span class="vw_total_ticket" data-count="0"><div class="spinner-border spinner-border-sm" role="status"></div></span></h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-success me-1 fw-semibold vw_total_ticket_p">
                            <i class="ri-arrow-up-s-line me-1 align-middle"></i>0%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-light me-4">
                      <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" class="svg-dark">
                        <path d="M19,12h-7V5c0-0.6-0.4-1-1-1c-5,0-9,4-9,9s4,9,9,9s9-4,9-9C20,12.4,19.6,12,19,12z M12,19.9c-3.8,0.6-7.4-2.1-7.9-5.9C3.5,10.2,6.2,6.6,10,6.1V13c0,0.6,0.4,1,1,1h6.9C17.5,17.1,15.1,19.5,12,19.9z M15,2c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h6c0.6,0,1-0.4,1-1C22,5.1,18.9,2,15,2z M16,8V4.1C18,4.5,19.5,6,19.9,8H16z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Overdue Invoices
                        <span class="badge bg-light text-default fw-semibold float-end">
                          1,105
                        </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">$<span class="count-up" data-count="32.47">32.47</span>K</h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-success me-1 fw-semibFold">
                            <i class="ri-arrow-down-s-line me-1 align-middle"></i>0.46%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div> -->
                  <div class="p-4">
                    <p class="fs-15 fw-semibold">Mini reporte <span class="text-muted fw-normal">(Últimos 6 meses) :</span></p>
                    <div id="invoice-list-stats"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- FORMULARIO -->
            <div class="col-xxl-12 col-xl-12" id="div-formulario"  style="display: none;">              
              <div class="card custom-card">
                <div class="card-body">                    
                  
                  <!-- FORM - COMPROBANTE -->                    
                  <form name="form-facturacion" id="form-facturacion" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row" id="cargando-1-formulario">

                      <!-- IMPUESTO -->
                      <input type="hidden" name="idventa" id="idventa" />
                      <!-- IMPUESTO -->
                      <input type="hidden" class="form-control" name="impuesto" id="impuesto" value="0">   
                      <!-- TIPO DOC -->
                      <input type="hidden" class="form-control" name="tipo_documento" id="tipo_documento" value="0">  
                      <!-- NUMERO DOC -->
                      <input type="hidden" class="form-control" name="numero_documento" id="numero_documento" value="0">                     

                      <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="row gy-3">
                          <!-- ENVIO AUTOMATICO -->
                          <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 px-0">
                            <div class="custom-toggle-switch d-flex align-items-center mb-4">
                              <input id="crear_y_emitir" name="crear_y_emitir" type="checkbox" checked="" value="SI">
                              <label for="crear_y_emitir" class="label-warning"></label><span class="ms-3">Crear y emitir SUNAT</span>
                            </div>
                          </div>
                          <!--  TIPO COMPROBANTE  -->
                          <div class="col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                            <div class="mb-sm-0 mb-2">
                              <p class="fs-14 mb-2 fw-semibold">Tipo de comprobante</p>
                              <div class="mb-0 authentication-btn-group">
                                <input type="hidden" id="tipo_comprobante_hidden" >
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante1" value="03"  onchange="modificarSubtotales(); ver_series_comprobante(this); es_valido_cliente();">
                                  <label class="btn btn-outline-primary btn-boleta" for="tipo_comprobante1"><i class="ri-article-line me-1 align-middle d-inline-block"></i>Boleta</label>
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante2" value="01" onchange="modificarSubtotales(); ver_series_comprobante(this); es_valido_cliente();">
                                  <label class="btn btn-outline-primary" for="tipo_comprobante2"><i class="ri-article-line me-1 align-middle d-inline-block"></i> Factura</label>
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante3" value="12" onchange="modificarSubtotales(); ver_series_comprobante(this); es_valido_cliente();">
                                  <label class="btn btn-outline-primary" for="tipo_comprobante3"><i class='bx bx-file-blank me-1 align-middle d-inline-block'></i> Ticket</label>
                                </div>
                              </div>
                            </div>                            
                          </div>    
                          
                          <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="form-group">
                              <label for="fecha_venta" class="form-label">Serie <span class="charge_serie_comprobante"></span></label>
                              <select class="form-control" name="serie_comprobante" id="serie_comprobante"></select>
                            </div>
                          </div>

                          <!--  PROVEEDOR  -->
                          <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="form-group">
                              <label for="idpersona_cliente" class="form-label">
                                <!-- <span class="badge bg-success m-r-4px cursor-pointer" onclick=" modal_add_trabajador(); limpiar_proveedor();" data-bs-toggle="tooltip" title="Agregar"><i class="las la-plus"></i></span> -->
                                <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_idpersona_cliente();" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                                Cliente
                                <span class="charge_idpersona_cliente"></span>
                              </label>
                              <select class="form-control" name="idpersona_cliente" id="idpersona_cliente" onchange="es_valido_cliente(); usar_anticipo_valid();"></select>
                            </div>
                          </div>   
                          
                          <!-- DESCRIPCION -->
                          <div class="col-md-6 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="form-group">
                              <label for="observacion_documento" class="form-label">Observacion</label>
                              <textarea name="observacion_documento" id="observacion_documento" class="form-control" rows="2" placeholder="ejemp: Cobro de servicio de internet."></textarea>
                            </div>
                          </div>
                          
                          <!-- FECHA EMISION -->
                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="form-group">
                              <label for="es_cobro" class="form-label">Es cobro?</label>
                              <div class="toggle toggle-secondary on es_cobro" onclick="delay(function(){es_cobro_valid()}, 100 );" >  <span></span>   </div>
                              <input type="hidden" class="form-control" name="es_cobro_inp" id="es_cobro_inp" value="SI" >
                            </div>
                          </div>  

                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 datos-de-cobro-mensual">
                            <div class="form-group">
                              <label for="periodo_pago" class="form-label">Periodo Pago</label>
                              <input type="month" class="form-control" name="periodo_pago" id="periodo_pago" >
                            </div>
                          </div>                                                                  

                        </div>
                      </div>

                      <div class="col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                        <div class="row">
                          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mt-xs-3">
                            <button class="btn btn-info label-btn m-r-10px" type="button" onclick="listar_tabla_producto('PR');"  >
                              <i class="ri-add-circle-line label-btn-icon me-2"></i> Producto
                            </button>
                          </div>
                          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mt-xs-3">
                            <button class="btn btn-primary label-btn m-r-10px" type="button"  onclick="listar_tabla_producto('SR');"  >
                            <i class="ri-add-fill label-btn-icon me-2"></i> 
                              Servicio
                            </button>
                          </div>  

                          <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5 mt-xs-3">
                            <div class="input-group">                              
                              <button type="button" class="input-group-text buscar_x_code" onclick="listar_producto_x_codigo();"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Buscar por codigo de producto."><i class='bx bx-search-alt'></i></button>
                              <input type="text" name="codigob" id="codigob" class="form-control" onkeyup="mayus(this);" placeholder="Digite el código de producto." >
                            </div>
                          </div>                                              

                          <!-- ------- TABLA PRODUCTOS SELECCIONADOS ------ --> 
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive pt-3">
                            <table id="tabla-productos-seleccionados" class="table table-striped table-bordered table-condensed table-hover">
                              <thead class="bg-color-dark text-white">
                                <th class="fs-11 py-1" data-toggle="tooltip" data-original-title="Opciones">Op.</th>
                                <th class="fs-11 py-1">Cod</th> 
                                <th class="fs-11 py-1">Producto</th>
                                <th class="fs-11 py-1">Unidad</th>
                                <th class="fs-11 py-1">Cantidad</th>                                        
                                <th class="fs-11 py-1" data-toggle="tooltip" data-original-title="Precio Unitario">P/U</th>
                                <th class="fs-11 py-1">Descuento</th>
                                <th class="fs-11 py-1">Subtotal</th>
                                <th class="fs-11 py-1 text-center" ><i class='bx bx-cog fs-4'></i></th>
                              </thead>
                              <tbody ></tbody>
                              <tfoot>
                                <td colspan="6"></td>

                                <th class="text-right">
                                  <h6 class="fs-11 tipo_gravada">SUBTOTAL</h6>
                                  <h6 class="fs-11 ">DESCUENTO</h6>
                                  <h6 class="fs-11 val_igv">IGV (18%)</h6>
                                  <h5 class="fs-13 font-weight-bold">TOTAL</h5>
                                </th>
                                <th class="text-right"> 
                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between venta_subtotal"> <span>S/</span>  0.00</h6>
                                  <input type="hidden" name="venta_subtotal" id="venta_subtotal" />
                                  <input type="hidden" name="tipo_gravada" id="tipo_gravada" />

                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between venta_descuento"><span>S/</span> 0.00</h6>
                                  <input type="hidden" name="venta_descuento" id="venta_descuento" />

                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between venta_igv"><span>S/</span> 0.00</h6>
                                  <input type="hidden" name="venta_igv" id="venta_igv" />
                                  
                                  <h5 class="fs-13 font-weight-bold d-flex justify-content-between venta_total"><span>S/</span> 0.00</h5>
                                  <input type="hidden" name="venta_total" id="venta_total" />
                                  
                                </th>
                                <th></th>
                              </tfoot>
                            </table>
                          </div>

                          <div class="col-12 pt-3">
                            <button type="button" class="btn btn-primary btn-sm pago_rapido" onclick="pago_rapido(this)" >0</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="pago_rapido(this)" >10</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="pago_rapido(this)" >20</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="pago_rapido(this)" >50</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="pago_rapido(this)" >100</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="pago_rapido(this)" >200</button>
                          </div>

                          <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="row">

                              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-3 pt-3">
                                <div class="form-group">
                                  <label for="metodo_pago" class="form-label">Método de pago</label>
                                  <select class="form-control" name="metodo_pago" id="metodo_pago" onchange="capturar_pago_venta();">
                                    <option value="EFECTIVO" selected >EFECTIVO</option>
                                    <option value="MIXTO">MIXTO</option>
                                    <option value="TARJETA">TARJETA</option>
                                    <option value="YAPE">YAPE</option>
                                    <option value="PLIN">PLIN</option>
                                    <option value="CULQI">CULQI</option>                                                      
                                    <option value="LUKITA">LUKITA</option>                                                      
                                    <option value="TUNKI">TUNKI</option>                                
                                  </select>                              
                                </div>
                              </div> 
                              
                              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-3 pt-3">
                                <div class="form-group">
                                  <label for="total_recibido" class="form-label">Monto a pagar</label>
                                  <input type="number" name="total_recibido" id="total_recibido" class="form-control"  onClick="this.select();" onchange="calcular_vuelto();" onkeyup="calcular_vuelto();"  placeholder="Ingrese monto a pagar." >                           
                                </div>
                              </div> 

                              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-3 pt-3" id="content-mp-monto" style="display: none;">
                                <div class="form-group">
                                  <label for="mp_monto" class="form-label">Monto: <span class="span-tipo-pago"></span></label>
                                  <input type="number" name="mp_monto" id="mp_monto" class="form-control" onClick="this.select();" onchange="calcular_vuelto();" onkeyup="calcular_vuelto();" placeholder="Pagar con" />
                                </div>
                              </div>

                              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-3 pt-3">
                                <div class="form-group">
                                  <label for="total_vuelto" class="form-label">Vuelto <small class="falta_o_completo"></small></label>
                                  <input type="number" name="total_vuelto" id="total_vuelto" class="form-control-plaintext px-2 total_vuelto" readonly placeholder="Ingrese monto a pagar." >                           
                                </div>
                              </div> 

                            </div>
                          </div>                          

                          <!-- USAR SALDO -->
                          <div class="col-md-12 col-lg-3 col-xl-3 col-xxl-3 pt-3">
                            <div class="form-group">
                              <label for="usar_anticipo" class="form-label">Usar anticipos?</label>
                              <div class="toggle toggle-secondary usar_anticipo" onclick="delay(function(){usar_anticipo_valid()}, 100 );" >  <span></span>   </div>
                              <input type="hidden" class="form-control" name="usar_anticipo" id="usar_anticipo" value="NO" >
                            </div>
                          </div>                           

                          <div class="col-md-12 col-lg-9 col-xl-9 col-xxl-9 pt-3 datos-de-saldo" style="display: none !important;">

                            <div class="row">    
                              <div class="col-12 pl-0">
                                <div class="text-primary p-l-10px" style="position: relative; top: 7px;"><label class="bg-white" for=""><b>DATOS DE ANTICIPOS</b></label></div>
                              </div>
                            </div>

                            <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                              <div class="row ">                                                                
                                
                                <!-- SALDO -->
                                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                  <div class="form-group">
                                    <label for="ua_monto_disponible" class="form-label">Saldo Disponible</label>
                                    <input type="number" class="form-control-plaintext" name="ua_monto_disponible" id="ua_monto_disponible" readonly>
                                  </div>
                                </div> 

                                <!-- Saldo Usar -->
                                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                  <div class="form-group">
                                    <label for="ua_monto_usado" class="form-label">Saldo Usar</label>
                                    <input type="number" class="form-control" name="ua_monto_usado" id="ua_monto_usado" >
                                  </div>
                                </div>       

                              </div>
                            </div>
                          </div>  

                          <div class="col-12" id="content-metodo-pago">
                            <div class="row">
                              <!-- Código de Baucher -->
                              <div class="col-sm-6 col-lg-6 col-xl-6 pt-3" >
                                <div class="form-group">
                                  <label for="mp_serie_comprobante">Código de Baucher <span class="span-code-baucher-pago"></span> </label>
                                  <input type="text" name="mp_serie_comprobante" id="mp_serie_comprobante" class="form-control" onClick="this.select();" placeholder="Codigo de baucher" />
                                </div>
                              </div>  
                              <!-- Baucher -->
                              <div class="col-sm-6 col-lg-6 col-xl-6 pt-3" >
                                <div class="form-group">                              
                                  <input type="file" class="multiple-filepond" name="mp_comprobante" id="mp_comprobante" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6" accept="image/*, application/pdf" >                             
                                  <input type="hidden" name="mp_comprobante_old" id="mp_comprobante_old">
                                </div>
                              </div>
                            </div>
                          </div>                          
                        </div>
                      </div>

                    </div>  
                    
                    <!-- ::::::::::: CARGANDO ... :::::::: -->
                    <div class="row" id="cargando-2-fomulario" style="display: none;" >
                      <div class="col-lg-12 mt-5 text-center">                         
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>

                    <!-- Chargue -->
                    <div class="p-l-25px col-lg-12" id="barra_progress_venta_div" style="display: none;" >
                      <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                        <div id="barra_progress_venta" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                      </div>
                    </div>
                    <!-- Submit -->
                    <button type="submit" style="display: none;" id="submit-form-venta">Submit</button>
                  </form>                                  

                </div>
                <div class="card-footer border-top-0">
                  <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1); limpiar_form_venta();" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                  <button type="button" class="btn btn-success btn-guardar" id="guardar_registro_venta" style="display: none;"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>              
            </div>

          </div>
          <!-- End::row-1 -->

          <!-- MODAL - IMPRIMIR -->
          <div class="modal fade modal-effect" id="modal-imprimir-comprobante" tabindex="-1" aria-labelledby="modal-imprimir-comprobante-label" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-imprimir-comprobante-label">COMPROBANTE</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >                  
                  <div id="html-imprimir-comprobante" class="text-center" > </div>
                </div>                
              </div>
            </div>
          </div> 
          <!-- End::Modal-Ver-Comprobante venta -->

          <!-- MODAL - VER COMPROBANTE venta -->
          <div class="modal fade modal-effect" id="modal-ver-comprobante1" tabindex="-1" aria-labelledby="modal-ver-comprobante1Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-modal-comprobante1" id="modal-ver-comprobante1Label1">COMPROBANTE</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="comprobante-container1" class="text-center"> <!-- archivo --> 
                    <div class="row" >
                      <div class="col-lg-12 text-center"> <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger py-1" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal-Ver-Comprobante venta -->

          <!-- MODAL - VER FOTO PROVEEDOR -->
          <div class="modal fade modal-effect" id="modal-ver-foto-proveedor" tabindex="-1" aria-labelledby="modal-ver-foto-proveedor" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-foto-proveedor" id="modal-ver-foto-proveedorLabel1">Imagen</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body html_ver_foto_proveedor">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal - Ver foto proveedor -->

          <!-- MODAL - SELECIONAR PRODUCTO -->
          <div class="modal fade modal-effect" id="modal-producto" tabindex="-1" aria-labelledby="title-modal-producto-label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="title-modal-producto-label">Seleccionar Producto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                  <table id="tabla-productos" class="table table-bordered w-100">
                    <thead>
                      <th>Op.</th>
                      <th>Code</th>
                      <th>Nombre Producto</th>                              
                      <th>P/U.</th>
                      <th>Descripción</th>
                    </thead>
                    <tbody></tbody>
                  </table>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div>
          <!-- End::Modal-Producto -->

          <!-- MODAL - DETALLE venta -->
          <div class="modal fade modal-effect" id="modal-detalle-venta" tabindex="-1" aria-labelledby="modal-detalle-ventaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-detalle-ventaLabel1">Detalle - venta</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                      <ul class="nav nav-tabs" id="custom-tab" role="tablist">
                        <!-- DATOS VENTA -->
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="rol-venta" data-bs-toggle="tab" data-bs-target="#rol-venta-pane" type="button" role="tab" aria-selected="true">venta</button>
                        </li>
                        <!-- DATOS TOURS -->
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rol-detalle" data-bs-toggle="tab" data-bs-target="#rol-detalle-pane" type="button" role="tab" aria-selected="true">PRODUCTOS</button>
                        </li>
                        
                      </ul>
                      <div class="tab-content" id="custom-tabContent">                                
                        <!-- /.tab-panel --> 
                      </div> 

                    <div class="row" id="cargando-4-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <i class="fas fa-spinner fa-pulse fa-6x"></i><br />
                        <br />
                        <h4>Cargando...</h4>
                      </div>
                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger py-1" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal-Detalle-venta -->          
          
          <!-- MODAL - AGREGAR PRODUCTO - charge p1 -->
          <div class="modal fade modal-effect" id="modal-agregar-producto" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-productoLabel">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-productoLabel1">Registrar Producto</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-producto" id="form-agregar-producto" method="POST" class="row needs-validation" novalidate >
                    <div class="row gy-2" id="cargando-P1-formulario">
                      <!-- ----------------------- ID ------------- -->
                      <input type="hidden" id="idproducto" name="idproducto">

                      <!-- ----------------- Categoria --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="categoria" class="form-label">Categoría</label>
                          <select class="form-control" name="categoria" id="categoria">
                            <!-- lista de categorias -->
                          </select>
                        </div>
                      </div>

                      <!-- ----------------- Unidad Medida --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="u_medida" class="form-label">U. Medida</label>
                          <select class="form-control" name="u_medida" id="u_medida">
                            <!-- lista de u medidas -->
                          </select>
                        </div>
                      </div>

                      <!-- ----------------- Marca --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="marca" class="form-label">Marca</label>
                          <select class="form-control" name="marca" id="marca">
                            <!-- lista de marcas -->
                          </select>
                        </div>
                      </div>
                      <!-- --------- NOMBRE ------ -->
                      <div class="col-md-4 col-lg-4 col-xl-6 col-xxl-6 mt-3">
                        <div class="form-group">
                          <label for="nombre" class="form-label">Nombre(*)</label>
                          <textarea class="form-control" name="nombre" id="nombre" rows="1"></textarea>
                        </div>
                      </div>

                      <!-- --------- DESCRIPCION ------ -->
                      <div class="col-md-4 col-lg-4 col-xl-6 col-xxl-6 mt-3">
                        <div class="form-group">
                          <label for="descripcion" class="form-label">Descrición(*)</label>
                          <textarea class="form-control" name="descripcion" id="descripcion" rows="1"></textarea>
                        </div>
                      </div>

                      <!-- ----------------- STOCK --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="stock" class="form-label">Stock(*)</label>
                          <input type="number" class="form-control" name="stock" id="stock" />
                        </div>
                      </div>

                      <!-- ----------------- STOCK MININO --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="stock_min" class="form-label">Stock Minimo(*)</label>
                          <input type="number" class="form-control" name="stock_min" id="stock_min" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO VENTA --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="precio_v" class="form-label">Precio Venta(*)</label>
                          <input type="number" class="form-control" name="precio_v" id="precio_v" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO venta --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="precio_c" class="form-label">Precio venta(*)</label>
                          <input type="number" class="form-control" name="precio_c" id="precio_c" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO X MAYOR --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_x_mayor" class="form-label">Precio por Mayor</label>
                          <input type="text" class="form-control" name="precio_x_mayor" id="precio_x_mayor" placeholder="precioB" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO DISTRIBUIDOR --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_dist" class="form-label">Precio Distribuidor</label>
                          <input type="text" class="form-control" name="precio_dist" id="precio_dist" placeholder="precioC"/>
                        </div>
                      </div>

                      <!-- ----------------- PRECIO ESPECIAL --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_esp" class="form-label">Precio Especial</label>
                          <input type="text" class="form-control" name="precio_esp" id="precio_esp" placeholder="precioD"/>
                        </div>
                      </div>

                      <!-- Imgen -->
                      <div class="col-md-6 col-lg-6 mt-4">
                        <span class="" > <b>Imagen Prducto</b> </span>
                        <div class="mb-4 mt-2 d-sm-flex align-items-center">
                          <div class="mb-0 me-5">
                            <span class="avatar avatar-xxl avatar-rounded">
                              <img src="../assets/modulo/productos/no-producto.png" alt="" id="imagenmuestraProducto" onerror="this.src='../assets/modulo/productos/no-producto.png';">
                              <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge cursor-pointer">
                                <input type="file" class="position-absolute w-100 h-100 op-0" name="imagenProducto" id="imagenProducto" accept="image/*">
                                <input type="hidden" name="imagenactualProducto" id="imagenactualProducto">
                                <i class="fe fe-camera  "></i>
                              </a>
                            </span>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-primary" onclick="cambiarImagenProducto()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                            <a class="btn btn-light" onclick="removerImagenProducto()"><i class="bi bi-trash fs-6"></i> Remover</a>
                          </div>
                        </div>
                      </div> 

                    </div>
                    <div class="row" id="cargando-P2-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>
                    <button type="submit" style="display: none;" id="submit-form-producto">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form_producto();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary" id="guardar_registro_producto"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::Modal-Agregar-Producto -->

        </div>
      </div>
      <!-- End::app-content -->
      <?php } else { $title_submodulo ='venta'; $descripcion ='Lista de ventas del sistema!'; $title_modulo = 'ventas'; include("403_error.php"); }?>   

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>
    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>   

    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Filepond JS -->
    <script src="../assets/libs/filepond/filepond.min.js"></script>
    <script src="../assets/libs/filepond/locale/es-es.js"></script>
    <script src="../assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="../assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="../assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="../assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
    <script src="../assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js"></script>
    <script src="../assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
    <script src="../assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
    <script src="../assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
    <script src="../assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
    <script src="../assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js"></script>

    <!-- Dropzone JS -->
    <script src="../assets/libs/dropzone/dropzone-min.js"></script>
    
    <script src="scripts/facturacion.js"></script>
    <script src="scripts/js_facturacion.js"></script>
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