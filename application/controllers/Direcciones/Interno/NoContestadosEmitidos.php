<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoContestadosEmitidos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {

		$data['titulo'] = 'Oficios No Contestados';
		$data['nocontestadosemitidos'] = $this -> Modelo_direccion -> getAllNoContestadosEmitidos($this->session->userdata('area_trabajo'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/internos/nocontestadosemitidos');
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

/* End of file NoContestadosInterno.php */
/* Location: ./application/controllers/NoContestadosInterno.php */