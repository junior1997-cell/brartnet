<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Cliente
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}
	/*T-- paepelera --desacctivar
	C-- crear
	R-- read
	U-- actualizar
	D-- delete -- eliminar*/
	//Implementamos un método para insertar registros
	public function insertar_cliente(
		$idtipo_persona,
		$idbancos,
		$idcargo_trabajador,
		$tipo_persona_sunat,
		$tipo_documento,
		$numero_documento,
		$nombre_razonsocial,
		$apellidos_nombrecomercial,
		$fecha_nacimiento,
		$celular,
		$direccion,
		$distrito,
		$departamento,
		$provincia,
		$ubigeo,
		$correo,
		$idpersona_trabajador,
		$idzona_antena,
		$idselec_centroProbl,
		$idplan,
		$ip_personal,
		$fecha_afiliacion,
		$estado_descuento,
		$descuento,
		$fecha_cancelacion,
		$img_perfil
	) {

		$sql1 = "INSERT INTO persona(idtipo_persona, idbancos, idcargo_trabajador, tipo_persona_sunat, nombre_razonsocial, 
		apellidos_nombrecomercial, tipo_documento, numero_documento, fecha_nacimiento, celular, direccion, departamento, provincia, 
		distrito, cod_ubigeo, correo,foto_perfil) 
		VALUES ( '$idtipo_persona', '$idbancos', '$idcargo_trabajador', '$tipo_persona_sunat', '$nombre_razonsocial', 
		'$apellidos_nombrecomercial', '$tipo_documento', '$numero_documento', '$fecha_nacimiento', '$celular', '$direccion', '$departamento', '$provincia', 
		'$distrito', '$ubigeo', '$correo','$img_perfil')";
		$inst_persona = ejecutarConsulta_retornarID($sql1, 'C');

		if ($inst_persona['status'] == false) {
			return $inst_persona;
		}
		$id = $inst_persona['data'];


		$sql2 = "INSERT INTO persona_cliente(idpersona,idzona_antena, idplan, idpersona_trabajador,idcentro_poblado, ip_personal, fecha_afiliacion, descuento, estado_descuento,fecha_cancelacion) 
		VALUES ('$id','$idzona_antena', '$idplan', '$idpersona_trabajador','$idselec_centroProbl',' $ip_personal', '$fecha_afiliacion', '$descuento', '$estado_descuento', '$fecha_cancelacion')";

		$insertar =  ejecutarConsulta($sql2, 'C');
		if ($inst_persona['status'] == false) {
			return $inst_persona;
		}

		return $insertar;
	}

	//Implementamos un método para editar registros
	public function editar_cliente(
		$idpersona,
		$idtipo_persona,
		$idbancos,
		$idcargo_trabajador,
		$idpersona_cliente,
		$tipo_persona_sunat,
		$tipo_documento,
		$numero_documento,
		$nombre_razonsocial,
		$apellidos_nombrecomercial,
		$fecha_nacimiento,
		$celular,
		$direccion,
		$distrito,
		$departamento,
		$provincia,
		$ubigeo,
		$correo,
		$idpersona_trabajador,
		$idzona_antena,
		$idselec_centroProbl,
		$idplan,
		$ip_personal,
		$fecha_afiliacion,
		$estado_descuento,
		$descuento,
		$fecha_cancelacion,
		$img_perfil
	) {

		$sql1 = "UPDATE persona SET 		
						idtipo_persona='$idtipo_persona',
						idbancos='$idbancos',
						idcargo_trabajador='$idcargo_trabajador',
						tipo_persona_sunat='$tipo_persona_sunat',
						nombre_razonsocial='$nombre_razonsocial',
						apellidos_nombrecomercial='$apellidos_nombrecomercial',
						tipo_documento='$tipo_documento',
						numero_documento='$numero_documento',
						fecha_nacimiento='$fecha_nacimiento',
						celular='$celular',
						direccion='$direccion',
						departamento='$departamento',
						provincia='$provincia',
						distrito='$distrito',
						cod_ubigeo='$ubigeo',
						correo='$correo',		
						foto_perfil='$img_perfil'	
				WHERE idpersona='$idpersona';";

		$editar1 =  ejecutarConsulta($sql1, 'U');

		if ($editar1['status'] == false) {
			return $editar1;
		}

		$sql = "UPDATE persona_cliente SET
		idpersona ='$idpersona',
		idzona_antena='$idzona_antena',
		idcentro_poblado='$idselec_centroProbl',
		idplan='$idplan',
		idpersona_trabajador='$idpersona_trabajador',
		ip_personal='$ip_personal',
		fecha_afiliacion='$fecha_afiliacion',
		fecha_cancelacion='$fecha_cancelacion',
		descuento='$descuento',
		estado_descuento='$estado_descuento'
		WHERE idpersona_cliente='$idpersona_cliente';";

		$editar =  ejecutarConsulta($sql, 'U');

		if ($editar['status'] == false) {
			return $editar;
		}

		return $editar;
	}

	//Implementamos un método para desactivar color
	public function desactivar_cliente($idpersona_cliente)
	{
		$sql = "UPDATE persona_cliente SET estado='0' WHERE idpersona_cliente='$idpersona_cliente'";
		$desactivar = ejecutarConsulta($sql, 'T');

		return $desactivar;
	}

	//Implementamos un método para eliminar persona_cliente
	public function eliminar_cliente($idpersona_cliente)
	{

		$sql = "UPDATE persona_cliente SET estado_delete='0' WHERE idpersona_cliente='$idpersona_cliente'";
		$eliminar =  ejecutarConsulta($sql, 'D');
		if ($eliminar['status'] == false) {
			return $eliminar;
		}

		return $eliminar;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar_cliente($idpersona_cliente)
	{
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan, pc.ip_personal, pc.idcentro_poblado,
		pc.fecha_afiliacion, pc.fecha_cancelacion, pc.nota, pc.descuento, pc.estado_descuento, pc.estado, p.*
		FROM persona_cliente as pc
		INNER JOIN persona as p on pc.idpersona=p.idpersona
		WHERE idpersona_cliente='$idpersona_cliente';";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function tabla_principal_cliente()
	{
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan , pc.ip_personal, DAY(pc.fecha_cancelacion) AS dia_cancelacion, pc.fecha_cancelacion,
		pc.fecha_afiliacion, pc.descuento,pc.estado_descuento,cp.nombre as centro_poblado,
		CASE 
		WHEN p.tipo_persona_sunat = 'NATURAL' 		THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
		WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
		ELSE '-'
		END AS nombre_completo, 
		p.tipo_documento, p.numero_documento, p.celular, p.foto_perfil, p.direccion,p.distrito,p1.nombre_razonsocial, pl.nombre as nombre_plan,pl.costo,za.nombre as zona, 
		za.ip_antena,pc.estado, i.abreviatura as tipo_doc

		FROM persona_cliente as pc
		INNER JOIN persona AS p on pc.idpersona=p.idpersona
		INNER JOIN persona_trabajador AS pt on pc.idpersona_trabajador= pt.idpersona_trabajador
		INNER JOIN persona as p1 on pt.idpersona=p1.idpersona
		INNER JOIN plan as pl on pc.idplan=pl.idplan
		INNER JOIN zona_antena as za on pc.idzona_antena=za.idzona_antena
		INNER JOIN sunat_doc_identidad as i on p.tipo_documento=i.code_sunat  
		INNER JOIN centro_poblado as cp on pc.idcentro_poblado=cp.idcentro_poblado  
		where pc.estado='1' and pc.estado_delete='1' ORDER BY idpersona_cliente DESC";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select2_plan()
	{
		$sql = "SELECT idplan, nombre, costo FROM plan WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}

	public function select2_zona_antena()
	{
		$sql = "SELECT idzona_antena, nombre, ip_antena FROM zona_antena WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}

	public function select2_trabajador()
	{
		$sql = "SELECT pt.idpersona_trabajador, p.idpersona, 
		CASE 
		WHEN p.tipo_persona_sunat = 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
		WHEN p.tipo_persona_sunat = 'JURÍDICA' THEN p.nombre_razonsocial 
		ELSE '-'
		END AS nombre_completo, 
		p.tipo_documento, p.numero_documento 
		FROM persona_trabajador pt 
		INNER JOIN persona AS p ON pt.idpersona = p.idpersona 
		WHERE pt.estado = '1' AND pt.estado_delete = '1' AND p.idtipo_persona = '2';";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function perfil_trabajador($id)
	{
		$sql = "SELECT p.foto_perfil	FROM persona as p WHERE p.idpersona = '$id' ;";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function selec_centroProbl(){
		$sql="SELECT idcentro_poblado, nombre FROM centro_poblado WHERE estado='1' and estado_delete='1';";
		return ejecutarConsulta($sql);
	}
}
