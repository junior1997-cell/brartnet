<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Correlacion_comprobante
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

    function listar_tabla(){
      $sql = "SELECT * FROM sunat_correlacion_comprobante WHERE estado = 1 AND estado_delete = 1";
      return ejecutarConsulta($sql);
    }

    public function validar($nombre)	{
      $sql="SELECT * from sunat_correlacion_comprobante where nombre='$nombre'";
      return ejecutarConsultaArray($sql);
    }

    public function insertar($codigo, $nombre, $abreviatura, $serie, $numero, $un1001) {
      $sql="INSERT INTO sunat_correlacion_comprobante(codigo, nombre, abreviatura, serie, numero, un1001)VALUES('$codigo', '$nombre', '$abreviatura', '$serie', '$numero', '$un1001')";
  
      $insertar =  ejecutarConsulta_retornarID($sql); 
      if ($insertar['status'] == false) {  return $insertar; } 
      
      //add registro en nuestra bitacora
      // $sql_bit = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) VALUES ('plan','".$insertar['data']."','Nueva plan registrado','" . $_SESSION['idusuario'] . "')";
      // $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }   
      
      return $insertar;
    }

    public function editar($id, $codigo, $nombre, $abreviatura, $serie, $numero, $un1001) {
      $sql="UPDATE sunat_correlacion_comprobante SET codigo = '$codigo', nombre='$nombre', abreviatura = '$abreviatura', serie = '$serie', numero = '$numero', un1001 ='$un1001' WHERE idtipo_comprobante='$id'";
      $editar =  ejecutarConsulta($sql);
      if ( $editar['status'] == false) {return $editar; } 
    
      //add registro en nuestra bitacora
      // $sql_bit = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) 
      // VALUES ('plan','$idsunat_tipo_tributo','plan editada','" . $_SESSION['idusuario'] . "')";
      // $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }  
    
      return $editar;
    }

    public function mostrar($id){
      $sql = "SELECT * FROM sunat_correlacion_comprobante Where idtipo_comprobante = '$id'";
      return ejecutarConsultaSimpleFila($sql);
    }

    //Implementamos un método para desactivar color
	public function desactivar($id) {
		$sql="UPDATE sunat_correlacion_comprobante SET estado='0', user_trash= '" . $_SESSION['idusuario'] . "' WHERE idtipo_comprobante='$id'";
		$desactivar= ejecutarConsulta($sql);

		// if ($desactivar['status'] == false) {  return $desactivar; }
		
		// //add registro en nuestra bitacora
		// $sql_bit = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) VALUES ('plan','".$idsunat_tipo_tributo."','plan desactivada','" . $_SESSION['idusuario'] . "')";
		// $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }   
		
		return $desactivar;
	}

	//Implementamos un método para activar plan
	public function activar($id) {
		$sql="UPDATE sunat_correlacion_comprobante SET estado='1' WHERE idtipo_comprobante='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar plan
	public function eliminar($id) {
		
		$sql="UPDATE sunat_correlacion_comprobante SET estado_delete='0' WHERE idtipo_comprobante='$id'";
		$eliminar =  ejecutarConsulta($sql);
		if ( $eliminar['status'] == false) {return $eliminar; }  
		
		//add registro en nuestra bitacora
		// $sql = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) VALUES ('plan', '$idsunat_tipo_tributo', 'plan Eliminada','" . $_SESSION['idusuario'] . "')";
		// $bitacora = ejecutarConsulta($sql); if ( $bitacora['status'] == false) {return $bitacora; }  
		
		return $eliminar;
	}

  public function listar_crl_comprobante(){
    $sql="SELECT idtipo_comprobante, abreviatura AS tipo_comprobante, serie
    FROM sunat_correlacion_comprobante WHERE estado = 1 AND estado_delete = 1;";
    return ejecutarConsultaArray($sql);
  }
    

  }
?>