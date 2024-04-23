<?php

  require "../config/Conexion_v2.php";

  class Facturacion
  {

    //Implementamos nuestro constructor
    public $id_usr_sesion; public $id_persona_sesion; public $id_trabajador_sesion;
    // public $id_empresa_sesion;   
    public function __construct( )
    {
      $this->id_usr_sesion        =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
      $this->id_persona_sesion    = isset($_SESSION['idpersona']) ? $_SESSION["idpersona"] : 0;
      $this->id_trabajador_sesion = isset($_SESSION['idpersona_trabajador']) ? $_SESSION["idpersona_trabajador"] : 0;
      // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
    }

    public function listar_tabla_facturacion() {

      $sql = "SELECT v.*, DATE_FORMAT(v.fecha_emision, '%Y-%m-%d') as fecha_emision_format, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, 
      p.numero_documento, p.foto_perfil, tc.abreviatura as tp_comprobante, sdi.abreviatura as tipo_documento, v.estado
      FROM venta AS v
      INNER JOIN persona_cliente AS pc ON pc.idpersona_cliente = v.idpersona_cliente
      INNER JOIN persona AS p ON p.idpersona = pc.idpersona
      INNER JOIN sunat_c06_doc_identidad as sdi ON sdi.code_sunat = p.tipo_documento
      INNER JOIN sunat_c01_tipo_comprobante AS tc ON tc.codigo = v.tipo_comprobante
      WHERE v.estado = 1 AND v.estado_delete = 1;";
      $venta = ejecutarConsulta($sql); if ($venta['status'] == false) {return $venta; }

      return $venta;
    }

    public function insertar(
      // DATOS TABLA venta
      $impuesto, $crear_y_emitir, $tipo_comprobante, $serie_comprobante, $idpersona_cliente, $observacion_documento, $es_cobro, $periodo_pago,
      $metodo_pago, $total_recibido, $mp_monto, $total_vuelto, $usar_anticipo, $ua_monto_disponible, $ua_monto_usado,
      $mp_serie_comprobante,$mp_comprobante, $venta_subtotal, $tipo_gravada, $venta_descuento, $venta_igv, $venta_total,
      //DATOS TABLA venta DETALLE
      $idproducto, $unidad_medida, $cantidad, $precio_compra, $precio_sin_igv, $precio_igv, $precio_con_igv, $descuento, $subtotal_producto    
    ){
      $sql_1 = "INSERT INTO venta(idpersona_cliente, iddocumento_relacionado, crear_enviar_sunat, es_cobro, tipo_comprobante, serie_comprobante,  periodo_pago,  impuesto, 
      venta_subtotal, venta_descuento, venta_igv, venta_total, metodo_pago, mp_serie_comprobante, mp_comprobante, mp_monto, venta_credito, vc_numero_operacion, 
      vc_fecha_proximo_pago, total_recibido, total_vuelto, usar_anticipo, ua_monto_disponible, ua_monto_usado, observacion_documento) 
      VALUES ('$idpersona_cliente', '', '$crear_y_emitir', '$es_cobro', '$tipo_comprobante', '$serie_comprobante', '$periodo_pago', '$impuesto', '$venta_subtotal', '$venta_descuento',
      '$venta_igv','$venta_total','$metodo_pago','$mp_serie_comprobante','$mp_comprobante','$mp_monto','','',CURRENT_TIMESTAMP, '$total_recibido', '$total_vuelto',
      '$usar_anticipo','$ua_monto_disponible','$ua_monto_usado','$observacion_documento')";
      $newdata = ejecutarConsulta_retornarID($sql_1, 'C'); if ($newdata['status'] == false) { return  $newdata;}
      $id = $newdata['data'];

      $i = 0;
      $detalle_new = "";

      if ( !empty($newdata['data']) ) {      
        while ($i < count($idproducto)) {

          $sql_2 = "INSERT INTO venta_detalle( idventa, idproducto, tipo, cantidad, precio_compra, precio_venta, descuento, subtotal)
          VALUES ('$id', '$idproducto[$i]', 'VENTA', '$cantidad[$i]', '$precio_compra[$i]', '$precio_con_igv[$i]', '$descuento[$i]', '$subtotal_producto[$i]');";
          $detalle_new =  ejecutarConsulta_retornarID($sql_2, 'C'); if ($detalle_new['status'] == false) { return  $detalle_new;}          
          $id_d = $detalle_new['data'];
          $i = $i + 1;
        }
      }
      return $detalle_new;
    }

    public function editar( $idventa, $idpersona_cliente,  $tipo_comprobante, $serie, $impuesto, $descripcion, $venta_subtotal, $tipo_gravada, $venta_igv, $venta_total, $fecha_venta, $img_comprob,        
    $idproducto, $unidad_medida, $cantidad, $precio_sin_igv, $precio_igv, $precio_con_igv, $descuento, $subtotal_producto) {

      $sql_1 = "UPDATE venta SET idpersona_cliente = '$idpersona_cliente', fecha_venta = '$fecha_venta', tipo_comprobante = '$tipo_comprobante', serie_comprobante = '$serie', 
      val_igv = '$impuesto', descripcion = '$descripcion', subtotal = '$venta_subtotal', igv = '$venta_igv', total = '$venta_total', comprobante = '$img_comprob'
      WHERE idventa = '$idventa'";
      $result_sql_1 = ejecutarConsulta($sql_1, 'U');if ($result_sql_1['status'] == false) { return $result_sql_1; }

      // Eliminamos los productos
      $sql_del = "DELETE FROM venta_detalle WHERE idventa = '$idventa'";
      ejecutarConsulta($sql_del);

      // Creamos los productos
      foreach ($idproducto as $ii => $producto) {
        $sql_2 = "INSERT INTO venta_detalle(idproducto, idventa, cantidad, precio_sin_igv, igv, precio_con_igv, descuento, subtotal)
        VALUES ('$idproducto[$ii]', '$idventa', '$cantidad[$ii]', '$precio_sin_igv[$ii]', '$precio_igv[$ii]', '$precio_con_igv[$ii]', '$descuento[$ii]', '$subtotal_producto[$ii]');";
        $detalle_new =  ejecutarConsulta_retornarID($sql_2, 'C'); if ($detalle_new['status'] == false) { return  $detalle_new;}        
      }  
      
      return array('status' => true, 'message' => 'Datos actualizados correctamente.');
    }
  

    public function mostrar_detalle_venta($idventa){

      $sql_1 = "SELECT c.*, p.*, tc.abreviatura as tp_comprobante, sdi.abreviatura as tipo_documento, c.estado
      FROM venta AS c
      INNER JOIN persona AS p ON c.idpersona_cliente = p.idpersona
      INNER JOIN sunat_c06_doc_identidad as sdi ON sdi.code_sunat = p.tipo_documento
      INNER JOIN sunat_c01_tipo_comprobante AS tc ON tc.idtipo_comprobante = c.tipo_comprobante
      WHERE c.idventa = '$idventa'
      AND c.estado = 1 AND c.estado_delete = 1";
      $venta = ejecutarConsultaSimpleFila($sql_1); if ($venta['status'] == false) {return $venta; }


      $sql_2 = "SELECT cd.*, pd.*
      FROM venta_detalle AS cd
      INNER JOIN producto AS pd ON cd.idproducto = pd.idproducto
      WHERE  cd.idventa = '$idventa'
      AND cd.estado = 1 AND cd.estado_delete = 1";
      $detalle = ejecutarConsultaArray($sql_2); if ($detalle['status'] == false) {return $detalle; }

      return $datos = ['status' => true, 'message' => 'Todo ok', 'data' => ['venta' => $venta['data'], 'detalle' => $detalle['data']]];

    }


    public function mostrar_venta($id){
      $sql = "SELECT * FROM venta WHERE idventa = '$id'";
      return ejecutarConsultaSimpleFila($sql);
    }

    public function mostrar_editar_detalles_venta($id){
      $sql = "SELECT * FROM venta WHERE idventa = '$id'";
      $venta = ejecutarConsultaSimpleFila($sql); if ($venta['status'] == false) {return $venta; }

      $sql = "SELECT dc.*, p.nombre, p.codigo, p.codigo_alterno, p.imagen, sum.nombre AS unidad_medida, cat.nombre AS categoria, mc.nombre AS marca
      FROM venta_detalle AS dc
        INNER JOIN producto AS p ON p.idproducto = dc.idproducto
        INNER JOIN sunat_unidad_medida AS sum ON p.idsunat_unidad_medida = sum.idsunat_unidad_medida
        INNER JOIN categoria AS cat ON p.idcategoria = cat.idcategoria
        INNER JOIN marca AS mc ON p.idmarca = mc.idmarca
      WHERE dc.idventa = '$id'
        AND p.estado = 1
        AND p.estado_delete = 1;";
      $venta_detalle = ejecutarConsultaArray($sql); if ($venta_detalle['status'] == false) {return $venta_detalle; }
      return ['status' => true, 'message' =>'todo okey', 'data'=>['venta' => $venta['data'], 'venta_detalle' => $venta_detalle['data'],]];
    }

    public function eliminar($id){
      $sql = "UPDATE venta SET estado_delete = 0
      WHERE idventa = '$id'";
      return ejecutarConsulta($sql, 'D');
    }

    public function desactivar($id){
      $sql = "UPDATE venta SET estado = 0
      WHERE idventa = '$id'";
      return ejecutarConsulta($sql, 'T');
    }    

    public function listar_tabla_producto($tipo_producto){
      $sql = "SELECT p.*, sum.nombre AS unidad_medida, cat.nombre AS categoria, mc.nombre AS marca
      FROM producto AS p
      INNER JOIN sunat_unidad_medida AS sum ON p.idsunat_unidad_medida = sum.idsunat_unidad_medida
      INNER JOIN categoria AS cat ON p.idcategoria = cat.idcategoria
      INNER JOIN marca AS mc ON p.idmarca = mc.idmarca
      WHERE p.tipo = '$tipo_producto'  AND p.estado = 1 AND p.estado_delete = 1;";
      return ejecutarConsulta($sql);
    }

    public function mostrar_producto($idproducto){
      $sql = "SELECT p.*, sum.nombre AS unidad_medida, cat.nombre AS categoria, mc.nombre AS marca
      FROM producto AS p
      INNER JOIN sunat_unidad_medida AS sum ON p.idsunat_unidad_medida = sum.idsunat_unidad_medida
      INNER JOIN categoria AS cat ON p.idcategoria = cat.idcategoria
      INNER JOIN marca AS mc ON p.idmarca = mc.idmarca
      WHERE p.idproducto = '$idproducto'  AND p.estado = 1 AND p.estado_delete = 1;";
      return ejecutarConsultaSimpleFila($sql);
    }

    Public function mini_reporte(){
      $sql_01 = "SELECT ROUND( COALESCE(( ( ventas_mes_actual.total_ventas_mes_actual - COALESCE(ventas_mes_anterior.total_ventas_mes_anterior, 0) ) / COALESCE( ventas_mes_anterior.total_ventas_mes_anterior, ventas_mes_actual.total_ventas_mes_actual ) * 100 ),0), 2 ) AS porcentaje, ventas_mes_actual.total_ventas_mes_actual, ventas_mes_anterior.total_ventas_mes_anterior
      FROM ( SELECT COALESCE(SUM(venta_total), 0) total_ventas_mes_actual FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE()) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE()) AND tipo_comprobante = '01' ) AS ventas_mes_actual,
      ( SELECT SUM(venta_total) AS total_ventas_mes_anterior FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE() - INTERVAL 1 MONTH) AND tipo_comprobante = '01' ) AS ventas_mes_anterior;";
      $factura_p = ejecutarConsultaSimpleFila($sql_01); if ($factura_p['status'] == false) {return $factura_p; }
      $sql_01 = "SELECT IFNULL( SUM( venta_total), 0 ) as venta_total FROM `venta` WHERE tipo_comprobante = '01' AND estado = '1' AND estado_delete = '1';";
      $factura = ejecutarConsultaSimpleFila($sql_01); if ($factura['status'] == false) {return $factura; }

      $sql_03 = "SELECT ROUND( COALESCE(( ( ventas_mes_actual.total_ventas_mes_actual - COALESCE(ventas_mes_anterior.total_ventas_mes_anterior, 0) ) / COALESCE( ventas_mes_anterior.total_ventas_mes_anterior, ventas_mes_actual.total_ventas_mes_actual ) * 100 ),0), 2 ) AS porcentaje, ventas_mes_actual.total_ventas_mes_actual, ventas_mes_anterior.total_ventas_mes_anterior
      FROM ( SELECT COALESCE(SUM(venta_total), 0) total_ventas_mes_actual FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE()) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE()) AND tipo_comprobante = '03' ) AS ventas_mes_actual,
      ( SELECT SUM(venta_total) AS total_ventas_mes_anterior FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE() - INTERVAL 1 MONTH) AND tipo_comprobante = '03' ) AS ventas_mes_anterior;";
      $boleta_p = ejecutarConsultaSimpleFila($sql_03); if ($boleta_p['status'] == false) {return $boleta_p; }
      $sql_03 = "SELECT IFNULL( SUM( venta_total), 0 ) as venta_total FROM `venta` WHERE tipo_comprobante = '03' AND estado = '1' AND estado_delete = '1';";
      $boleta = ejecutarConsultaSimpleFila($sql_03); if ($boleta['status'] == false) {return $boleta; }

      $sql_12 = "SELECT ROUND( COALESCE(( ( ventas_mes_actual.total_ventas_mes_actual - COALESCE(ventas_mes_anterior.total_ventas_mes_anterior, 0) ) / COALESCE( ventas_mes_anterior.total_ventas_mes_anterior, ventas_mes_actual.total_ventas_mes_actual ) * 100 ),0), 2 ) AS porcentaje, ventas_mes_actual.total_ventas_mes_actual, ventas_mes_anterior.total_ventas_mes_anterior
      FROM ( SELECT COALESCE(SUM(venta_total), 0) total_ventas_mes_actual FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE()) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE()) AND tipo_comprobante = '12' ) AS ventas_mes_actual,
      ( SELECT SUM(venta_total) AS total_ventas_mes_anterior FROM venta WHERE MONTH (periodo_pago_format) = MONTH (CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR (periodo_pago_format) = YEAR (CURRENT_DATE() - INTERVAL 1 MONTH) AND tipo_comprobante = '12' ) AS ventas_mes_anterior;";
      $ticket_p = ejecutarConsultaSimpleFila($sql_12); if ($ticket_p['status'] == false) {return $ticket_p; }
      $sql_12 = "SELECT IFNULL( SUM( venta_total), 0 ) as venta_total FROM `venta` WHERE tipo_comprobante = '12' AND estado = '1' AND estado_delete = '1';";
      $ticket = ejecutarConsultaSimpleFila($sql_12); if ($ticket['status'] == false) {return $ticket; }

      return ['status' => true, 'message' =>'todo okey', 
        'data'=>[
          'factura'=> floatval($factura['data']['venta_total']), 'factura_p' => floatval($factura_p['data']['porcentaje']) , 
          'boleta' => floatval($boleta['data']['venta_total']), 'boleta_p' => floatval($boleta_p['data']['porcentaje']) , 
          'ticket' => floatval($ticket['data']['venta_total']), 'ticket_p' => floatval($ticket_p['data']['porcentaje']) , 
        ]
      ];

    }

    public function listar_producto_x_codigo($codigo){
      $sql = "SELECT p.*, sum.nombre AS unidad_medida, cat.nombre AS categoria, mc.nombre AS marca
      FROM producto AS p
      INNER JOIN sunat_unidad_medida AS sum ON p.idsunat_unidad_medida = sum.idsunat_unidad_medida
      INNER JOIN categoria AS cat ON p.idcategoria = cat.idcategoria
      INNER JOIN marca AS mc ON p.idmarca = mc.idmarca
      WHERE (p.codigo = '$codigo' OR p.codigo_alterno = '$codigo' ) AND p.estado = 1 AND p.estado_delete = 1;";
        return ejecutarConsultaSimpleFila($sql);
      
    }

    // ══════════════════════════════════════ C O M P R O B A N T E ══════════════════════════════════════

    public function datos_empresa(){
      $sql = "SELECT * FROM empresa;";
      return ejecutarConsultaSimpleFila($sql);      
    }

    // ══════════════════════════════════════ U S A R   A N T I C I P O ══════════════════════════════════════
    public function mostrar_anticipos($idcliente){
      $sql = "SELECT pc.idpersona_cliente, p.nombre_razonsocial AS nombres,  p.apellidos_nombrecomercial AS apellidos,
        (
          IFNULL( (SELECT  SUM( CASE  WHEN ac.tipo = 'EGRESO' THEN ac.total * -1 ELSE ac.total END )
          FROM anticipo_cliente AS ac
          WHERE ac.idpersona_cliente = pc.idpersona_cliente
          GROUP BY ac.idpersona_cliente) , 0)
        ) AS total_anticipo
      FROM persona_cliente AS pc  
      INNER JOIN persona AS p ON pc.idpersona = p.idpersona
      WHERE pc.idpersona_cliente = '$idcliente';";
      return ejecutarConsultaSimpleFila($sql);
      
    }

    // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
    public function select2_cliente(){
      $filtro_id_trabajador  = '';
      if ($_SESSION['user_cargo'] == 'TÉCNICO DE RED') {
        $filtro_id_trabajador = "pc.idpersona_trabajador = '$this->id_trabajador_sesion'";
      } 
      $sql = "SELECT LPAD(pc.idpersona_cliente, 5, '0') as idcliente, pc.idpersona_cliente, p.idpersona,  p.nombre_razonsocial, p.apellidos_nombrecomercial, 
      p.numero_documento
      FROM persona_cliente as pc      
      INNER JOIN persona as p ON p.idpersona = pc.idpersona
      WHERE p.idpersona > 2 $filtro_id_trabajador ORDER BY p.nombre_razonsocial ASC;"; 
      return ejecutarConsultaArray($sql);
    }

    public function select2_series_comprobante($codigo){
      $sql = "SELECT stp.abreviatura,  stp.serie
      FROM sunat_usuario_comprobante as suc
      INNER JOIN sunat_c01_tipo_comprobante as stp ON stp.idtipo_comprobante = suc.idtipo_comprobante
      WHERE stp.codigo = '$codigo' AND suc.idusuario = '$this->id_usr_sesion';";
      return ejecutarConsultaArray($sql);      
    }
  }
?>