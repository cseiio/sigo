<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RespuestasEmitidos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
		$this -> load -> model('Modelo_direccion');
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {

			$data['titulo'] = 'Respuesta a Oficios Emitidos';
			$data['emitidos'] = $this -> Modelo_direccion -> getRespuestaAEmitidos('DIRECCIÓN GENERAL');
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/dirgral/internos/respuesta_emitidos');
			$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file RespuestasEmitidos.php */
/* Location: ./application/controllers/Direcciones/Interno/RespuestasEmitidos.php */