<?php
ob_start();
if (strlen(session_id()) < 1) {
  session_start();
} //Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status' => 'login', 'message' => 'Tu sesion a terminado pe, inicia nuevamente', 'data' => []];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['empresa'] == 1) {

    require_once "../modelos/Persona_cliente.php";

    $persona_cliente = new Cliente();

    $idpersona_cliente     = isset($_POST["idpersona_cliente"]) ? limpiarCadena($_POST["idpersona_cliente"]) : "";
    $idzona_antena       = isset($_POST["idzona_antena"]) ? limpiarCadena($_POST["idzona_antena"]) : "";
    $idplan         = isset($_POST["idplan"]) ? limpiarCadena($_POST["idplan"]) : "";
    $id_tecnico         = isset($_POST["id_tecnico"]) ? limpiarCadena($_POST["id_tecnico"]) : "";

    $ip_personal         = isset($_POST["ip_personal"]) ? limpiarCadena($_POST["ip_personal"]) : "";
    $fecha_afiliacion         = isset($_POST["fecha_afiliacion"]) ? limpiarCadena($_POST["fecha_afiliacion"]) : "";
    $nota         = isset($_POST["nota"]) ? limpiarCadena($_POST["nota"]) : "";
    $descuento         = isset($_POST["descuento"]) ? limpiarCadena($_POST["descuento"]) : "";
    $estado_descuento         = isset($_POST["estado_descuento"]) ? limpiarCadena($_POST["estado_descuento"]) : "";

    // $idpersona_cliente, $idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento
    //`idpersona_cliente`, `idzona_antena`, `idplan`, `id_tecnico`, `ip_personal`, `ip_antena`, `fecha_afiliacion`, `nota`, `descuento`, `estado_descuento`
    //---id cliente no va 
    switch ($_GET["op"]) {
      case 'guardar_y_editar_cliente':
        if (empty($idpersona_cliente)) {
          $rspta = $persona_cliente->insertar_cliente($idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento);
          echo json_encode($rspta, true);
        } else {
          $rspta = $persona_cliente->editar_cliente($idpersona_cliente, $idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento);
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

        $toltip = '<script> $(function() { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

        if ($rspta['status'] == true) {

          foreach ($rspta['data'] as $key => $value) {

            $data[] = array(
              "0" => $cont++,
              "1" => '<button class="btn btn-icon btn-sm btn-warning-light" onclick="mostrar_cliente(' . $value['idpersona_cliente'] . ')" data-bs-toggle="tooltip" title="Editar"><i class="ri-edit-line"></i></button>' .
                ' <button  class="btn btn-icon btn-sm btn-danger-light product-btn" onclick="eliminar_cliente(' . $value['idpersona_cliente'] . ', \'' . encodeCadenaHtml($value['nombre']) . '\')" data-bs-toggle="tooltip" title="Eliminar"><i class="ri-delete-bin-line"></i></button>',
              "2" => $value['nombre'],
              "3" => $value['idplan'],
              "4" => ($value['estado'] == '1') ? '<span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Activo</span>' : '<span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Desactivado</span>'

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
