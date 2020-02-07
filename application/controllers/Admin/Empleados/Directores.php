<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directores extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Directores de Área';
			$data['directores'] = $this -> Model_admin-> getAllDirectoresArea();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/directores');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	public function EditarDirectorArea()
	{
		$this -> form_validation -> set_rules('nombre_empleado','Nombre Completo','required');
			$this -> form_validation -> set_rules('descripcion','Descripción','required');
			$this -> form_validation -> set_rules('email','Email','required');
			$this -> form_validation -> set_rules('email_personal','Email_personal','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Directores de Área';
				$data['directores'] = $this -> Model_admin-> getAllDirectoresArea();
				$this->load->view('plantilla/header', $data);
				$this->load->view('admin/empleados/directores');
				$this->load->view('plantilla/footer');	
			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('clave_area'),
					$nombre = $this -> input -> post('nombre_empleado'),
					$direccion = $this -> input -> post('direccion_a'),
					$descripcion = $this -> input -> post('descripcion'),
					$email = $this -> input -> post('email'),
					$email_personal = $this -> input -> post('email_personal')
				);

					$actualizar = $this->Model_admin->updateDirectorArea($id,$nombre,$direccion,$descripcion, $email, $email_personal);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El empleado:  '.$nombre. ' fué modificado correctamente');
						redirect(base_url() . 'Admin/Empleados/Directores/');
					}

					else
					{
						$this->session->set_flashdata('error_actualizacion', 'El empleado:  '.$nombre. ' no sufrió ningún cambio en su información, verifique');
						redirect(base_url() . 'Admin/Empleados/Directores/');
					}	
			}
	}

}

/* End of file Directores.php */
/* Location: ./application/controllers/Admin/Empleados/Directores.php */