<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelDirGral extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Panel de Dirección General';
		$this->load->view('plantilla/header', $data);
		$this->load->view('dirgral/index');
		$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}		
	}

}

/* End of file PanelDirGral.php */
/* Location: ./application/controllers/PanelDirGral.php */