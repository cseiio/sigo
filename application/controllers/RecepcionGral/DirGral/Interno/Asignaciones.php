<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Asignaciones';
		$data['asignaciones'] = $this -> Modelo_direccion -> getAsignacionesInternas($this->session->userdata('id_direccion'));
		$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/internos/asignaciones');
		$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}  	
	}

	function eliminarAsignacion()
	{	
		$id = $this->uri->segment(5);
		$delete = $this->Modelo_direccion->eliminarAsignacionOfInternas($id);

		if($delete)
		{ 	
			$this->session->set_flashdata('exito', 'Se ha eliminado la asignación del oficio con éxito');
			redirect(base_url() . 'Direcciones/Interno/Asignaciones/');
		}	
	}

	function editarAsignacion()
	{
		//Validacion de los campos
		$this -> form_validation -> set_rules('id_asignacion','ID de asignación','required');
		$this -> form_validation -> set_rules('area_destino','Departamento','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Asignaciones';
			$data['asignaciones'] = $this -> Modelo_direccion -> getAsignacionesInternas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/asignaciones');
			$this->load->view('plantilla/footer');	 

		}
		else
		{
			$data =  array(
				$id_asignacion = $this-> input -> post('id_asignacion'),
				$area_destino = $this -> input -> post('area_destino')
			);
			//Modificar la informacion de asignacion del oficio
			$modificar = $this->Modelo_direccion->editarAsignacionInternas($id_asignacion,$area_destino);
			
			if ($modificar) {
				$this->session->set_flashdata('exito', 'Se ha editado la información de asignación con éxito');
				redirect(base_url() . 'Direcciones/Interno/Asignaciones/');
			}
			else
			{
			  $this->session->set_flashdata('error', 'No se pudo editar la asignación del oficio');
				redirect(base_url() . 'Direcciones/Interno/Asignaciones/');
			}
		}
		
	}


}

/* End of file Asgnaciones.php */
/* Location: ./application/controllers/Asgnaciones.php */