<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContestadosInterno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Contestados';
		$data['contestados'] = $this -> Modelo_direccion -> getFullContestadosInternos();
		$this->load->view('plantilla/header', $data);
		$this->load->view('admin/oficios/internos/contestados');
		$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file ContestadosInterno.php */
/* Location: ./application/controllers/Admin/Oficios/Internos/ContestadosInterno.php */