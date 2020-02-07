<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Respuesta_salidas extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctossalida/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Respuestas a Oficios de Salida';
			$data['res_salidas'] = $this -> Modelo_recepcion -> getAllRespuestasASalidas();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/respuesta_salidas');
			$this->load->view('plantilla/footer');	 	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 	
	}

	public function agregarRespuesta()
	{
		$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto_h','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
		$this -> form_validation -> set_rules('numoficio_salida','Oficio de Respuesta','required');

		if ($this->form_validation->run() == FALSE) {
			
			$data['titulo'] = 'Oficios de Salida';
			$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/oficiossalida');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$id_oficio_recepcion = $this -> input -> post('txt_idoficio'),
				$num_oficio = $this -> input -> post('num_oficio_h'),
				$asunto = $this -> input -> post('asunto_h'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$oficio_salida = $this -> input -> post('numoficio_salida'),
				$emisor = $this -> input -> post('emisor_h'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia = $this -> input -> post('dependencia_h'),
				$receptor = $this -> input -> post('receptor_h'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
				$fecha_respuesta  = $this -> input -> post('fecha_dependencia'),
				$hora_respuesta = $this -> input -> post('hora_dependencia'),
				$valor_doc  = $this -> input -> post('valor_doc'),
				$vigencia_doc  = $this -> input -> post('vigencia_doc'),
				$clasificacion_info = $this -> input -> post('clasificacion_info'),
				$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')
				);

			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
			if (!empty($_FILES['ofrespuesta']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './respuesta_salidas/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
				    $config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_'.'Oficio_de_respuesta'.'_'.$num_oficio;
					
            				// Cargamos la configuración del Archivo 1
					$this->upload->initialize($config);

           				 // Subimos archivo 1
					if ($this->upload->do_upload('ofrespuesta'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}
					$respuesta = $this->upload->data('file_name');

				}


			    // CARGANDO ANEXOS
				if (!empty($_FILES['anexos']['name']))
				{
             // La configuración del Archivo 2, debe ser diferente del archivo 1
            // si configuras como el Archivo 1 no hará nada
					$config['upload_path'] = './anexos_salidas/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_'.'Anexos'.'_'.$num_oficio;
					
            // Cargamos la nueva configuración
					$this->upload->initialize($config);

            // Subimos el segundo Archivo
					if ($this->upload->do_upload('anexos'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}

					$anexos = $this->upload->data('file_name');

					//$respuesta = $_FILES['ofrespuesta']['name'];
					//$anexos = $_FILES['anexos']['name'];



	//fecha y hora de recepcion se generan basado en el servidor 
					date_default_timezone_set('America/Mexico_City');
					$fecha_subida = date('Y-m-d');
					$hora_subida =  date("H:i:s");
					// Correo de la unidad central de correspondencia
					
			
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_recepcion->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);

					$this->Modelo_recepcion->actualizarBandera($id_oficio_recepcion);

					$fecha_r = $this->Modelo_recepcion->consultarFechaEmision($id_oficio_recepcion);
					foreach ($fecha_r as $key) {

						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta > $fecha_termino_of) {
							$this->Modelo_recepcion->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta < $fecha_termino_of) {
								$this->Modelo_recepcion->actualizarStatusContesado($id_oficio_recepcion);
							}
							else
								if ($fecha_respuesta = $fecha_termino_of) {
									$this->Modelo_recepcion->actualizarStatusContesado($id_oficio_recepcion);
								}


							}

	
					if($agregar)
					{ 	
							//Cambiar bandera de respuesta	
						// $cambiar_estatus = this->Modelo_recepcion->cambiarEstatusSalida($id_oficio_recepcion);

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}

				}
				//Si el usuario no carga el anexo el sistema le asignará uno por defecto, el cual es un pdf con la leyenda: "EL OFICIO NO TIENE ANEXOS"
				else
				{
      		 		//$respuesta = $_FILES['ofrespuesta']['name'];
					$anexos = 'default.pdf';

	//fecha y hora de recepcion se generan basado en el servidor 
					date_default_timezone_set('America/Mexico_City');
					$fecha_subida = date('Y-m-d');
					$hora_subida =  date("H:i:s");
			
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_recepcion->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					
					$this->Modelo_recepcion->actualizarBandera($id_oficio_recepcion);
		
					$fecha_r = $this->Modelo_recepcion->consultarFechaEmision($id_oficio_recepcion);
					foreach ($fecha_r as $key) {

						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta > $fecha_termino_of) {
							$this->Modelo_recepcion->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta < $fecha_termino_of) {
								$this->Modelo_recepcion->actualizarStatusContesado($id_oficio_recepcion);
							}
							else
								if ($fecha_respuesta = $fecha_termino_of) {
									$this->Modelo_recepcion->actualizarStatusContesado($id_oficio_recepcion);
								}


							}

					if($agregar)
					{ 

						//Cambiar bandera de respuesta
					
						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}

				}

			}
			else
			{
				$data['titulo'] = 'Oficios de Salida';
				$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
				$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
				$this->load->view('plantilla/header', $data);
				$this->load->view('recepcion/salidas/oficiossalida');
				$this->load->view('plantilla/footer');	
			}
		}

	}
	//doctossalida
	public function Descargar($name)
	{
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
	}

	  function DescargarAnexos($name)
		{
			//$this->folder = './doctosanexos/';
			$data = file_get_contents(base_url().'anexos_salidas/'.$name); 
        	force_download($name,$data); 
		}
			function DescargarRespuesta($name)
		{
			//$this->folder = './doctosrespuesta/';
			$data = file_get_contents(base_url().'respuesta_salidas/'.$name); 
        	force_download($name,$data); 
		}

}

/* End of file Respuesta_salidas.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Respuesta_salidas.php */