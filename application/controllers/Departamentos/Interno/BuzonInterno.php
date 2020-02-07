<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuzonInterno extends CI_Controller {

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
		if ($this->session->userdata('nombre')) {
			
			$data['titulo'] = 'Panel de Depatamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['entradas'] = $this -> Modelo_departamentos -> getBuzonDeOficiosEntrantes($this->session->userdata('id_area'));
			$data['entradas_num'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('area_trabajo'));
			$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));
			//$data['deptos'] = $this -> Modelo_departamentos -> getDeptos($this->session->userdata('id_area'));
			$data['codigos'] = $this -> Modelo_departamentos-> getCodigos();

				$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/index');
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

	public function asignarOficio()
	{
		$this -> form_validation -> set_rules('iddir','Dirección','required');
		$this -> form_validation -> set_rules('area_destino','Departamento','required');
		$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			
			$data['titulo'] = 'Panel de Depatamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_departamentos -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/recepciondir');
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
			// Obtener el nombre del departamento mediante el id que se selecciona en el formulario
			// Consulta: Obtiene el departamento cuando el id_departamento sea igual a = ?
			$depto = $this->Modelo_departamentos->consultarNombreDepartamento($id_departamento);
			foreach ($depto as $key) {

				$nombre_depto= $key->nombre_area;
			}

			$asignar = $this->Modelo_departamentos->asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones);


				// La bandera de asignacion debe cambiar para que se muestre en la tabla de recepcion del director y de la recepcionista 
			$this->Modelo_departamentos->ModificarBanderaDeptosInt($id_oficio_recepcion);

			if($asignar)
			{ 	
				$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado al: <strong> ' .$nombre_depto. ' </strong> con éxito');
				redirect(base_url() . 'Depatamentos/Interno/BuzonInterno/');
			}
			else
			{
				$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
				redirect(base_url() . 'Depatamentos/Interno/BuzonInterno/');
			}
		}

	}

	public function agregarRespuestaDepto()
	{
		$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto_h','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Panel de Depatamentos';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_departamentos -> getDeptos($this->session->userdata('id_direccion'));

			$data['entradas_num'] = $this -> Modelo_departamentos -> getAllEntradasInternas($this->session->userdata('area_trabajo'));
			$data['nums_memorandums']  = $this -> Modelo_direccion -> getNumsMemorandums($this->session->userdata('area_trabajo'));
			$data['nums_oficio']  = $this -> Modelo_direccion -> getNumsOficiosUsados($this->session->userdata('area_trabajo'));
			$data['nums_circular']  = $this -> Modelo_direccion -> getNumsCircular($this->session->userdata('area_trabajo'));
			//$data['deptos'] = $this -> Modelo_departamentos -> getDeptos($this->session->userdata('id_area'));
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
				$id_del_area = $this->session->userdata('id_area'),
				$area_trabajo = $this->session->userdata('area_trabajo'),
				$valor_doc  = $this -> input -> post('valor_doc'),
				$vigencia_doc  = $this -> input -> post('vigencia_doc'),
				$clasificacion_info = $this -> input -> post('clasificacion_info'),
				$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico')
			);


			date_default_timezone_set('America/Mexico_City');
			$fecha_subida= date('Y-m-d');
			
		

				//if ($fecha_acuse == $fecha_subida) {

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
								$this->session->set_flashdata('errorarchivo', $this->upload->display_errors().'Error en Oficio de Respuesta');
								redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
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
								$this->session->set_flashdata('errorarchivo', $this->upload->display_errors().'Error en Anexo');
								redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
							}

							$anexos = $this->upload->data('file_name');

					//$respuesta = $_FILES['ofrespuesta']['name'];
					//$anexos = $_FILES['anexos']['name'];



	//fecha y hora de recepcion se generan basado en el servidor 
							date_default_timezone_set('America/Mexico_City');
							$fecha_subida= date('Y-m-d');
							$hora_subida =  date("H:i:s");

					if ($this->Modelo_departamentos->comprobarSiYaExisteRespuestaByIdOficio($id_oficio_recepcion)) {
						
					
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
							$agregar = $this->Modelo_departamentos->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse,$id_del_area, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					// Actualizar bandera de respuesta
							$this->Modelo_departamentos->actualizarBanderaInt($id_oficio_recepcion);

							}
							else{

								$agregar = $this->Modelo_departamentos->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse,$id_del_area, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					// Actualizar bandera de respuesta
							$this->Modelo_departamentos->actualizarBanderaInt($id_oficio_recepcion);

							$fecha_r = $this->Modelo_departamentos->consultarFechaRecepcionInt($id_oficio_recepcion);
							foreach ($fecha_r as $key) {

								$fecha_termino_of = $key->fecha_termino;

								if ($fecha_respuesta > $fecha_termino_of) {
									$this->Modelo_departamentos->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
								}

								else
									if ($fecha_respuesta < $fecha_termino_of) {
										$this->Modelo_departamentos->actualizarStatusContesadoInt($id_oficio_recepcion);
									}
									else
										if ($fecha_respuesta = $fecha_termino_of) {
											$this->Modelo_departamentos->actualizarStatusContesadoInt($id_oficio_recepcion);
										}


									}

									}

									if($agregar)
									{ 	
										$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
										redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
									}
									else
									{
										$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
										redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
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
									$agregar = $this->Modelo_departamentos->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $id_del_area, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
				//Actualiza la bandera de respuesta
									$this->Modelo_departamentos->actualizarBanderaInt($id_oficio_recepcion);
				//Si las fecha de respuesta es mayor a la fecha de recepcion el status cambia a Fuera de tiempo 
				// Si la fecha de respuesta es menor a la fecha de termino el estatus cambia 
									$fecha_r = $this->Modelo_departamentos->consultarFechaRecepcionInt($id_oficio_recepcion);
									foreach ($fecha_r as $key) {

										$fecha_termino_of = $key->fecha_termino;

										if ($fecha_respuesta > $fecha_termino_of) {
											$this->Modelo_departamentos->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
										}

										else
											if ($fecha_respuesta < $fecha_termino_of) {
												$this->Modelo_departamentos->actualizarStatusContesadoInt($id_oficio_recepcion);
											}
											else
												if ($fecha_respuesta = $fecha_termino_of) {
													$this->Modelo_departamentos->actualizarStatusContesadoInt($id_oficio_recepcion);
												}

											}

											if($agregar)
											{ 	
												$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong>'.$num_oficio. ' </strong> correctamente');
												redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
											}
											else
											{
												$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio:  <strong> '.$num_oficio. ' </strong> verifique la información');
												redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
											}
										}

									}
									else
									{
				//En caso de no haber archivos en el formulario, envia un error a la vista ssad indicando que no hay archivos
										$data['titulo'] = 'Panel de Depatamentos';
										$data['entradas'] = $this -> Modelo_departamentos -> getAllEntradas($this->session->userdata('id_direccion'));
										$data['deptos'] = $this -> Modelo_departamentos -> getDeptos($this->session->userdata('id_direccion'));
										$this->load->view('plantilla/header', $data);
										$this->load->view('deptos/internos/recepciondir');
										$this->load->view('plantilla/footer');		
									}

									}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$numoficio_salida.'</strong> que esta tratando de ingresar ya existe, verifique su información');
									redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
							}
								# code...
								// }
								// else
								// {
								// 	$this->session->set_flashdata('error', 'El oficio debe subirse al sistema, el mismo día en que fue recibido físicamente por el area de destino. Comuniquese con el administrador');
								// 	redirect(base_url() . 'Departamentos/Interno/BuzonInterno/');
								// }
						}

						//
						
					}


				}


				/* End of file BuzonInterno.php */
/* Location: ./application/controllers/BuzonInterno.php */