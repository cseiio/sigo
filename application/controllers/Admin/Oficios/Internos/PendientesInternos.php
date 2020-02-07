<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PendientesInternos extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Pendientes Internos';
		$data['pendientes'] = $this -> Modelo_direccion -> getFullPendientesInterno();
		$this->load->view('plantilla/header', $data);
		$this->load->view('admin/oficios/internos/pendientes');
		$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file PendientesInternos.php */
/* Location: ./application/controllers/Admin/Oficios/Internos/PendientesInternos.php */