<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoContestados extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}


	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Oficios No Contestados';
		$data['nocontestados'] = $this -> Modelo_recepcion -> getAllNoContestados();
		$this->load->view('plantilla/header', $data);
		$this->load->view('admin/oficios/externos/nocontestados');
		$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file NoContestados.php */
/* Location: ./application/controllers/Admin/Oficios/Externos/NoContestados.php */