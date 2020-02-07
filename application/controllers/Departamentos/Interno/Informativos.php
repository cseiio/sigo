<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informativos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Oficios Informativos Internos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['informativos'] = $this->Modelo_departamentos->getAllInformativosRecepcionados($this->session->userdata('id_area'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/informativos');
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