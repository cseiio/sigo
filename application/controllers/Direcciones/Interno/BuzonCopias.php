<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuzonCopias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Buzon de Copias Recibidas';
			$data['buzon_oficios'] = $this -> Modelo_direccion -> getBuzonDeCopias($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/buzoncopias');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file BuzonCopias.php */
/* Location: ./application/controllers/BuzonCopias.php */