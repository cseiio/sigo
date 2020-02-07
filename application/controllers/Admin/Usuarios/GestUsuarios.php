<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GestUsuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies

	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Gestión de Usuarios';
			$data['usuarios'] = $this -> Model_admin-> getAllUsuarios();
			$data['usuarios_alta'] = $this -> Model_admin-> getUsuariosPorDarDeAlta();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/usuarios/gestusuarios');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	public function agregarUsuarios()
	{
		$this -> form_validation -> set_rules('empleado','Usuario','required');
		$this -> form_validation -> set_rules('password','Password','required');	
		$this -> form_validation -> set_rules('nivel','Nivel','required');


		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Gestión de Usuarios';
			$data['usuarios'] = $this -> Model_admin-> getAllUsuarios();
			$data['usuarios_alta'] = $this -> Model_admin-> getUsuariosPorDarDeAlta();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/usuarios/gestusuarios');
			$this->load->view('plantilla/footer');

		}
		else
		{
			$data =  array(
				$clave_area = $this -> input -> post('empleado'),
				$password = $this -> input -> post('password'),
				$nivel = $this -> input -> post('nivel')
				
			);

			$agregar = $this->Model_admin->addUsuario($clave_area,$password,$nivel);

			if($agregar)
			{ 	
				$actualizar_bandera_activado = $this->Model_admin->cambiarBanderaActivacion($clave_area);

				$this->session->set_flashdata('exito', 'El usuario:  <strong>'.$clave_area. '</strong> se ha dado de alta correctamente');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios/');
			}
			else
			{
				$this->session->set_flashdata('error', 'El usuario: <strong> '.$clave_area. ' </strong> no se dio de alta, verifique la información');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios');
			}
		}

	}

	public function modificarUsuario()
	{
		$this -> form_validation -> set_rules('clave_area','Usuario','required');
		$this -> form_validation -> set_rules('password','Password','required');	
		$this -> form_validation -> set_rules('nivel','Nivel','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Gestión de Usuarios';
			$data['usuarios'] = $this -> Model_admin-> getAllUsuarios();
			$data['usuarios_alta'] = $this -> Model_admin-> getUsuariosPorDarDeAlta();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/usuarios/gestusuarios');
			$this->load->view('plantilla/footer');

		}
		else
		{
			$data =  array(
				$clave_area = $this -> input -> post('clave_area'),
				$password = $this -> input -> post('password'),
				$nivel = $this -> input -> post('nivel')
				
			);

			$actualizar = $this->Model_admin->updateUsuario($clave_area,$password,$nivel);

			if($actualizar)
			{ 	
			

				$this->session->set_flashdata('exito', 'El usuario:  <strong>'.$clave_area. '</strong> se ha modificado correctamente.');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios/');
			}
			else
			{
				$this->session->set_flashdata('error', 'El usuario: <strong> '.$clave_area. ' </strong> no se ha modificado en su información.');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios');
			}
		}

	}


	public function bajaUsuarios()
	{
		
		$id = $this->uri->segment(5);
		$delete = $this->Model_admin->deleteUsuario($id);

		if($delete)
		{ 	

			$actualizar_bandera_desactivado = $this->Model_admin->cambiarBanderaBaja($id);

			$this->session->set_flashdata('exito', 'Se ha dado de baja al empleado con éxito');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios');
		}	
		else
		{
			$this->session->set_flashdata('error', 'No se pudo dar de baja al empleado, verifique');
				redirect(base_url() . 'Admin/Usuarios/GestUsuarios');
		}


	}

}

/* End of file GestUsuarios.php */
/* Location: ./application/controllers/Admin/Usuarios/GestUsuarios.php */