<?php
ob_start();
if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status' => 'login', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => []];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['cliente'] == 1) {

    require_once "../modelos/Persona_cliente.php";

    $persona_cliente = new Cliente();
    date_default_timezone_set('America/Lima');
    $date_now = date("d_m_Y__h_i_s_A");

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
    $fecha_cancelacion           = isset($_POST["fecha_cancelacion"]) ? limpiarCadena($_POST["fecha_cancelacion"]) : "";
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
            $fecha_afiliacion,
            $estado_descuento,
            $descuento,
            $fecha_cancelacion,
            $img_perfil
          );
          echo json_encode($rspta, true);
        } else {

          if ($flat_img1 == true || empty($img_perfil)) {
            $datos_f1 = $persona_cliente->perfil_trabajador($idpersona);
            $img1_ant = $datos_f1['data']['foto_perfil'];
            if (!empty($img1_ant)) {
              unlink("../assets/modulo/persona/perfil/" . $img1_ant);
            }
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
            $fecha_afiliacion,
            $estado_descuento,
            $descuento,
            $fecha_cancelacion,
            $img_perfil
          );
          echo json_encode($rspta, true);
        }
        break;

      case 'desactivar':
        $rspta = $persona_cliente->desactivar_cliente($_GET["id_tabla"]);
        echo json_encode($rspta, true);
        break;

      case 'eliminar':
        $rspta = $persona_cliente->eliminar_cliente($_GET["id_tabla"]);
        echo json_encode($rspta, true);
        break;

      case 'mostrar_cliente':
        $rspta = $persona_cliente->mostrar_cliente($idpersona_cliente);
        //Codificar el resultado utilizando json
        echo json_encode($rspta, true);
        break;

      case 'tabla_principal_cliente':
        $rspta = $persona_cliente->tabla_principal_cliente();
        //Vamos a declarar un array
        $data = [];
        $cont = 1;
        $dia_cancel = "";
        $fecha_proximo_pago = '';
        $fecha_pago = "";
        $falta="";
        $fecha_pago_of="";
        $class_dia = "";
        $toltip = '<script> $(function() { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

        if ($rspta['status'] == true) {
          //dia_cancelacion
          foreach ($rspta['data'] as $key => $value) {

            if (isset($value['dia_cancelacion']) && $value['dia_cancelacion'] !== null) {

              $dia_cancel = $value['dia_cancelacion'];

              // Obtener la fecha actual
              $fecha_actual = date("Y-m-d");

              $dia_act = date("d", strtotime($fecha_actual));

              if ($dia_cancel >= $dia_act) {

                $anio_mes_actual  = date('Y-m');

                $dif_dias=$dia_cancel-$dia_act;

                $fecha_pago_of = $anio_mes_actual . '-' . $dia_cancel;

                $falta = "Falta ".$dif_dias." Días"; 

              
                if($dif_dias>5){
                  $class_dia="bg-success";

                }elseif ($dif_dias<=5 && $dif_dias>=3){
                  $class_dia="bg-warning";
                } else{
                  $class_dia="bg-danger";
                }



              } elseif ($value['dia_cancelacion'] < $dia_act) {

                $anio_mes_siguiente = date('Y-m', strtotime('+1 month'));

                $fecha_pago_of = $anio_mes_siguiente . '-' . $value['dia_cancelacion'];

                $dif =diferencia_days_months_years($fecha_pago_of, date('Y-m-d'), 'days');



                $falta = "Falta ".$dif." Días";

                if($dif>5){
                  $class_dia="bg-outline-success";

                }elseif ($dif<=5 && $dif>=3){
                  $class_dia="bg-outline-warning";
                } else{
                  $class_dia="bg-outline-danger";
                }


              } else {
              }
            } else {

              $fecha_proximo_pago = '';
            }


            $imagen_perfil = empty($value['foto_perfil']) ? 'no-perfil.jpg' :   $value['foto_perfil'];

            $data[] = array(
              "0" => $cont++,
              "1" => '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar_cliente(' . $value['idpersona_cliente'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>' .
                ' <button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar_cliente(' . $value['idpersona_cliente'] . ', \'' . encodeCadenaHtml($value['nombre_completo']) . '\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>',
              "2" => '<div class="d-flex flex-fill align-items-center">
              <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen"><span class="avatar"> <img src="../assets/modulo/persona/perfil/' . $imagen_perfil . '" alt="" onclick="ver_img(\'' . $imagen_perfil . '\', \'' . encodeCadenaHtml($value['nombre_completo']) . '\')"> </span></div>
              <div>
                <span class="d-block fw-semibold text-primary">' . $value['nombre_completo'] . '</span>
                <span class="text-muted">' . $value['tipo_doc'] . ' : ' . $value['numero_documento'] . '</span>
              </div>
            </div>',
              "3" => $value['celular'],
              "4" => '<textarea cols="30" rows="2" class="textarea_datatable bg-light " readonly="">' . $value['centro_poblado'] . ' : ' . $value['direccion'] . '</textarea>',
              "5" => '<span class="badge '.$class_dia.'">'. $falta .'- ' .   date("d/m/Y", strtotime($fecha_pago_of)) .'</span>',
              "6" => '<span class="badge bg-outline-success">' . $value['zona'] . '</span>' . '' . '<span class="badge bg-outline-success">' . $value['nombre_plan'] . ' : ' . $value['costo'] . '</span>',
              "7" => '<div class="text-start font-size-12px" >
                      <span class="d-block text-primary fw-semibold"> <i class="bx bx-broadcast bx-burst fa-1x" ></i> ' . $value['ip_antena'] . '</span>
                      <span class="text-muted"><i class="bx bx-wifi bx-burst" ></i>' . $value['ip_personal'] . '</span>
                    </div>',
              "8" => $value['nombre_razonsocial'],
              "9" => $value['nombre_completo'],
              "10" => $value['tipo_doc'],
              "11" => $value['numero_documento'],
              "12" => $value['centro_poblado'],
              "13" => $value['direccion'],
              "14" => $value['nombre_plan'],
              "15" => $value['costo'],
              "16" => $value['zona'],
              "17" =>  date("d/m/Y", strtotime($fecha_pago_of)),
              "18" => $value['ip_antena']

            );
          }
          $results = [
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
        $rspta = ['status' => 'error_code', 'message' => 'Te has confundido en escribir en el <b>swich.</b>', 'data' => []];
        echo json_encode($rspta, true);
        break;
    }
  } else {
    $retorno = ['status' => 'nopermiso', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => []];
    echo json_encode($retorno);
  }
}

ob_end_flush();
