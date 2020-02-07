<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelAccesos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies

	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Monitor de Accesos';
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/accesos/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file LogAccesos.php */
/* Location: ./application/controllers/Admin/LogAccesos.php */