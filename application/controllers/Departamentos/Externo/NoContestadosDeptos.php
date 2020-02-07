<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoContestadosDeptos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Oficios No Contestados';
		$data['nocontestados'] = $this -> Modelo_departamentos -> getAllNoContestados($this->session->userdata('id_area'));
		$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('deptos/externos/nocontestadosdeptos');
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