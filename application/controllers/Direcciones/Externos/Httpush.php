<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Httpush extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
		$fecha_ac = isset($_POST['timestamp']) ? $_POST['timestamp']:0;
		$row = null;
		$fecha_bd = $row['timestamp'];

		while( $fecha_bd <= $fecha_ac )
		{	
			$consulta = $this->Modelo_direccion->getAllEntradasbyTime($this->session->userdata('id_direccion'));
			usleep(100000);//anteriormente 10000
			clearstatcache();
			foreach ($consulta as $key) {
				$fecha_bd = strtotime($key->timestamp);
			}
			//$fecha_bd  = strtotime($ro['timestamp']);
	}

	$consulta = $this->Modelo_direccion->getAllEntradasbyTime($this->session->userdata('id_direccion'));
	foreach ($consulta as $row) {
				$fecha_bd = strtotime($row->timestamp);
				$ar["timestamp"] = strtotime($key->timestamp);	
				$ar["num_oficio"] 	= $row->num_oficio;	
				$ar["asunto"] = $row->asunto;	
				$ar["emisor"] = $row->emisor;	
			}

		
	$dato_json   = json_encode($ar);
	echo $dato_json;
	flush();

}

}

?>
