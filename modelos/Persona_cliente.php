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
	public function insertar_cliente($idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento)
	{

		$sql = "INSERT INTO persona_cliente(idzona_antena, idplan, id_tecnico, ip_personal, fecha_afiliacion, nota, descuento, estado_descuento) 
		VALUES ('$idzona_antena', '$idplan', '$id_tecnico',' $ip_personal', '$fecha_afiliacion', '$nota', '$descuento', '$estado_descuento')";

		$insertar =  ejecutarConsulta($sql, 'C');

		return $insertar;
	}

	//Implementamos un método para editar registros
	public function editar_cliente($idpersona_cliente, $idzona_antena, $idplan, $id_tecnico, $ip_personal, $fecha_afiliacion, $nota, $descuento, $estado_descuento)
	{

		$sql = "UPDATE
		idzona_antena='$idzona_antena',
		idplan='$idplan',
		id_tecnico='$id_tecnico',
		ip_personal='$ip_personal',
		fecha_afiliacion='$fecha_afiliacion',
		nota='$nota',
		descuento='$descuento',
		estado_descuento='$estado_descuento'

		WHERE idpersona_cliente='$idpersona_cliente'";

		$editar =  ejecutarConsulta($sql, 'U');

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
		$sql = "SELECT * FROM persona_cliente WHERE idpersona_cliente='$idpersona_cliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function tabla_principal_cliente()
	{
		$sql = "SELECT * FROM persona_cliente WHERE estado=1  AND estado_delete=1 ORDER BY nombre ASC";
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
