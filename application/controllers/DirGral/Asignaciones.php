<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_dirgral');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			
		$data['titulo'] = 'Asignaciones';
		$data['asignaciones'] = $this -> Model_dirgral -> getAsignaciones();
		$data['deptos'] = $this -> Model_dirgral -> getDeptos($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('dirgral/asignaciones');
		$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

		function eliminarAsignacion()
	{	
		$id = $this->uri->segment(4);
		$delete = $this->Model_dirgral->eliminarAsignacionOf($id);

		if($delete)
		{ 	
			$this->session->set_flashdata('exito', 'Se ha eliminado la asignación del oficio con éxito');
			redirect(base_url() . 'DirGral/Asignaciones/');
		}	
	}

	function editarAsignacion()
	{
		//Validacion de los campos
		$this -> form_validation -> set_rules('id_asignacion','ID de asignación','required');
		$this -> form_validation -> set_rules('direccion_a','Direccion','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Asignaciones';
			$data['asignaciones'] = $this -> Model_dirgral -> getAsignaciones($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Model_dirgral -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/asignaciones');
			$this->load->view('plantilla/footer');	 

		}
		else
		{
			$data =  array(
				$id_asignacion = $this-> input -> post('id_asignacion'),
				$area_destino = $this -> input -> post('direccion_a')
			);
			//Modificar la informacion de asignacion del oficio
			$modificar = $this->Model_dirgral->editarAsignacion($id_asignacion,$area_destino);
			
			if ($modificar) {
				$this->session->set_flashdata('exito', 'Se ha editado la información de asignación con éxito');
				redirect(base_url() . 'DirGral/Asignaciones/');
			}
			else
			{
			  $this->session->set_flashdata('error', 'No se pudo editar la asignación del oficio');
				redirect(base_url() . 'DirGral/Asignaciones/');
			}
		}
		
	}

	public function Descargar($name)
		{
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
		}


}

/* End of file Asignaciones.php */
/* Location: ./application/controllers/Asignaciones.php */