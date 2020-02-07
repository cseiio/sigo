<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoContestadosDir extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {

		$data['titulo'] = 'Oficios No Contestados';
		$data['nocontestados'] = $this -> Modelo_direccion -> getAllNoContestados($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/externos/nocontestadosdir');
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

/* End of file NoContestados.php */
/* Location: ./application/controllers/NoContestados.php */