<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelInterno extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Panel Interno de Departamentos';
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('nombre'));
			$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
			$consulta = $this->Modelo_departamentos->getAllEntradasInternas($this->session->userdata('nombre'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if (!$key->status == 'Fuera de Tiempo') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}

			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/panelinterno');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file PanelInterno.php */
/* Location: ./application/controllers/Direcciones/Interno/PanelInterno.php */