<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PendientesInternos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Pendientes Internos';
		$data['pendientes'] = $this -> Modelo_direccion -> getAllPendientesInternos($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/internos/pendientesdir');
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

/* End of file PendientesInternos.php */
/* Location: ./application/controllers/PendientesInternos.php */