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
		$data['asignaciones'] = $this -> Modelo_direccion -> getAsignaciones($this->session->userdata('id_direccion'));
		$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/externos/asignaciones');
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
		$delete = $this->Modelo_direccion->eliminarAsignacionOf($id);

		if($delete)
		{ 	
			$this->session->set_flashdata('exito', 'Se ha eliminado la asignación del oficio con éxito');
			redirect(base_url() . 'Direcciones/Externos/Asignaciones/');
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
			$data['asignaciones'] = $this -> Modelo_direccion -> getAsignaciones($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/asignaciones');
			$this->load->view('plantilla/footer');	 

		}
		else
		{
			$data =  array(
				$id_asignacion = $this-> input -> post('id_asignacion'),
				$area_destino = $this -> input -> post('area_destino')
			);
			//Modificar la informacion de asignacion del oficio
			$modificar = $this->Modelo_direccion->editarAsignacion($id_asignacion,$area_destino);
			
			if ($modificar) {
				$this->session->set_flashdata('exito', 'Se ha editado la información de asignación con éxito');
				redirect(base_url() . 'Direcciones/Externos/Asignaciones/');
			}
			else
			{
			  $this->session->set_flashdata('error', 'No se pudo editar la asignación del oficio');
				redirect(base_url() . 'Direcciones/Externos/Asignaciones/');
			}
		}
		
	}


		public function emitirAlertas()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
				$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
				$this->load->view('plantilla/header', $data);
				$this->load->view('directores/externos/pendientesdir');
				$this->load->view('plantilla/footer');		
			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$mensaje = $this -> input -> post('mensaje')
				);

				// Aqui se enviaria el correo para notificar al usuario correspondiente
					// tomando los datos de sesion del emisor y os datos del recpetor del oficio 
					 //cargamos la libreria email de ci
				$this->load->library("email");

					 //configuracion para gmail - Servidor de correo homologado para el sistema
				$configGmail = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.gmail.com',
					'smtp_port' => 465,
					'smtp_user' => 'sgocseiiomail@gmail.com',
					'smtp_pass' => 'c53iI02018',
					'mailtype' => 'html',
					'charset' => 'utf-8',
					'newline' => "\r\n"
				);    

					 //cargamos la configuración para enviar con gmail
				$this->email->initialize($configGmail);

				$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
					 //
				$id_area = $this -> Modelo_direccion -> getAsignacionId($id);
				foreach ($id_area as $area) {
					$id_area = $area->id_area;
				}

				$correos = $this ->Modelo_direccion->obtenerCorreoDeptoByID($id, $id_area);
				foreach ($correos as $key) {
					 	# code...

					$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
					$this->email->cc($key->email_personal);

					$this->email->subject('Alerta de Oficio Pendiente');
					$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  ,pendiente por responder, con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
				}
				$this->email->send();
					 //con esto podemos ver el resultado
				var_dump($this->email->print_debugger());

				$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
				redirect(base_url() . 'Direcciones/Externos/PendientesDir/');

			}

		}

		public function emitirAlertasNC()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
				$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
				$this->load->view('plantilla/header', $data);
				$this->load->view('directores/externos/nocontestadosdir');
				$this->load->view('plantilla/footer');		
			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$mensaje = $this -> input -> post('mensaje')
				);

				// Aqui se enviaria el correo para notificar al usuario correspondiente
					// tomando los datos de sesion del emisor y os datos del recpetor del oficio 
					 //cargamos la libreria email de ci
				$this->load->library("email");

					 //configuracion para gmail - Servidor de correo homologado para el sistema
				$configGmail = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.gmail.com',
					'smtp_port' => 465,
					'smtp_user' => 'sgocseiiomail@gmail.com',
					'smtp_pass' => 'c53iI02018',
					'mailtype' => 'html',
					'charset' => 'utf-8',
					'newline' => "\r\n"
				);    

					 //cargamos la configuración para enviar con gmail
				$this->email->initialize($configGmail);

				$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
				$id_area = $this -> Modelo_direccion -> getAsignacionId($id);
				foreach ($id_area as $area) {
					$id_area = $area->id_area;
				}

				$correos = $this ->Modelo_direccion->obtenerCorreoDeptoByID($id, $id_area);
				foreach ($correos as $key) {
					 	# code...

					$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
					$this->email->cc($key->email_personal);

					$this->email->subject('Alerta de Oficio No Respondido');
					$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  ,el cuál no ha sido respondido, con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
				}
				$this->email->send();
					 //con esto podemos ver el resultado
				var_dump($this->email->print_debugger());

				$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
				redirect(base_url() . 'Direcciones/Externos/NoContestadosDir/');

			}

		}

}

/* End of file Asgnaciones.php */
/* Location: ./application/controllers/Asgnaciones.php */