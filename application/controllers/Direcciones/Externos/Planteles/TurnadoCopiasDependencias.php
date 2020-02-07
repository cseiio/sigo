<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TurnadoCopiasDependencias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_planteles');
		$this -> load -> model('Modelo_recepcion');
		$this -> load -> model('Modelo_direccion');
		$this->folder = './salidasplanteles/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Turnado de Copias a Dependencias';
		$data['copias'] = $this -> Modelo_planteles -> getAllCopiasADependencias();

		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/externos/planteles/copias_dependencias');
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

/* End of file TurnadoCopiasDependencias.php */
/* Location: ./application/controllers/Direcciones/Externos/Planteles/TurnadoCopiasDependencias.php */