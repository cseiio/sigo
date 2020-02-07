<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FueraDeTiempoEmitidos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Pendientes Emitidos';
			$data['fueratiempoemitidos'] = $this -> Modelo_direccion -> getAllFueraTiempoEmitidos('DIRECCIÓN GENERAL');
			$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();

			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");

			$consulta = $this->Modelo_direccion->getAllEntradasInternas('DIRECCIÓN GENERAL');
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}

			}

			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/dirgral/internos/fueradetiemposemitidos');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			
		}
	}

}

/* End of file FueraDeTiempoEmitidos.php */
/* Location: ./application/controllers/Direcciones/Interno/FueraDeTiempoEmitidos.php */