<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Proveedores
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
      $sql = "SELECT p.*, b.idbancos, b.nombre as banco
      FROM persona p
      JOIN bancos b ON p.idbancos = b.idbancos
      WHERE p.idtipo_persona = 4
        AND p.estado = 1
        AND p.estado_delete = 1;";
      return ejecutarConsulta($sql);
    }

    public function insertar( $tipo_persona_sunat, $idtipo_persona, $tipo_documento, $numero_documento, 
    $nombre_razonsocial, $apellidos_nombrecomercial, $correo, $celular, $direccion, $distrito, 
    $departamento, $provincia, $ubigeo, $idbanco, $cuenta_bancaria, $cci, $img_perfil)	{
		$sql = "INSERT INTO persona( idtipo_persona, idbancos, idcargo_trabajador, tipo_persona_sunat, nombre_razonsocial, apellidos_nombrecomercial, 
		tipo_documento, numero_documento, celular, direccion, departamento, provincia, distrito, cod_ubigeo, correo, 
		cuenta_bancaria, cci, foto_perfil ) VALUES 
		('$idtipo_persona', '$idbanco', '1', '$tipo_persona_sunat', '$nombre_razonsocial', '$apellidos_nombrecomercial', '$tipo_documento', '$numero_documento',
		'$celular', '$direccion', '$departamento', '$provincia', '$distrito', '$ubigeo', '$correo', '$cuenta_bancaria','$cci',	'$img_perfil')";
		$id_new = ejecutarConsulta_retornarID($sql, 'C');	if ($id_new['status'] == false) {  return $id_new; }

    return $id_new;
	  }

    public function editar($idpersona, $tipo_persona_sunat, $idtipo_persona, $tipo_documento, $numero_documento, 
      $nombre_razonsocial, $apellidos_nombrecomercial, $correo, $celular, $direccion, $distrito, 
      $departamento, $provincia, $ubigeo, $idbanco, $cuenta_bancaria, $cci, $img_perfil) {

      $sql = "UPDATE persona SET idtipo_persona='$idtipo_persona', idbancos='$idbanco', idcargo_trabajador='1',
      tipo_persona_sunat='$tipo_persona_sunat', nombre_razonsocial='$nombre_razonsocial', apellidos_nombrecomercial='$apellidos_nombrecomercial',
      tipo_documento='$tipo_documento',	numero_documento='$numero_documento',celular='$celular',direccion='$direccion',
      departamento='$departamento',	provincia='$provincia', distrito='$distrito', cod_ubigeo='$ubigeo', correo='$correo', cuenta_bancaria='$cuenta_bancaria', cci='$cci',
      foto_perfil='$img_perfil' 
      WHERE idpersona = '$idpersona'";
      $edit_user = ejecutarConsulta($sql, 'U'); if ($edit_user['status'] == false) {  return $edit_user; }

      return $edit_user;		
    }

    public function eliminar($id){
      $sql = "UPDATE persona SET estado_delete = 0
      WHERE idpersona = '$id'";
      return ejecutarConsulta($sql, 'U');
    }

    public function papelera($id){
      $sql = "UPDATE persona SET estado = 0
      WHERE idpersona = '$id'";
      return ejecutarConsulta($sql, 'U');
    }

    function mostrar($id){
      $sql = "SELECT p.*, b.idbancos, b.nombre as banco
      FROM persona p
      JOIN bancos b ON p.idbancos = b.idbancos
      WHERE p.idpersona = '$id'
        AND p.idtipo_persona = 4
        AND p.estado = 1
        AND p.estado_delete = 1;";
      return ejecutarConsultaSimpleFila($sql);
    }








  }
?>