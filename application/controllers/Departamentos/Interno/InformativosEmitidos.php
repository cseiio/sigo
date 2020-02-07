<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InformativosEmitidos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Oficios Informativos Internos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['informativos'] = $this->Modelo_departamentos->getAllInformativosInternos($this->session->userdata('area_trabajo'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/informativosemitidos');
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

/* End of file InformativosEmitidos.php */
/* Location: ./application/controllers/InformativosEmitidos.php */