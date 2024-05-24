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
                <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="wiev_tabla_formulario(2); limpiar_cliente();"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar</button>
                <button class="btn-modal-effect btn btn-info label-btn btn-pagos-all m-r-10px" onclick="cargar_fltros_pagos_all_cliente();"><i class="ti ti-currency-dollar label-btn-icon me-2"></i>Pagos</button>
                <button type="button" class="btn btn-danger btn-cancelar btn-regresar m-r-10px" onclick="wiev_tabla_formulario(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"> <i class="ri-save-2-line label-btn-icon me-2"></i> Guardar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Lista de clientes!</p>
                  <span class="fs-semibold text-muted">Adminstra de manera eficiente tus clientes.</span>
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
                    <!-- ::::::::::::::::::::: FILTRO DIA DE PAGO :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_dia_pago" class="form-label">                         
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_dia');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Día de Afiliación
                          <span class="charge_filtro_dia_pago"></span>
                        </label>
                        <select class="form-control" name="filtro_dia_pago" id="filtro_dia_pago" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > <!-- lista de categorias --> </select>
                      </div>
                    </div>
                    <!-- ::::::::::::::::::::: FILTRO PLAN :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_plan" class="form-label">                         
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_plan');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Plan
                          <span class="charge_filtro_plan"></span>
                        </label> 
                        <select class="form-control" name="filtro_plan" id="filtro_plan" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > </select>
                      </div>
                    </div>
                    <!-- ::::::::::::::::::::: FILTRO ZONA ANTENA :::::::::::::::::::::: -->
                    <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                      <div class="form-group">
                        <label for="filtro_zona_antena" class="form-label">                         
                          <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_zona_antena');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                          Zona Antena
                          <span class="charge_filtro_zona_antena"></span>
                        </label>
                        <select class="form-control" name="filtro_zona_antena" id="filtro_zona_antena" onchange="cargando_search(); delay(function(){filtros()}, 50 );" > <!-- lista de categorias --> </select>
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
                          <th class="text-center">Acciones</th>
                          <th>Cliente</th>
                          <th>Direccion</th>
                          <th>Falta</th>
                          <th>Cancelación</th>
                          <th>Zona/Plan</th>
                          <th>IP</th>
                          <th>Trabajador</th>                                
                          <th class="text-center">Obs.</th>

                          <th class="text-center">Nombres</th>
                          <th class="text-center">Tipo Documento</th>
                          <th class="text-center">Número Documento</th>
                          <th class="text-center">Centro Poblado</th>
                          <th class="text-center">Dirección</th>
                          <th class="text-center">Plan</th>
                          <th class="text-center">Costo Plan</th>
                          <th class="text-center">Nombre Zona</th>
                          <th class="text-center">Siguiente Pago</th>
                          <th class="text-center">Ip Antena</th>

                        </tr>
                      </thead>
                      <tbody></tbody>
                      <tfoot>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">Acciones</th>
                          <th>Cliente</th>
                          <th>Direccion</th>
                          <th>Falta</th>
                          <th>Cancelación</th>
                          <th>Zona/Plan</th>
                          <th>IP</th>
                          <th>Trabajador</th>
                          <th class="text-center">Obs.</th>

                          <th class="text-center">Nombres</th>
                          <th class="text-center">Tipo Documento</th>
                          <th class="text-center">Número Documento</th>
                          <th class="text-center">Centro Poblado</th>
                          <th class="text-center">Dirección</th>
                          <th class="text-center">Plan</th>
                          <th class="text-center">Costo Plan</th>
                          <th class="text-center">Nombre Zona</th>
                          <th class="text-center">Siguiente Pago</th>
                          <th class="text-center">Ip Antena</th>

                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div id="div-form" style="display: none;">
                    <form name="form-agregar-cliente" id="form-agregar-cliente" method="POST">

                      <div class="row" id="cargando-1-fomulario">

                        <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>DATOS PERSONALES</b></label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">

                            <div class="row ">

                              <input type="hidden" id="idpersona" name="idpersona">
                              <input type="hidden" id="idtipo_persona" name="idtipo_persona" value="3">
                              <input type="hidden" id="idbancos" name="idbancos" value="1">
                              <input type="hidden" id="idcargo_trabajador" name="idcargo_trabajador" value="1">
                              <!-- ----------- -->

                              <input type="hidden" id="idpersona_cliente" name="idpersona_cliente">

                              <!-- TIPO PERSONA -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-4 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="nombre_razonsocial">Tipo Persona: <sup class="text-danger">*</sup></label>
                                  <select name="tipo_persona_sunat" id="tipo_persona_sunat" class="form-control" placeholder="Tipo Persona">
                                    <option value="NATURAL">NATURAL</option>
                                    <option value="JURÍDICA">JURÍDICA</option>
                                  </select>
                                </div>
                              </div>

                              <!-- Tipo Doc -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-4 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="tipo_documento">Tipo Doc. <sup class="text-danger">*</sup></label>
                                  <select name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo de documento" ></select>
                                </div>
                              </div>

                              <!-- N° de documento -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="numero_documento">N° de documento <sup class="text-danger">*</sup></label>
                                  <div class="input-group ">
                                    <input type="text" class="form-control" name="numero_documento" id="numero_documento" placeholder="" aria-describedby="icon-view-password">
                                    <button class="btn btn-primary" type="button" onclick="buscar_sunat_reniec('#form-agregar-cliente', '_t', '#tipo_documento', '#numero_documento', '#nombre_razonsocial', '#apellidos_nombrecomercial', '#direccion', '#distrito' );">
                                      <i class='bx bx-search-alt' id="search_t"></i>
                                      <div class="spinner-border spinner-border-sm" role="status" id="charge_t" style="display: none;"></div>
                                    </button>
                                  </div>
                                </div>
                              </div>

                              <!-- Nombre -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-2" >
                                <div class="form-group">
                                  <label class="form-label nombre_razon" for="nombre_razonsocial">Nombre <sup class="text-danger">*</sup></label>
                                  <input type="text" name="nombre_razonsocial" class="form-control inpur_edit" id="nombre_razonsocial" />
                                </div>
                              </div>

                              <!-- Apellidos -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-2" >
                                <div class="form-group">
                                  <label class="form-label apellidos_nombrecomer" for="apellidos_nombrecomercial">Apellidos <sup class="text-danger">*</sup></label>
                                  <input type="text" name="apellidos_nombrecomercial" class="form-control inpur_edit" id="apellidos_nombrecomercial" />
                                </div>
                              </div>
                              <!-- Fecha cumpleaño -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-5 col-xxl-5 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="fecha_nacimiento">Fecha nacimiento </label>
                                  <input type="date" name="fecha_nacimiento" class="form-control inpur_edit" id="fecha_nacimiento" placeholder="Fecha de Nacimiento" onclick="calcular_edad('#fecha_nacimiento', '#edad', '.edad');" onchange="calcular_edad('#fecha_nacimiento', '#edad', '.edad');" />
                                  <input type="hidden" name="edad" id="edad" />
                                </div>
                              </div>
                              <!-- Edad -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 col-xxl-2 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="Edad">Edad </label>
                                  <p class="edad" style="border: 1px solid #ced4da; border-radius: 4px; padding: 5px;">0 años.</p>

                                </div>
                              </div>
                              <!-- Celular  -->
                              <div class="col-12 col-sm-6 col-md-12 col-lg-5 col-xl-5 col-xxl-5 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="celular">Celular </label>
                                  <input type="number" name="celular" class="form-control inpur_edit" id="celular" />
                                </div>
                              </div>

                              <!-- Correo -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-2" >
                                <div class="form-group">
                                  <label class="form-label" for="Correo">Correo </label>
                                  <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo"></input>
                                </div>
                              </div>

                            </div>

                          </div>

                        </div>
                        <!-- --------------DIRECCION -->
                        <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>UBICACIÓN</b></label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">

                            <div class="row ">

                              <!-- Dirección -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="direccion">Dirección: <sup class="text-danger">*</sup></label>
                                  <input type="text" name="direccion" class="form-control inpur_edit" id="direccion" placeholder="ejemp: Jr las flores - Al costado del colegio" />
                                </div>
                              </div>

                              <!-- Distrito -->
                              <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xl-6 col-xxl-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label for="distrito" class="form-label">Distrito: </label></label>
                                  <select name="distrito" id="distrito" class="form-control" placeholder="Seleccionar" onchange="llenar_dep_prov_ubig(this);">
                                  </select>
                                </div>
                              </div>
                              <!-- Departamento -->
                              <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xl-6 col-xxl-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label for="departamento" class="form-label">Departamento: <span class="chargue-pro"></span></label>
                                  <input type="text" class="form-control" name="departamento" id="departamento" readonly>
                                </div>
                              </div>
                              <!-- Provincia -->
                              <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xl-6 col-xxl-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label for="provincia" class="form-label">Provincia: <span class="chargue-dep"></span></label>
                                  <input type="text" class="form-control" name="provincia" id="provincia" readonly>
                                </div>
                              </div>
                              <!-- Ubigeo -->
                              <div class="col-12 col-md-12 col-lg-6 col-xl-6 col-xl-6 col-xxl-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label for="ubigeo" class="form-label">Ubigeo: <span class="chargue-ubi"></span></label>
                                  <input type="text" class="form-control" name="ubigeo" id="ubigeo" readonly>
                                </div>
                              </div>

                            </div>

                          </div>

                        </div>

                        <div class="col-12 col-md-12">

                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b>DATOS TÉCNICOS </b>
                            </label></div>
                            </div>
                          </div>

                          <div class="card-body" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                            <div class="row">


                              <!-- Select trabajdor -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="idpersona_trabajador">
                                  <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('trab');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                                  Trabajador <sup class="text-danger">*</sup><span class="charge_idtrabaj"></span></label>
                                  <select name="idpersona_trabajador" id="idpersona_trabajador" class="form-control" placeholder="Selec. Trabajador"></select>
                                </div>
                              </div>

                              <!-- Select Zona antena -->
                              <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="idzona_antena">
                                  <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('zona');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span> 
                                  Zona Antena <sup class="text-danger">*</sup> <span class="charge_idzona"></span></label>
                                  <select name="idzona_antena" id="idzona_antena" class="form-control" placeholder="Selec. Zona Antena"></select>
                                </div>
                              </div>
                              <!-- Select Zona antena -->
                              <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="idselec_centroProbl">
                                  <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('centroPbl');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                                  Centro Poblado <sup class="text-danger">*</sup><span class="charge_idctroPbl"></span></label>
                                  <select name="idselec_centroProbl" id="idselec_centroProbl" class="form-control" placeholder="Selecionar"></select>
                                </div>
                              </div>

                              <!-- Select Plan -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="idplan">
                                  <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('plan');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                                  Plan <sup class="text-danger">*</sup><span class="charge_idplan"></span></label>
                                  <select name="idplan" id="idplan" class="form-control" placeholder="Selec. Plan"></select>
                                </div>
                              </div>

                              <!-- Ip Personal -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="ip_personal">Ip Personal </label>
                                  <input type="text" name="ip_personal" class="form-control inpur_edit" id="ip_personal" placeholder="ejemp: 192.168.1.12" />
                                </div>
                              </div>

                              <!-- fecha afiliacion -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="fecha_afiliacion">Fecha Afiliación <sup class="text-danger">*</sup></label>
                                  <input type="date" name="fecha_afiliacion" class="form-control inpur_edit" id="fecha_afiliacion" />
                                </div>
                              </div>
                              <!-- fecha CANCELACION -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="fecha_cancelacion">Fecha Cancelación <sup class="text-danger">*</sup></label>
                                  <input type="date" name="fecha_cancelacion" class="form-control inpur_edit" id="fecha_cancelacion" />
                                </div>
                              </div>
                              <!-- USUARIO MICROTICK -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="usuario_microtick">Usuario Microtic <sup class="text-danger">*</sup></label>
                                  <input type="text" name="usuario_microtick"  id="usuario_microtick" class="form-control inpur_edit" />
                                </div>
                              </div>
                              <!--NOTA -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-9 col-xxl-9" style="margin-bottom: 20px;">
                                <div class="form-group">
                                  <label class="form-label" for="nota">Nota </label>
                                  <textarea class="form-control inpur_edit" name="nota" id="nota" cols="30" rows="2" placeholder="ejemp: Se removio el servicio por deuda" ></textarea>
                                </div>
                              </div>
                              <!-- Descuento -->
                              <div class="col-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2" style="margin-bottom: 20px; display: none;">
                                <div class="form-group">
                                  <label class="form-label" for="estado_descuento"><sup class="text-white">*</sup></label>
                                  <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                    <input id="toggleswitchSuccess" name="toggleswitch001" type="checkbox" onchange="funtion_switch();">
                                    <label for="toggleswitchSuccess" class="label-success"></label><span class="ms-3">Descuento</span>
                                  </div>
                                  <input type="hidden" id="estado_descuento" name="estado_descuento" value="0">
                                </div>
                              </div>

                              <!-- fecha afiliacion -->
                              <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 col-xxl-2" style="margin-bottom: 20px; display: none;">
                                <div class="form-group">
                                  <label class="form-label" for="descuento">Monto descuento <sup class="text-danger">*</sup></label>
                                  <input type="number" name="descuento" class="form-control inpur_edit" id="descuento" readonly />
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                        <!-- Imgen -->
                        <div class="col-md-4 col-lg-4 mt-4">
                          <span class=""> <b>Imagen de Perfil</b> </span>
                          <div class="mb-4 mt-2 d-sm-flex align-items-center">
                            <div class="mb-0 me-5">
                              <span class="avatar avatar-xxl avatar-rounded">
                                <img src="../assets/images/faces/9.jpg" alt="" id="imagenmuestra" onerror="this.src='../assets/modulo/persona/perfil/no-perfil.jpg';">
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
                      <button type="submit" style="display: none;" id="submit-form-cliente">Submit</button>
                    </form>
                  </div>

                  <div id="div-pago-x-cliente" style="display: none;">
                    <div class="table-responsive" id="div_tabla_x_cliente">
                      <div class="row" >
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>                       
                    </div>
                  </div>

                  <div id="div-pago-all-cliente" style="display: none;">
                    <div class="row mb-3" >
                        
                      <!-- ::::::::::::::::::::: FILTRO TRABAJADOR :::::::::::::::::::::: -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="form-group">
                          <label for="filtro_p_all_trabajador" class="form-label">                         
                            <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_p_all_trabajador');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                            Trabajador
                            <span class="charge_filtro_p_all_trabajador"></span>
                          </label>
                          <select class="form-control" name="filtro_p_all_trabajador" id="filtro_p_all_trabajador" onchange="cargando_search_pago_all(); delay(function(){filtros_pago_all()}, 50 );" > <!-- lista de categorias --> </select>
                        </div>
                      </div>
                      <!-- ::::::::::::::::::::: FILTRO DIA DE PAGO :::::::::::::::::::::: -->
                      <div class="col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <div class="form-group">
                          <label for="filtro_p_all_dia_pago" class="form-label">                         
                            <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_dia_pago');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                            Día Afiliación
                            <span class="charge_filtro_p_all_dia_pago"></span>
                          </label>
                          <select class="form-control" name="filtro_p_all_dia_pago" id="filtro_p_all_dia_pago" onchange="cargando_search_pago_all(); delay(function(){filtros_pago_all()}, 50 );" > <!-- lista de categorias --> </select>
                        </div>
                      </div>
                      <!-- ::::::::::::::::::::: FILTRO AÑO :::::::::::::::::::::: -->
                      <div class="col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <div class="form-group">
                          <label for="filtro_p_all_anio_pago" class="form-label">                         
                            <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_anio_pago');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                            Año de Pago
                            <span class="charge_filtro_p_all_anio_pago"></span>
                          </label>
                          <select class="form-control" name="filtro_p_all_anio_pago" id="filtro_p_all_anio_pago" onchange="cargando_search_pago_all(); delay(function(){filtros_pago_all()}, 50 );" > <!-- lista de categorias --> </select>
                        </div>
                      </div>
                      <!-- ::::::::::::::::::::: FILTRO PLAN :::::::::::::::::::::: -->
                      <div class="col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                        <div class="form-group">
                          <label for="filtro_p_all_plan" class="form-label">                         
                            <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_p_all_plan');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                            Plan
                            <span class="charge_filtro_p_all_plan"></span>
                          </label> 
                          <select class="form-control" name="filtro_p_all_plan" id="filtro_p_all_plan" onchange="cargando_search_pago_all(); delay(function(){filtros_pago_all()}, 50 );" > </select>
                        </div>
                      </div>
                      <!-- ::::::::::::::::::::: FILTRO ZONA ANTENA :::::::::::::::::::::: -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                        <div class="form-group">
                          <label for="filtro_p_all_zona_antena" class="form-label">                         
                            <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_select('filtro_p_all_zona_antena');" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                            Zona Antena
                            <span class="charge_filtro_p_all_zona_antena"></span>
                          </label>
                          <select class="form-control" name="filtro_p_all_zona_antena" id="filtro_p_all_zona_antena" onchange="cargando_search_pago_all(); delay(function(){filtros_pago_all()}, 50 );" > <!-- lista de categorias --> </select>
                        </div>
                      </div>
                      
                    </div>
                    <div class="table-responsive" id="div_tabla_all_pagos">
                      <div class="row" >
                        <div class="col-lg-12 text-center">
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>                      
                    </div>
                  </div>
                </div>
                <div class="card-footer border-top-0">
                  <button type="button" class="btn btn-danger btn-cancelar" onclick="wiev_tabla_formulario(1);" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                  <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"> <i class="ri-save-2-line label-btn-icon me-2"></i> Guardar </button>
                </div>
              </div>
              
            </div>
          </div>          
          <!-- End::row-1 --> 
          
          <!-- Start::Modal-pago-cliente-x-mes -->
          <div class="modal fade" id="pago-cliente-mes" tabindex="-1" aria-labelledby="pago-cliente-mesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="pago-cliente-mesLabel1">Pagos por Mes</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="table-responsive" id="div_tabla_pagos_Cx_mes">
                    <div class="row" >
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>                      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::Modal-pago-cliente-x-mes -->

          <!-- Start::modal-imprimir_ticket -->
          <div class="modal fade" id="modal-imprimir-comprobante" tabindex="-1" aria-labelledby="modal-imprimir-comprobante-Label" aria-hidden="true">
            <div class="modal-dialog modal-md" >
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal-imprimir-comprobante-Label"> <button type="button" class="btn btn-icon btn-sm btn-primary btn-wave" data-bs-toggle="tooltip" title="Imprimir Ticket" onclick="printIframe('modalAntcticket')"><i class="ri-printer-fill"></i></button> Ticket Pago Cliente</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="html-imprimir-comprobante" class="text-center" > </div>                   
                </div>
                
              </div>
            </div>
          </div>
          <!-- End::modal-imprimir_ticket -->

        </div>
      </div>
      <!-- End::app-content -->

      <?php } else { $title_submodulo ='Clientes'; $descripcion ='Lista de Clientes del sistema!'; $title_modulo = 'Ventas'; include("403_error.php"); }?>   


      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>

    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>


    <script src="scripts/persona_cliente.js?version_jdl=1.1"></script>
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