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
		$idplan,
		$ip_personal,
		$fecha_afiliacion,
		$estado_descuento,
		$descuento
	) {

		$sql1 = "INSERT INTO persona(idtipo_persona, idbancos, idcargo_trabajador, tipo_persona_sunat, nombre_razonsocial, 
		apellidos_nombrecomercial, tipo_documento, numero_documento, fecha_nacimiento, celular, direccion, departamento, provincia, 
		distrito, cod_ubigeo, correo) 
		VALUES ( '$idtipo_persona', '$idbancos', '$idcargo_trabajador', '$tipo_persona_sunat', '$nombre_razonsocial', 
		'$apellidos_nombrecomercial', '$tipo_documento', '$numero_documento', '$fecha_nacimiento', '$celular', '$direccion', '$departamento', '$provincia', 
		'$distrito', '$ubigeo', '$correo')";
		$inst_persona = ejecutarConsulta_retornarID($sql1, 'C');

		if ($inst_persona['status'] == false) {
			return $inst_persona;
		}
		$id = $inst_persona['data'];


		$sql2 = "INSERT INTO persona_cliente(idpersona,idzona_antena, idplan, idpersona_trabajador, ip_personal, fecha_afiliacion, descuento, estado_descuento) 
		VALUES ('$id','$idzona_antena', '$idplan', '$idpersona_trabajador',' $ip_personal', '$fecha_afiliacion', '$descuento', '$estado_descuento')";

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
		$idplan,
		$ip_personal,
		$fecha_afiliacion,
		$estado_descuento,
		$descuento
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
						correo='$correo'		
				WHERE idpersona='$idpersona';";

		$editar1 =  ejecutarConsulta($sql1, 'U');

		if ($editar1['status'] == false) {
			return $editar1;
		}

		$sql = "UPDATE persona_cliente SET
		idpersona ='$idpersona',
		idzona_antena='$idzona_antena',
		idplan='$idplan',
		idpersona_trabajador='$idpersona_trabajador',
		ip_personal='$ip_personal',
		fecha_afiliacion='$fecha_afiliacion',
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
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan, pc.ip_personal, 
		pc.fecha_afiliacion, pc.nota, pc.descuento, pc.estado_descuento, pc.estado, p.*
		FROM persona_cliente as pc
		INNER JOIN persona as p on pc.idpersona=p.idpersona
		WHERE idpersona_cliente='$idpersona_cliente';";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function tabla_principal_cliente()
	{
		$sql = "SELECT pc.idpersona_cliente, pc.idpersona_trabajador, pc.idzona_antena, pc.idplan , pc.ip_personal, 
		pc.fecha_afiliacion, pc.descuento,pc.estado_descuento,
		CASE 
		WHEN p.tipo_persona_sunat = 'natural' 		THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
		WHEN p.tipo_persona_sunat = 'juridica' THEN p.nombre_razonsocial 
		ELSE 'Valor por defecto'
		END AS nombre_completo, 
		p.tipo_documento, p.numero_documento, p.celular, p.direccion,p.distrito,p1.nombre_razonsocial, pl.nombre as nombre_plan,pl.costo,za.nombre as zona, 
		za.ip_antena,pc.estado, i.abreviatura as tipo_doc

		FROM persona_cliente as pc
		INNER JOIN persona AS P on pc.idpersona=p.idpersona
		INNER JOIN persona_trabajador AS pt on pc.idpersona_trabajador= pt.idpersona_trabajador
		INNER JOIN persona as p1 on pt.idpersona=p1.idpersona
		INNER JOIN plan as pl on pc.idplan=pl.idplan
		INNER JOIN zona_antena as za on pc.idzona_antena=za.idzona_antena
		INNER JOIN sunat_doc_identidad as i on p.tipo_documento=i.code_sunat  
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
		WHEN p.tipo_persona_sunat = 'natural' 		THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial) 
		WHEN p.tipo_persona_sunat = 'juridica' THEN p.nombre_razonsocial 
		ELSE 'Valor por defecto'
		END AS nombre_completo, 
		p.tipo_documento, p.numero_documento 
		FROM persona_trabajador pt 
		INNER JOIN persona AS p ON pt.idpersona = p.idpersona 
		WHERE pt.estado = '1' AND pt.estado_delete = '1' AND p.idtipo_persona = '2';";
		return ejecutarConsulta($sql);
	}
}
