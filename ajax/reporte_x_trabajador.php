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

    require_once "../modelos/Reporte_x_trabajador.php";

    $reporte_x_trabajador = new Reporte_x_trabajador();
    date_default_timezone_set('America/Lima');
    $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function() { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

    //---id cliente no va 
    switch ($_GET["op"]) {
      // ══════════════════════════════════════ VALIDAR SESION CLIENTE ══════════════════════════════════════
      case 'verificarC':
        $loginc   = $_POST['loginc'];
        $clavec   = $_POST['clavec'];
        $st       = $_POST['st'];

        $clavehash = hash("SHA256", $loginc);

        $rspta  = $reporte_x_trabajador->verificar($loginc, $clavehash); 
      break;

      case 'tabla_principal_cliente':
        $rspta = $reporte_x_trabajador->tabla_principal_cliente($_GET["filtro_trabajador"],$_GET["filtro_anio_pago"],$_GET["filtro_p_all_mes_pago"],$_GET["filtro_tipo_comprob"]);
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

            $imagen_perfil = empty($value['foto_perfilCliente']) ? 'no-perfil.jpg' :   $value['foto_perfilCliente'];

            $data[] = array(
              "0" => $cont++,
              "1" => '<div class="d-flex flex-fill align-items-center">
                <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                  <span class="avatar"> <img src="../assets/modulo/persona/perfil/' . $imagen_perfil . '" alt="" onclick="ver_img(\'' . $imagen_perfil . '\')"> </span>
                </div>
                <div>
                  <span class="d-block fw-semibold text-primary">' . $value['nombre_completoCliente'] . '</span>
                  <span class="text-muted text-nowrap">' . $value['tipoDocumentoCliente'] . ' : ' . $value['nroDocumentoCliente'] . '</span> |
                  <span class="text-muted text-nowrap">Cel.: ' . '<a href="tel:+51'.$value['cellCliente'].'" data-bs-toggle="tooltip" title="Clic para hacer llamada">'.$value['cellCliente'].'</a>' . '</span>
                </div>
              </div>',
              "2" => '<b>'.$value['tp_comprobante_v2'].'</b>' . ' <br> ' . $value['correlativo'],
              "3" => $value['total_Pag_servicio'] ,
              "4" => $value['nombre_completoTrabajador'] ,
              "5" => $value['user_created_pago'] ,
              "6" => $value['peridoPago'] ,
              "7" => $value['fecha_emision'] ,

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

      // ══════════════════════════════════════  S E L E C T 2 ══════════════════════════════════════ 

      case 'select2_filtro_trabajador':

        $rspta = $reporte_x_trabajador->select2_filtro_trabajador();        
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
      
      case 'select2_filtro_anio_pago':

        $rspta = $reporte_x_trabajador->select2_filtro_anio_pago();        
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

      case 'select2_filtro_mes_pago':

        $rspta = $reporte_x_trabajador->select2_filtro_mes_pago();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['mes_cancelacion']  . '">' . $value['mes_cancelacion'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
          echo json_encode($retorno, true);
        } else {
          echo json_encode($rspta, true);
        }

      break;
      
      case 'select2_filtro_tipo_comprob':

        $rspta = $reporte_x_trabajador->select2_filtro_tipo_comprob();        
        $data = "";
        if ($rspta['status'] == true) {
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value="' . $value['tipo_comprobante']  . '">' . $value['abreviatura'] . '</option>';
          }

          $retorno = array( 'status' => true, 'message' => 'Salió todo ok', 'data' => $data,  );
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