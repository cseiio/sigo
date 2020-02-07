<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelDeptos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this -> load -> model('Modelo_departamentos');
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
		$data['titulo'] = 'Panel de Departamentos';
		$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));

		//Proceso Externo
		 $data['conteoTotalext'] = $this->Modelo_departamentos->conteo_totalExt($this->session->userdata('id_area'));
		 $data['contestadosext'] = $this->Modelo_departamentos->contestadosExt($this->session->userdata('id_area'));
		 $data['pendientesext'] = $this->Modelo_departamentos->pendientesExt($this->session->userdata('id_area'));
		 $data['nocontestadosext'] = $this->Modelo_departamentos->nocontestadosExt($this->session->userdata('id_area'));
		 $data['fueratiempoext'] = $this->Modelo_departamentos->fuera_de_tiempoExt($this->session->userdata('id_area'));

		 // // Proceso Interno
		 $data['conteoTotalint'] = $this->Modelo_departamentos->conteo_totalInt($this->session->userdata('id_area'));
		 $data['emitidosint'] = $this->Modelo_departamentos->emitidosInt($this->session->userdata('area_trabajo'));
		 $data['contestadosint'] = $this->Modelo_departamentos->contestadosInt($this->session->userdata('id_area'));
		 $data['pendientesint'] = $this->Modelo_departamentos->pendientesInt($this->session->userdata('id_area'));
		 $data['nocontestadosint'] = $this->Modelo_departamentos->nocontestadosInt($this->session->userdata('id_area'));
		 $data['fueratiempoint'] = $this->Modelo_departamentos->fuera_de_tiempoInt($this->session->userdata('id_area'));

		$this->load->view('plantilla/header', $data);
		$this->load->view('deptos/index');
		$this->load->view('plantilla/footer');
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file DashboardDeptos.php */
/* Location: ./application/controllers/DashboardDeptos.php */