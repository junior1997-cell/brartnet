<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Trabajador
{
	//Implementamos nuestro constructor
  public $id_usr_sesion; public $id_empresa_sesion;
  //Implementamos nuestro constructor
  public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
  {
    $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
		$this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
  }

	//Implementamos un método para insertar registros
	public function insertar($idpersona, $login, $clavehash, $permisos, $series)	{
		$sql = "INSERT INTO usuario( idpersona, login, password) VALUES ('$idpersona','$login','$clavehash')";
		$id_new = ejecutarConsulta_retornarID($sql, 'C');	if ($id_new['status'] == false) {  return $id_new; } 		

		$id = $id_new['data'];
		$zz = 0;
		$yy = 0;

		while ($zz < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$id', '$permisos[$zz]')";
			$usr_permiso = ejecutarConsulta($sql_detalle, 'C'); if ($usr_permiso['status'] == false) {  return $usr_permiso; } 
			$zz = $zz + 1;
		}

		while ($yy < count($series)) {
			$sql_detalle_series = "INSERT into sunat_usuario_comprobante(idusuario, idtipo_comprobante) values ('$id', '$series[$yy]')";
			$usr_num = ejecutarConsulta($sql_detalle_series, 'C'); if ($usr_num['status'] == false) {  return $usr_num; } 
			$yy = $yy + 1;
		}		

    return $id_new;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario, $idpersona, $login, $clavehash, $permisos, $series) {

		$sql = "UPDATE usuario SET idpersona='$idpersona', login='$login', password='$clavehash' WHERE idusuario='$idusuario'";
		$edit_user = ejecutarConsulta($sql, 'U'); if ($edit_user['status'] == false) {  return $edit_user; }

		//Eliminar todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE from usuario_permiso where 	idusuario='$idusuario'";
		$del_up = ejecutarConsulta($sqldel); if ($del_up['status'] == false) {  return $del_up; }

		$sqldelSeries = "DELETE from sunat_usuario_comprobante where idusuario='$idusuario'";
		$del_suc = ejecutarConsulta($sqldelSeries); if ($del_suc['status'] == false) {  return $del_suc; }

		$zz = 0;
		$yy = 0;

		while ($zz < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$idusuario', '$permisos[$zz]')";
			$usr_permiso = ejecutarConsulta($sql_detalle, 'C'); if ($usr_permiso['status'] == false) {  return $usr_permiso; } 
			$zz = $zz + 1;
		}

		while ($yy < count($series)) {
			$sql_detalle_series = "INSERT into sunat_usuario_comprobante(idusuario, idtipo_comprobante) values ('$idusuario', '$series[$yy]')";
			$usr_num = ejecutarConsulta($sql_detalle_series, 'C'); if ($usr_num['status'] == false) {  return $usr_num; } 
			$yy = $yy + 1;
		}		

    return $edit_user;		
	}

	//Implementamos un método para desactivar usuario
	public function desactivar($idusuario) {
		$sql = "UPDATE usuario set condicion='0' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar usuario
	public function activar($idusuario)	{
		$sql = "UPDATE usuario set condicion='1' where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)	{
		$sql = "SELECT u.idusuario, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo,
		p.foto_perfil, u.login, DATE_FORMAT(u.last_sesion, '%m/%d/%Y %h:%i: %p') AS last_sesion, u.estado,	t.nombre as tipo_persona, c.nombre as cargo_trabajador
		FROM  usuario as u
		inner join persona as p on u.idpersona = p.idpersona
		INNER JOIN tipo_persona as t ON t.idtipo_persona = p.idtipo_persona
		INNER JOIN cargo_trabajador as c ON c.idcargo_trabajador = p.idcargo_trabajador
		where u.idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()	{
		$sql = "SELECT u.idusuario, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo,
		p.foto_perfil, u.login, DATE_FORMAT(u.last_sesion, '%m/%d/%Y %h:%i: %p') AS last_sesion, u.estado,	t.nombre as tipo_persona, c.nombre as cargo_trabajador
		FROM  usuario as u
		inner join persona as p on u.idpersona = p.idpersona
		INNER JOIN tipo_persona as t ON t.idtipo_persona = p.idtipo_persona
		INNER JOIN cargo_trabajador as c ON c.idcargo_trabajador = p.idcargo_trabajador
		WHERE u.estado = '1' AND u.estado_delete = '1'";
		return ejecutarConsulta($sql);
	}

}
