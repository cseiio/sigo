<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuzonInterno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('area_trabajo')) {
			$data['titulo'] = 'Panel de Direcciones';
			$data['entradas'] = $this -> Modelo_direccion -> getBuzonDeOficiosEntrantes($this->session->userdata('id_direccion'));

			$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));

			$data['nums_memorandums_planteles']  = $this -> Modelo_direccion -> getNumsMemorandumsPlanteles($this->session->userdata('area_trabajo'));
			$data['nums_oficio_planteles']  = $this -> Modelo_direccion -> getNumsOficiosUsadosPlanteles($this->session->userdata('area_trabajo'));
			$data['nums_circular_planteles']  = $this -> Modelo_direccion -> getNumsCircularPlanteles($this->session->userdata('area_trabajo'));
			
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_direccion-> getCodigos();

			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
			
			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this -> Modelo_direccion -> getBuzonDeOficiosEntrantes($this->session->userdata('id_direccion'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}
				
			}

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 	
	}

	public function Descargar($name)
	{
		$data = file_get_contents($this->folder.$name); 
		force_download($name,$data); 
	}

	public function agregarRespuesta()
	{
		$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto_h','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Panel de Direcciones';
			$data['entradas'] = $this -> Modelo_direccion -> getBuzonDeOficiosEntrantes($this->session->userdata('id_direccion'));

				$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));

			$data['nums_memorandums_planteles']  = $this -> Modelo_direccion -> getNumsMemorandumsPlanteles($this->session->userdata('area_trabajo'));
			$data['nums_oficio_planteles']  = $this -> Modelo_direccion -> getNumsOficiosUsadosPlanteles($this->session->userdata('area_trabajo'));
			$data['nums_circular_planteles']  = $this -> Modelo_direccion -> getNumsCircularPlanteles($this->session->userdata('area_trabajo'));
			
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_direccion-> getCodigos();

			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/index');
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
				$numoficio_salida = $this -> input -> post('numoficio_salida'),
				$emisor = $this -> input -> post('emisor_h'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia = $this -> input -> post('dependencia_h'),
				$receptor = $this -> input -> post('receptor_h'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
				$fecha_respuesta = $this -> input -> post('fecha_emision_fisica'),
				$hora_respuesta = $this -> input -> post('hora_emision_fisica'),
				$fecha_acuse = $this -> input -> post('fecha_acuse'),
				$hora_acuse = $this -> input -> post('hora_acuse'),
				$id_del_area = $this->session->userdata('id_direccion'),
				$area_trabajo = $this->session->userdata('area_trabajo'),
				$valor_doc  = $this -> input -> post('valor_doc'),
				$vigencia_doc  = $this -> input -> post('vigencia_doc'),
				$clasificacion_info = $this -> input -> post('clasificacion_info'),
				$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')
			);

			date_default_timezone_set('America/Mexico_City');
					$fecha_subida= date('Y-m-d');

	//	if ($fecha_acuse == $fecha_subida) {

			//IF QUE COMPARA EL NUMERO DE OFICIO PROVENIENTE DEL FORMULARIO, CON EL CONSULTADO DE LA BASE DE DATOS, O EN SU DEFECTO, SI ESE NUM DE OFICIO YA EXISTE, QUE ENTRE A LA VALIDACION
			//
			if (!$this->Modelo_direccion->existeNumDeOficioDirInterno($numoficio_salida)) {
			

			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['ofrespuesta']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosrespuestainterna/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_Oficio_de_respuesta';

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
					$config['upload_path'] = './doctosanexosinternos/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_Anexos';

            // Cargamos la nueva configuración 'Folio_'.$id_oficio_recepcion.'_'.'Oficio_de_respuesta'.'_'.$num_oficio;
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

					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_direccion->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $id_del_area, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					// Actualizar bandera de respuesta
					$this->Modelo_direccion->actualizarBanderaInt($id_oficio_recepcion);
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
					$fecha_r = $this->Modelo_direccion->consultarFechaRecepcionInt($id_oficio_recepcion);
					foreach ($fecha_r as $key) {

						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta > $fecha_termino_of) {
							$this->Modelo_direccion->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta < $fecha_termino_of) {
								$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
							}
							else
								if ($fecha_respuesta = $fecha_termino_of) {
									$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
								}


							}

							if($agregar)
							{ 	

							// al realizar la respuesta del oficio, se tiene que enviar un correo electronico a la direccion que lo emitio, avisando sobre la respuesta
							
							$correos = $this->Modelo_direccion->obtenerCorreosInternos($id_oficio_recepcion);

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
								//consulta los correos que pertenecen a la direccion que turna el oficio, entra a un ciclo y envia, los correos dependeindo de la dirección en turno

								foreach ($correos as $key) {
					 //Correo de la direccion que emitio el oficio
									$this->email->to($key->email);
									$this->email->cc($key->email_personal);

								$this->email->subject('Oficio respondido');
								$this->email->message('<h2>El : '.$emisor.' , ha respondido el oficio interno :'.$num_oficio.'  ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel de "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');

								$this->email->send();
					 //con esto podemos ver el resultado
								var_dump($this->email->print_debugger());

									}

								$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
							else
							{
								$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
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
							$flag_contestado = 1;
		// Estatus por defecto es : Pendiente

				//Agrega las respuestas
							$agregar = $this->Modelo_direccion->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento,$numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $id_del_area,$area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
				//Actualiza la bandera de respuesta
							$this->Modelo_direccion->actualizarBanderaInt($id_oficio_recepcion);
				//Si las fecha de respuesta es mayor a la fecha de recepcion el status cambia a Fuera de tiempo 
				// Si la fecha de respuesta es menor a la fecha de termino el estatus cambia 
							$fecha_r = $this->Modelo_direccion->consultarFechaRecepcionInt($id_oficio_recepcion);
							foreach ($fecha_r as $key) {

								$fecha_termino_of = $key->fecha_termino;

								if ($fecha_respuesta > $fecha_termino_of) {
									$this->Modelo_direccion->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
								}

								else
									if ($fecha_respuesta < $fecha_termino_of) {
										$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
									}
									else
										if ($fecha_respuesta = $fecha_termino_of) {
											$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
										}

									}

									if($agregar)
									{ 	

							$correos = $this->Modelo_direccion->obtenerCorreosInternos($id_oficio_recepcion);


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
								//consulta los correos que pertenecen a la direccion que turna el oficio, entra a un ciclo y envia, los correos dependeindo de la dirección en turno
							
								foreach ($correos as $key) {
					 //Correo de la direccion que emitio el oficio
									$this->email->to($key->email);
									$this->email->cc($key->email_personal);

								$this->email->subject('Oficio respondido');
								$this->email->message('<h2>El : '.$emisor.' , ha respondido el oficio interno :'.$num_oficio.'  ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel de "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
								$this->email->send();
					 //con esto podemos ver el resultado
								var_dump($this->email->print_debugger());

								}

										$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong>'.$num_oficio. ' </strong> correctamente');
										redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
									}
									else
									{
										$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio:  <strong> '.$num_oficio. ' </strong> verifique la información');
										redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
									}
								}

							}
							else
							{
				//En caso de no haber archivos en el formulario, envia un error a la vista ssad indicando que no hay archivos
								$data['titulo'] = 'Panel de Direcciones';
								$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
								$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
								$this->load->view('plantilla/header', $data);
								$this->load->view('directores/internos/index');
								$this->load->view('plantilla/footer');		
							}

							//EL ELSE DE LA VALIDACION POR NUMERO DE OFICIO DE RESPUESTA, VA EN ESTE ÁMBITO DE CÓDIGO.
							}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$numoficio_salida.'</strong> que esta tratando de ingresar ya existe, verifique su información');
									redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
							
							// }
							// else
							// {
							// 	$this->session->set_flashdata('error', 'El oficio debe subirse al sistema, el mismo día en que fue recibido físicamente por el area de destino. Comuniquese con el administrador');
							// 			redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							// }
						}

					}


		public function asignarOficio()
	{
		$this -> form_validation -> set_rules('iddir','Dirección','required');
		//$this -> form_validation -> set_rules('area_destino','Departamento','required');
		$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/recepciondir');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$num_oficio = $this-> input -> post('num_oficio_h'),
				$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
				$id_direccion = $this -> input -> post('iddir'),
								//$id_departamento = $this -> input -> post('area_destino'),
				$observaciones = $this -> input -> post('observaciones'),
			);

			date_default_timezone_set('America/Mexico_City');
			$fecha_recepcion = date('Y-m-d');
			$hora_recepcion =  date("H:i:s");

			
			
			//Si el oficio no tiene asignaciones y se han marcado departamentos en el formulario
			
			$numero_de_asignaciones = $this->Modelo_direccion->numAsignacionesInternos($id_oficio_recepcion);

			if($numero_de_asignaciones == 0){
				
				foreach ($_POST['area_destino'] as $indice => $deptoFormulario) {
					
					$asignar = $this->Modelo_direccion->asignarOficioInterno($id_direccion,$deptoFormulario,$id_oficio_recepcion,$observaciones, $hora_recepcion,$fecha_recepcion);
				}

				if($asignar)
				{ 	
					$this->Modelo_direccion->ModificarBanderaDeptosInt($id_oficio_recepcion);

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
					foreach ($_POST['area_destino'] as $indice => $deptos) {		
						$correos = $this->Modelo_direccion->ConsultarEmailsdeDeptos($deptos);
						foreach ($correos as $row) {

							$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
							$num_oficio = $this-> input -> post('num_oficio_h');
							$this->email->to($row->email);
							$this->email->cc($row->email_personal);

							$this->email->subject('Nuevo Oficio Asignado');
							$this->email->message('<h2>Se te ha asignado el oficio: '.$num_oficio. ',para pronta respuesta, ingresa al sistema de control de oficios <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos" perteneciente a tu Departamento</h2><hr><br> Correo informativo libre de SPAM');
							$this->email->send();
							var_dump($this->email->print_debugger());
						}

					}

					$num_oficio = $this->input-> post('num_oficio_h');
					$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado con éxito');
					redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');

				}
				else
				{
					$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
					redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
				}

			}
			else{

				$deptosconsultados = array();
				$deptosFormulario = array();

			//$this -> load -> model('Modelo_direccion');
				$deptos  = $this->Modelo_direccion->obtenerDepartamentosAsignadosByIDrecepcionInt($id_oficio_recepcion);

				foreach ($deptos  as $key) {
					$asignaciones_en_bd = $key->id_area;
					array_push($deptosconsultados, $asignaciones_en_bd);
				}

				$deptosFormulario = $_POST['area_destino'];

				$num_deptos_en_bd = sizeof($deptosconsultados);
				$num_deptos_en_formulario = sizeof($deptosFormulario);


				if ($num_deptos_en_bd == $num_deptos_en_formulario) {
					$this->session->set_flashdata('error', 'Este oficio ya ha sido asignado a los departamentos marcados en el formulario.');
						redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
				}

				else
				if ($num_deptos_en_bd < $num_deptos_en_formulario) {
					
					foreach ($deptosFormulario as $value2) {
						$encontrado=false;
						foreach ($deptosconsultados as $value1) {
							if ($value1 == $value2){
								$encontrado=true;
								$break;
							}
						}
						if ($encontrado == false){

							date_default_timezone_set('America/Mexico_City');
							$fecha_recepcion = date('Y-m-d');
							$hora_recepcion =  date("H:i:s");
							//echo "Agregando Asignación a los siguientes Deptos: ---> $value2<br>\n";
							$asignar = $this->Modelo_direccion->asignarOficioInterno($id_direccion,$value2,$id_oficio_recepcion,$observaciones, $hora_recepcion,$fecha_recepcion);
						}
					}

					if($asignar)
					{ 	
						$this->Modelo_direccion->ModificarBanderaDeptosInt($id_oficio_recepcion);

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
						foreach ($_POST['area_destino'] as $indice => $deptos) {		
							$correos = $this->Modelo_direccion->ConsultarEmailsdeDeptos($deptos);
							foreach ($correos as $row) {

								$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
								$num_oficio = $this-> input -> post('num_oficio_h');
								$this->email->to($row->email);
								$this->email->cc($row->email_personal);

								$this->email->subject('Nuevo Oficio Asignado');
								$this->email->message('<h2>Se te ha asignado el oficio: '.$num_oficio. ',para pronta respuesta, ingresa al sistema de control de oficios <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos" perteneciente a tu Departamento</h2><hr><br> Correo informativo libre de SPAM');
								$this->email->send();
								var_dump($this->email->print_debugger());
							}

						}

						$num_oficio = $this->input-> post('num_oficio_h');
						$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado con éxito');
						redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');

					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
						redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
					}
				}
				else
					if ($num_deptos_en_bd > $num_deptos_en_formulario) {
						//echo "Se han deseleccionado uno o varios departamentos, se eliminaran "."<br>";

						foreach ($deptosconsultados as $deptosbd) {

							$encontrado=false;
							foreach ($deptosFormulario as $deptosform) {
								if ($deptosbd == $deptosform){
									$encontrado=true;
									$break;
								}
							}
							if ($encontrado == false){
								eliminarAsignacionDeptoInterna($id_oficio_recepcion, $deptosbd);
							}
						}
						if ($eliminarDeptos) {
							$this->session->set_flashdata('exito', 'La asignación del oficio nº <strong>: '.$num_oficio. '</strong> Se ha eliminado con éxito');
						redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');

						}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido eliminar la asignacion del oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
						redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
					}
				}
				
			}	
		}
	}


					public function asignarOficio2()
					{
						$this -> form_validation -> set_rules('iddir','Dirección','required');
						$this -> form_validation -> set_rules('area_destino','Departamento','required');
						$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

						if ($this->form_validation->run() == FALSE) {
			# code...
							$data['titulo'] = 'Recepción de Oficios';
							$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
							$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
							$this->load->view('plantilla/header', $data);
							$this->load->view('directores/internos/recepciondir');
							$this->load->view('plantilla/footer');	

						}
						else
						{
							$data =  array(
								$num_oficio = $this-> input -> post('num_oficio_h'),
								$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
								$id_direccion = $this -> input -> post('iddir'),
								$id_departamento = $this -> input -> post('area_destino'),
								$observaciones = $this -> input -> post('observaciones'),
							);

							$flag_departamento = 1;

							date_default_timezone_set('America/Mexico_City');
							$fecha_respuesta = date('Y-m-d');
							$hora_respuesta =  date("H:i:s");

							$consulta = $this->Modelo_direccion->seleccionarDeptoInterno($id_oficio_recepcion);
							foreach ($consulta as $key) {
								$area = $key->id_area;
							}

			// Obtener el nombre del departamento mediante el id que se selecciona en el formulario
			// Consulta: Obtiene el departamento cuando el id_departamento sea igual a = ?
							$depto = $this->Modelo_direccion->consultarNombreDepartamento($id_departamento);

							foreach ($depto as $key) {

								$nombre_depto= $key->nombre_area;
							}


							if ($id_departamento != $area ) {

								$asignar = $this->Modelo_direccion->asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones, $hora_respuesta, $fecha_respuesta);


				// La bandera de asignacion debe cambiar para que se muestre en la tabla de recepcion del director y de la recepcionista 
								$this->Modelo_direccion->ModificarBanderaDeptosInt($id_oficio_recepcion);

								if($asignar)
								{ 	
									$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado al: <strong> ' .$nombre_depto. ' </strong> con éxito');
									redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
								}
								else
								{
									$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
									redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
								}

							}
							else
							{
								$this->session->set_flashdata('error', 'Se esta tratando de asignar el mismo oficio al mismo departamento');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
						}

					}


				}

				/* End of file BuzonInterno.php */
/* Location: ./application/controllers/BuzonInterno.php */