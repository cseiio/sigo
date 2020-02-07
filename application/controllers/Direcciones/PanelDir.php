<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelDir extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Panel de Direcciones';
			
		//Proceso Externo
			$data['conteoTotalext'] = $this->Modelo_direccion->conteo_totalExt($this->session->userdata('id_direccion'));
			$data['contestadosext'] = $this->Modelo_direccion->contestadosExt($this->session->userdata('id_direccion'));
			$data['pendientesext'] = $this->Modelo_direccion->pendientesExt($this->session->userdata('id_direccion'));
			$data['nocontestadosext'] = $this->Modelo_direccion->nocontestadosExt($this->session->userdata('id_direccion'));
			$data['fueratiempoext'] = $this->Modelo_direccion->fuera_de_tiempoExt($this->session->userdata('id_direccion'));
		// // Proceso Interno
			$data['conteoTotalint'] = $this->Modelo_direccion->conteo_totalInt($this->session->userdata('id_direccion'));
			$data['emitidosint'] = $this->Modelo_direccion->emitidosInt($this->session->userdata('area_trabajo'));
			$data['contestadosint'] = $this->Modelo_direccion->contestadosInt($this->session->userdata('id_direccion'));
			$data['pendientesint'] = $this->Modelo_direccion->pendientesInt($this->session->userdata('id_direccion'));
			$data['nocontestadosint'] = $this->Modelo_direccion->nocontestadosInt($this->session->userdata('id_direccion'));
			$data['fueratiempoint'] = $this->Modelo_direccion->fuera_de_tiempoInt($this->session->userdata('id_direccion'));
			$data['totalsalientes'] = $this->Modelo_recepcion->total_salientes();
			//$data['contestadosDatos'] = $this ->Modelo_direccion-> getAllContestadosByFecha($fecha_hoy);
			

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

