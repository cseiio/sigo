<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RespuestaDocentes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_planteles');
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './salidasplanteles/';
	}


	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Respuesta a Docentes';
			$data['res_salidas'] = $this -> Modelo_planteles -> getAllRespuestaDocentes($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/respuesta_docentes');
			$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

			function limpiar_num_oficio($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
      $string = str_replace(array('','"',"'",'/','select','insert','delete',',',';','.',':','_','{','}','[',']','´','^','`','~','!','|','°','¬','#','$','%','&','(',')','=','?','¡','*','+'),'-',$string
    );
 
 
    return $string;
}

	public function agregarRespuesta()
	{
		$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto_h','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
		$this -> form_validation -> set_rules('numoficio_salida','Oficio de Respuesta','required');

		if ($this->form_validation->run() == FALSE) {
			
			$data['titulo'] = 'Oficios de Docentes';
			$data['docentes'] = $this -> Modelo_planteles -> getAllOficiosDocentes($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/docentes');
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
				$cargo_receptor = $this -> input -> post('cargo_receptor_h'),
				$plantel_receptor = $this -> input -> post('plantel_receptor_h'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
				$area_trabajo = $this->session->userdata('area_trabajo'),
				$valor_doc  = $this -> input -> post('valor_doc'),
				$vigencia_doc  = $this -> input -> post('vigencia_doc'),
				$clasificacion_info = $this -> input -> post('clasificacion_info'),
				$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')

				);

			$oficio_salida = $this->limpiar_num_oficio($oficio_salida);

			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
			if (!empty($_FILES['ofrespuesta']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './respuestas_docentes/';
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
					$config['upload_path'] = './anexos_docentes/';
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
					$fecha_respuesta = date('Y-m-d');
					$hora_respuesta =  date("H:i:s");
					// Correo de la unidad central de correspondencia
					
			
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_planteles->agregarRespuestaDocentes($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $cargo_receptor, $plantel_receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);

					// Actualizar bandera de respuesta
					$this->Modelo_planteles->actualizarBanderaDocentes($id_oficio_recepcion);
					$this->Modelo_planteles->actualizarStatusContesadoDocentes($id_oficio_recepcion);
		
		
					if($agregar)
					{ 	
								

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}

				}
				//Si el usuario no carga el anexo el sistema le asignará uno por defecto, el cual es un pdf con la leyenda: "EL OFICIO NO TIENE ANEXOS"
				else
				{
      		 		//$respuesta = $_FILES['ofrespuesta']['name'];
					$anexos = 'default.pdf';

	//fecha y hora de recepcion se generan basado en el servidor 
					date_default_timezone_set('America/Mexico_City');
					$fecha_respuesta = date('Y-m-d');
					$hora_respuesta =  date("H:i:s");
			
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_planteles->agregarRespuestaDocentes($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $cargo_receptor, $plantel_receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);

					$this->Modelo_planteles->actualizarBanderaDocentes($id_oficio_recepcion);
					$this->Modelo_planteles->actualizarStatusContesadoDocentes($id_oficio_recepcion);
		

					if($agregar)
					{ 

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}

				}

			}
			else
			{
				$data['titulo'] = 'Oficios de Docentes';
			$data['docentes'] = $this -> Modelo_planteles -> getAllOficiosDocentes($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/docentes');
			$this->load->view('plantilla/footer');	
			}
		}

	}


	function DescargarAnexos($name)
	{
			//$this->folder = './doctosanexos/';
		$data = file_get_contents(base_url().'anexos_docentes/'.$name); 
		force_download($name,$data); 
	}
	function DescargarRespuesta($name)
	{
			//$this->folder = './doctosrespuesta/';
		$data = file_get_contents(base_url().'respuestas_docentes/'.$name); 
		force_download($name,$data); 
	}


}

/* End of file RespuestaDocentes.php */
/* Location: ./application/controllers/Direcciones/Externos/Planteles/RespuestaDocentes.php */