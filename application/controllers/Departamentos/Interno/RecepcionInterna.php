<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RecepcionInterna extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Panel de Departamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('area_trabajo'));

			$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));
			
			$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();

			$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$consulta = $this->Modelo_departamentos->getAllEntradasInternas($this->session->userdata('area_trabajo'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if (!$key->status == 'Fuera de Tiempo') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}

			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/recepciondir');
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
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		//$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
			
			$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));
			
			$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();

			$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/recepciondir');
			$this->load->view('plantilla/footer');

		}
		else
		{
			
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor = $this -> input -> post('emisor_h'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia = $this -> input -> post('dependencia_h'),
				$direccion = $this -> input -> post('direccion'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				$reqRespuesta = $this -> input -> post('ReqRespuesta'),
				$fecha_recepcion = $this -> input -> post('fecha_emision_fisica'),
				$hora_recepcion = $this -> input -> post('hora_emision_fisica'),
				$fecha_acuse = $this -> input -> post('fecha_acuse'),
				$hora_acuse = $this -> input -> post('hora_acuse'),
				$tipo_inserccion =  $this -> input -> post('turnadoDirecto'),
				$departamento = $this -> input -> post('deptos_combo'),
				$area_trabajo = $this->session->userdata('area_trabajo'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
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
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosinternos/';
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
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_subida = date('Y-m-d');
				$hora_subida =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';

				if ($fecha_acuse < $fecha_subida) {
					$date1 = $fecha_subida;
					$date2 = $fecha_acuse;
					$diff = abs(strtotime($date2) - strtotime($date1));

					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					
						$observaciones = 'El oficio se ha subido  '.$days. ' día(s) después de su recepción';
					
					
				}

				/* VALIDAR EL TIPO DE INSERCIÓN DEPENDIENDO DEL TIPO DE ELECCIÓN 
				DE COPIA
					-  */
				if (!$this->Modelo_direccion->existeNumDeOficioDirInterno($num_oficio)) {
					
				
					if (isset($_POST['direccion']) and !isset($_POST['deptos'])) {

						//if ($fecha_acuse == $fecha_subida) {

							if ($reqRespuesta == 0) {
								$status = 'Informativo';

								foreach ($_POST['direccion'] as $indice => $valor){ 

									$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion

								foreach ($_POST['direccion'] as $indice => $valor){ 
									$correos = $this->Modelo_direccion->obtenerCorreoMultiple($valor);
									foreach ($correos as $key) {

										$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
										$this->email->to($key->email);
										$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

										$this->email->subject('Nuevo Oficio Interno');
										$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
										$this->email->send();
					 //con esto podemos ver el resultado
										var_dump($this->email->print_debugger());
									}

								}

								$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
							}
							else
								if ($reqRespuesta == 1) {
									foreach ($_POST['direccion'] as $indice => $valor){ 

										$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion

								foreach ($_POST['direccion'] as $indice => $valor){ 
									$correos = $this->Modelo_direccion->obtenerCorreoMultiple($valor);
									foreach ($correos as $key) {

										$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
										$this->email->to($key->email);
										$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

										$this->email->subject('Nuevo Oficio Interno');
										$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
										$this->email->send();
					 //con esto podemos ver el resultado
										var_dump($this->email->print_debugger());
									}

								}

								$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}

								}

						

						// }
						// else
						// {
						// 	$this->session->set_flashdata('error', 'El oficio debe subirse al sistema, el mismo día en que fue recibido físicamente por el area de destino.');
						// 	redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						// }
					}
					// INSERCCION INDIVIDUAL
					else
						if (isset($_POST['direccion']) and  isset($_POST['deptos'])) {
							//Se guarda en una variable los deptos seleccionados por el usuario
							$deptos_seleccionados = $_POST['deptos'];

							// if ($fecha_acuse == $fecha_subida) {
							
								if ($reqRespuesta == 0) {
								$status = 'Informativo';

								foreach ($_POST['direccion'] as $indice => $valor){ 

									$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
								}
							}
							else
								if ($reqRespuesta == 1) {
									foreach ($_POST['direccion'] as $indice => $valor){ 

										$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
									}

								}

								//se guarda en una variable, las direcciones leidas desde el formulario
									//$direccionesmarcadas = $_POST['direccion'];

									if($agregar)
									{ 	
										$consulta_ultimo_numoficio_insertado = $this->Modelo_direccion->ObtenerUltimoNumOficioOficioInterno();

										foreach ($consulta_ultimo_numoficio_insertado as $key) {
											$ultimo_num_oficio = $key->num_oficio;
										}

										//echo $ultimo_num_oficio."<br>";
										$direccionesmarcadas = $_POST['direccion'];
										$deptosmarcados = $_POST['deptos'];


										$ids_que_tienen_el_num_oficio_consultado = $this->Modelo_direccion->idsPorNumDeOficio($ultimo_num_oficio);

										foreach ($direccionesmarcadas as $dir) {

											$dirsindeptos = $this->Modelo_direccion->consultaSiTieneDeptos($dir);
											if (!$dirsindeptos) {

												foreach ($deptosmarcados as $depto) {

													$deptospordirs = $this->Modelo_direccion->deptosByIdDireccion($dir);
													foreach ($deptospordirs as $value) {

														if ($value->id_area == $depto) {

															foreach ($ids_que_tienen_el_num_oficio_consultado as $llave) {
																
																$asignar = $this->Modelo_direccion->asignarOficioInterno($dir,$depto,$llave->id_recepcion_int,$llave->observaciones, $llave->hora_subida, $llave->fecha_subida);

																$modificar_flag_depto = $this->Modelo_direccion->ModificarBanderaDeptosInt($llave->id_recepcion_int);

																break;
															}
														}					

													}

												}

											}

										}
									
					// Despues de agregar, debe consultar el ultimo id, insertado 
					// para realizar la asignacion directa
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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
										$correos = $this->Modelo_direccion->obtenerCorreoMultiple($id_direccion);
										foreach ($correos as $key) {

											$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
											$this->email->to($key->email);
											$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

											$this->email->subject('Nuevo Oficio Interno');
											$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
											$this->email->send();
					 //con esto podemos ver el resultado
											var_dump($this->email->print_debugger());
										}



										$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
									else
									{
										$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}

								// }
								// else
								// {
								// 	$this->session->set_flashdata('error', 'El oficio debe subirse al sistema, el mismo día en que fue recibido físicamente por el area de destino.');
								// 	redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								// }
							}
						}
						else
						{
							$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$num_oficio.'</strong> que esta tratando de ingresar ya existe, verifique su información');
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}	
					}
		}


	public function agregarEntrada_COPIA_DE_SEGURIDAD()
	{
		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
			$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/recepciondir');
			$this->load->view('plantilla/footer');

		}
		else
		{
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor = $this -> input -> post('emisor_h'),
				$direccion = $this -> input -> post('direccion'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia =  $this -> input -> post('dependencia_h'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				$correo = $this -> input -> post('email'),
				$correo_personal = $this -> input -> post('email_personal'),
				$reqRespuesta = $this -> input -> post('ReqRespuesta'),
				$fecha_recepcion = $this -> input -> post('fecha_emision_fisica'),
				$hora_recepcion = $this -> input -> post('hora_emision_fisica'),
				$fecha_acuse = $this -> input -> post('fecha_acuse'),
				$hora_acuse = $this -> input -> post('hora_acuse'),
				$tipo_inserccion =  $this -> input -> post('turnadoDirecto'),
				$departamento = $this -> input -> post('deptos_combo')
			);


			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosinternos/';
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
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_subida = date('Y-m-d');
				$hora_subida =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';

					/* VALIDAR EL TIPO DE INSERCIÓN DEPENDIENDO DEL TIPO DE ELECCIÓN 
				DE COPIA
					- Si el cliente ha seleccionado que desea turnar diractamente la copia a algun departamento, entonces, la inserciion debe de tomar la direccion directa y en automatico asignar el oficio al departamento

						Si el cliente, selecciona "NO" se ejecuta el proceso de asignacion mediante el uso del array de direcciones 

						Esta validacion debe de ser antes de comparar las fechas de acuse con la fecha de subida  */
						if (!$this->Modelo_departamentos->existeNumDeOficioDirInterno($num_oficio)) {
							
							if ($tipo_inserccion == 0) {

								if ($fecha_acuse == $fecha_subida) {

									if ($requiere_respuesta == 0) {
										$status = 'Informativo';

										foreach ($_POST['direccion'] as $indice => $valor){ 

											$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse);
										}
									}
									else
										if ($requiere_respuesta == 1) {
											foreach ($_POST['direccion'] as $indice => $valor){ 

												$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse);
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

										foreach ($_POST['direccion'] as $indice => $valor){ 
											$correos = $this->Modelo_direccion->obtenerCorreoMultiple($valor);
											foreach ($correos as $key) {

												$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
												$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
												$this->email->cc($key->email_personal);
												$this->email->subject('Nuevo Oficio Interno');
												$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
												$this->email->send();
					 //con esto podemos ver el resultado
												var_dump($this->email->print_debugger());
											}
										}
										$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
									else
									{
										$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
										$data['titulo'] = 'Recepción de Oficios';
										$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
										$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
										$this->load->view('plantilla/header', $data);
										$this->load->view('deptos/internos/recepciondir');
										$this->load->view('plantilla/footer');
										//redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}

								}
								else
								{
									$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recibido. Comuniquese con el administrador');
									redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								}
							}
							else
								if ($tipo_inserccion == 1) {
									if ($fecha_acuse == $fecha_subida) {
										$id_direccion = $_POST['dirinternos_single'];
				// METODO DE ENVIO MULTIPLE, SERVIDOR 

					//echo "indice: ".$indice." => ".$valor."<br>"; 
										$agregar = $this->Modelo_departamentos->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $id_direccion, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse);

										if($agregar)
										{ 	
											$consulta_ultimo_id_insertado = $this->Modelo_departamentos->ObtenerUltimoIDOficioInterno();

											foreach ($consulta_ultimo_id_insertado as $key) {
												$id_oficio_recepcion = $key->id_recepcion_int;

												$asignar = $this->Modelo_direccion->asignarOficioInterno($id_direccion,$departamento,$id_oficio_recepcion,$observaciones, $hora_subida, $fecha_subida);

												$this->Modelo_direccion->ModificarBanderaDeptosInt($id_oficio_recepcion);
											}
					// Despues de agregar, debe consultar el ultimo id, insertado 
					// para realizar la asignacion directa
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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
											$correos = $this->Modelo_direccion->obtenerCorreoMultiple($id_direccion);
											foreach ($correos as $key) {

												$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
												$this->email->to($key->email);
												$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

												$this->email->subject('Nuevo Oficio Interno');
												$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
												$this->email->send();
					 //con esto podemos ver el resultado
												var_dump($this->email->print_debugger());
											}



											$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}
										else
										{
											$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}

									}
									else
									{
										$this->session->set_flashdata('error', 'El oficio debe subirse al sistema, el mismo día en que fue recibido físicamente por el area de destino.');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
								}
							}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$num_oficio.'</strong> que esta tratando de ingresar ya existe, verifique su información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}	
							
						}
					}

		public function Descargar($name)
		{
			$data = file_get_contents($this->folder.$name); 
			force_download($name,$data); 
		}




		public function ModificarOficio()
		{
		# code..

			$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
			$this -> form_validation -> set_rules('asunto_a','Asunto','required');
			$this -> form_validation -> set_rules('emisor_h','Emisor','required');
			//$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('deptos/internos/recepciondir');
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
					$emisor = $this -> input -> post('emisor_h'),
					$direccion = $this -> input -> post('direccion_a'),
					$fecha_termino = $this -> input -> post('fecha_termino_a'),
					$status = $this -> input -> post('status_a'),
					$prioridad = $this -> input -> post('prioridad_a'),
					$observaciones = $this -> input -> post('observaciones_a'),
					$tipo_dias = $this -> input -> post('tipo_dias_a'),
					$codigo_archivistico = $this -> input -> post('codigo_archivistico_a'), 
					$valor_doc = $this -> input -> post('valor_doc_a'), 
					$vigencia_doc = $this -> input -> post('vigencia_doc_a'), 
					$clasificacion_info = $this -> input -> post('clasificacion_info_a'), 
					$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico_a'),
					$area_trabajo = $this -> input -> post('area_trabajo'),
					$requiereRespuesta =  $this -> input -> post('ReqRespuesta_a')
				);



				date_default_timezone_set('America/Mexico_City');
				$fecha_actual = date('Y-m-d');

					if ($requiereRespuesta == '0') {
						$status =  'Informativo';
						$bandera_respuesta = '0';
					}
					else
						if($fecha_termino > $fecha_actual)
						{
							$status =  'Pendiente';
							$bandera_respuesta = '1';
						}
						else
							if ($fecha_termino < $fecha_actual) {
								$status =  'No Contestado';
								$bandera_respuesta = '1';
							}
							else
								if ($fecha_termino == $fecha_actual) {
									$status =  'Pendiente';
									$bandera_respuesta = '1';
								}
								


				$dirconsultadas =  array();
				$deptosconsultados = array();
				$direccionesFormulario = array();
				$deptosFormulario = array();

				if(isset($_POST['direccion_a'])){

				if (isset($_POST['btn_enviar_a']))
				{
			// Cargamos la libreria Upload
					$this->load->library('upload');

        //CARGANDO SLIDER
					if (!empty($_FILES['archivo']['name']))
					{
            // Configuración para el Archivo 1
						$config['upload_path'] = './doctosinternos/';
						$config['allowed_types'] = 'pdf|docx';
						$config['remove_spaces']=FALSE;
						$config['max_size']    = '2048';
						$config['overwrite'] = TRUE;

						if ($config['allowed_types'] = 'pdf|PDF') {
							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
							$_FILES['archivo']['name'] = $pdf_formateado.'.'.'pdf';
							$archivo_actualizable = $pdf_formateado.'.'.'pdf';
						}
						else
							if ($config['allowed_types'] = 'docx|DOCX') {
								$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
								$_FILES['archivo']['name'] = $pdf_formateado.'.'.'docx';
								$archivo_actualizable = $pdf_formateado.'.'.'docx';
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
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}

						}
							else
							{
								//Si el usuario no captura el archivo se debe de dejar el mismo que ya habia subido con anterioridad
								
								$consultarArchivoInternoActual= $this->Modelo_direccion->getArchivoInternoActual($id);
								foreach ($consultarArchivoInternoActual as $key) {

									$archivo_actualizable = $key->archivo_oficio;
								}

							}

					}

					//Consultar las direcciones guardadas con el num de oficio que viene del formulario y guardarlo en un arreglo
					$this -> load -> model('Modelo_direccion');
					$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
					foreach ($direcciones as $key) {
				
						$direccion_destinobd = $key->direccion_destino;
						array_push($dirconsultadas, $direccion_destinobd);

					}
					// Consultar los departamentos que tienen asignados el oficio y guardarlos en un arreglo
					$this -> load -> model('Modelo_direccion');
					$deptosasignados = $this->Modelo_direccion->getAllAsignacionesInternas($id);
					foreach ($deptosasignados as $key) {

						$deptos_asignadosbd = $key->id_area;
						array_push($deptosconsultados, $deptos_asignadosbd);

					}

					//Obtener las direcciones y los departamentos que estan marcados en el formulario, se guardan mediante una variable
					
					$direccionesFormulario = $_POST['direccion_a'];
					$deptosFormulario = $_POST['deptos'];

					//Obtener el tamaño del arreglo de direcciones y departamentos consultados de la base de datos y el tamaño de las direcciones y departamentos que vienen del formulario
					
					$num_dirs_en_bd = sizeof($dirconsultadas);
					$num_dirs_en_formulario = sizeof($direccionesFormulario);

					$num_deptos_en_bd = sizeof($deptosconsultados);
					$num_deptos_en_formulario = sizeof($deptosFormulario);

		//CASO 1: EL USUARIO NO AGREGO, NI QUITÓ DEL LOS CHECKBOXES ALGUNA DIRECCIÓN O DEPARTAMENTO
					if ($num_dirs_en_bd == $num_dirs_en_formulario AND $num_deptos_en_bd == $num_deptos_en_formulario) {

						$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);

						if ($num_deptos_en_formulario == 1) {
							// $this->session->set_flashdata('actualizado', 'se detectaron: '.$num_deptos_en_formulario);
							// redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							foreach ($direcciones as $key) {

								foreach ($direccionesFormulario as $dir) {

									$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $dir, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);

									foreach($deptosFormulario as $depto) { 
										$consultarIDAsignacionActual = $this->Modelo_direccion->getIdAsignacionByDepto($key->id_recepcion_int);
										
										foreach($consultarIDAsignacionActual as $id_obtenido) { 
												$id = $id_obtenido->id_asignacion_int;
											$actualizar = $this->Modelo_direccion->editarAsignacionInternasConDir($id_obtenido->id_asignacion_int,$dir,$depto);
											break;

											
										}
										
									}

								}
							}

			
							if($actualizar)
							{ 	
								// $this->session->set_flashdata('actualizado', 'Actualizando asignacion: '.$id.' '.$dir.' '.$depto);
								// redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
							else
							{
								$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
						}
						else
						{

							# ACTUALIZAR DIRECCIONES Y DEPARTAMENTOS
							foreach ($direcciones as $key) {
								foreach ($direccionesFormulario as $dir) {
									$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $dir, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
								}
							}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
							if($actualizar)
							{ 	
								$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
							else
							{
								$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}

						}

							

						}

						
				
		//CASO 2: EL USUARIO AGREGO UNA O VARIAS DIRECCIONES, NO AGREGÓ NUEVOS DEPARTAMENTOS
					else
						if($num_dirs_en_bd < $num_dirs_en_formulario AND $num_deptos_en_bd == $num_deptos_en_formulario)
						{
							//echo "Se detectaron una o varias direcciones por agregar, los departamentos asignados son los mismos: "."<br>";

							foreach ($direccionesFormulario as $value2) {
								$encontrado=false;
								foreach ($dirconsultadas as $value1) {
									if ($value1 == $value2){
										$encontrado=true;
										$break;
									}
								}
								if ($encontrado == false){
									//echo "Agregando Dirs: ---> $value2<br>\n";
									$query = $this->Modelo_direccion->getAllsByNumOficioLimitado1($num_oficio);
									foreach ($query as $valor) {

										$agregar = $this->Modelo_direccion->insertarEntrada($valor->num_oficio,$valor->fecha_emision,$valor->hora_recepcion,$valor->asunto,$valor->tipo_recepcion, $valor->tipo_documento, $valor->emisor, $valor->cargo, $valor->dependencia, $value2, $valor->fecha_termino, $valor->archivo_oficio, $valor->status, $valor->prioridad, $valor->observaciones,$valor->flag_direciones,$valor->tipo_dias, $valor->tieneRespuesta, $valor->fecha_subida, $valor->hora_subida, $valor->fecha_acuse, $valor->hora_acuse, $valor->area_trabajo, $valor->num_oficio, $valor->codigo_archivistico, $valor->valor_doc, $valor->vigencia_doc, $valor->clasificacion_info, $valor->tipo_doc_archivistico);
								

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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
											$correos = $this->Modelo_direccion->obtenerCorreoMultiple($value2);
											foreach ($correos as $key) {

												$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
												$this->email->to($key->email);
												$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

												$this->email->subject('Nuevo Oficio Interno');
												$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
												$this->email->send();
					 //con esto podemos ver el resultado
												var_dump($this->email->print_debugger());
											}

									}

									$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
									foreach ($direcciones as $key) {

										$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
									}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
									if($actualizar)
									{ 	
										$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
									else
									{
										$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}

								}
							}
						}
					}
			//CASO 3: EL USUARIO AGREGO UNO O VARIOS DEPARTAMENTOS, PERO NO AGREGO NINGUNA DIRECCIÓN
			else
				if($num_dirs_en_bd == $num_dirs_en_formulario AND $num_deptos_en_bd < $num_deptos_en_formulario){
					//echo "Se detectaron uno o varios departamentos por asignar, las direcciones son las mismas: "."<br>";
					foreach ($deptosFormulario as $value2) {
						$encontrado=false;
						foreach ($deptosconsultados as $value1) {
							if ($value1 == $value2){
								$encontrado=true;
								$break;
							}
						}
						if ($encontrado == false){
							//echo "Agregando Deptos: ---> $value2<br>\n";
							
							$ids_que_tienen_el_num_oficio_consultado = $this->Modelo_direccion->idsPorNumDeOficio($num_oficio);

							//Consultar la direccion del nuevo departamento a agregar

										$direcciondeldeptoaagregar = $this->Modelo_direccion->direccionDelDeptoAsignar($value2);

										foreach ($direcciondeldeptoaagregar as $value) {

												foreach ($ids_que_tienen_el_num_oficio_consultado as $llave) {

													$asignar = $this->Modelo_direccion->asignarOficioInterno($value->direccion,$value2,$llave->id_recepcion_int,$llave->observaciones, $llave->hora_subida, $llave->fecha_subida);
													break;
											}					
									}

								$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
									foreach ($direcciones as $key) {

										$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
									}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
									if($actualizar)
									{ 	
										$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
									else
									{
										$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
						}
					}
				}
				// CASO 4: EL USUARIO AGREGÓ DIRECCIONES Y DEPARTAMENTOS 
				else
					if($num_dirs_en_bd < $num_dirs_en_formulario AND $num_deptos_en_bd < $num_deptos_en_formulario)
					{
						//echo "Se detectaron uno o varias direcciones, al igual que departamentos por asignar"."<br>";

						//AGREGANDO DIRECCIONES
						foreach ($direccionesFormulario as $value2) {
							$encontrado=false;
							foreach ($dirconsultadas as $value1) {
								if ($value1 == $value2){
									$encontrado=true;
									$break;
								}
							}
							if ($encontrado == false){
									//echo "Agregando Dirs: ---> $value2<br>\n";
								$query = $this->Modelo_direccion->getAllsByNumOficioLimitado1($num_oficio);
								foreach ($query as $valor) {

									$agregar = $this->Modelo_direccion->insertarEntrada($valor->num_oficio,$valor->fecha_emision,$valor->hora_recepcion,$valor->asunto,$valor->tipo_recepcion, $valor->tipo_documento, $valor->emisor, $valor->cargo, $valor->dependencia, $value2, $valor->fecha_termino, $valor->archivo_oficio, $valor->status, $valor->prioridad, $valor->observaciones,$valor->flag_direciones,$valor->tipo_dias, $valor->tieneRespuesta, $valor->fecha_subida, $valor->hora_subida, $valor->fecha_acuse, $valor->hora_acuse, $valor->area_trabajo, $valor->num_oficio, $valor->codigo_archivistico, $valor->valor_doc, $valor->vigencia_doc, $valor->clasificacion_info, $valor->tipo_doc_archivistico);


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


					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
										$correos = $this->Modelo_direccion->obtenerCorreoMultiple($value2);
										foreach ($correos as $key) {

											$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
											$this->email->to($key->email);
											$this->email->cc($key->email_personal);

					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 

											$this->email->subject('Nuevo Oficio Interno');
											$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
											$this->email->send();
					 //con esto podemos ver el resultado
											var_dump($this->email->print_debugger());
										}

									}



								}
							}
						}
						// AGREGANDO DEPARTAMENTOS
						foreach ($deptosFormulario as $value2) {
							$encontrado=false;
							foreach ($deptosconsultados as $value1) {
								if ($value1 == $value2){
									$encontrado=true;
									$break;
								}
							}
							if ($encontrado == false){
							//echo "Agregando Deptos: ---> $value2<br>\n";

								$ids_que_tienen_el_num_oficio_consultado = $this->Modelo_direccion->idsPorNumDeOficio($num_oficio);

							//Consultar la direccion del nuevo departamento a agregar

								$direcciondeldeptoaagregar = $this->Modelo_direccion->direccionDelDeptoAsignar($value2);

								foreach ($direcciondeldeptoaagregar as $value) {

									foreach ($ids_que_tienen_el_num_oficio_consultado as $llave) {

										$asignar = $this->Modelo_direccion->asignarOficioInterno($value->direccion,$value2,$llave->id_recepcion_int,$llave->observaciones, $llave->hora_subida, $llave->fecha_subida);
										break;
									}					
								}

							}
						}

						$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
						foreach ($direcciones as $key) {

							$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
						}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
						if($actualizar)
						{ 	
							$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}
						else
						{
							$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}
					}

/// ELIMINACIONES 
/// 					CASO 1: ELIMINACIÓN DE DIRECCIONES CUANDO NO HAY DEPARTAMENTOS PRESENTES 								EN EL FORMULARIO
						else
						if($num_dirs_en_bd > $num_dirs_en_formulario AND $num_deptos_en_formulario == 0){

							//echo "Se detectaron uno o varios departamentos que ya no seleccionaron, los direcciones asignadas son los mismas"."<br>";

							foreach ($dirconsultadas as $dirbd) {
									$encontrado=false;
									foreach ($direccionesFormulario as $dirform) {
										if ($dirbd == $dirform){
											$encontrado=true;
											$break;
										}
									}
									if ($encontrado == false){
										//echo "Quitando la dirección: ---> $dirbd<br>\n";
										$eliminarDireccion = $this->Modelo_direccion->eliminarDirCuandoNoHayDeptos($id,$dirbd);

									}
						  		}

						  		if ($eliminarDireccion) {
						  			
						  			$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
						  			foreach ($direcciones as $key) {

						  				$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
						  			}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
						  			if($actualizar)
						  			{ 	
						  				$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
						  				redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						  			}
						  			else
						  			{
						  				$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
						  				redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						  			}
						  		}
						  		else
						  			{
						  				$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
						  				redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						  			}
						}

					// ELIMINACIONES
					// CASO 2: ELIMINACIÓN DE TODOS LOS DEPARTAMENTOS CUANDO LAS DIRECCIONES NO SE MODIFICAN 
					else
						if($num_deptos_en_formulario == 0){

							//echo "Se detectaron uno o varios departamentos que ya no seleccionaron, los direcciones asignadas son los mismas"."<br>";

							foreach ($deptosconsultados as $value1) {
								$encontrado=false;
										
								if ($encontrado == false){
									//echo "Quitando el depto: ---> $value1<br>\n";
									$eliminarDepto = $this->Modelo_direccion->eliminarDeptoCuandoSeModificanDirs($id,$value1);
								}
							}

							if ($eliminarDepto) {
								$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
								foreach ($direcciones as $key) {

									$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
								}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
								if($actualizar)
								{ 	
									$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
									redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								}
								else
								{
									$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
									redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								}
							}
							else
							{
								$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
								redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
							}
						}

//CASO 3: SE QUIEREN ELIMINAR UNA O VARIAS DIRECCIONES AL IGUAL QUE UNO O VARIOS DEPARTAMENTOS
						else
							if($num_dirs_en_bd > $num_dirs_en_formulario AND $num_deptos_en_bd > $num_deptos_en_formulario){

								//echo "Se detectaron una o varias direcciones que ya no seleccionaron, al igual que uno o varios departamentos"."<br>";

								foreach ($dirconsultadas as $dirbd) {
									$encontrado=false;
									foreach ($direccionesFormulario as $dirform) {
										if ($dirbd == $dirform){
											$encontrado=true;
											$break;
										}
									}
									if ($encontrado == false){
										//echo "Quitando la dirección: ---> $dirbd<br>\n";
										$eliminarDireccion = $this->Modelo_direccion->eliminarDirCuandoNoHayDeptos($id,$dirbd);

									}
								}

								foreach ($deptosconsultados as $deptosbd) {

									$encontrado=false;
									foreach ($deptosFormulario as $deptosform) {
										if ($deptosbd == $deptosform){
											$encontrado=true;
											$break;
										}
									}
									if ($encontrado == false){
										//echo "Quitando el depto: ---> $deptosbd<br>\n";
										$eliminarDepto = $this->Modelo_direccion->eliminarDeptoCuandoSeModificanDirs($id,$deptosbd);
									}
								}


								if ($eliminarDireccion AND $eliminarDepto) {
									$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
									foreach ($direcciones as $key) {

										$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
									}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
									if($actualizar)
									{ 	
										$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
									else
									{
										$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}
								}
								else
								{
									$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
									redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
								}

							}
							else
						//CASO APLICADO PARA CUANDO SOLO SE QUITEN DIRECCIONES
								if($num_dirs_en_bd > $num_dirs_en_formulario AND $num_deptos_en_bd ==$num_deptos_en_formulario){

									//echo "Se detectaron uno o varias direcciones que ya no seleccionaron, los departamentos asignados son los mismos"."<br>";
									foreach ($dirconsultadas as $dirbd) {
										$encontrado=false;
										foreach ($direccionesFormulario as $dirform) {
											if ($dirbd == $dirform){
												$encontrado=true;
												$break;
											}
										}
										if ($encontrado == false){
										//echo "Quitando la dirección: ---> $dirbd<br>\n";
											$eliminarDireccion = $this->Modelo_direccion->eliminarDirCuandoNoHayDeptos($id,$dirbd);

										}
									}

									if ($eliminarDireccion) {

										$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
										foreach ($direcciones as $key) {

											$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
										}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
										if($actualizar)
										{ 	
											$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}
										else
										{
											$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}
									}
									else
									{
										$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}

								}

								else
									if($num_dirs_en_bd == $num_dirs_en_formulario AND $num_deptos_en_bd > $num_deptos_en_formulario){

										//echo "Se detectaron uno o varios departamentos que ya no seleccionaron, los direcciones asignadas son los mismas"."<br>";

										foreach ($deptosconsultados as $deptosbd) {

											$encontrado=false;
											foreach ($deptosFormulario as $deptosform) {
												if ($deptosbd == $deptosform){
													$encontrado=true;
													$break;
												}
											}
											if ($encontrado == false){
										//echo "Quitando el depto: ---> $deptosbd<br>\n";
												$eliminarDepto = $this->Modelo_direccion->eliminarDeptoCuandoSeModificanDirs($id,$deptosbd);
											}
										}

										if ($eliminarDepto) {

										$direcciones = $this->Modelo_direccion->getAllsByNumOficio($num_oficio);
										foreach ($direcciones as $key) {

											$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($key->id_recepcion_int,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta);
										}
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
										if($actualizar)
										{ 	
											$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}
										else
										{
											$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
											redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
										}
									}
									else
									{
										$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
										redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
									}

									}

					}
				else
				{
					$this->session->set_flashdata('error_actualizacion', 'Se debe seleccionar al menos una dirección, verifique su información');
						redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
				}

				}	

			}

		public function ModificarOficio_COPIA_DE_SEGURIDAD()
		{
		# code..

				$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
				$this -> form_validation -> set_rules('asunto_a','Asunto','required');
				$this -> form_validation -> set_rules('emisor_h','Emisor','required');
				$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('deptos/internos/recepciondir');
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
					$emisor = $this -> input -> post('emisor_h'),
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
							redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
						}

					}

				}

					$actualizar = $this->Modelo_departamentos->modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}		
				}	
			
		}

		public function ModificarOficioInterno()
		{
			
			$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
			$this -> form_validation -> set_rules('asunto_a','Asunto','required');
			$this -> form_validation -> set_rules('emisor_h','Emisor','required');
			$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
				$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
				$this->load->view('plantilla/header', $data);
				$this->load->view('deptos/internos/recepciondir');
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
					$emisor = $this -> input -> post('emisor_h'),
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
								redirect(base_url() . 'Departamentos/Interno/Informativos/');
							}

						}

					}

					$actualizar = $this->Modelo_departamentos->modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
						redirect(base_url() . 'Departamentos/Interno/Informativos/');
					}

					else
					{
						$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
						redirect(base_url() . 'Departamentos/Interno/Informativos/');
					}		
				}
			}


		public function TurnarCopiaDir()
		{
				$this -> form_validation -> set_rules('txt_idoficio','Id de Oficio','required');
				$this -> form_validation -> set_rules('direccion_a','Direccion de destino','required');

					if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('deptos/internos/recepciondir');
					$this->load->view('plantilla/footer');

				}
				else
				{
					$data =  array(
						$direccion_destino = $this -> input -> post('direccion_a'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$observaciones = $this -> input -> post('observaciones_a')
						);

					$turnar = $this->Modelo_departamentos->TurnarADireccion($direccion_destino,$id_oficio,$observaciones);

					if($turnar)
					{ 	
						$this->session->set_flashdata('actualizado', 'Se ha turnado copia a la dirección seleccionada');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia a la direccion seleccionada, verifique');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}
				}
		
		}

		public function TurnarCopiaDeptos()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Id de Oficio','required');
			$this -> form_validation -> set_rules('area_destino','Direccion de destino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_departamentos -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('deptos/internos/recepciondir');
					$this->load->view('plantilla/footer');

				}
				else
				{
					$data =  array(
						$depto_destino = $this -> input -> post('area_destino'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$observaciones = $this -> input -> post('observaciones_a')
						);

					$turnar = $this->Modelo_departamentos->TurnarADeptos($depto_destino,$id_oficio,$observaciones);

					if($turnar)
					{ 	
						$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
					redirect(base_url() . 'Departamentos/Interno/RecepcionInterna/');
					}
				}
		}


						// Funcion para llenar el combo de departamentos 
		public function llenarComboEmailInterno()
		{
			$options="";
			if ($_POST["deptoemail"]== 1) 
			{
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(1);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';    
					echo $options; 
				}
			}
			if ($_POST["deptoemail"]==2) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(2);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';    
					echo $options;  
				}
			}

			if ($_POST["deptoemail"]==3) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(3);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}
			}


			if ($_POST["deptoemail"]==4) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(4);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}   
			}


			if ($_POST["deptoemail"]==5) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(5);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}

			if ($_POST["deptoemail"]==6) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(6);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}


			if ($_POST["deptoemail"]==7) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoDireccionInterno(7);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}
		}


	    public function llenarComboPersonalInterno()
		{
			$options="";
			if ($_POST["deptopersonal"]== 1) 
			{
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(1);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';    
					echo $options; 
				}
			}
			if ($_POST["deptopersonal"]==2) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(2);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';    
					echo $options;  
				}
			}

			if ($_POST["deptopersonal"]==3) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(3);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}
			}


			if ($_POST["deptopersonal"]==4) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(4);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}   
			}


			if ($_POST["deptopersonal"]==5) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(5);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}

			if ($_POST["deptopersonal"]==6) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(6);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}


			if ($_POST["deptopersonal"]==7) {
				$deptos = $this ->Modelo_departamentos->obtenerCorreoPersonalInterno(7);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}




		}
		
	}

