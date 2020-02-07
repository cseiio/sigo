<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contestados extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_planteles');
		$this->folder = './doctos/';
	}

	public function index()
	{
		
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Pendientes';
			$data['contestados'] = $this -> Modelo_planteles -> getAllContestados();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/contestados');
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

      function DescargarAnexos($name)
		{
			//$this->folder = './doctosanexos/';
			$data = file_get_contents(base_url().'doctosanexos/'.$name); 
        	force_download($name,$data); 
		}
			function DescargarRespuesta($name)
		{
			//$this->folder = './doctosrespuesta/';
			$data = file_get_contents(base_url().'doctosrespuesta/'.$name); 
        	force_download($name,$data); 
		}

}

/* End of file Contestados.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Contestados.php */