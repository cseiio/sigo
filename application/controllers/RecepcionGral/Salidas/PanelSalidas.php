<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelSalidas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctossalida/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Oficios de Salida';
			$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$data['funcionarioscseiio'] = $this -> Modelo_recepcion-> getFuncionariosCseiio();
			$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			$data['nums_oficio'] = $this->Modelo_recepcion->getNumerosDeOficioUsados();	

			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this->Modelo_recepcion->getAllOficiosSalida();
			foreach ($consulta as $key) {
				$idoficio = $key->id_oficio_salida;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas_salidas('".$idoficio."')");
				}
				
			}

			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/oficiossalida');
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

	public function agregarEntrada()
	{
		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('emisor_principal','Emisor','required');
		$this -> form_validation -> set_rules('cargo','Cargo','required');
		$this -> form_validation -> set_rules('dependencia','Dependencia','required');
		$this -> form_validation -> set_rules('fun_emisor','Funcionario que emite','required');
		$this -> form_validation -> set_rules('remitente','Remitente','required');
		$this -> form_validation -> set_rules('cargo_remitente','Cargo Remitente','required');
		$this -> form_validation -> set_rules('dependencia_remitente','Dependencia Remitente','required');
		//$this -> form_validation -> set_rules('fecha_termino','Fecha de termino','required');
//fecha_termino
		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Oficios de Salida';
			$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$data['funcionarioscseiio'] = $this -> Modelo_recepcion-> getFuncionariosCseiio();
			$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/oficiossalida');
			$this->load->view('plantilla/footer');	
		}
		else
		{
			
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_emision = $this -> input -> post('tipo_emision'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor_principal = $this -> input -> post('emisor_principal'),
				$titular = $this -> input -> post('titular'),
				$dependencia = $this -> input -> post('dependencia'),	
				$fun_emisor = $this -> input -> post('fun_emisor'),
				$cargo = $this -> input -> post('cargo'),
				$remitente = $this -> input -> post('remitente'),
				$cargo_remitente = $this -> input -> post('cargo_remitente'),
				$dependencia_remitente = $this -> input -> post('dependencia_remitente'),
				$observaciones = $this -> input -> post('observaciones'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
				$requiere_respuesta = $this -> input -> post('ReqRespuesta'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				$fecha_emision = $this -> input -> post('fecha_emision_fisica'),
				$hora_emision = $this -> input -> post('hora_emision_fisica'),
				$fecha_acuse = $this -> input -> post('fecha_acuse'),
				$hora_acuse = $this -> input -> post('hora_acuse'),
				$valor_doc  = $this -> input -> post('valor_doc'),
				$vigencia_doc  = $this -> input -> post('vigencia_doc'),
				$clasificacion_info = $this -> input -> post('clasificacion_info'),
				$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')
			);

			$num_oficio = $this->limpiar_num_oficio($num_oficio);

			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctossalida/';
					$config['allowed_types'] = 'pdf|docx';
					$config['remove_spaces']=FALSE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;

					if ($config['allowed_types'] = 'pdf|PDF') {
						$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
						$_FILES['archivo']['name'] = $pdf_formateado.'.'.'pdf';
						$archivo_of = $pdf_formateado.'.'.'pdf';
					}
					else
						if ($config['allowed_types'] = 'docx|DOCX') {
							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
							$_FILES['archivo']['name'] = $pdf_formateado.'.'.'docx';
							$archivo_of = $pdf_formateado.'.'.'docx';
						}

            				// Cargamos la configuración del Archivo 1
						$this->upload->initialize($config);

           				 // Subimos archivo 1
						if ($this->upload->do_upload('archivo'))
						{
							$data = $this->upload->data();
						}
						else
						{
							$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
							redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_subida= date('Y-m-d');
				$hora_subida =  date("H:i:s");
				$flag_direccion = 1;
				$status = 'Pendiente';
		// Estatus por defecto es : Pendiente
				
				if (!$this->Modelo_recepcion->existeNumDeOficioSalida($num_oficio)) {

					if ($requiere_respuesta == 0) {
						$status = 'Informativo';
						$agregar = $this->Modelo_recepcion->agregarOficioSalida($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$titular, $dependencia,$fun_emisor,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo_of,  $observaciones, $codigo_archivistico,$requiere_respuesta, $fecha_termino, $status, $tipo_dias, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico );

					}
					else
						if($requiere_respuesta == 1)
						{
							$agregar = $this->Modelo_recepcion->agregarOficioSalida($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$titular, $dependencia,$fun_emisor,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo_of,  $observaciones, $codigo_archivistico,$requiere_respuesta, $fecha_termino, $status, $tipo_dias, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
						}

						if($agregar)
						{ 	

							$this->session->set_flashdata('exito', 'El número de oficio de salida:  '.$num_oficio. ' se ha ingresado correctamente');
							redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
						}
						else
						{
							$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
							redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$num_oficio.'</strong> que esta tratando de ingresar ya existe, verifique su información');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}
				}
			}

			public function ModificarOficio()
			{
		# code..

				$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
				$this -> form_validation -> set_rules('asunto','Asunto','required');
				$this -> form_validation -> set_rules('cargo','Cargo','required');
				$this -> form_validation -> set_rules('fun_emisor','Funcionario que emite','required');
				$this -> form_validation -> set_rules('remitente','Remitente','required');
				$this -> form_validation -> set_rules('cargo_remitente','Cargo Remitente','required');
				$this -> form_validation -> set_rules('dependencia_remitente','Dependencia Remitente','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Oficios de Salida';
					$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
					$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
					$data['funcionarioscseiio'] = $this -> Modelo_recepcion-> getFuncionariosCseiio();
					$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/salidas/oficiossalida');
					$this->load->view('plantilla/footer');	
				}
				else
				{

					$data =  array(
						$id =  $this -> input -> post('txt_idoficio'),
						$num_oficio = $this -> input -> post('num_oficio'),
						$asunto = $this -> input -> post('asunto'),
						$tipo_emision = $this -> input -> post('tipo_emision'),
						$tipo_documento = $this -> input -> post('tipo_documento'),	
						$fun_emisor = $this -> input -> post('fun_emisor'),
						$cargo = $this -> input -> post('cargo'),
						$remitente = $this -> input -> post('remitente'),
						$cargo_remitente = $this -> input -> post('cargo_remitente'),
						$dependencia_remitente = $this -> input -> post('dependencia_remitente'),
						$observaciones = $this -> input -> post('observaciones'),
						$fecha_acuse = $this -> input -> post('fecha_acuse_a'),
						$hora_acuse = $this -> input -> post('hora_acuse_a'),
						$codigo = $this -> input -> post('codigo_archivistico_a'),
						$valor_doc  = $this -> input -> post('valor_doc_a'),
						$vigencia_doc  = $this -> input -> post('vigencia_doc_a'),
						$clasificacion_info = $this -> input -> post('clasificacion_info_a'),
						$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico_a'),
						$ReqRespuesta_a = $this -> input -> post('ReqRespuesta_a'),
						$fecha_termino_a = $this -> input -> post('fecha_termino_a')
					);

					date_default_timezone_set('America/Mexico_City');
					$fecha_actual = date('Y-m-d');

					if ($ReqRespuesta_a == '0') {
						$status =  'Informativo';
						$bandera_respuesta = '0';
					}
					else
						if($fecha_termino_a > $fecha_actual)
						{
							$status =  'Pendiente';
							$bandera_respuesta = '1';
						}
						else
							if ($fecha_termino_a < $fecha_actual) {
								$status =  'No Contestado';
								$bandera_respuesta = '1';
							}
							else
								if ($fecha_termino_a == $fecha_actual) {
									$status =  'Pendiente';
									$bandera_respuesta = '1';
								}


					if (isset($_POST['btn_enviar']))
					{
			// Cargamos la libreria Upload
						$this->load->library('upload');

        //CARGANDO SLIDER
						if (!empty($_FILES['archivo']['name']))
						{
            // Configuración para el Archivo 1
							$config['upload_path'] = './doctossalida/';
							$config['allowed_types'] = 'pdf|docx';
							$config['remove_spaces']=FALSE;
							$config['max_size']    = '2048';
							$config['overwrite'] = TRUE;

							if ($config['allowed_types'] = 'pdf|PDF') {
								$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
								$_FILES['archivo']['name'] = $pdf_formateado.'.'.'pdf';
								$archivo_of = $pdf_formateado.'.'.'pdf';
							}
							else
								if ($config['allowed_types'] = 'docx|DOCX') {
									$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
									$_FILES['archivo']['name'] = $pdf_formateado.'.'.'docx';
									$archivo_of = $pdf_formateado.'.'.'docx';
								}

            				// Cargamos la configuración del Archivo 1
								$this->upload->initialize($config);

           				 // Subimos archivo 1
								if ($this->upload->do_upload('archivo'))
								{
									$data = $this->upload->data();
								}
								else
								{
									$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
									redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
								}

							}
							else
							{
								//Si el usuario no captura el archivo se debe de dejar el mismo que ya habia subido con anterioridad
								
								$consultarArchivoActual = $this->Modelo_recepcion->getArchivoActualSalida($id);
								foreach ($consultarArchivoActual as $key) {

									$archivo_of = $key->archivo;
								}	

							}

						}

						$actualizar = $this->Modelo_recepcion->modificarOficioSalida($id,$num_oficio,$asunto,$tipo_emision, $tipo_documento, $fun_emisor,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $observaciones, $fecha_acuse, $hora_acuse, $archivo_of, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
						if($actualizar)
						{ 	
							$this->session->set_flashdata('actualizado', 'El número de oficio de salida:  '.$num_oficio. ' fué modificado correctamente');
							redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
						}

						else
						{
							$this->session->set_flashdata('error_actualizacion', 'El número de oficio de salida:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
							redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
						}		
					}	

				}

				public function DescargarSalidas($name)
				{
					$data = file_get_contents($this->folder.$name); 
					force_download($name,$data); 
				}


				public function getNombreDependencia(){
					$keyword=$this->input->post('keyword');
					$data=$this->Modelo_recepcion->GetRow($keyword);        
					echo json_encode($data);
				}

				public function llenarInputFuncionarios()
				{
					$fun_emisor =  $_POST["fun_emisor"];
					if ($fun_emisor) 
					{
						$informacion = $this->Modelo_recepcion->getInfoEmpleados($fun_emisor);

						foreach ($informacion as $row){
							$options="<input name='cargo' class='form-control' value='".$row->descripcion."' required>"; 
							echo $options; 
						}
					}

				}

				public function llenarInputRemitente()
				{
					//Consulta el nombre de la dependencia en conjunto con los datos de 
					//la dependencia 
					$dependencia_remitente =  $_POST["dependencia_remitente"];
					if ($dependencia_remitente) 
					{
						$informacion = $this->Modelo_recepcion->getInfoDependencias($dependencia_remitente);

						foreach ($informacion as $row)
						{
							$options="<input name='remitente' class='form-control' value='".$row->titular."' required>"; 
							echo $options; 
						}
					}
				}

				public function llenarInputCargo()
				{
					//Consulta el nombre de la dependencia en conjunto con los datos de 
					//la dependencia 
					$dependencia_remitente =  $_POST["dependencia_remitente"];
					if ($dependencia_remitente) 
					{
						$informacion = $this->Modelo_recepcion->getInfoDependencias($dependencia_remitente);

						foreach ($informacion as $row)
						{
							$options="<input name='cargo_remitente' class='form-control' value='".$row->cargo."' required>"; 
							echo $options; 
						}
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
						$data['titulo'] = 'Oficios de Salida';
						$data['salidas'] = $this -> Modelo_recepcion -> getAllOficiosSalida();
						$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
						$data['funcionarioscseiio'] = $this -> Modelo_recepcion-> getFuncionariosCseiio();
						$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
						$this->load->view('plantilla/header', $data);
						$this->load->view('recepcion/salidas/oficiossalida');
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
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}
					else
					{
						$this->session->set_flashdata('error', 'La dependencia: <strong> '.$nombre_dependencia. ' </strong> no se registró, verifique la información');
						redirect(base_url() . 'RecepcionGral/Salidas/PanelSalidas');
					}
				}
			}

		}

		/* End of file PanelSalidas.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/PanelSalidas.php */