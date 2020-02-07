<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendientes extends CI_Controller {

function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Pendientes';
			$data['pendientes'] = $this -> Modelo_recepcion -> getAllPendientes();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/oficios/externos/pendientes');
			$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file Pendientes.php */
/* Location: ./application/controllers/Admin/Oficios/Externos/Pendientes.php */