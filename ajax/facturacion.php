<?php
ob_start();
if (strlen(session_id()) < 1) { session_start(); }

if (!isset($_SESSION["user_nombre"])) {
  $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => [] ];
  echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
} else {

  if ($_SESSION['facturacion'] == 1) {

    require_once "../modelos/Facturacion.php";
    require_once "../modelos/Gasto_de_trabajador.php";
    require_once "../modelos/Correlacion_comprobante.php";
    require_once "../modelos/Producto.php";

    $facturacion            = new Facturacion();    
    $gasto_trab         = new Gasto_de_trabajador();    
    $correlacion_compb  = new Correlacion_comprobante();    
    $productos          = new Producto();

    date_default_timezone_set('America/Lima');  $date_now = date("d_m_Y__h_i_s_A");
    $imagen_error = "this.src='../dist/svg/404-v2.svg'";
    $toltip = '<script> $(function () { $(\'[data-bs-toggle="tooltip"]\').tooltip(); }); </script>';

    $idventa                = isset($_POST["idventa"]) ? limpiarCadena($_POST["idventa"]) : "";   
    $impuesto               = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]) : ""; 

    $tipo_comprobante       = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";    
    $idpersona_cliente      = isset($_POST["idpersona_cliente"]) ? limpiarCadena($_POST["idpersona_cliente"]) : "";         
    $observacion_documento  = isset($_POST["observacion_documento"]) ? limpiarCadena($_POST["observacion_documento"]) : "";    
    $es_cobro               = isset($_POST["es_cobro"]) ? limpiarCadena($_POST["es_cobro"]) : "";    
    $periodo_pago           = isset($_POST["periodo_pago"]) ? limpiarCadena($_POST["periodo_pago"]) : "";    
    
    $metodo_pago            = isset($_POST["metodo_pago"]) ? limpiarCadena($_POST["metodo_pago"]) : "";  
    $total_recibido         = isset($_POST["total_recibido"]) ? limpiarCadena($_POST["total_recibido"]) : "";  
    $mp_monto               = isset($_POST["mp_monto"]) ? limpiarCadena($_POST["mp_monto"]) : "";  
    $total_vuelto           = isset($_POST["total_vuelto"]) ? limpiarCadena($_POST["total_vuelto"]) : "";  

    $usar_anticipo          = isset($_POST["usar_anticipo"]) ? limpiarCadena($_POST["usar_anticipo"]) : "";  
    $disponible_anticipo    = isset($_POST["disponible_anticipo"]) ? limpiarCadena($_POST["disponible_anticipo"]) : "";  
    $monto_anticipo         = isset($_POST["monto_anticipo"]) ? limpiarCadena($_POST["monto_anticipo"]) : "";  

    $mp_serie_comprobante   = isset($_POST["mp_serie_comprobante"]) ? limpiarCadena($_POST["mp_serie_comprobante"]) : "";  
    $mp_comprobante         = isset($_POST["mp_comprobante"]) ? limpiarCadena($_POST["mp_comprobante"]) : "";  

    $subtotal_venta         = isset($_POST["subtotal_venta"]) ? limpiarCadena($_POST["subtotal_venta"]) : "";    
    $tipo_gravada           = isset($_POST["tipo_gravada"]) ? limpiarCadena($_POST["tipo_gravada"]) : "";    
    $igv_venta              = isset($_POST["igv_venta"]) ? limpiarCadena($_POST["igv_venta"]) : "";    
    $total_venta            = isset($_POST["total_venta"]) ? limpiarCadena($_POST["total_venta"]) : "";   
    
     
    $img_comprob      = isset($_POST["doc_old_1"]) ? limpiarCadena($_POST["doc_old_1"]) : ""; 

    switch ($_GET["op"]){

      // :::::::::::: S E C C I O N   C O M P R A S ::::::::::::

      case 'listar_tabla_facturacion':

        $rspta = $facturacion->listar_tabla_facturacion();
        $data = []; $count = 1;

        if($rspta['status'] == true){

          foreach($rspta['data'] as $key => $value){

            $img_proveedor = empty($value['foto_perfil']) ? 'no-perfil.jpg' : $value['foto_perfil'];

            $data[] = [
              "0" => $count,
              "1" => '<div class="hstack gap-2 fs-15">' .                        
                '<button class="btn btn-icon btn-sm btn-info-light" onclick="mostrar_detalle_venta('.($value['idventa']).')" data-bs-toggle="tooltip" title="Ver"><i class="ri-eye-line"></i></button>'.
              '</div>',
              "2" =>  $value['fecha_venta'],
              "3" => '<div class="d-flex flex-fill align-items-center">
                <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen">
                  <span class="avatar"> <img class="w-35px h-auto" src="../assets/modulo/persona/perfil/' . $img_proveedor . '" alt="" onclick="ver_img_proveedor(\'' . $img_proveedor . '\', \'' . encodeCadenaHtml(($value['nombre_razonsocial']) .' '. ($value['apellidos_nombrecomercial'])) . '\')"> </span>
                </div>
                <div>
                  <span class="d-block fw-semibold text-primary">'.$value['nombre_razonsocial'] .' '. $value['apellidos_nombrecomercial'].'</span>
                  <span class="text-muted"><b>'.$value['tipo_documento'] .'</b>: '. $value['numero_documento'].'</span>
                </div>
              </div>',
              "4" =>  '<b>'.$value['tp_comprobante'].'</b>' . ' ' . $value['serie_comprobante'],
              "5" =>  $value['total'] , 
              "6" => '<div class="textarea_datatable bg-light" style="overflow: auto; resize: vertical; height: 45px;">' . $value['descripcion'] . '</div>',
              
              "7" => !empty($value['comprobante']) ? '<div class="d-flex justify-content-center"><button class="btn btn-icon btn-sm btn-info-light" onclick="ver_img_comprobante('.($value['idventa']).');" data-bs-toggle="tooltip" title="Ver"><i class="ti ti-file-dollar fs-lg"></i></button></div>' : 
              '<div class="d-flex justify-content-center"><button class="btn btn-icon btn-sm btn-danger-light" data-bs-toggle="tooltip" title="no encontrado"><i class="ti ti-file-alert fs-lg"></i></button></div>',
                    
                    
                    
            ];
          }
          $results =[
            'status'=> true,
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
          ];
          echo json_encode($results);

        } else { echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data']; }
      break;

      case 'guardar_editar_facturacion':

        if ( !file_exists($_FILES['doc1']['tmp_name']) || !is_uploaded_file($_FILES['doc1']['tmp_name']) ) {
          $img_comprob = $_POST["doc_old_1"];
          $flat_img = false; 
        } else {          
          $ext = explode(".", $_FILES["doc1"]["name"]);
          $flat_img = true;
          $img_comprob = $date_now . '__' . random_int(0, 20) . round(microtime(true)) . random_int(21, 41) . '.' . end($ext);
          move_uploaded_file($_FILES["doc1"]["tmp_name"], "../assets/modulo/comprobante_venta/" . $img_comprob);          
        } 

        if (empty($idventa)) {
          
          $rspta = $facturacion->insertar( $idpersona_cliente,  $tipo_comprobante, $serie, $impuesto, $descripcion,
          $subtotal_venta, $tipo_gravada, $igv_venta, $total_venta, $fecha_venta, $img_comprob,
          $_POST["idproducto"], $_POST["unidad_medida"], $_POST["cantidad"], $_POST["precio_sin_igv"], $_POST["precio_igv"], $_POST["precio_con_igv"], 
          $_POST["descuento"], $_POST["subtotal_producto"]);

          echo json_encode($rspta, true);
        } else {

          $rspta = $facturacion->editar( $idventa, $idpersona_cliente,  $tipo_comprobante, $serie, $impuesto, $descripcion,
          $subtotal_venta, $tipo_gravada, $igv_venta, $total_venta, $fecha_venta, $img_comprob,
          $_POST["idproducto"], $_POST["unidad_medida"], $_POST["cantidad"], $_POST["precio_sin_igv"], $_POST["precio_igv"], $_POST["precio_con_igv"], 
          $_POST["descuento"], $_POST["subtotal_producto"]);
    
          echo json_encode($rspta, true);
        }
    
      break; 

      case 'mostrar_detalle_venta':
        $rspta=$facturacion->mostrar_detalle_venta($idventa);
        

        echo '<div class="tab-pane fade active show" id="rol-venta-pane" role="tabpanel" tabindex="0">';
        echo '<div class="table-responsive p-0">
          <table class="table table-hover table-bordered  mt-4">          
            <tbody>
              <tr> <th>Proveedor</th>        <td>'.$rspta['data']['venta']['nombre_razonsocial'].'  '.$rspta['data']['venta']['apellidos_nombrecomercial'].'
              <div class="font-size-12px" >Cel: <a href="tel:+51'.$rspta['data']['venta']['celular'].'">'.$rspta['data']['venta']['celular'].'</a></div> 
              <div class="font-size-12px" >E-mail: <a href="mailto:'.$rspta['data']['venta']['correo'].'">'.$rspta['data']['venta']['correo'].'</a></div> </td> </tr>            
              <tr> <th>Total venta</th>      <td>'.$rspta['data']['venta']['total'].'</td> </tr>             
              <tr> <th>Fecha</th>         <td>'.$rspta['data']['venta']['fecha_venta'].'</td> </tr>                
              <tr> <th>Comprobante</th>   <td>'.$rspta['data']['venta']['tp_comprobante']. ' | '.$rspta['data']['venta']['serie_comprobante'].'</td> </tr>
              <tr> <th>Observacion</th>   <td>'.$rspta['data']['venta']['descripcion'].'</td> </tr>         
            </tbody>
          </table>
        </div>';
        echo '</div>'; # div-content

        echo'<div class="tab-pane fade" id="rol-detalle-pane" role="tabpanel" tabindex="0">';
        echo '<div class="table-responsive p-0">
          <table class="table table-hover table-bordered  mt-4">  
            <thead>
              <tr> <th>#</th> <th>Nombre</th> <th>Cantidad</th> <th>P/U</th> <th>Dcto.</th>  <th>Subtotal</th> </tr>
            </thead>        
            <tbody>';
            foreach ($rspta['data']['detalle'] as $key => $val) {
              echo '<tr> <td>'. $key + 1 .'</td> <td>'.$val['nombre'].'</td> <td class="text-center">'.$val['cantidad'].'</td> <td class="text-right">'.$val['precio_con_igv'].'</td> <td class="text-right">'.$val['descuento'].'</td> <td class="text-right" >'.$val['subtotal'].'</td> </tr>';
            }
        echo '</tbody>
            <tfoot>
              <td colspan="4"></td>

              <th class="text-right">
                <h6 class="tipo_gravada">SUBTOTAL</h6>
                <h6 class="val_igv">IGV (18%)</h6>
                <h5 class="font-weight-bold">TOTAL</h5>
              </th>
              <th class="text-right text-nowrap"> 
                <h6 class="font-weight-bold subtotal_venta">S/ '.$rspta['data']['venta']['subtotal'].'</h6> 
                <h6 class="font-weight-bold igv_venta">S/ '.$rspta['data']['venta']['igv'].'</h6>                 
                <h5 class="font-weight-bold total_venta">S/ '.$rspta['data']['venta']['total'].'</h5>                 
              </th>              
            </tfoot>
          </table>
        </div>';
        echo'</div>';# div-content
      break; 

      case 'mostrar_venta':
        $rspta=$facturacion->mostrar_venta($_POST["idventa"]);
        echo json_encode($rspta, true);
      break; 

      case 'mostrar_editar_detalles_venta':
        $rspta=$facturacion->mostrar_editar_detalles_venta($_POST["idventa"]);
        echo json_encode($rspta, true);
      break;

      case 'listar_producto_x_codigo':
        $rspta=$facturacion->listar_producto_x_codigo($_POST["codigo"]);
        echo json_encode($rspta, true);
      break;

      case 'eliminar':
        $rspta = $facturacion->eliminar($_GET["id_tabla"]);
        echo json_encode($rspta, true);
      break;

      case 'papelera':
        $rspta = $facturacion->desactivar($_GET["id_tabla"]);
        echo json_encode($rspta, true);
      break;

      case 'mostrar_producto':
        $rspta=$facturacion->mostrar_producto($_POST["idproducto"]);
        echo json_encode($rspta, true);
      break; 

      case 'listar_tabla_producto':
          
        $rspta = $facturacion->listar_tabla_producto($_GET["tipo_producto"]); 

        $datas = []; 

        if ($rspta['status'] == true) {

          foreach($rspta['data'] as $key => $value){

            $img = empty($value['imagen']) ? 'no-producto.png' : $value['imagen'];
            $data_btn_1 = 'btn-add-producto-1-'.$value['idproducto']; $data_btn_2 = 'btn-add-producto-2-'.$value['idproducto'];
            $datas[] = [
              "0" => '<button class="btn btn-warning '.$data_btn_1.' mr-1 px-2 py-1" onclick="agregarDetalleComprobante(' . $value['idproducto'] . ', false)" data-bs-toggle="tooltip" title="Agregar"><span class="fa fa-plus"></span></button>' ,
              "1" => '<span class="fs-12"> <i class="bi bi-upc"></i> '.$value['codigo'] .'<br> <i class="bi bi-person"></i> '.$value['codigo_alterno'] .'</span>' ,
              "2" =>  '<div class="d-flex flex-fill align-items-center">
                <div class="me-2 cursor-pointer" data-bs-toggle="tooltip" title="Ver imagen"><span class="avatar"> <img class="w-35px h-auto" src="../assets/modulo/productos/' . $img . '" alt="" onclick="ver_img(\'' . $img . '\', \'' . encodeCadenaHtml(($value['nombre'])) . '\')"> </span></div>
                <div>
                  <span class="d-block fs-12 fw-semibold text-primary nombre_producto_' . $value['idproducto'] . '">'.$value['nombre'] .'</span>
                  <span class="d-block fs-10 text-muted">Marca: <b>'.$value['marca'].'</b> | Categoría: <b>'.$value['categoria'].'</b></span> 
                </div>
              </div>',             
              "3" => ($value['precio_venta']),
              "4" => '<textarea class="textarea_datatable bg-light"  readonly>' .($value['descripcion']). '</textarea>' . $toltip
            ];
          }
  
          $results = [
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($datas), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($datas), //enviamos el total registros a visualizar
            "aaData" => $datas,
          ];
          echo json_encode($results, true);
        } else {
          echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
        }
    
      break;

      // ══════════════════════════════════════ U S A R   A N T I C I P O S ══════════════════════════════════════
      case 'mostrar_anticipos':
        $rspta=$facturacion->mostrar_anticipos($_GET["id_cliente"]);
        echo json_encode($rspta, true);
      break; 

      // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
      case 'select2_cliente':
        $rspta = $facturacion->select2_cliente(); $cont = 1; $data = "";
        if($rspta['status'] == true){
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idpersona_cliente']  . '>' . $value['nombre_razonsocial'] . ' '. $value['apellidos_nombrecomercial'] . ' - '. $value['numero_documento'] . '</option>';
          }

          $retorno = array(
            'status' => true, 
            'message' => 'Salió todo ok', 
            'data' => '<option  value="1" >CLIENTES VARIOS - 0000000</option>'.$data, 
          );
          echo json_encode($retorno, true);

        } else { echo json_encode($rspta, true); }      
      break; 

      case 'select2_series_comprobante':
        $rspta = $facturacion->select2_series_comprobante($_GET["tipo_comprobante"]); $cont = 1; $data = "";
        if($rspta['status'] == true){
          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option title="' . $value['abreviatura'] . '" value="' . $value['serie']  . '">' . $value['serie']  . '</option>';
          }

          $retorno = array(
            'status'  => true, 
            'message' => 'Salió todo ok', 
            'data'    => $data, 
          );
          echo json_encode($retorno, true);

        } else { echo json_encode($rspta, true); }      
      break; 

      case 'listar_crl_comprobante':
        $rspta = $correlacion_compb->listar_crl_comprobante($_GET["tipos"]); $cont = 1; $data = "";
          if($rspta['status'] == true){
            foreach ($rspta['data'] as $key => $value) {
              $data .= '<option  value=' . $value['codigo']  . '>' . $value['tipo_comprobante'] . '</option>';
            }
    
            $retorno = array(
              'status' => true, 
              'message' => 'Salió todo ok', 
              'data' => $data, 
            );
            echo json_encode($retorno, true);
    
          } else { echo json_encode($rspta, true); }
      break;

      case 'select_categoria':
        $rspta = $productos->select_categoria();
        $data = "";
  
        if ($rspta['status']) {
  
          foreach ($rspta['data'] as $key => $value) {
            $data  .= '<option value="' . $value['idcategoria'] . '" title ="' . $value['nombre'] . '" >' . $value['nombre'] . '</option>';
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

      case 'select_u_medida':
        $rspta = $productos->select_u_medida();
        $data = "";
  
        if ($rspta['status']) {
  
          foreach ($rspta['data'] as $key => $value) {
            $data  .= '<option value="' . $value['idsunat_unidad_medida'] . '" title ="' . $value['nombre'] . '" >' . $value['nombre'] .' - '. $value['abreviatura'] . '</option>';
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

      case 'select_marca':
        $rspta = $productos->select_marca();
        $data = "";
  
        if ($rspta['status']) {
  
          foreach ($rspta['data'] as $key => $value) {
            $data  .= '<option value="' . $value['idmarca'] . '" title ="' . $value['nombre'] . '" >' . $value['nombre'] . '</option>';
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

      default: 
        $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
      break;

    }

  }else {
    $retorno = ['status'=>'nopermiso', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [], 'aaData' => [] ];
    echo json_encode($retorno);
  }
}
ob_end_flush();

?>