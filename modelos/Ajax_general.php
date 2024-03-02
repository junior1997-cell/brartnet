<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

Class Ajax_general
{
	//Implementamos nuestro variable global
  public $id_usr_sesion;

  //Implementamos nuestro constructor
  public function __construct($id_usr_sesion = 0)
  {
    $this->id_usr_sesion = $id_usr_sesion;
  } 

  // ══════════════════════════════════════ RENIEC JDL ══════════════════════════════════════
  public function datos_reniec_jdl($dni) { 

    $url = "https://dniruc.apisperu.com/api/v1/dni/".$dni."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imp1bmlvcmNlcmNhZG9AdXBldS5lZHUucGUifQ.bzpY1fZ7YvpHU5T83b9PoDxHPaoDYxPuuqMqvCwYqsM";
    
    $curl = curl_init();                              //  Iniciamos curl    
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );  // Desactivamos verificación SSL    
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );  // Devuelve respuesta aunque sea falsa    
    curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ] );// Especificamo los MIME-Type que son aceptables para la respuesta.    
    curl_setopt( $curl, CURLOPT_URL, $url );          // Establecemos la URL    
    $json = curl_exec( $curl );                       // Ejecutmos curl    
    curl_close( $curl );                              // Cerramos curl
    return json_decode( $json, true );
  }

  // ══════════════════════════════════════ RENIEC WFACX ══════════════════════════════════════
  public function datos_reniec_otro($ruc)	{ 
    $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
    $nndnii = $_GET['nrodni'];

    // Iniciar llamada a API
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $nndnii,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 2,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array( 'Referer: https://apis.net.pe/consulta-dni-api', 'Authorization: Bearer' . $token ),
    ));
    $response = curl_exec($curl); // Ejecutmos curl 
    curl_close($curl);            // Cerramos curl
    
    return json_decode($response);
  }

  // ══════════════════════════════════════ SUNAT JDL ══════════════════════════════════════
  public function datos_sunat_jdl($ruc)	{ 
    $url = "https://dniruc.apisperu.com/api/v1/ruc/".$ruc."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imp1bmlvcmNlcmNhZG9AdXBldS5lZHUucGUifQ.bzpY1fZ7YvpHU5T83b9PoDxHPaoDYxPuuqMqvCwYqsM";    
    $curl = curl_init();                              //  Iniciamos curl    
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );  // Desactivamos verificación SSL    
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );  // Devuelve respuesta aunque sea falsa    
    curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ] );// Especificamo los MIME-Type que son aceptables para la respuesta.    
    curl_setopt( $curl, CURLOPT_URL, $url );          // Establecemos la URL    
    $json = curl_exec( $curl );                       // Ejecutmos curl    
    curl_close( $curl );                              // Cerramos curl
    return json_decode( $json, true );
  }  

  // ══════════════════════════════════════ SUNAT WFACX ══════════════════════════════════════
  public function datos_sunat_otro($ruc)	{ 
    $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';  

    // Iniciar llamada a API
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $ruc,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Referer: https://apis.net.pe/api-ruc',
        'Authorization: Bearer' . $token
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // Datos listos para usar
    return json_decode($response);
  }

  // ══════════════════════════════════════ U S U A R I O - S E L E C T 2  ══════════════════════════════════════
	public function select2_usuario_trabajador($id)	{
    // $data = [];
		$sql="SELECT p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.numero_documento,p.foto_perfil, ct.nombre as cargo 
		FROM persona p 
		LEFT JOIN usuario u ON p.idpersona = u.idpersona 
		INNER JOIN cargo_trabajador ct ON p.idcargo_trabajador = ct.idcargo_trabajador
		WHERE p.idtipo_persona = '2' and p.estado = '1' AND p.estado_delete = '1' AND u.idpersona IS NULL;";
		$select_1 = ejecutarConsultaArray($sql);		

    if ( empty($id) ) {
      return $select_1;
    }else{

      $sql="SELECT p.idpersona, p.nombre_razonsocial, p.apellidos_nombrecomercial, p.numero_documento,p.foto_perfil, ct.nombre as cargo 
      FROM persona p 
      LEFT JOIN usuario u ON p.idpersona = u.idpersona 
      INNER JOIN cargo_trabajador ct ON p.idcargo_trabajador = ct.idcargo_trabajador
      WHERE p.idtipo_persona = '2' and p.estado = '1' AND p.estado_delete = '1' AND u.idusuario = '$id';";
      $select_2 = ejecutarConsultaSimpleFila($sql);

      $data = [
        'idpersona'                 =>$select_2['data']['idpersona'],
        'nombre_razonsocial'        =>$select_2['data']['nombre_razonsocial'],
        'apellidos_nombrecomercial' =>$select_2['data']['apellidos_nombrecomercial'],
        'numero_documento'          =>$select_2['data']['numero_documento'],
        'foto_perfil'               =>$select_2['data']['foto_perfil'],
        'cargo'                     =>$select_2['data']['cargo'],
      ];

      array_push( $select_1['data'], $data);
      
      return $retorno = ['status'=>true, 'mesage'=>'Todo bien', 'data'=>$select_1['data'], ]; 
    }
	}

}
