<?php
  ob_start();
  if (strlen(session_id()) < 1) { session_start(); } //Validamos si existe o no la sesión

  if (!isset($_SESSION["user_nombre"])) {
    $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => [] ];
    echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
  } else {

    if ($_SESSION['dashboard'] == 1) {

      require_once "../modelos/Escritorio.php";
      $escritorio = new Escritorio();

      date_default_timezone_set('America/Lima'); $date_now = date("d_m_Y__h_i_s_A");
      $imagen_error = "this.src='../assets/svg/user_default.svg'";
      $toltip = '<script> $(function () { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';
      $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/fun_route/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/admin/');

      $formato_cci = isset($_POST["formato_cci"]) ? limpiarCadena($_POST["formato_cci"]) : "";
      $formato_cta = isset($_POST["formato_cta"]) ? limpiarCadena($_POST["formato_cta"]) : "";
      $formato_detracciones = isset($_POST["formato_detracciones"]) ? limpiarCadena($_POST["formato_detracciones"]) : "";  

      switch ($_GET["op"]) {       

        case 'ver_reporte':
          $rspta = $escritorio->ver_reporte();
          echo json_encode( $rspta, true) ;
        break;        

        default: 
          $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
        break;
      }

    } else {
      $retorno = ['status'=>'nopermiso', 'message'=>'No tienes acceso a este modulo, pide acceso a tu administrador', 'data' => [], 'aaData' => [] ];
      echo json_encode($retorno);
    }  

  }

  ob_end_flush();
?>