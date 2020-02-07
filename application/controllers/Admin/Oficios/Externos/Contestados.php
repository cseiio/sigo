<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contestados extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Contestados';
			$data['contestados'] = $this -> Modelo_recepcion -> getAllContestados();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/oficios/externos/contestados');
			$this->load->view('plantilla/footer');	 	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file Contestados.php */ 
/* Location: ./application/controllers/Admin/Oficios/Externos/Contestados.php */