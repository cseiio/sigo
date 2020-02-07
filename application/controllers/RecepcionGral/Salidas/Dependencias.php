<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dependencias extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Administración de Dependencias';
			$data['dependencias'] = $this -> Modelo_recepcion -> getAllDependencias();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/dependencias');
			$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}


	public function AgregarDependencia()
	{
		$this -> form_validation -> set_rules('nombre_dependencia','Nombre Dependencia','required');
		$this -> form_validation -> set_rules('nombre_titular','Nombre de Titular','required');	
		$this -> form_validation -> set_rules('cargo_titular','Cargo','required');
		$this -> form_validation -> set_rules('direccion_dependencia','Dirección','required');
		$this -> form_validation -> set_rules('pagina_web','Página Web','required');
		
		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Administración de Dependencias';
			$data['dependencias'] = $this -> Modelo_recepcion -> getAllDependencias();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/dependencias');
			$this->load->view('plantilla/footer');		

		}
		else
		{
			$data =  array(

				$nombre_dependencia = $this -> input -> post('nombre_dependencia'),
				$nombre_titular = $this -> input -> post('nombre_titular'),
				$cargo_titular = $this -> input -> post('cargo_titular'),
				$direccion_dependencia = $this -> input -> post('direccion_dependencia'),
				$telefono = $this -> input -> post('telefono'),
				$email = $this -> input -> post('email'),
				$pagina_web = $this -> input -> post('pagina_web')
				
			);

			$agregar = $this->Modelo_recepcion->addDependencia($nombre_dependencia,$nombre_titular,$cargo_titular,$direccion_dependencia, $telefono, $email, $pagina_web);

			if($agregar)
			{ 	

				$this->session->set_flashdata('exito', 'La dependencia:  <strong>'.$nombre_dependencia. '</strong> se ha registrado correctamente');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
			}
			else
			{
				$this->session->set_flashdata('error', 'La dependencia: <strong> '.$nombre_dependencia. ' </strong> no se registró, verifique la información');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
			}
		}
	}

	public function ModificarDependencia()
	{
		$this -> form_validation -> set_rules('nombre_dependencia_a','Nombre Dependencia','required');
		$this -> form_validation -> set_rules('nombre_titular_a','Nombre de Titular','required');	
		$this -> form_validation -> set_rules('cargo_titular_a','Cargo','required');
		$this -> form_validation -> set_rules('direccion_dependencia_a','Dirección','required');
		$this -> form_validation -> set_rules('pagina_web_a','Página Web','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Administración de Dependencias';
			$data['dependencias'] = $this -> Modelo_recepcion -> getAllDependencias();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/dependencias');
			$this->load->view('plantilla/footer');	
		}
		else
		{
				$data =  array(

				$id_dependencia = $this -> input -> post('id_dependencia_a'),
				$nombre_dependencia = $this -> input -> post('nombre_dependencia_a'),
				$nombre_titular = $this -> input -> post('nombre_titular_a'),
				$cargo_titular = $this -> input -> post('cargo_titular_a'),
				$direccion_dependencia = $this -> input -> post('direccion_dependencia_a'),
				$telefono = $this -> input -> post('telefono_a'),
				$email = $this -> input -> post('email_a'),
				$pagina_web = $this -> input -> post('pagina_web_a')
				
			);

			$modificar = $this->Modelo_recepcion->updateDependencia($id_dependencia, $nombre_dependencia,$nombre_titular,$cargo_titular,$direccion_dependencia, $telefono, $email, $pagina_web);

			if($modificar)
			{ 	

				$this->session->set_flashdata('exito', 'La dependencia:  <strong>'.$nombre_dependencia. '</strong> se ha modificado correctamente');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
			}
			else
			{
				$this->session->set_flashdata('error', 'La dependencia: <strong> '.$nombre_dependencia. ' </strong> no se ha modificado correctamente, verifique la información');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
			}
		}
	}

	public function EliminarDependencia()
	{
		$id = $this->uri->segment(5);
		$delete = $this->Modelo_recepcion->deleteDependencia($id);

		if($delete)
		{ 	
			$this->session->set_flashdata('exito', 'Se ha eliminado la información de la dependencia con éxito');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
		}	
		else
		{
			$this->session->set_flashdata('error', 'No se pudo eliminar la información de la dependencia con éxito, verifique');
				redirect(base_url() . 'RecepcionGral/Salidas/Dependencias');
		}

	}


}

/* End of file Dependencias.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Dependencias.php */