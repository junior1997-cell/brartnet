<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Gasto_de_trabajador
  {
    //Implementamos nuestro constructor
    public $id_usr_sesion; 
    // public $id_empresa_sesion;
    //Implementamos nuestro constructor
    public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
    {
      $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
      // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
    }

    function insertar($idtrabajador, $descr_gastos, $tp_comprobante, $serie_comprobante, $fecha, $idproveedor, $sub_total, $igv, $val_igv, $total_gasto, $descr_comprobante, $img_comprob){
      $sql = "INSERT INTO gasto_de_trabajador (idtrabajador, descripcion_gasto, tipo_comprobante, serie_comprobante, fecha_ingreso, idproveedor, precio_sin_igv, precio_igv, val_igv, precio_con_igv, descripcion_comprobante, comprobante)
      VALUES ('$idtrabajador', '$descr_gastos', '$tp_comprobante', '$serie_comprobante', '$fecha', '$idproveedor', '$sub_total', '$igv', '$val_igv', '$total_gasto', '$descr_comprobante', '$img_comprob')";
      return ejecutarConsulta_retornarID($sql, 'C');
    }

    function editar($id, $idtrabajador, $descr_gastos, $tp_comprobante, $serie_comprobante, $fecha, $idproveedor, $sub_total, $igv, $val_igv, $total_gasto, $descr_comprobante, $img_comprob){
      $sql = "UPDATE gasto_de_trabajador  SET idtrabajador = '$idtrabajador', descripcion_gasto = '$descr_gastos', tipo_comprobante = '$tp_comprobante', serie_comprobante = '$serie_comprobante', fecha_ingreso = '$fecha', 
      idproveedor = '$idproveedor', precio_sin_igv = '$sub_total', precio_igv = '$igv', val_igv = '$val_igv', precio_con_igv = '$total_gasto', descripcion_comprobante = '$descr_comprobante', comprobante = '$img_comprob'
      WHERE idgasto_de_trabajador = '$id' ";
      return ejecutarConsulta($sql, 'U');
    }

    function mostrar_detalle_gasto($id){

      $sql_1 = "SELECT gt.*, p.* FROM gasto_de_trabajador as gt, persona as p
      WHERE gt.idgasto_de_trabajador = '$id' AND gt.idtrabajador = p.idpersona AND p.idtipo_persona = 2
      AND gt.estado = 1 AND gt.estado_delete = 1;";
      $trabajador = ejecutarConsultaSimpleFila($sql_1); if ($trabajador['status'] == false) { return $trabajador; }

      $sql_2 = "SELECT p.* FROM gasto_de_trabajador as gt
      INNER JOIN persona as p ON gt.idproveedor = p.idpersona
      WHERE gt.idgasto_de_trabajador = '$id'
        AND p.idtipo_persona IN (1, 4)
        AND gt.estado = 1
        AND gt.estado_delete = 1;
      ";
      $proveedor = ejecutarConsultaSimpleFila($sql_2); if ($proveedor['status'] == false) { return $proveedor; }

      $results = [
        "status" => true,
        "data" => [
        "trabajador" => $trabajador,
        "proveedor" => $proveedor,
        
      ],
      "message" => 'Todo oka'
      ];

      return $results;

    }

    function listar_tabla(){
      $sql = "SELECT gt.*, p.*, ct.nombre cargo FROM gasto_de_trabajador as gt, persona as p, cargo_trabajador as ct
      WHERE gt.idtrabajador = p.idpersona AND p.idtipo_persona = 2 AND p.idcargo_trabajador = ct.idcargo_trabajador
      AND gt.estado = 1 AND gt.estado_delete = 1;";
      return ejecutarConsulta($sql);
    }

    public function desactivar($id){
      $sql="UPDATE gasto_de_trabajador SET estado='0',user_trash= '$this->id_usr_sesion' WHERE idgasto_de_trabajador='$id'";
      $desactivar =  ejecutarConsulta($sql, 'U'); if ( $desactivar['status'] == false) {return $desactivar; }  
      
      //add registro en nuestra bitacora
      // $sql_d = $id;
      // $sql = "INSERT INTO bitacora_bd(idcodigo,nombre_tabla, id_tabla, sql_d, id_user) VALUES (2,'gasto_de_trabajador','.$id.','$sql_d','$this->id_usr_sesion')";
      // $bitacora = ejecutarConsulta($sql); if ( $bitacora['status'] == false) {return $bitacora; }  

      return $desactivar;
    }

    public function eliminar($id) {
      $sql="UPDATE gasto_de_trabajador SET estado_delete='0',user_delete= '$this->id_usr_sesion' WHERE idgasto_de_trabajador='$id'";
      $eliminar =  ejecutarConsulta($sql); if ( $eliminar['status'] == false) {return $eliminar; }  

      //add registro en nuestra bitacora
      // $sql_d = $id;
      // $sql_bit = "INSERT INTO bitacora_bd(idcodigo, nombre_tabla, id_tabla, sql_d, id_user) VALUES (4,'gasto_de_trabajador','$id','$sql_d','$this->id_usr_sesion')";
		  // $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }  
		
		  return $eliminar;
    }
    
    function listar_trabajador(){
      $sql = "SELECT idpersona, nombre_razonsocial nombre, apellidos_nombrecomercial apellido 
      FROM persona WHERE idtipo_persona = 2 AND estado = 1 AND estado_delete = 1;";
      return ejecutarConsultaArray($sql);
    }

    function listar_proveedor(){
      $sql = "SELECT idpersona, nombre_razonsocial nombre, apellidos_nombrecomercial apellido 
      FROM persona WHERE idtipo_persona = 4 AND estado = 1 AND estado_delete = 1;";
      return ejecutarConsultaArray($sql);
    }

    function ver_gasto_trabajador($id){
      $sql = "SELECT * FROM gasto_de_trabajador WHERE idgasto_de_trabajador = '$id'";
      return ejecutarConsultaSimpleFila($sql);
    }
  }
?>