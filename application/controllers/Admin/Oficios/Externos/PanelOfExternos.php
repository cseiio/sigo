<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelOfExternos extends CI_Controller {

function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Panel de Oficios Externos';
			//$data['directores'] = $this -> Model_admin-> getAllDirectoresArea();
			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/oficios/externos/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file PanelOfExternos.php */
/* Location: ./application/controllers/Admin/Oficios/Externos/PanelOfExternos.php */