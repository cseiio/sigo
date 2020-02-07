<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PendientesEmitidos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Panel de Departamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['pendientesemitidos'] = $this -> Modelo_departamentos -> getAllPendientesEmitidos($this->session->userdata('area_trabajo'));
			$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
			$consulta = $this->Modelo_departamentos->getAllEntradasInternas($this->session->userdata('area_trabajo'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if (!$key->status == 'Fuera de Tiempo') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}

			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/pendientesemitidos');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file PendientesEmitidos.php */
/* Location: ./application/controllers/PendientesEmitidos.php */