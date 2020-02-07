<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecepcionDeptos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_area'));
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this->Modelo_departamentos->getAllEntradas($this->session->userdata('id_area'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas('".$idoficio."')");
				}
				
			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/externos/recepciondeptos');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}   
	}

	public function agregarEntrada()
	{
		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('emisor','Emisor','required');
		$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_area'));

			$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/externos/recepciondeptos');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor = $this -> input -> post('emisor'),
				$direccion = $this -> input -> post('direccion'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias')
			);


			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctos/';
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
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_recepcion = date('Y-m-d');
				$hora_recepcion =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';
				
				$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias );

				if($agregar)
				{ 	

					

					$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
					redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
				}
				else
				{
					$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
					redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
				}
			}
		}

		public function ModificarOficio()
		{
		# code..

			$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
			$this -> form_validation -> set_rules('asunto_a','Asunto','required');
			$this -> form_validation -> set_rules('emisor_a','Emisor','required');
			$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_area'));

				$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

				$this->load->view('plantilla/header', $data);
				$this->load->view('deptos/externos/recepciondeptos');
				$this->load->view('plantilla/footer');	

			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$num_oficio = $this -> input -> post('num_oficio_a'),
					$asunto = $this -> input -> post('asunto_a'),
					$tipo_recepcion = $this -> input -> post('tipo_recepcion_a'),
					$tipo_documento = $this -> input -> post('tipo_documento_a'),
					$emisor = $this -> input -> post('emisor_a'),
					$direccion = $this -> input -> post('direccion_a'),
					$fecha_termino = $this -> input -> post('fecha_termino_a'),
					$status = $this -> input -> post('status_a'),
					$prioridad = $this -> input -> post('prioridad_a'),
					$observaciones = $this -> input -> post('observaciones_a'),
					$tipo_dias = $this -> input -> post('tipo_dias_a')
				);


				if (isset($_POST['btn_enviar_a']))
				{
			// Cargamos la libreria Upload
					$this->load->library('upload');

        //CARGANDO SLIDER
					if (!empty($_FILES['archivo_a']['name']))
					{
            // Configuración para el Archivo 1
						$config['upload_path'] = './doctos/';
						$config['allowed_types'] = 'pdf|docx';
						$config['remove_spaces']=FALSE;
						$config['max_size']    = '2048';
						$config['overwrite'] = TRUE;

						if ($config['allowed_types'] = 'pdf|PDF') {
							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
							$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'pdf';
							$archivo_actualizable = $pdf_formateado.'.'.'pdf';
						}
						else
							if ($config['allowed_types'] = 'docx|DOCX') {
								$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
								$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'docx';
								$archivo_actualizable = $pdf_formateado.'.'.'docx';
							}

            				// Cargamos la configuración del Archivo 1
							$this->upload->initialize($config);

           				 // Subimos archivo 1
							if ($this->upload->do_upload('archivo_a'))
							{
								$data = $this->upload->data();
							}
							else
							{
								$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
							}

						}

					}

					$actualizar = $this->Modelo_departamentos->modificarRegistro($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $status, $prioridad, $observaciones, $tipo_dias);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
						redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
					}

					else
					{
						$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
						redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
					}		
				}	
			}
			
			public function Descargar($name)
			{
				$data = file_get_contents(base_url().'doctos/'.$name); 
				force_download($name,$data); 
			}

			function DescargarAnexos($name)
			{
			//$this->folder = './doctosanexos/';
				$data = file_get_contents(base_url().'doctosanexos/'.$name); 
				force_download($name,$data); 
			}
			function DescargarRespuesta($name)
			{
			//$this->folder = './doctosrespuesta/';
				$data = file_get_contents(base_url().'doctosrespuesta/'.$name); 
				force_download($name,$data); 
			}

		 /* Cambia el estatus de recepcion cuando la fecha actual ha sobrepasado la fecha de termino del oficio
  
		      BEGIN
				DECLARE fecha_actual DATE default DATE_FORMAT(now(),'%Y-%m-%d');
				DECLARE termino DATE;
				DECLARE nuevo_estatus VARCHAR(90);

				SELECT fecha_termino from recepcion_oficios where id_recepcion = idcurso into termino;

				IF (fecha_actual > termino)
					THEN
						UPDATE recepcion_oficios as t SET t.`status`='No Contestado' where t.id_recepcion = idcurso;
					END IF;
					
			 END
     */
			 public function CambiaEstatus()
			 {
			 	$consulta = $this->Modelo_departamentos->getAllEntradas($this->session->userdata('id_area'));
			 	
			 	foreach ($consulta as $key) {
			 		$idoficio = $key->id_recepcion;

			 		if($this->db->query("CALL comparar_fechas('".$idoficio."')"))
			 		{
			 			echo 'Ejecutando Cambios';
			 		}else{
			 			show_error('Error! al ejecutar');
			 		}
			 	}

			 	redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
			 }

			 public function agregarRespuesta()
			 {
			 	$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
			 	$this -> form_validation -> set_rules('asunto_h','Asunto','required');
			 	$this -> form_validation -> set_rules('emisor_h','Emisor','required');
			 	$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
			 	$this -> form_validation -> set_rules('numoficio_salida','Oficio de Respuesta','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

			 	if ($this->form_validation->run() == FALSE) {
			# code...
			 		$data['titulo'] = 'Recepción de Oficios';
			 		$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_area'));

			 		$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
			
			 		$this->load->view('plantilla/header', $data);
			 		$this->load->view('deptos/externos/recepciondeptos');
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
			 			$fecha_respuesta_fisica = $this -> input -> post('fecha_res_fisica'),
			 			$hora_respuesta_fisica = $this -> input -> post('hora_res_fisica'),
			 			$valor_doc  = $this -> input -> post('valor_doc'),
			 			$vigencia_doc  = $this -> input -> post('vigencia_doc'),
			 			$clasificacion_info = $this -> input -> post('clasificacion_info'),
			 			$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')
			 		);

			 		$fecha= date('Y-m-d');
			 		if (isset($_POST['btn_enviar']))
			 		{
			// Cargamos la libreria Upload
			 			$this->load->library('upload');

        //CARGANDO SLIDER
			 			if (!empty($_FILES['ofrespuesta']['name']))
			 			{
            // Configuración para el Archivo 1
			 				$config['upload_path'] = './doctosrespuesta/';
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
			 				$config['upload_path'] = './doctosanexos/';
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

			 			
			 					
			 					if ($fecha_respuesta_fisica == $fecha_respuesta) {
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
			 						$agregar = $this->Modelo_departamentos->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_respuesta_fisica, $hora_respuesta_fisica, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					// Actualizar bandera de respuesta
			 						$this->Modelo_departamentos->actualizarBandera($id_oficio_recepcion);
					// Habiendo actualizado la bandera de respuesta, se debe validar lo siguiente:
					// 
					// si (respondido = 1)
					// 			si, entonces:
					//                 si (fecha_actual > fecha_recepcion)
					// 				 			si, entonces: Actualiza status: "Respondido Fuera de Tiempo"
					// 				 			si no: Oficio dentro de tiempo
					// 	si no
					// 		Oficio no respondido
					// 	-------------	AQUI TE QUEDASTE -------
			 						$fecha_r = $this->Modelo_departamentos->consultarFechaRecepcion($id_oficio_recepcion);
			 						foreach ($fecha_r as $key) {
			 							
			 							$fecha_termino_of = $key->fecha_termino;

			 							if ($fecha_respuesta_fisica > $fecha_termino_of) {
			 								$this->Modelo_departamentos->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
			 							}

			 							else
			 								if ($fecha_respuesta_fisica < $fecha_termino_of) {
			 									$this->Modelo_departamentos->actualizarStatusContesado($id_oficio_recepcion);
			 								}
			 								else
			 									if ($fecha_respuesta_fisica = $fecha_termino_of) {
			 										$this->Modelo_direccion->actualizarStatusContesado($id_oficio_recepcion);
			 									}

			 								}

			 								if($agregar)
					{ 				// Aqui se enviaria el correo para notificar al usuario correspondiente
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
						$this->email->to('dirgeneralcseiio@oaxaca.gob.mx');
						$this->email->subject('Oficio Repondido por Departamento');
						$this->email->message('<h2>Se ha respondido el oficio: '.$num_oficio. ' por un departamento, ingresa al sistema de control de oficios <a href="'.base_url().'">aquí</a> y revisa el panel de la "Unidad Central de Correspondencia" para mas información</h2><hr><br> Correo informativo libre de SPAM');
						$this->email->send();
					 //con esto podemos ver el resultado
						var_dump($this->email->print_debugger());

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recepcionado, verifique con el administrador');
					redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
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
				$flag_contestado = 1;
		// Estatus por defecto es : Pendiente
				if ($fecha_respuesta_fisica == $fecha_respuesta) {
				//Agrega las respuestas
					$agregar = $this->Modelo_departamentos->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_respuesta_fisica, $hora_respuesta_fisica, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
				//Actualiza la bandera de respuesta
					$this->Modelo_departamentos->actualizarBandera($id_oficio_recepcion);
				//Si las fecha de respuesta es mayor a la fecha de recepcion el status cambia a Fuera de tiempo 
				// Si la fecha de respuesta es menor a la fecha de termino el estatus cambia 
					$fecha_r = $this->Modelo_departamentos->consultarFechaRecepcion($id_oficio_recepcion);
					foreach ($fecha_r as $key) {
						
						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta_fisica > $fecha_termino_of) {
							$this->Modelo_departamentos->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta_fisica < $fecha_termino_of) {
								$this->Modelo_departamentos->actualizarStatusContesado($id_oficio_recepcion);
							}
							else
								if ($fecha_respuesta_fisica = $fecha_termino_of) {
									$this->Modelo_direccion->actualizarStatusContesado($id_oficio_recepcion);
								}

							}

							if($agregar)
							{ 	
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
								$this->email->to('dirgeneralcseiio@oaxaca.gob.mx');
								$this->email->subject('Oficio Repondido por Departamento');
								$this->email->message('<h2>Se ha respondido el oficio: '.$num_oficio. ' por un departamento, ingresa al sistema de control de oficios <a href="'.base_url().'">aquí</a> y revisa el panel de la "Unidad Central de Correspondencia" para mas información</h2><hr><br> Correo informativo libre de SPAM');
								$this->email->send();
					 //con esto podemos ver el resultado
								var_dump($this->email->print_debugger());
								
								$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong>'.$num_oficio. ' </strong> correctamente');
								redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
							}
							else
							{
								$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio:  <strong> '.$num_oficio. ' </strong> verifique la información');
								redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
							}

						}
						else
						{
							$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recepcionado, verifique con el administrador');
							redirect(base_url() . 'Departamentos/Externo/RecepcionDeptos/');
						}
					}
				
			}
			else
			{
				//En caso de no haber archivos en el formulario, envia un error a la vista ssad indicando que no hay archivos
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_area'));
				$this->load->view('plantilla/header', $data);
				$this->load->view('deptos/externos/recepciondeptos');
				$this->load->view('plantilla/footer');	
			}
		}

	}


}