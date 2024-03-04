<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }//Validamos si existe o no la sesión

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['empresa'] == 1) {
    
    require_once "../modelos/Trabajador.php";

    $trabajador = new Trabajador();
    
    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
    $scheme_host =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/front_jdl/admin/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');

    // :::::::::::::::::::::::::::::::::::: D A T O S   E M P R E S A ::::::::::::::::::::::::::::::::::::::
    $id             = isset($_POST["idnosotros"])? limpiarCadena($_POST["idnosotros"]):"";
    $direccion      = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $nombre         = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $tipo_documento = isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
    $num_documento  = isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
    $mapa           = isset($_POST["mapa"])? limpiarCadena($_POST["mapa"]):"";    
    $horario        = isset($_POST["horario"])? limpiarCadena($_POST["horario"]):"";
    

    switch ($_GET["op"]) {   

      
      // :::::::::::::::::::::::::: S E C C I O N   T R A B A J A D O R   ::::::::::::::::::::::::::

      case 'guardar_y_editar':
        //guardar f_img_fondo fondo
        if ( !file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name']) ) {
          $f_img_fondo = $_POST["doc_old_1"];
          $flat_img1 = false; 
        } else {          
          $ext1 = explode(".", $_FILES["doc1"]["name"]);
          $flat_img1 = true;
          $f_img_fondo = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext1);
          move_uploaded_file($_FILES["doc1"]["tmp_name"], "../assets/modulo/persona/perfil/" . $f_img_fondo);          
        }        

        if ( empty($idlanding_disenio) ) { #Creamos el registro

          $rspta = $landing_disenio->insertar($f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo);
          echo json_encode($rspta, true);

        } else { # Editamos el registro

          if ($flat_img1 == true || empty($f_img_fondo)) {
            $datos_f1 = $landing_disenio->obtenerImg($idlanding_disenio);
            $img1_ant = $datos_f1['data']['f_img_fondo'];
            if (!empty($img1_ant)) { unlink("../assets/modulo/persona/perfil/" . $img1_ant); }         
          }  
         
          $rspta = $landing_disenio->editar($idlanding_disenio,$f_titulo,$f_descripcion,$fe_titulo,$fe_descripcion,$f_img_fondo,$f_img_promocion, $fe_img_fondo);
          echo json_encode($rspta, true);
        }        

        
      break;      

      case 'mostrar_empresa':
        $rspta = $trabajador->mostrar_empresa();
        echo json_encode($rspta);
      break;
      
      case 'actualizar_datos_empresa':
        if (empty($id)){
          $rspta = ['status'=> 'error_personalizado', 'user'=>$_SESSION["nombre"], 'message'=>"No no modifique el codigo por favor", 'data'=>[]];
          json_encode( $rspta, true) ;
        }else {
          // editamos un documento existente
          $rspta=$trabajador->actualizar_datos_empresa( $id, $direccion,$nombre,$tipo_documento, $num_documento,$celular,$telefono, $link_grupo_whats,$mapa,$correo,$horario, 
          $rs_facebook,$rs_instagram,$rs_web, $rs_facebook_etiqueta, $rs_instagram_etiqueta, $rs_web_etiqueta);          
          echo json_encode( $rspta, true) ;
        }
      break;
    

      default: 
        $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
      break;
    }

  } else {
    $retorno = ['status'=>'nopermiso', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
    echo json_encode($retorno);
  }  
}

ob_end_flush();
?>
