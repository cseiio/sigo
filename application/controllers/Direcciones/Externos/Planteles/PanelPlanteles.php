<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelPlanteles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_planteles');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Panel de Planteles';
			
			
		// // //Oficios Externos
			$data['conteoTotalext'] = $this->Modelo_planteles->conteo_totalExt($this->session->userdata('id_direccion'));
		// // // Oficios Internos 
			$data['conteoTotalint'] = $this->Modelo_planteles->conteo_totalInt($this->session->userdata('id_direccion'));
			$data['emitidosint'] = $this->Modelo_planteles->emitidosInt($this->session->userdata('id_direccion'));
			$data['contestadosint'] = $this->Modelo_planteles->contestadosInt($this->session->userdata('id_direccion'));
			$data['pendientesint'] = $this->Modelo_planteles->pendientesInt($this->session->userdata('id_direccion'));
			$data['nocontestadosint'] = $this->Modelo_planteles->nocontestadosInt($this->session->userdata('id_direccion'));
			$data['fueratiempoint'] = $this->Modelo_planteles->fuera_de_tiempoInt($this->session->userdata('id_direccion'));
			

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file PanelPlanteles.php */
/* Location: ./application/controllers/Direcciones/Externos/Planteles/PanelPlanteles.php */