 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecepcionDir extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this -> load -> model('Modelo_recepcion');
		
		//$this->anexos = './doctosanexos/';
		//$this->respuestas = './doctosrespuesta/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Recepción de Oficios';
		$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
		$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
		$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
		$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
		$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
		$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
		$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

		date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");

		$consulta = $this->Modelo_direccion->getAllEntradas($this->session->userdata('id_direccion'));
		foreach ($consulta as $key) {
    		$idoficio = $key->id_recepcion;
    		if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
    			$this->db->query("CALL comparar_fechas('".$idoficio."')");
    		}
    		
    	}
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/externos/recepciondir');
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
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));

			$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
		$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/recepciondir');
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


			$oficio_salida = $this->limpiar_num_oficio($oficio_salida);

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
					// Correo de la unidad central de correspondencia
					// Validar la respuesta con el numero de oficio de salida 
					//if (!$this->Modelo_direccion->existeNumDeOficioRespuestaExternaDir($num_oficio)) {}

					if ($fecha_respuesta_fisica == $fecha_respuesta) {
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_direccion->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_respuesta_fisica, $hora_respuesta_fisica,$valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico );
					// Actualizar bandera de respuesta
					$this->Modelo_direccion->actualizarBandera($id_oficio_recepcion);
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
					$fecha_r = $this->Modelo_direccion->consultarFechaRecepcion($id_oficio_recepcion);
					foreach ($fecha_r as $key) {
						
						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta_fisica > $fecha_termino_of) {
							$this->Modelo_direccion->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta_fisica < $fecha_termino_of) {
								$this->Modelo_direccion->actualizarStatusContesado($id_oficio_recepcion);
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
					 //Correo de la unidad central de correspondencia
					 $this->email->to('dirgeneralcseiio@oaxaca.gob.mx');
					 $this->email->subject('Oficio respondido');
					  $this->email->message('<h2>El : '.$emisor.' , ha respondido el oficio :'.$num_oficio.'  ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel de la "Unidad Central de Correspondencia del CSEIIO"</h2><hr><br> Correo informativo libre de SPAM');
					 $this->email->send();
					 //con esto podemos ver el resultado
					 var_dump($this->email->print_debugger());

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
					}

				}
				else
				{
					$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recepcionado, verifique con el administrador');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
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
					
					if ($fecha_respuesta_fisica == $fecha_respuesta) {
					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_direccion->agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_respuesta_fisica, $hora_respuesta_fisica,$valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
					// Actualizar bandera de respuesta
					$this->Modelo_direccion->actualizarBandera($id_oficio_recepcion);
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
					$fecha_r = $this->Modelo_direccion->consultarFechaRecepcion($id_oficio_recepcion);
					foreach ($fecha_r as $key) {
						
						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta_fisica > $fecha_termino_of) {
							$this->Modelo_direccion->actualizarStatusFueraDeTiempo($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta_fisica < $fecha_termino_of) {
								$this->Modelo_direccion->actualizarStatusContesado($id_oficio_recepcion);
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
					 //Correo de la unidad central de correspondencia
					$this->email->to('dirgeneralcseiio@oaxaca.gob.mx');
					 $this->email->subject('Oficio respondido por Dirección');
					 $this->email->message('<h2>El : '.$emisor.' , ha respondido el oficio :'.$num_oficio.'  ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel de la "Unidad Central de Correspondencia del CSEIIO"</h2><hr><br> Correo informativo libre de SPAM');
					 $this->email->send();
					 //con esto podemos ver el resultado
					 var_dump($this->email->print_debugger());

						$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
					}
					}
				else
				{
					$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recepcionado, verifique con el administrador');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
				}

				}

			}
			else
			{
				//En caso de no haber archivos en el formulario, envia un error a la vista ssad indicando que no hay archivos
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
				$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
				$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
		$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

				$this->load->view('plantilla/header', $data);
				$this->load->view('directores/externos/recepciondir');
				$this->load->view('plantilla/footer');	
			}
		}

	}

	public function asignarOficio2()
	{
		

		$data =  array(
			$num_oficio = $this-> input -> post('num_oficio_h'),
			$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
			$id_direccion = $this -> input -> post('iddir'),
			$observaciones = $this -> input -> post('observaciones'),
			$correo = $this -> input -> post('email'),
			$correo_personal = $this -> input -> post('email_personal')
		);

		echo "id de oficio: ".$id_oficio_recepcion."<br>";
		$numero_de_asignaciones = $this->Modelo_direccion->numAsignaciones($id_oficio_recepcion);
		
		if($numero_de_asignaciones == 0){
			echo "Este numero de oficio no tiene asignaciones previas";
			foreach ($_POST['area_destino'] as $indice => $deptoFormulario) {
				echo "Departamentos a asignar el oficio: ".$deptoFormulario."<br>";
			}

		}
		else
		{
			echo "Este oficio tiene asignaciones, se analizará"."<br>";

			$deptosconsultados = array();
			$deptosFormulario = array();

			//$this -> load -> model('Modelo_direccion');
			$deptos  = $this->Modelo_direccion->obtenerDepartamentosAsignadosByIDrecepcion($id_oficio_recepcion);

			foreach ($deptos  as $key) {
				$asignaciones_en_bd = $key->id_area;
				array_push($deptosconsultados, $asignaciones_en_bd);
			}

			$deptosFormulario = $_POST['area_destino'];

			$num_deptos_en_bd = sizeof($deptosconsultados);
			$num_deptos_en_formulario = sizeof($deptosFormulario);

			if ($num_deptos_en_bd == $num_deptos_en_formulario) {
				echo "Ya se asignó este oficio a esos departamentos"."<br>";
			}
			else
				if ($num_deptos_en_bd < $num_deptos_en_formulario) {
					echo "Se detectaron nuevos departamentos para asignar "."<br>";

					foreach ($deptosFormulario as $value2) {
						$encontrado=false;
						foreach ($deptosconsultados as $value1) {
							if ($value1 == $value2){
								$encontrado=true;
								$break;
							}
						}
						if ($encontrado == false){
							echo "Agregando Asignación a los siguientes Deptos: ---> $value2<br>\n";
						}
					}
				}
				else
					if ($num_deptos_en_bd > $num_deptos_en_formulario) {
						echo "Se han deseleccionado uno o varios departamentos, se eliminaran "."<br>";

						foreach ($deptosconsultados as $deptosbd) {

							$encontrado=false;
							foreach ($deptosFormulario as $deptosform) {
								if ($deptosbd == $deptosform){
									$encontrado=true;
									$break;
								}
							}
							if ($encontrado == false){
								echo "Quitando asignación del depto: ---> $deptosbd<br>\n";
							}
						}
					}
				}

			}

	public function obtenerDeptosAsignados($id_recepcion)
	{
		$this -> load -> model('Modelo_direccion');
		$query = $this->Modelo_direccion->obtenerDepartamentosAsignadosByIDrecepcion($id_recepcion);
		echo json_encode($query);
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

			$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
		$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/recepciondir');
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
				$correo = $this -> input -> post('email'),
				$correo_personal = $this -> input -> post('email_personal')
			);

			date_default_timezone_set('America/Mexico_City');
			$fecha_recepcion = date('Y-m-d');
			$hora_recepcion =  date("H:i:s");
			
			//Si el oficio no tiene asignaciones y se han marcado departamentos en el formulario
			
			$numero_de_asignaciones = $this->Modelo_direccion->numAsignaciones($id_oficio_recepcion);

			if($numero_de_asignaciones == 0){
				
				foreach ($_POST['area_destino'] as $indice => $deptoFormulario) {
					
					$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$deptoFormulario,$id_oficio_recepcion,$observaciones,$fecha_recepcion,$hora_recepcion);
				}

				if($asignar)
				{ 	
					$habilitar = $this->Modelo_direccion->cambiarBanderaHabilitado($id_oficio_recepcion);

					$this->Modelo_direccion->ModificarBanderaDeptos($id_oficio_recepcion);

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
					redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');

				}
				else
				{
					$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
					redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
				}

			}
			else{

				$deptosconsultados = array();
				$deptosFormulario = array();

			//$this -> load -> model('Modelo_direccion');
				$deptos  = $this->Modelo_direccion->obtenerDepartamentosAsignadosByIDrecepcion($id_oficio_recepcion);

				foreach ($deptos  as $key) {
					$asignaciones_en_bd = $key->id_area;
					array_push($deptosconsultados, $asignaciones_en_bd);
				}

				$deptosFormulario = $_POST['area_destino'];

				$num_deptos_en_bd = sizeof($deptosconsultados);
				$num_deptos_en_formulario = sizeof($deptosFormulario);


				if ($num_deptos_en_bd == $num_deptos_en_formulario) {
					$this->session->set_flashdata('error', 'Este oficio ya ha sido asignado a los departamentos marcados en el formulario.');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
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
							//echo "Agregando Asignación a los siguientes Deptos: ---> $value2<br>\n";
							$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$value2,$id_oficio_recepcion,$observaciones,$fecha_recepcion,$hora_recepcion);
						}
					}

					if($asignar)
					{ 	
						$habilitar = $this->Modelo_direccion->cambiarBanderaHabilitado($id_oficio_recepcion);

						$this->Modelo_direccion->ModificarBanderaDeptos($id_oficio_recepcion);

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
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');

					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
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
								//echo "Quitando asignación del depto: ---> $deptosbd<br>\n";
								$eliminarDeptos = $this->Modelo_direccion->eliminarAsignacionDeptoExterna($id_oficio_recepcion,$deptosbd);
							}
						}
						if ($eliminarDeptos) {
							$this->session->set_flashdata('exito', 'La asignación del oficio nº <strong>: '.$num_oficio. '</strong> Se ha eliminado con éxito');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');

						}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido eliminar la asignacion del oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
					}
				}
				
			}	
		}
	}


	public function asignarOficio_COPIA_DE_SEGURIDAD()
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
			$this->load->view('directores/externos/recepciondir');
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
				$correo = $this -> input -> post('email'),
				$correo_personal = $this -> input -> post('email_personal')
			);

			date_default_timezone_set('America/Mexico_City');
			$fecha_recepcion = date('Y-m-d');
			$hora_recepcion =  date("H:i:s");
			//$area =  null;
			
			foreach ($_POST['area_destino'] as $indice => $valor) {

				$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$valor,$id_oficio_recepcion,$observaciones,$fecha_recepcion,$hora_recepcion);

			}

				// La bandera de asignacion debe cambiar para que se muestre en la tabla de recepcion del director y de la recepcionista 
						// $depto = $this->Modelo_direccion->consultarNombreDepartamento($valor);
						// foreach ($depto as $key) {

						// 	$nombre_depto= $key->nombre_area;
						// }

			if($asignar)
			{ 	
				$habilitar = $this->Modelo_direccion->cambiarBanderaHabilitado($id_oficio_recepcion);

				$this->Modelo_direccion->ModificarBanderaDeptos($id_oficio_recepcion);

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
				redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
				
			}
			else
			{
				$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
				redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
			}
		}
	}


	// public function asignarOficio_COPIA_DE_SEGURIDAD()
	// {
	// 	$this -> form_validation -> set_rules('iddir','Dirección','required');
	// 	//$this -> form_validation -> set_rules('area_destino','Departamento','required');
	// 	$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

	// 	if ($this->form_validation->run() == FALSE) {
	// 		# code...
	// 		$data['titulo'] = 'Recepción de Oficios';
	// 		$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
	// 		$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
	// 		$this->load->view('plantilla/header', $data);
	// 		$this->load->view('directores/externos/recepciondir');
	// 		$this->load->view('plantilla/footer');	

	// 	}
	// 	else
	// 	{
	// 		$data =  array(
	// 			$num_oficio = $this-> input -> post('num_oficio_h'),
	// 			$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
	// 			$id_direccion = $this -> input -> post('iddir'),
	// 			//$id_departamento = $this -> input -> post('area_destino'),
	// 			$observaciones = $this -> input -> post('observaciones'),
	// 			$correo = $this -> input -> post('email'),
	// 			$correo_personal = $this -> input -> post('email_personal')
	// 			);

	// 		date_default_timezone_set('America/Mexico_City');
	// 		$fecha_recepcion = date('Y-m-d');
	// 		$hora_recepcion =  date("H:i:s");
	// 		//$area =  null;

	// 	    $consulta = $this->Modelo_direccion->seleccionarDepto($id_oficio_recepcion);
	// 		foreach ($consulta as $key) {
	// 			$area = $key->id_area;
	// 		}
            
 //            $flag_departamento = 1;
	// 		// Obtener el nombre del departamento mediante el id que se selecciona en el formulario
	// 		// Consulta: Obtiene el departamento cuando el id_departamento sea igual a = ?
	// 		   	$depto = $this->Modelo_direccion->consultarNombreDepartamento($id_departamento);
	// 				foreach ($depto as $key) {
						
	// 					$nombre_depto= $key->nombre_area;
 //    				}
 //    				//basado en el numero de oficio, buscara en la tabla de asignaciones si ya se ha asignado a el departamento leido
    				

 //    				if ($id_departamento != $area ) {
 //    				# code...
 //    					foreach ($_POST['area_destino'] as $indice => $valor) {
 //    						$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$valor,$id_oficio_recepcion,$observaciones,$fecha_recepcion,$hora_recepcion);
 //    					}
    					

	// 			// La bandera de asignacion debe cambiar para que se muestre en la tabla de recepcion del director y de la recepcionista 


 //    					if($asignar)
 //    					{ 	
 //    						$habilitar = $this->Modelo_direccion->cambiarBanderaHabilitado($id_oficio_recepcion);
    						
 //    						$this->Modelo_direccion->ModificarBanderaDeptos($id_oficio_recepcion);

 //    						// Aqui se enviaria el correo para notificar al usuario correspondiente 
	// 				// tomando los datos de sesion del emisor y os datos del recpetor del oficio 
	// 				 //cargamos la libreria email de ci
 //    						$this->load->library("email");

	// 				 //configuracion para gmail - Servidor de correo homologado para el sistema
 //    						$configGmail = array(
 //    							'protocol' => 'smtp',
 //    							'smtp_host' => 'ssl://smtp.gmail.com',
 //    							'smtp_port' => 465,
 //    							'smtp_user' => 'sgocseiiomail@gmail.com',
 //    							'smtp_pass' => 'c53iI02018',
 //    							'mailtype' => 'html',
 //    							'charset' => 'utf-8',
 //    							'newline' => "\r\n"
 //    						);    

	// 				 //cargamos la configuración para enviar con gmail
 //    						$this->email->initialize($configGmail);

 //    						$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
	// 				 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
 //    						$this->email->to($correo);
 //    						$this->email->cc($correo_personal);
 //    						$this->email->subject('Nuevo Oficio Asignado');
 //    						$this->email->message('<h2>Se te ha asignado'.$num_oficio. ' un oficio, para pronta respuesta, ingresa al sistema de control de oficios <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos" perteneciente a tu Departamento</h2><hr><br> Correo informativo libre de SPAM');
 //    						$this->email->send();
	// 				 //con esto podemos ver el resultado
 //    						var_dump($this->email->print_debugger());

 //    						$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado al: <strong> ' .$nombre_depto. ' </strong> con éxito');
 //    						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
 //    					}
 //    					else
 //    					{
 //    						$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
 //    						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
 //    					}

 //    				}
 //    				else
 //    				{
 //    					$this->session->set_flashdata('error', 'Se esta tratando de asignar el mismo oficio al mismo departamento');
 //    						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
 //    				}
	// 	}
		
	// }

	public function habilitarOficio()
	{
		$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));

			$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
		$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
			
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/recepciondir');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			$data =  array(
				$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a')
				); 	

			$habilitar = $this->Modelo_direccion->cambiarBanderaHabilitado($id_oficio_recepcion);


			if ($habilitar) {
				$asignar = $this->Modelo_direccion->cambiarBanderaAsignacion($id_oficio_recepcion);
				$this->session->set_flashdata('exito', 'El oficio asignado por la Unidad Central de Correspondencia, se ha sido habilitado para ser respondido por el departamento.');
    						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
			}
			else
			{
				$this->session->set_flashdata('error', 'No se pudo habilitar el oficio para respuesta del oficio');
    						redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
			}
		}

	}

		public function Descargar($name)
		{
			$this->folder = './doctos/';
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
		}

			public function DescargarAnexos($name)
		{
			$this->folder = './doctosanexos/';
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
		}
			public function DescargarRespuesta($name)
		{
			$this->folder = './doctosrespuesta/';
			$data = file_get_contents($this->folder.$name); 
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
    	$consulta = $this->Modelo_direccion->getAllEntradas($this->session->userdata('id_direccion'));
    	
    	foreach ($consulta as $key) {
    		$idoficio = $key->id_recepcion;

    		if($this->db->query("CALL comparar_fechas('".$idoficio."')"))
    		{
    			echo 'Ejecutando Cambios';
    		}else{
    			show_error('Error! al ejecutar');
    		}
    	}

        redirect(base_url() . 'Direcciones/Externos/RecepcionDir/');
    }

    //EMISION - RECEPCION : PROCESO INTERNO
    // DIRECCION A DEPARTAMENTO
    // En este proceso, la direccion emite el documento
    // A su vez, el sistema crea la recepcion y asigna el documento
    public function llenarCombo()
    {

    
    	$area_destino = $_POST["dir"];

    	$options="";
    	
    	$deptos = $this ->Modelo_direccion->obtenerCorreoDepto($area_destino);

    	foreach ($deptos as $row){
    		$options= '
    		<option value='.$row->email.'>'.$row->email.'</option>
    		';    
    		echo $options; 
    	}
    	

    }


    public function llenarComboPersonal()
    {

    
    	$area_destino = $_POST["d"];

    	$options="";
    	
    	$deptos = $this ->Modelo_direccion->obtenerCorreoDeptoPersonal($area_destino);

    	foreach ($deptos as $row){
    		$options= '
    		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
    		';    
    		echo $options; 
    	}
    	

    }

    //Funcion para emitir alertas a los departamentos adscritos a los departamentos 

  
		public function emitirAlertasNC()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Oficios No Contestados';
				$data['nocontestados'] = $this -> Modelo_direccion -> getAllNoContestados($this->session->userdata('id_direccion'));
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
				$correos = $this ->Modelo_direccion->obtenerCorreoDireccion($id);
				foreach ($correos as $key) {
					 	# code...

					$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
					$this->email->cc($key->email_personal);

					$this->email->subject('Alerta de Término');
					$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  , con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http:'.base_url().'">aquí</a>.</h2><hr><br> Correo informativo libre de SPAM');
				}
				$this->email->send();
					 //con esto podemos ver el resultado
				var_dump($this->email->print_debugger());

				$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
						redirect(base_url() . 'Direcciones/Externos/NoContestadosDir/');

			}

		}

		

}