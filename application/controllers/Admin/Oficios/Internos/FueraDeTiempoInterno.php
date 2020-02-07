<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FueraDeTiempoInterno extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}
	
	public function index()
	{
		if ($this->session->userdata('nombre')) {

		$data['titulo'] = 'Contestados Fuera de Tiempo';
		$data['fueratiempo'] = $this -> Modelo_direccion -> getFullFueraTiempoInternos();
		$this->load->view('plantilla/header', $data);
		$this->load->view('admin/oficios/internos/fueratiempo');
		$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file FueraDeTiempoInterno.php */
/* Location: ./application/controllers/Admin/Oficios/Internos/FueraDeTiempoInterno.php */