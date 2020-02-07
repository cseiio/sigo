<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelEmpleados extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies
	}

	// List all your items
	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Gestión de Empleados';
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}


}

/* End of file Empleados.php */
/* Location: ./application/controllers/Admin/Empleados.php */
