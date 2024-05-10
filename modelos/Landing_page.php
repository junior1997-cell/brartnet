<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

Class Landing_page
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


    public function editar_plan($idplan, $caracteristicas){
        $sql = "UPDATE plan SET landing_caracteristica = '$caracteristicas' WHERE idplan = '$idplan'";
        $editar =  ejecutarConsulta($sql, 'U');	if ( $editar['status'] == false) {return $editar; } 
        return $editar;
    }

    public function editar_estadoLanding($idplan, $landing_estado){
        if ($landing_estado == 1) {
            $sql_1 = "UPDATE plan SET landing_estado = 0 WHERE idplan = '$idplan'";
            $visible = ejecutarConsulta($sql_1);
        } else if ($landing_estado == 0) {
            $sql_2 = "UPDATE plan SET landing_estado = 1 WHERE idplan = '$idplan'";
            $oculto = ejecutarConsulta($sql_2);
        }
         
        return $retorno=['status'=>true, 'message'=>'todo okey'];
    }

    public function tabla_principal_PregFerct(){
        $sql="SELECT * FROM preguntas_frecuentes WHERE estado = '1' AND estado_delete = '1'";
        return ejecutarConsulta($sql);
    }


    public function insertar($pregunta_pf, $respuesta_pf) {
		$sql_0 = "SELECT * FROM preguntas_frecuentes  WHERE pregunta = '$pregunta_pf';";
        $existe = ejecutarConsultaArray($sql_0); if ($existe['status'] == false) { return $existe;}
        
        if ( empty($existe['data']) ) {
                $sql="INSERT INTO preguntas_frecuentes(pregunta, respuesta)VALUES('$pregunta_pf', '$respuesta_pf')";
                $insertar =  ejecutarConsulta_retornarID($sql, 'C'); if ($insertar['status'] == false) {  return $insertar; } 
                
                //add registro en nuestra bitacora
                // $sql_bit = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) VALUES ('plan','".$insertar['data']."','Nueva plan registrado','" . $_SESSION['idusuario'] . "')";
                // $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }   
                
                return $insertar;
            } else {
                $info_repetida = ''; 

                foreach ($existe['data'] as $key => $value) {
                    $info_repetida .= '<li class="text-left font-size-13px">
                        <span class="font-size-15px text-danger"><b>Esta Pregunta Ya Existe</b></span><br>
                        <b>Papelera: </b>'.( $value['estado']==0 ? '<i class="fas fa-check text-success"></i> SI':'<i class="fas fa-times text-danger"></i> NO') .' <b>|</b>
                        <b>Eliminado: </b>'. ($value['estado_delete']==0 ? '<i class="fas fa-check text-success"></i> SI':'<i class="fas fa-times text-danger"></i> NO').'<br>
                        <hr class="m-t-2px m-b-2px">
                    </li>'; 
                }
                return array( 'status' => 'duplicado', 'message' => 'duplicado', 'data' => '<ul>'.$info_repetida.'</ul>', 'id_tabla' => '' );
            }			
	}


    public function editar($idpreguntas_frecuentes, $pregunta_pf, $respuesta_pf) {
		$sql_0 = "SELECT * FROM preguntas_frecuentes  WHERE pregunta = '$pregunta_pf' AND idpreguntas_frecuentes <> '$idpreguntas_frecuentes';";
        $existe = ejecutarConsultaArray($sql_0); if ($existe['status'] == false) { return $existe;}
        
        if ( empty($existe['data']) ) {
			$sql="UPDATE preguntas_frecuentes SET pregunta='$pregunta_pf', respuesta ='$respuesta_pf' WHERE idpreguntas_frecuentes='$idpreguntas_frecuentes'";
			$editar =  ejecutarConsulta($sql, 'U');	if ( $editar['status'] == false) {return $editar; } 
		
			//add registro en nuestra bitacora
			// $sql_bit = "INSERT INTO bitacora_bd( nombre_tabla, id_tabla, accion, id_user) 
			// VALUES ('plan','$idplan','plan editada','" . $_SESSION['idusuario'] . "')";
			// $bitacora = ejecutarConsulta($sql_bit); if ( $bitacora['status'] == false) {return $bitacora; }  
		
			return $editar;
		} else {
			$info_repetida = ''; 

			foreach ($existe['data'] as $key => $value) {
				$info_repetida .= '<li class="text-left font-size-13px">
                    <span class="font-size-15px text-danger"><b>Esta Pregunta Ya Existe</b></span><br>
					<b>Papelera: </b>'.( $value['estado']==0 ? '<i class="fas fa-check text-success"></i> SI':'<i class="fas fa-times text-danger"></i> NO') .' <b>|</b>
					<b>Eliminado: </b>'. ($value['estado_delete']==0 ? '<i class="fas fa-check text-success"></i> SI':'<i class="fas fa-times text-danger"></i> NO').'<br>
					<hr class="m-t-2px m-b-2px">
				</li>'; 
			}
			return array( 'status' => 'duplicado', 'message' => 'duplicado', 'data' => '<ul>'.$info_repetida.'</ul>', 'id_tabla' => '' );
		}			
	}


    public function mostrar_pregFrec($idpreguntas_frecuentes){
        $sql ="SELECT * FROM preguntas_frecuentes WHERE idpreguntas_frecuentes = '$idpreguntas_frecuentes'";
        return ejecutarConsultaSimpleFila($sql);
    }


    public function desactivar($id){
        $sql = "UPDATE preguntas_frecuentes SET estado = 0 WHERE idpreguntas_frecuentes = '$id'";
        return ejecutarConsulta($sql);
    }


    public function eliminar($id){
        $sql = "UPDATE preguntas_frecuentes SET estado_delete = 0 WHERE idpreguntas_frecuentes = '$id'";
        $eliminar =  ejecutarConsulta($sql, 'D');	if ( $eliminar['status'] == false) {return $eliminar; }  
        return $eliminar;
    }


}
?>