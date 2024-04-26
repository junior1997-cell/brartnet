<?php
ob_start();
if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status' => 'login', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => []];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['cliente'] == 1) {

    require_once "../modelos/Persona_cliente.php";

    $persona_cliente = new Cliente();
    date_default_timezone_set('America/Lima');
    $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function() { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

    $idpersona                  = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
    $idtipo_persona             = isset($_POST["idtipo_persona"]) ? limpiarCadena($_POST["idtipo_persona"]) : "";
    $idbancos                   = isset($_POST["idbancos"]) ? limpiarCadena($_POST["idbancos"]) : "";
    $idcargo_trabajador         = isset($_POST["idcargo_trabajador"]) ? limpiarCadena($_POST["idcargo_trabajador"]) : "";
    $idpersona_cliente          = isset($_POST["idpersona_cliente"]) ? limpiarCadena($_POST["idpersona_cliente"]) : "";
    $tipo_persona_sunat         = isset($_POST["tipo_persona_sunat"]) ? limpiarCadena($_POST["tipo_persona_sunat"]) : "";
    $tipo_documento             = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
    $numero_documento           = isset($_POST["numero_documento"]) ? limpiarCadena($_POST["numero_documento"]) : "";
    $nombre_razonsocial         = isset($_POST["nombre_razonsocial"]) ? limpiarCadena($_POST["nombre_razonsocial"]) : "";
    $apellidos_nombrecomercial  = isset($_POST["apellidos_nombrecomercial"]) ? limpiarCadena($_POST["apellidos_nombrecomercial"]) : "";
    $fecha_nacimiento           = isset($_POST["fecha_nacimiento"]) ? limpiarCadena($_POST["fecha_nacimiento"]) : "";

    $celular                    = isset($_POST["celular"]) ? limpiarCadena($_POST["celular"]) : "";
    $direccion                  = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
    $distrito                   = isset($_POST["distrito"]) ? limpiarCadena($_POST["distrito"]) : "";
    $departamento               = isset($_POST["departamento"]) ? limpiarCadena($_POST["departamento"]) : "";
    $provincia                  = isset($_POST["provincia"]) ? limpiarCadena($_POST["provincia"]) : "";
    $ubigeo                     = isset($_POST["ubigeo"]) ? limpiarCadena($_POST["ubigeo"]) : "";
    $correo                     = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
    $idpersona_trabajador       = isset($_POST["idpersona_trabajador"]) ? limpiarCadena($_POST["idpersona_trabajador"]) : "";
    $idzona_antena              = isset($_POST["idzona_antena"]) ? limpiarCadena($_POST["idzona_antena"]) : "";
    $idselec_centroProbl        = isset($_POST["idselec_centroProbl"]) ? limpiarCadena($_POST["idselec_centroProbl"]) : "";
    $idplan                     = isset($_POST["idplan"]) ? limpiarCadena($_POST["idplan"]) : "";
    $ip_personal                = isset($_POST["ip_personal"]) ? limpiarCadena($_POST["ip_personal"]) : "";
    $fecha_afiliacion           = isset($_POST["fecha_afiliacion"]) ? limpiarCadena($_POST["fecha_afiliacion"]) : "";
    $fecha_cancelacion          = isset($_POST["fecha_cancelacion"]) ? limpiarCadena($_POST["fecha_cancelacion"]) : "";
    $usuario_microtick          = isset($_POST["usuario_microtick"]) ? limpiarCadena($_POST["usuario_microtick"]) : "";
    $nota                       = isset($_POST["nota"]) ? limpiarCadena($_POST["nota"]) : "";

    $estado_descuento           = isset($_POST["estado_descuento"]) ? limpiarCadena($_POST["estado_descuento"]) : "";
    $descuento                  = isset($_POST["descuento"]) ? limpiarCadena($_POST["descuento"]) : "";

    
    // $idpersona_cliente, $idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento
    //`idpersona_cliente`, `idzona_antena`, `idplan`, `id_tecnico`, `ip_personal`, `ip_antena`, `fecha_afiliacion`, `nota`, `descuento`, `estado_descuento`
    //---id cliente no va 
    switch ($_GET["op"]) {
      case 'guardar_y_editar_cliente':

        //guardar f_img_fondo fondo
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
          $img_perfil = $_POST["imagenactual"];
          $flat_img1 = false;
        } else {
          $ext1 = explode(".", $_FILES["imagen"]["name"]);
          $flat_img1 = true;
          $img_perfil = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext1);
          move_uploaded_file($_FILES["imagen"]["tmp_name"], "../assets/modulo/persona/perfil/" . $img_perfil);
        }


        if (empty($idpersona_cliente)) {
          $rspta = $persona_cliente->insertar_cliente(
            $idtipo_persona,
            $idbancos,
            $idcargo_trabajador,
            $tipo_persona_sunat,
            $tipo_documento,
            $numero_documento,
            $nombre_razonsocial,
            $apellidos_nombrecomercial,
            $fecha_nacimiento,
            $celular,
            $direccion,
            $distrito,
            $departamento,
            $provincia,
            $ubigeo,
            $correo,
            $idpersona_trabajador,
            $idzona_antena,
            $idselec_centroProbl,
            $idplan,
            $ip_personal,
            $fecha_afiliacion, $fecha_cancelacion, $usuario_microtick,$nota,
            $estado_descuento, 
            $descuento,            
            $img_perfil
          );
          echo json_encode($rspta, true);
        } else {

          if ($flat_img1 == true || empty($img_perfil)) {
            $datos_f1 = $persona_cliente->perfil_trabajador($idpersona);
            $img1_ant = $datos_f1['data']['foto_perfil'];
            if (!empty($img1_ant)) { unlink("../assets/modulo/persona/perfil/" . $img1_ant); }
          }


          $rspta = $persona_cliente->editar_cliente(
            $idpersona,
            $idtipo_persona,
            $idbancos,
            $idcargo_trabajador,
            $idpersona_cliente,
            $tipo_persona_sunat,
            $tipo_documento,
            $numero_documento,
            $nombre_razonsocial,
            $apellidos_nombrecomercial,
            $fecha_nacimiento,
            $celular,
            $direccion,
            $distrito,
            $departamento,
            $provincia,
            $ubigeo,
            $correo,
            $idpersona_trabajador,
            $idzona_antena,
            $idselec_centroProbl,
            $idplan,
            $ip_personal,
            $fecha_afiliacion,$fecha_cancelacion, $usuario_microtick,$nota,
            $estado_descuento,
            $descuento,            
            $img_perfil
          );
          echo json_encode($rspta, true);
        }
      break;

      case 'desactivar_cliente':
        $rspta = $persona_cliente->desactivar_cliente($_GET["id_tabla"], $_GET["descripcion"]);
        echo json_encode($rspta, true);
      break;

      case 'activar_cliente':
        $rspta = $persona_cliente->activar_cliente($_GET["id_tabla"], $_GET["descripcion"]);
        echo json_encode($rspta, true);
      break;

      case 'eliminar_cliente':
        $rspta = $persona_cliente->eliminar_cliente($_GET["id_tabla"]);
        echo json_encode($rspta, true);
      break;

      case 'mostrar_cliente':
        $rspta = $persona_cliente->mostrar_cliente($idpersona_cliente);
        //Codificar el resultado utilizando json
        echo json_encode($rspta, true);
      break;

      case 'tabla_principal_cliente':
        $rspta = $persona_cliente->tabla_principal_cliente($_GET["filtro_trabajador"],$_GET["filtro_dia_pago"],$_GET["filtro_plan"],$_GET["filtro_zona_antena"]);
        //Vamos a declarar un array
        $data = [];
        $cont = 1;
        $dia_cancel = "";
        $fecha_proximo_pago = '';
        $fecha_pago = "";        
        $fecha_pago_of="";
        $class_dia = "";        

        if ($rspta['status'] == true) {
          //dia_cancelacion
          foreach ($rspta['data'] as $key => $value) {

            if (isset($value['dia_cancelacion']) && $value['dia_cancelacion'] !== null) {

              $dia_cancel = $value['dia_cancelacion'];              
              $fecha_actual = date("Y-m-d"); // Obtener la fecha actual
              $dia_act = date("d", strtotime($fecha_actual));
              $dif_dias = 0;

              if ($dia_cancel >= $dia_act) {

                $anio_mes_actual  = date('Y-m');
                $dif_dias         = $dia_cancel-$dia_act;
                $fecha_pago_of    = $anio_mes_actual . '-' . $dia_cancel;                 

              } elseif ($value['dia_cancelacion'] < $dia_act) {

                $anio_mes_siguiente = date('Y-m', strtotime('+1 month'));
                $fecha_pago_of      = $anio_mes_siguiente . '-' . $value['dia_cancelacion'];
                $dif_dias           = diferencia_days($fecha_pago_of, date("Y-m-d"));
              } 
            } else {
              $fecha_proximo_pago = '';
            }

            if($dif_dias>5){  $class_dia="bg-outline-success";  }elseif ($dif_dias<=5 && $dif_dias>=3){ $class_dia="bg-outline-warning";  } else{ $class_dia="bg-outline-danger";  }

            $imagen_perfil = empty($value['foto_perfil']) ? 'no-perfil.jpg' :   $value['foto_perfil'];

            $data[] = array(
              "0" => $cont++,
              "1" => '<button class="btn btn-icon btn-sm border-warning btn-warning-light" onclick="mostrar_cliente(' . $value['idpersona_cliente'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>' .
                ( $value['estado'] ? ' <button  class="btn btn-icon btn-sm border-danger btn-danger-light product-btn" onclick="eliminar_cliente(' . $value['idpersona_cliente'] . ', \'' . encodeCadenaHtml($value['cliente_nombre_completo']) . '\')" data-bs-toggle="tooltip" title="Dar de baja o Eliminar"><i class="ri-delete-bin-line"></i></button>' : 
                ' <button  class="btn btn-icon btn-sm border-success btn-success-light product-btn" onclick="activar(' . $value['idpersona_cliente'] . ', \'' . encodeCadenaHtml($value['cliente_nombre_completo']) . '\')" data-bs-toggle="tooltip" title="Reactivar"><i class="ri-check-line"></i></button>').
              ' <div class="btn-group ">
                <button type="button" class="btn btn-info btn-sm dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ri-settings-4-line"></i></button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-coin"></i> Realizar Pago</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="ver_pagos_x_cliente(' . $value['idpersona_cliente'] . ');" ><i class="ti ti-checkup-list"></i> Listar pagos</a></li>                  
                </ul>
              </div>',
              "2" => '<div class="d-flex flex-fill align-items-center">
                <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                  <span class="avatar"> <img src="../assets/modulo/persona/perfil/' . $imagen_perfil . '" alt="" onclick="ver_img(\'' . $imagen_perfil . '\', \'' . encodeCadenaHtml($value['cliente_nombre_completo']) . '\')"> </span>
                </div>
                <div>
                  <span class="d-block fw-semibold text-primary">' . $value['cliente_nombre_completo'] . '</span>
                  <span class="text-muted text-nowrap">' . $value['tipo_doc'] . ' : ' . $value['numero_documento'] . '</span> |
                  <span class="text-muted text-nowrap">Cel.: ' . '<a href="tel:+51'.$value['celular'].'" data-bs-toggle="tooltip" title="Clic para hacer llamada">'.$value['celular'].'</a>' . '</span>
                </div>
              </div>',
              "3" => '<textarea cols="30" rows="2" class="textarea_datatable bg-light " readonly="">' . $value['centro_poblado'] . ' : ' . $value['direccion'] . '</textarea>',
              "4" => $dif_dias,
              "5" => '<span class="badge '.$class_dia.'">'.   date("d/m/Y", strtotime($fecha_pago_of)) .'</span>',
              "6" => '<span class="badge bg-outline-success">' . $value['zona'] . '</span>' . '<br>' . '<span class="badge bg-outline-success">' . $value['nombre_plan'] . ' : ' . $value['costo'] . '</span>',
              "7" => '<div class="text-start font-size-12px" >
                      <span class="d-block text-primary fw-semibold text-nowrap"> <i class="bx bx-broadcast bx-burst fa-1x" ></i> ' . $value['ip_antena'] . '</span>
                      <span class="d-block text-muted text-nowrap"><i class="bx bx-wifi bx-burst" ></i> ' . $value['ip_personal'] . '</span>
                      <span class="text-muted text-nowrap"><i class="bx bx-user-pin fa-1x"></i> ' . $value['usuario_microtick'] . '</span>
                    </div>',
              "8" => $value['trabajador_nombre'],
              "9" => '<textarea cols="30" rows="2" class="textarea_datatable bg-light " readonly="">' . $value['nota'] . '</textarea>',
              
              "10" => $value['cliente_nombre_completo'],
              "11" => $value['tipo_doc'],
              "12" => $value['numero_documento'],
              "13" => $value['centro_poblado'],
              "14" => $value['direccion'],
              "15" => $value['nombre_plan'],
              "16" => $value['costo'],
              "17" => $value['zona'],
              "18" =>  date("d/m/Y", strtotime($fecha_pago_of)),
              "19" => $value['ip_antena']

            );
          }
          $results = [
            'status'=> true,
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data,
          ];
          echo json_encode($results, true);
        } else {
          echo $rspta['code_error'] . ' - ' . $rspta['message'] . ' ' . $rspta['data'];
        }

      break;

      // ══════════════════════════════════════   PAGOS ALL CLIENTES   ══════════════════════════════════════ 
      case 'ver_pagos_x_cliente':
        $rspta = $persona_cliente->ver_pagos_x_cliente($_GET["idcliente"]);

        $imagen_perfil = empty($rspta['data']['foto_perfil']) ? 'no-perfil.jpg' :   $rspta['data']['foto_perfil'];
        $bg_light = $rspta['data']['estado'] == 1 ? '' : 'bg-danger-transparent';

        echo '<table class="table table-striped table-bordered table-condensed">
          <thead>
            <th >N°</th> <th >APELLIDOS Y NOMBRES</th> <th >CANCELACIÓN</th> <th >IMPORTE</th> <th >AÑO</th> <th >ENE</th> <th >FEB</th> <th >MAR</th> <th >ABR</th>
            <th >MAY</th> <th >JUN</th> <th >JUL</th> <th >AGO</th> <th >SEP</th> <th >OCT</th> <th >SEP</th> <th >NOV</th> <th >DIC</th> <th >OBSERVACIONES</th>
          </thead>
          <tbody>
            <tr>
              <th class="py-2  text-center">1</th>
              <td class="py-2  text-nowrap" rowspan="3" ><div class="d-flex flex-fill align-items-center">
                  <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                    <span class="avatar"> <img class="w-30px h-auto" src="../assets/modulo/persona/perfil/' . $imagen_perfil . '" alt="" onclick="ver_img(\'' . $imagen_perfil . '\', \'' . encodeCadenaHtml($rspta['data']['cliente_nombre_completo']) . '\')" alt="" > </span>
                  </div>
                  <div>
                    <span class="d-block fw-semibold text-primary">' . $rspta['data']['cliente_nombre_completo'] . '</span>
                    <span class="text-muted fs-10 text-nowrap">' . $rspta['data']['tipo_doc'] . ' : ' . $rspta['data']['numero_documento'] . '</span> |
                    <span class="text-muted fs-10 text-nowrap"><i class="ti ti-fingerprint fs-12"></i> '. $rspta['data']['idcliente'] . '</span>
                  </div>
                </div></td>
              <td class="py-2  text-center" rowspan="3">'.$rspta['data']['fecha_cancelacion_format'].'</td>                            
              <td class="py-2  text-center" rowspan="3" >'.$rspta['data']['costo'].'</td>
              <td class="py-2  text-nowrap" >2022</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2 " rowspan="3"><textarea cols="30" rows="2" class="textarea_datatable  bg-light" readonly="">' . $rspta['data']['nota'] . '</textarea></td>
            </tr>      
            
            <tr>
              <th class="py-2  text-center">2</th>
              <td class="py-2  text-nowrap" >2021</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
            </tr>      
            <tr>
              <th class="py-2  text-center">3</th>
              <td class="py-2  text-nowrap" >2020</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" >50</td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
              <td class="py-2  text-center" ></td>
            </tr>      

          </tbody>
        </table>';        
        
      break;

      // ══════════════════════════════════════   PAGOS ALL CLIENTES   ══════════════════════════════════════ 
      case 'ver_pagos_all_cliente':
        $rspta = $persona_cliente->ver_pagos_all_cliente($_GET["filtro_trabajador"],$_GET["filtro_dia_pago"],$_GET["filtro_anio_pago"],$_GET["filtro_plan"],$_GET["filtro_zona_antena"]);
        
        echo '<table class="table  table-hover table-bordered table-condensed">
        <thead>
          <tr id="id_buscando_tabla_pago_all"> 
            <th colspan="20" class="bg-danger " style="text-align: center !important;"><i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando... </th>
          </tr>
          <tr > 
            <th >N°</th> <th >APELLIDOS Y NOMBRES</th> <th >CANCELACIÓN</th> <th >IMPORTE</th> <th >AÑO</th> <th >ENE</th> <th >FEB</th> <th >MAR</th> <th >ABR</th>
            <th >MAY</th> <th >JUN</th> <th >JUL</th> <th >AGO</th> <th >SEP</th> <th >OCT</th> <th >NOV</th> <th >DIC</th> <th >OBSERVACIONES</th>
          </tr>
        </thead>
        <tbody>';

        foreach ($rspta['data'] as $key => $val) {
          $imagen_perfil = empty($val['foto_perfil']) ? 'no-perfil.jpg' :   $val['foto_perfil'];
          $bg_light = $val['estado'] == 1 ? '' : 'bg-danger-transparent';
          echo '<tr>
            <th class="py-0 '.$bg_light.' text-center">'.($key + 1).'</th>
            <td class="py-0 '.$bg_light.' text-nowrap"><div class="d-flex flex-fill align-items-center">
                <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                  <span class="avatar"> <img class="w-30px h-auto" src="../assets/modulo/persona/perfil/' . $imagen_perfil . '" alt="" onclick="ver_img(\'' . $imagen_perfil . '\', \'' . encodeCadenaHtml($val['cliente_nombre_completo']) . '\')"> </span>
                </div>
                <div>
                  <span class="d-block fw-semibold text-primary">' . $val['cliente_nombre_completo'] . '</span>
                  <span class="text-muted fs-10 text-nowrap">' . $val['tipo_doc'] . ' : ' . $val['numero_documento'] . '</span> |
                  <span class="text-muted fs-10 text-nowrap"><i class="ti ti-fingerprint fs-12"></i> '. $val['idcliente'] . '</span>
                </div>
              </div></td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['fecha_cancelacion_format'].'</td>
            <td class="py-0 '.$bg_light.' text-nowrap" >S/ '.$val['costo'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['periodo_pago_year'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_enero'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_febrero'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_marzo'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_abril'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_mayo'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_junio'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_julio'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_agosto'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_septiembre'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_octubre'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_noviembre'].'</td>
            <td class="py-0 '.$bg_light.' text-center" >'.$val['venta_diciembre'].'</td>
            <td class="py-0 '.$bg_light.'" ><textarea cols="30" rows="2" class="textarea_datatable '.$bg_light.' bg-light " readonly="">' . $val['nota'] . '</textarea></td>
          </tr>';
        }

        echo '</tbody>
        </table>';
      break;

      // ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════ 

      case 'select2_filtro_trabajador':

        $rspta = $persona_cliente->select2_filtro_trabajador();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['idpersona_trabajador']  . '">' . $value['idtrabajador']. ' '.  $value['nombre_razonsocial']  . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;  
      
      case 'select2_filtro_dia_pago':

        $rspta = $persona_cliente->select2_filtro_dia_pago();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['dia_cancelacion']  . '">Día ' . $value['dia_cancelacion'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;

      case 'select2_filtro_anio_pago':

        $rspta = $persona_cliente->select2_filtro_anio_pago();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['anio_cancelacion']  . '">' . $value['anio_cancelacion'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;
      case 'select2_filtro_plan':

        $rspta = $persona_cliente->select2_filtro_plan();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['idplan']  . '">' . $value['nombre'] . ' ' . $value['costo'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;

      case 'select2_filtro_zona_antena':

        $rspta = $persona_cliente->select2_filtro_zona_antena();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['idzona_antena']  . '">' . $value['nombre'] . ' - IP: ' . $value['ip_antena'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;

      case 'select2_plan':

        $rspta = $persona_cliente->select2_plan();
        $cont = 1;
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idplan']  . '>' . $value['nombre'] . ' - Costo: ' . $value['costo'] . '</option>';
          }

          $retorno = array(
            'status' => true,
            'message' => 'Salió todo ok',
            'data' => $data,
          );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;

      case 'select2_zona_antena':

        $rspta = $persona_cliente->select2_zona_antena();
        $cont = 1;
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idzona_antena']  . '>' . $value['nombre'] . ' - IP: ' . $value['ip_antena'] . '</option>';
          }

          $retorno = array(
            'status' => true,
            'message' => 'Salió todo ok',
            'data' => $data,
          );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }
      break;

      case 'select2_trabajador':

        $rspta = $persona_cliente->select2_trabajador();
        $cont = 1;
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idpersona_trabajador']  . '>' . $value['nombre_completo'] . ' ' . $value['numero_documento'] . '</option>';
          }

          $retorno = array(
            'status' => true,
            'message' => 'Salió todo ok',
            'data' => $data,
          );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;

      case 'selec_centroProbl':

        $rspta = $persona_cliente->selec_centroProbl();
        $cont = 1;
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idcentro_poblado']  . '>' . $value['nombre'] . '</option>';
          }

          $retorno = array(
            'status' => true,
            'message' => 'Salió todo ok',
            'data' => $data,
          );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;


      case 'salir':
        //Limpiamos las variables de sesión
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
      break;

      default:
        $rspta = ['status' => 'error_code', 'message' => 'Te has confundido en escribir en el <b>swich.</b>', 'data' => [], 'aaData' => []];
        echo json_encode($rspta, true);
      break;
    }
  } else {
    $retorno = ['status' => 'nopermiso', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => []];
    echo json_encode($retorno);
  }
}

ob_end_flush();
