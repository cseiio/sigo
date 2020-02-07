<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JefesDepto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		$this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Jefes de Departamento';
			$data['jefes'] = $this -> Model_admin-> getAllJefesDepto();
			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/jefesdepto');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}


	public function llenarComboDeptos()
	{
		$options="";
		if ($_POST["direccion_adsc"]== 1) 
		{
			$deptos = $this->Model_admin->getDeptosByIdDireccion(1);

			foreach ($deptos as $row){
				$options= '
				<option value='.$row->id_area.'>'.$row->nombre_area.'</option>
				';    
				echo $options; 
			}
		}
		if ($_POST["direccion_adsc"]==2) {
			$deptos = $this->Model_admin->getDeptosByIdDireccion(2);

			foreach ($deptos as $row){
				$options= '
				<option value='.$row->id_area.'>'.$row->nombre_area.'</option>
				';    
				echo $options;  
			}
		}

		if ($_POST["direccion_adsc"]==3) {
			$deptos = $this->Model_admin->getDeptosByIdDireccion(3);

			foreach ($deptos as $row){
				$options= '
				<option value='.$row->id_area.'>'.$row->nombre_area.'</option>
				';   
				echo $options;   
			}
		}


		if ($_POST["direccion_adsc"]==4) {
			$deptos = $this->Model_admin->getDeptosByIdDireccion(4);

			foreach ($deptos as $row){
				$options= '
				<option value='.$row->id_area.'>'.$row->nombre_area.'</option>
				';   
				echo $options;   
			}   
		}


		if ($_POST["direccion_adsc"]==7) {
			$deptos = $this->Model_admin->getDeptosByIdDireccion(7);

			foreach ($deptos as $row){
				$options= '
				<option value='.$row->id_area.'>'.$row->nombre_area.'</option>
				';   
				echo $options;   
			}  
		}


	}

	public function agregarJefeDepto()
	{
		$this -> form_validation -> set_rules('clave_area','Usuario','required');
		$this -> form_validation -> set_rules('nombre_completo','Nombre Completo','required');	
		$this -> form_validation -> set_rules('cargo_empleado','Cargo','required');
		$this -> form_validation -> set_rules('email','Email','required');
		$this -> form_validation -> set_rules('email_personal','Email Personal','required');


		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Jefes de Departamento';
			$data['jefes'] = $this -> Model_admin-> getAllJefesDepto();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/jefesdepto');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$clave_area = $this -> input -> post('clave_area'),
				$nombre_completo = $this -> input -> post('nombre_completo'),
				$direccion = $this -> input -> post('direccion'),
				$departamento_adsc = $this -> input -> post('departamento_adsc'),
				$cargo_empleado = $this -> input -> post('cargo_empleado'),
				$email = $this -> input -> post('email'),
				$email_personal = $this -> input -> post('email_personal')
				
			);

			
			$isDir =0;

			$consultar_clave = $this->Model_admin->getClaveArea($clave_area);
			foreach ($consultar_clave as $key) {
				$clave_consultada =  $key->clave_area;
			}

			if ($clave_consultada  != $clave_area) {
				$agregar = $this->Model_admin->addJefeDepto($clave_area,$nombre_completo,$direccion,$departamento_adsc, $cargo_empleado, $email, $email_personal, $isDir);

				if($agregar)
				{ 	


					$this->session->set_flashdata('exito', 'El empleado:  <strong>'.$nombre_completo. '</strong> se ha registrado correctamente');
					redirect(base_url() . 'Admin/Empleados/JefesDepto/');
				}
				else
				{
					$this->session->set_flashdata('error', 'El empleado: <strong> '.$nombre_completo. ' </strong> no se registró, verifique la información');
					redirect(base_url() . 'Admin/Empleados/JefesDepto');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'La clave de área:  <strong> '.$clave_area. '</strong> ya se encuentra registrada, intente con otra');
					redirect(base_url() . 'Admin/Empleados/JefesDepto');
			}
		}
	}




		public function modificarJefeDepto()
	{
		$this -> form_validation -> set_rules('clave_area_a','Usuario','required');
		$this -> form_validation -> set_rules('nombre_completo_a','Nombre Completo','required');	
		$this -> form_validation -> set_rules('cargo_empleado_a','Cargo','required');
		$this -> form_validation -> set_rules('email_a','Email','required');
		$this -> form_validation -> set_rules('email_personal_a','Email Personal','required');


		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Jefes de Departamento';
			$data['jefes'] = $this -> Model_admin-> getAllJefesDepto();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/jefesdepto');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$clave_area = $this -> input -> post('clave_area_a'),
				$nombre_completo = $this -> input -> post('nombre_completo_a'),
				$direccion = $this -> input -> post('direccion_a'),
				$departamento_adsc = $this -> input -> post('departamento_adsc_a'),
				$cargo_empleado = $this -> input -> post('cargo_empleado_a'),
				$email = $this -> input -> post('email_a'),
				$email_personal = $this -> input -> post('email_personal_a')
				
			);

			$isDir =0;

	
				$modificar = $this->Model_admin->updateJefeDepto($clave_area,$nombre_completo,$direccion,$departamento_adsc, $cargo_empleado, $email, $email_personal, $isDir);

				if($modificar)
				{ 	


					$this->session->set_flashdata('exito', 'El empleado:  '.$nombre_completo. ' ha sido modificada su información con éxito');
					redirect(base_url() . 'Admin/Empleados/JefesDepto/');
				}
				else
				{
					$this->session->set_flashdata('error', 'El empleado:  '.$nombre_completo. ' no se modifico, verifique');
					redirect(base_url() . 'Admin/Empleados/JefesDepto');
				}
			
			
		}
	}

	public function eliminarJefeDepto()
	{
		
		$id = $this->uri->segment(5);
		$delete = $this->Model_admin->deleteJefeDepto($id);

		if($delete)
		{ 	
			$this->session->set_flashdata('exito', 'Se ha eliminado la información del empleado con éxito');
				redirect(base_url() . 'Admin/Empleados/JefesDepto/');
		}	
		else
		{
			$this->session->set_flashdata('error', 'No se pudo eliminar la información del empleado, verifique');
				redirect(base_url() . 'Admin/Empleados/JefesDepto/');
		}


	}

}

/* End of file JefesDepto.php */
/* Location: ./application/controllers/Admin/Empleados/JefesDepto.php */