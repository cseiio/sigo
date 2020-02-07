<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelOfInternos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Panel de Oficios Externos';
			$data['entradas'] = $this -> Modelo_direccion -> getaAllBuzonDeOficiosEntrantes();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/oficios/internos/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file PanelOfInternos.php */
/* Location: ./application/controllers/Admin/Oficios/Internos/PanelOfInternos.php */