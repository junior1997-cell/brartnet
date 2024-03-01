<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Usuario
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
	public function insertar($nombre, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos, $series, $empresa)	{
		$sql = "INSERT into usuario (nombre, apellidos, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen)
    values ('$nombre','$apellidos', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email','$cargo', '$login', '$clave', '$imagen')";

		$idusuarionew = ejecutarConsulta_retornarID($sql);

		// Insertar en vendedorsitio SOLO si cargo es igual a 1 (Ventas)
		if ($cargo == 1) {
			$sql_vendedor = "INSERT into vendedorsitio(nombre, estado, idempresa) values ('$nombre', 1, 1)";
			ejecutarConsulta($sql_vendedor);
		}

		$num_elementos = 0;
		$num_elementos2 = 0;
		$num_elementos3 = 0;

		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		while ($num_elementos2 < count($series)) {
			$sql_detalle_series = "INSERT into detalle_usuario_numeracion(idusuario, idnumeracion) values ('$idusuarionew', '$series[$num_elementos2]')";
			ejecutarConsulta($sql_detalle_series) or $sw = false;
			$num_elementos2 = $num_elementos2 + 1;
		}

		while ($num_elementos3 < count($empresa)) {
			$sql_usuario_empresa = "INSERT into usuario_empresa(idusuario, idempresa) values ('$idusuarionew', '$empresa[$num_elementos3]')";
			ejecutarConsulta($sql_usuario_empresa) or $sw = false;
			$num_elementos3 = $num_elementos3 + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario, $nombre, $apellidos, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, 
	$imagen, $permisos, $series, $empresa) {
		$sql = "UPDATE usuario set nombre='$nombre', apellidos='$apellidos',tipo_documento='$tipo_documento', num_documento='$num_documento', 
		direccion='$direccion', telefono='$telefono', email='$email', cargo='$cargo' , login='$login' , clave='$clave', imagen='$imagen' where idusuario='$idusuario'";
		$edit_user = ejecutarConsulta($sql); if ($edit_user['status'] == false) {  return $edit_user; }

		//Eliminar todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE from usuario_permiso where 	idusuario='$idusuario'";
		$del_user_permiso = ejecutarConsulta($sqldel); if ($del_user_permiso['status'] == false) {  return $del_user_permiso; }

		$sqldelSeries = "DELETE from detalle_usuario_numeracion where idusuario='$idusuario'";
		$del_detalle_user_num = ejecutarConsulta($sqldelSeries); if ($del_detalle_user_num['status'] == false) {  return $del_detalle_user_num; }

		$sqldelEmpresa = "DELETE from usuario_empresa where idusuario='$idusuario'";
		$del_usuario_empresa = ejecutarConsulta($sqldelEmpresa); if ($del_usuario_empresa['status'] == false) {  return $del_usuario_empresa; }

		$ii = 0;
		$ii2 = 0;
		$iii = 0;

		$sw = true;

		while ($ii < count($permisos)) {
			$sql_detalle = "INSERT into usuario_permiso(idusuario, idpermiso) values ('$idusuario', '$permisos[$ii]')";
			$user_permiso = ejecutarConsulta($sql_detalle); if ($user_permiso['status'] == false) {  return $user_permiso; }
			$ii = $ii + 1;
		}

		while ($ii2 < count($series)) {
			$sql_detalleSeries = "INSERT into detalle_usuario_numeracion(idusuario, idnumeracion) values ('$idusuario', '$series[$ii2]')";
			$user_num =  ejecutarConsulta($sql_detalleSeries); if ($user_num['status'] == false) {  return $user_num; }
			$ii2 = $ii2 + 1;
		}
		// return count($empresa);
		while ($iii < count($empresa)) {
			$sql_Usuario_emresa = "INSERT into usuario_empresa(idusuario, idempresa) values ('$idusuario', '$empresa[$iii]')";
			$user_empresa = ejecutarConsulta($sql_Usuario_emresa); if ($user_empresa['status'] == false) {  return $user_empresa; }
			$iii = $iii + 1;
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
		$sql = "SELECT * from usuario where idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function validar_usuario($idusuario, $user) {
    $validar_user = empty($idusuario) ? "" : "AND u.idusuario != '$idusuario'" ;
    $sql = "SELECT u.idusuario, u.login, u.clave, u.estado FROM usuario AS u WHERE u.login = '$user' $validar_user;";
    $buscando =  ejecutarConsultaArray($sql); if ( $buscando['status'] == false) {return $buscando; }

    if (empty($buscando['data'])) { return true; }else { return false; }
  }

	//Implementar un método para listar los registros
	public function listar()	{
		$sql = "SELECT u.idusuario, p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo,
		p.foto_perfil, u.login, u.last_sesion, u.estado,	t.nombre as tipo_persona, c.nombre as cargo_trabajador
		FROM persona as p
		inner join usuario as u on u.idusuario = p.idpersona
		INNER JOIN tipo_persona as t ON t.idtipo_persona = p.idtipo_persona
		INNER JOIN cargo_trabajador as c ON c.idcargo_trabajador = p.idcargo_trabajador
		WHERE u.estado = '1' AND u.estado_delete = '1'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()	{
		$sql = "SELECT * from usuario where condicion=1";
		return ejecutarConsulta($sql);
	}

	//Implementar un metodo para listar los permisos marcados
	public function listarmarcados($idusuario)	{		
		$sql = "SELECT * from usuario_permiso where idusuario='$idusuario'";
		return ejecutarConsultaArray($sql); 		
	}

	public function listar_grupo_marcados($idusuario)	{		
		$sql = "SELECT up.idusuario, p.idpermiso, p.estado, p.modulo, count(p.modulo) 
		from usuario_permiso AS up 
		INNER JOIN permiso as p ON up.idpermiso = p.idpermiso 
		where idusuario='$idusuario'
		GROUP BY p.modulo ORDER BY count(p.modulo) DESC; ";
		return ejecutarConsultaArray($sql); 		
	}

	public function listarmarcadosEmpresa($idusuario)	{
		$sql = "SELECT * from usuario_empresa where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosEmpresaTodos()	{
		$sql = "SELECT * from usuario_empresa ";
		return ejecutarConsulta($sql);
	}

	public function listarmarcadosNumeracion($idusuario)	{
		$sql = "SELECT * from sunat_usuario_comprobante where idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Funcion para verificar el acceso al sistema
	public function verificar($login, $clave)	{

		$sql = "SELECT u.idusuario, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.tipo_documento, p.numero_documento, p.celular, p.correo, ct.nombre as cargo, u.login, p.foto_perfil, p.tipo_documento
    FROM usuario as u, persona as p, cargo_trabajador as ct 
    WHERE  u.idpersona = p.idpersona AND p.idcargo_trabajador =ct.idcargo_trabajador AND  u.login='$login' AND u.password='$clave' 
    AND p.estado=1 and p.estado_delete=1 and u.estado=1 and u.estado_delete=1;";
		$user = ejecutarConsultaSimpleFila($sql); if ($user['status'] == false) {  return $user; } 

		// $id_user =  empty($user['data']) ? '' : $user['data']['idusuario'];

		// $sql2 = "SELECT ue.*, u.nombre as nombre_usuario, u.apellidos as apellido_usuario, e.nombre_razon_social, e.nombre_comercial, e.domicilio_fiscal, e.numero_ruc, co.igv 
		// FROM usuario_empresa as ue
		// INNER JOIN usuario AS u ON u.idusuario = ue.idusuario
		// INNER JOIN empresa as e ON e.idempresa = ue.idempresa
		// inner join configuraciones co on e.idempresa=co.idempresa 
		// WHERE ue.idusuario = '$id_user'";
		// $sucursal = ejecutarConsultaSimpleFila($sql2); if ($sucursal['status'] == false) {  return $sucursal; }

		$data = [ 'status'=>true, 'message'=>'todo okey','data'=> ['usuario' => $user['data']]  ];
    return $data;
	}

	public function onoffTempo($st)	{
		$sql = "UPDATE temporizador set estado='$st' where id='1' ";
		return ejecutarConsulta($sql);
	}

	public function consultatemporizador()	{
		$sql = "SELECT id as idtempo, tiempo, estado from temporizador where id='1' ";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function savedetalsesion($idusuario)	{
		$sql = "INSERT into detalle_usuario_sesion (idusuario, tcomprobante, idcomprobante, fechahora) 
      values ('$idusuario', '','', now())";
		return ejecutarConsulta($sql);
	}
}
