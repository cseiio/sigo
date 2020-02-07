<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CopiasDeptos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Copias a Departamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['copias_deptos'] = $this -> Modelo_departamentos -> getBuzonDeCopiasDepto($this->session->userdata('area_trabajo'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/copiasdepto');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file CopiasDeptos.php */
/* Location: ./application/controllers/CopiasDeptos.php */