<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelAdmin extends CI_Controller {


public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Administrador Inicio';

			$data['empleados_registrados'] = $this->Model_admin->total_empleados_registrados();
			$data['usuarios_registrados'] = $this->Model_admin->total_usuarios_en_alta();
			$data['accesos'] = $this->Model_admin->total_accesos_registrados();
			$data['externos'] = $this->Model_admin->total_oficios_externos();
			$data['internos'] = $this->Model_admin->total_oficios_internos();

			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/index');
			$this->load->view('plantilla/footer');
			}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}  
	}

}