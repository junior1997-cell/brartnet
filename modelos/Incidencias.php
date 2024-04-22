<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Incidencias
  {
    //Implementamos nuestro constructor
    public $id_usr_sesion; 

    //Implementamos nuestro constructor
    public function __construct( $id_usr_sesion = 0, $id_empresa_sesion = 0 )
    {
      $this->id_usr_sesion =  isset($_SESSION['idusuario']) ? $_SESSION["idusuario"] : 0;
      // $this->id_empresa_sesion = isset($_SESSION['idempresa']) ? $_SESSION["idempresa"] : 0;
    }

    function insertar($actividad, $creacionfecha, $prioridad,$id_trabajador,$categoria,$actividad_detalle){
      //id_trabajador es un arr       // var_dump( $fecha );die();
      $fecha= new DateTime($creacionfecha); $fecha_str = $fecha->format('Y-m-d');

      $sql = "INSERT INTO incidencias(idincidencia_categoria, actividad, actividad_detalle, fecha_creacion,estado_revicion) 
      VALUES ('$categoria','$actividad','$actividad_detalle','$fecha_str','$prioridad')";
      $newdata =  ejecutarConsulta_retornarID($sql, 'C'); if ( $newdata['status'] == false) {return $newdata; }  
      $id = $newdata['data'];
      $i = 0;
      $detalle_new = "";

      if ( !empty($newdata['data']) ) { 

        while ($i < count($id_trabajador)) {

          $sql_2 = "INSERT INTO incidencia_trabajador(idpersona_trabajador, idincidencias) VALUES ('$id_trabajador[$i]','$id');";
          $detalle_new =  ejecutarConsulta($sql_2, 'C'); if ($detalle_new['status'] == false) { return  $detalle_new;}          

          $i = $i + 1;

        }
      }
      return $detalle_new;

    }

    function editar($idincidencia,$actividad, $creacionfecha, $prioridad,$id_trabajador,$categoria,$actividad_detalle){
      $sql = "UPDATE gasto_de_trabajador  SET idpersona_trabajador = '$idtrabajador', descripcion_gasto = '$descr_gastos', tipo_comprobante = '$tp_comprobante', serie_comprobante = '$serie_comprobante', fecha_ingreso = '$fecha', 
      idproveedor = '$idproveedor', precio_sin_igv = '$sub_total', precio_igv = '$igv', val_igv = '$val_igv', precio_con_igv = '$total_gasto', descripcion_comprobante = '$descr_comprobante', comprobante = '$img_comprob'
      WHERE idgasto_de_trabajador = '$id' ";
      return ejecutarConsulta($sql, 'U');
    }

    function mostrar_detalle_gasto($id){

      $sql_2 = "SELECT gdt.idgasto_de_trabajador, gdt.idproveedor, gdt.tipo_comprobante, gdt.serie_comprobante, gdt.fecha_ingreso,  DATE_FORMAT(gdt.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso_f, 
      gdt.day_name, gdt.month_name, gdt.year_name, gdt.precio_sin_igv, gdt.precio_igv, gdt.val_igv, gdt.precio_con_igv, gdt.descripcion_comprobante, gdt.descripcion_gasto, gdt.comprobante,  gdt.estado,
      CASE p.tipo_persona_sunat 
        WHEN 'NATURAL' THEN CONCAT(p.nombre_razonsocial, ' ', p.apellidos_nombrecomercial )
        WHEN 'JURIDICA' THEN p.nombre_razonsocial
      END AS proveedor, p.foto_perfil as foto_perfil_proveedor, p.numero_documento as numero_documento_p, sdi_p.abreviatura as tipo_documento_nombre_p,
      CASE t.tipo_persona_sunat 
        WHEN 'NATURAL' THEN CONCAT(t.nombre_razonsocial, ' ', t.apellidos_nombrecomercial )
        WHEN 'JURIDICA' THEN t.nombre_razonsocial
      END AS trabajador, t.foto_perfil as foto_perfil_trabajador, t.numero_documento as numero_documento_t, sdi.abreviatura as tipo_documento_nombre_t
      FROM gasto_de_trabajador as gdt
      INNER JOIN persona as p ON p.idpersona = gdt.idproveedor 
      INNER JOIN sunat_doc_identidad as sdi_p ON sdi_p.code_sunat = p.tipo_documento
      INNER JOIN persona_trabajador as pt ON pt.idpersona_trabajador = gdt.idpersona_trabajador
      INNER JOIN persona as t ON t.idpersona = pt.idpersona
      INNER JOIN sunat_doc_identidad as sdi ON sdi.code_sunat = t.tipo_documento
      WHERE gdt.estado = '1' AND gdt.estado_delete = '1' AND gdt.idgasto_de_trabajador = '$id' ;";
      return ejecutarConsultaSimpleFila($sql_2); 

    }

    function view_incidencias($categoria,$prioridad){

      $data = Array();
      // $data_trab = Array();

      $filtro_categoria = ""; $filtro_prioridad = ""; 
  
      if (empty($categoria) || $categoria=="TODOS" ) {  $filtro_categoria = ""; } else { $filtro_categoria = "AND idincidencia_categoria = '$categoria'"; }
      if (empty($prioridad) || $prioridad=="TODOS" ) {  $filtro_prioridad = ""; } else { $filtro_prioridad = "AND estado_revicion = '$prioridad'"; }
  

        $sql = "SELECT  idincidencias,idincidencia_categoria,actividad,actividad_detalle,fecha_creacion,fecha_fin,estado_revicion,estado 
        FROM incidencias where estado='1' and estado_delete='1' $filtro_categoria $filtro_prioridad";
        
        $incidencias =  ejecutarConsultaArray($sql); if ( $incidencias['status'] == false) {return $incidencias ; } 

        foreach ($incidencias['data'] as $key => $value) {
          $trabajardorhtml="";
          $idincidencias = $value['idincidencias'];
          $sql2 = "SELECT it.idincidencia_trabajador,it.idpersona_trabajador, p.idpersona, p.nombre_razonsocial, p.foto_perfil
          FROM incidencia_trabajador as it
          inner join persona_trabajador as pt on it.idpersona_trabajador = pt.idpersona_trabajador
          INNER JOIN persona as p on pt.idpersona = p.idpersona
          where idincidencias='$idincidencias';";

          $trabadores = ejecutarConsultaArray($sql2); if ($trabadores['status'] == false) { return $trabadores; }

          foreach ($trabadores['data'] as $key => $valor) {
            $trabajardorhtml .='<span class="avatar avatar-sm avatar-rounded"> <img src="../assets/modulo/persona/perfil/'.$valor['foto_perfil'].'" alt="img" data-toggle="tooltip" data-placement="top" title="'.$valor['nombre_razonsocial'].'"> </span>';
          };

          $data[] = [

            'idincidencias'           => $value['idincidencias'],
            'idincidencia_categoria'  => $value['idincidencia_categoria'],
            'actividad'               => $value['actividad'],
            'actividad_detalle'       => $value['actividad_detalle'],
            'fecha_creacion'          => $value['fecha_creacion'],
            'fecha_fin'               => $value['fecha_fin'],
            'estado_revicion'         => $value['estado_revicion'],
            'estado'                  => $value['estado'],
            'trabadores'              => $trabadores['data'],
            'trabajadoreshtml'        => $trabajardorhtml
          ];
        }
    
        return $retorno = ['status' => true, 'message' => 'todo ok pe.', 'data' =>$data, 'affected_rows' =>$incidencias['affected_rows'],  ] ;



    }

    public function desactivar($id){
      $sql="UPDATE gasto_de_trabajador SET estado='0',user_trash= '$this->id_usr_sesion' WHERE idgasto_de_trabajador='$id'";
      $desactivar =  ejecutarConsulta($sql, 'U'); if ( $desactivar['status'] == false) {return $desactivar; }  

      return $desactivar;
    }

    public function eliminar($id) {
      $sql="DELETE FROM incidencias WHERE idincidencias='$id'";
      $eliminar =  ejecutarConsulta($sql); if ( $eliminar['status'] == false) {return $eliminar; }  
		  return $eliminar;
    }

    function listar_trabajador(){
      $sql = "SELECT pt.idpersona_trabajador, p.nombre_razonsocial 
      FROM persona_trabajador as pt
      inner JOIN persona as p on pt.idpersona=p.idpersona  WHERE pt.estado = 1 AND pt.estado_delete = 1;";
      return ejecutarConsultaArray($sql);
    }

    function mostrar_editar_gdt($id){
      $sql = "SELECT * FROM gasto_de_trabajador WHERE idgasto_de_trabajador = '$id'";
      return ejecutarConsultaSimpleFila($sql);
    }

    function categorias_incidencias(){

      $sql = "SELECT idincidencia_categoria,nombre FROM incidencia_categoria WHERE estado='1' and estado_delete= '1';";
      return ejecutarConsultaArray($sql);
      
    }

  }
?>