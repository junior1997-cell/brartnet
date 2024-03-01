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


  function listar(){
    $sql = "SELECT gt.idgasto_de_trabajador, gt.fecha_ingreso, p.foto_perfil, p.nombres, ct.nombre cargo,
    gt.precio_con_igv monto, gt.descripcion, gt.comprobante, gt.estado
    FROM gasto_de_trabajador as gt, persona as p, cargo_trabajador as ct 
    WHERE gt.idpersona = p.idpersona  AND p.idcargo_trabajador = ct.idcargo_trabajador
    AND gt.estado = 1 AND gt.estado_delete = 1;";
    return ejecutarConsulta($sql);
  }
}