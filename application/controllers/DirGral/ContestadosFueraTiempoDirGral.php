<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContestadosFueraTiempoDirGral extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_dirgral');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			
		$data['titulo'] = 'Pendientes';
		$data['fueratiempo'] = $this -> Model_dirgral -> getAllFueraTiempo();
		$this->load->view('plantilla/header', $data);
		$this->load->view('dirgral/fueradetiempodir');
		$this->load->view('plantilla/footer');

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	public function Descargar($name)
	{
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
	}

}

/* End of file ContestadosFueraTiempoDirGral.php */
/* Location: ./application/controllers/ContestadosFueraTiempoDirGral.php */