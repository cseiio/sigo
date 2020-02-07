<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_departamentos');
	}
	
	public function index()
	{
		if ($this->session->userdata('nombre')) {

            //$data['inforecepcion'] = $this -> Modelo_recepcion-> getInfoDepartamento($this->session->userdata('id_area'));

			$data['titulo'] = 'Reportes';
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/oficios/externos/reportes');
			$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file Reportes.php */
/* Location: ./application/controllers/Admin/Oficios/Externos/Reportes.php */