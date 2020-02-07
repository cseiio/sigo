<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelUsuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies

	}

	// List all your items
	public function index()
	{

		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Directores de Plantel';
			$data['planteles'] = $this -> Model_admin-> getAllDirectoresPlantel();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/usuarios/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	// Add a new item
	public function add()
	{

	}

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file Usuarios.php */
/* Location: ./application/controllers/Admin/Usuarios.php */
