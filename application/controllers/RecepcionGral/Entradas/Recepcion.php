<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			
			$data['titulo'] = 'Recepción de Oficios';
			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			$data['entradas_limit'] = $this -> Modelo_recepcion -> getAllEntradasLimitInformativos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
			// Actualiza los oficios que han sobrepasado el tiempo de res
			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this->Modelo_recepcion->getAllEntradas();
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas('".$idoficio."')");
				}
				
			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/recepcion');
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
		$this -> form_validation -> set_rules('emisor','Emisor','required');
		$this -> form_validation -> set_rules('cargo','Cargo','required');
		$this -> form_validation -> set_rules('dependencia','Dependencia','required');
		//$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		$this -> form_validation -> set_rules('fecha_recepcion_fisica','Fecha de Recepcion','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			$data['entradas_limit'] = $this -> Modelo_recepcion -> getAllEntradasLimitInformativos();
			$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
			$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
			$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/recepcion');
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
				$cargo = $this -> input -> post('cargo'),
				$dependencia = $this -> input -> post('dependencia'),
				$direccion = $this -> input -> post('direccion'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				$requiereRespuesta =  $this -> input -> post('ReqRespuesta'),
				$fecha_recepcion_fisica =  $this -> input -> post('fecha_recepcion_fisica'),
				$hora_recepcion_fisica = $this -> input -> post('hora_recepcion_fisica'),
				$fecha_emision_fisica =  $this -> input -> post('fecha_emision_fisica'),
				$hora_emision_fisica = $this -> input -> post('hora_emision_fisica'),
				$codigo = $this -> input -> post('codigo'),
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
							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_subida = date('Y-m-d');
				$hora_recepcion =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';

		

				if ($fecha_recepcion_fisica < $fecha_subida) {
					$date1 = $fecha_subida;
					$date2 = $fecha_recepcion_fisica;
					$diff = abs(strtotime($date2) - strtotime($date1));

					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

					$observaciones = 'El oficio se ha subido  '.$days. ' día(s) después de su recepción';
					
				}

				// Si el Oficio no requiere respuesta, se agrega con estatus contestado
				// Y con direccion numero 8 que representa a un oficio sin
				// 
				// VALIDACION DE NUMERO DE OFICIO
				// Consultar el numero de oficio que el cliente ha ingresado para ver si existe
				if (!$this->Modelo_recepcion->existeNumDeOficio($num_oficio)) {
					
					// if ($fecha_recepcion_fisica == $fecha_subida) {

						if ($requiereRespuesta == 0) {

							$status = 'Informativo';
							foreach ($_POST['direccion'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
								$agregar = $this->Modelo_recepcion->insertarEntrada($num_oficio,$fecha_subida,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor,$dependencia, $cargo, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $requiereRespuesta, $fecha_recepcion_fisica, $hora_recepcion_fisica, $fecha_emision_fisica, $hora_emision_fisica, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
							}
						}
						else
							if($requiereRespuesta == 1)
							{
								foreach ($_POST['direccion'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
									$agregar = $this->Modelo_recepcion->insertarEntrada($num_oficio,$fecha_subida,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor,$dependencia, $cargo, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $requiereRespuesta, $fecha_recepcion_fisica, $hora_recepcion_fisica, $fecha_emision_fisica, $hora_emision_fisica, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico);
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
									$correos = $this->Modelo_recepcion->obtenerCorreoMultiple($valor);
									foreach ($correos as $key) {

										$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion

										$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
										$this->email->cc($key->email_personal);
										$this->email->subject('Nuevo Oficio');
										$this->email->message('<h2>Has recibido el oficio externo: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
										$this->email->send();
					 //con esto podemos ver el resultado
										var_dump($this->email->print_debugger());
									}
								}

								$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}
							else
							{
								$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}
						// }
						// else
						// {
						// 	$this->session->set_flashdata('error', 'El oficio debe subirse el mismo día en que fue recepcionado, verifique con el administrador');
						// 	redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						// }
					}
					else
					{
						$this->session->set_flashdata('error', 'El número de oficio: <strong>'.$num_oficio.'</strong> que esta tratando de ingresar ya existe, verifique su información');
						redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
					}
				}
			}


					// Funcion para llenar el combo de departamentos 
			public function llenarComboEmial()
			{
				$options="";
				if ($_POST["dir"]== 1) 
				{
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(1);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';    
						echo $options; 
					}
				}
				if ($_POST["dir"]==2) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(2);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';    
						echo $options;  
					}
				}

				if ($_POST["dir"]==3) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(3);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';   
						echo $options;   
					}
				}


				if ($_POST["dir"]==4) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(4);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';   
						echo $options;   
					}   
				}


				if ($_POST["dir"]==5) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(5);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';   
						echo $options;   
					}  
				}

				if ($_POST["dir"]==6) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(6);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';   
						echo $options;   
					}  
				}


				if ($_POST["dir"]==7) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(7);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email.'>'.$row->email.'</option>
						';   
						echo $options;   
					}  
				}




			}


			public function llenarComboPersonal()
			{
				$options="";
				if ($_POST["dir2"]== 1) 
				{
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(1);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';    
						echo $options; 
					}
				}
				if ($_POST["dir2"]==2) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(2);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';    
						echo $options;  
					}
				}

				if ($_POST["dir2"]==3) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(3);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';   
						echo $options;   
					}
				}


				if ($_POST["dir2"]==4) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(4);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';   
						echo $options;   
					}   
				}


				if ($_POST["dir2"]==5) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(5);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';   
						echo $options;   
					}  
				}

				if ($_POST["dir2"]==6) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(6);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';   
						echo $options;   
					}  
				}


				if ($_POST["dir2"]==7) {
					$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(7);

					foreach ($deptos as $row){
						$options= '
						<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
						';   
						echo $options;   
					}  
				}

			}
		//Funcion para emitir alertas a los directores de area via correo electronico, basado en el id del oficio recepcionado
			public function emitirAlertas()
			{
				$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
					$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/entradas/recepcion');
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
					$correos = $this ->Modelo_recepcion->obtenerCorreo($id);
					foreach ($correos as $key) {
					 	# code...
						$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
						$this->email->cc($key->email_personal);

						$this->email->subject('Alerta de Término');
						$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  , con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
					}
					$this->email->send();
					 //con esto podemos ver el resultado
					var_dump($this->email->print_debugger());

					$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
					redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');

				}

			}


			public function emitirAlertasNC()
			{
				$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
					$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/entradas/recepcion');
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
					$correos = $this ->Modelo_recepcion->obtenerCorreo($id);
					foreach ($correos as $key) {
					 	# code...

						$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
						$this->email->cc($key->email_personal);

						$this->email->subject('Alerta de Oficio No Contestado');
						$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  , con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
					}
					$this->email->send();
					 //con esto podemos ver el resultado
					var_dump($this->email->print_debugger());

					$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
					redirect(base_url() . 'RecepcionGral/Entradas/NoContestados/');

				}

			}

			public function ModificarOficio2()
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


				$dirconsultadas =  array();
				$direccionesFormulario = array();
				$countConsultados = null;
//entonces al llamarse igual varios componentes esto te manda un arreglo
				$this -> load -> model('Modelo_recepcion');
				$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
				foreach ($query as $key) {
				//echo 'ID´s: '.$key->id_recepcion.'<br>';
				//echo 'DIRECCIONES CONSULTADAS: '.$key->direccion_destino.'<br>';
					$direccion_destinobd = $key->direccion_destino;
					array_push($dirconsultadas, $direccion_destinobd);

				}
				$direccionesFormulario = $_POST['direccion_a'];
				echo "----------------------------------------------".'<br>';

				
				echo 'BD ='.print_r($dirconsultadas).'<br>';
				echo 'FORMULARIO = '.print_r($direccionesFormulario).'<br>';

				echo "----------------------------------------------".'<br>';

				$num_datos_bd = sizeof($dirconsultadas);
				$num_datos_formulario = sizeof($direccionesFormulario);

				echo "Num de dirs en BD = ".$num_datos_bd."<br>";
				echo "Num de dirs en formulario = ".$num_datos_formulario."<br>";

				if ($num_datos_bd == $num_datos_formulario) {
					echo "Los datos del formulario y BD son iguales, solo se actualizará"."<br>";
				}
				else
				{
					echo "Se detectaron una o varias direcciones por agregar: "."<br>";
					foreach ($direccionesFormulario as $value2) {
						$encontrado=false;
						foreach ($dirconsultadas as $value1) {
							if ($value1 == $value2){
								$encontrado=true;
								$break;
							}
						}
						if ($encontrado == false){
							echo "---> $value2<br>\n";
						}
					}

				// echo "Elementos que existen en las 2 arrays<br>\n";
				// foreach ($dirconsultadas as $value1) {
				// 	foreach ($direccionesFormulario as $value2) {
				// 		if ($value1 == $value2){
				// 			echo "---> $value1<br>\n";
				// 		}
				// 	}
				// }
				// 
				// echo "<br>\nElementos que sólo existen en array1<br>\n";
				// foreach ($array1 as $value1) {
				// 	$encontrado=false;
				// 	foreach ($array2 as $value2) {
				// 		if ($value1 == $value2){
				// 			$encontrado=true;
				// 			$break;
				// 		}
				// 	}
				// 	if ($encontrado == false){
				// 		echo "---> $value1<br>\n";
				// 	}
				// }
				// echo "<br>\nElementos que sólo existen en array2<br>\n";
				// foreach ($array2 as $value2) {
				// 	$encontrado=false;
				// 	foreach ($array1 as $value1) {
				// 		if ($value1 == $value2){
				// 			$encontrado=true;
				// 			$break;
				// 		}
				// 	}
				// 	if ($encontrado == false){
				// 		echo "---> $value2<br>\n";
				// 	}
				// }

				}



			}

			public function ModificarOficio()
			{
		# code..

				$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
				$this -> form_validation -> set_rules('asunto_a','Asunto','required');
				$this -> form_validation -> set_rules('emisor_a','Emisor','required');
				//$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
					$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
					$data['entradas_limit'] = $this -> Modelo_recepcion -> getAllEntradasLimitInformativos();
					$data['valores_doc'] = $this -> Modelo_recepcion -> getAllValoresDoc();
					$data['vigencia_doc'] = $this -> Modelo_recepcion -> getAllVigenciaDoc();
					$data['clasificacion_informacion'] = $this -> Modelo_recepcion -> getAllClasificacionInfo();
					$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
					$data['tipo_documento'] = $this -> Modelo_recepcion-> getAllTipoDocumento();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/entradas/recepcion');
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
						$tipo_dias = $this -> input -> post('tipo_dias_a'),
						$codigo = $this -> input -> post('codigo_a'),
						$valor_doc  = $this -> input -> post('valor_doc_a'),
						$vigencia_doc  = $this -> input -> post('vigencia_doc_a'),
						$clasificacion_info = $this -> input -> post('clasificacion_info_a'),
						$tipo_doc_archivistico = $this -> input -> post('tipo_doc_archivistico_a'),
						$requiereRespuesta =  $this -> input -> post('ReqRespuesta_a'),
						$tipo_dias_a =  $this -> input -> post('tipo_dias_a'),
						$fecha_termino_a =  $this -> input -> post('fecha_termino_a')

					);


				date_default_timezone_set('America/Mexico_City');
				$fecha_actual = date('Y-m-d');

					if ($requiereRespuesta == '0') {
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
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}

							}
							else
							{
								//Si el usuario no captura el archivo se debe de dejar el mismo que ya habia subido con anterioridad
								
								$consultarArchivoActual = $this->Modelo_recepcion->getArchivoActual($id);
								foreach ($consultarArchivoActual as $key) {

									$archivo_actualizable = $key->archivo_oficio;
								}

							}

						}

					//Definir los arreglos que van a guardar las direcciones de la base de datos
					//y del formulario que el usuario determine
						$dirconsultadas =  array();
						$direccionesFormulario = array();
					// Se obtienen las direcciones que tienen asignado el numero de oficio, mediante una consulta, el resultado se guarda en un arreglo
						$this -> load -> model('Modelo_recepcion');
						$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
						foreach ($query as $key) {

							$direccion_destinobd = $key->direccion_destino;
							array_push($dirconsultadas, $direccion_destinobd);

						}
					//se asignan las direcciones leidas del formulario en la variable $direccionesFormulario para posteriomente ser usado
						$direccionesFormulario = $_POST['direccion_a'];

					//Se obtiene la longitud de cada arreglo de tal manera que puedan conpararse
						$num_datos_bd = sizeof($dirconsultadas);
						$num_datos_formulario = sizeof($direccionesFormulario);

					//Si el numero de registros obtenidos de la BD son iguales a los datos del formulario entonces, el usuario no realizo ninguna manipulacion, la modificiacion es directa.
					//
					//Si no, significa que el usuario marco uno o mas checkboxes, para agregar nuevas direcciones y asignarles el oficio

						if ($num_datos_bd == $num_datos_formulario) {
							//echo "Los datos del formulario y BD son iguales, solo se actualizará"."<br>";
						//MODIFICAR
							$this -> load -> model('Modelo_recepcion');
							$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
							foreach ($query as $key) {

								foreach ($direccionesFormulario as $dir) {

									$actualizar = $this->Modelo_recepcion->modificarRegistro($key->id_recepcion,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $dir, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta, $fecha_termino_a);

									//status bandera_respuesta
								}
							}

               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
							if($actualizar)
							{ 	
								$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}

							else
							{
								$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}
						}

						else
							if ($num_datos_bd < $num_datos_formulario) 

							{
							//echo "Se detectaron una o varias direcciones por agregar: "."<br>";
							foreach ($direccionesFormulario as $value2) {
								$encontrado=false;
								foreach ($dirconsultadas as $value1) {
									if ($value1 == $value2){
										$encontrado=true;
										$break;
									}
								}
								if ($encontrado == false){
									//echo "---> $value2<br>\n";

								//Realizar una consulta a la base de datos, para obtener los datos del oficio, de tal manera que se agregue la nueva o las nuevas direcciones elegidas por el usuario

									$query = $this->Modelo_recepcion->getAllsByNumOficioLimitado1($num_oficio);
									foreach ($query as $key) {

										$agregar = $this->Modelo_recepcion->insertarEntrada($key->num_oficio,$key->fecha_recepcion,$key->hora_recepcion,$key->asunto,$key->tipo_recepcion, $key->tipo_documento, $key->emisor,$key->dependencia_emite, $key->cargo, $value2, $key->fecha_termino, $key->archivo_oficio, $key->status, $key->prioridad, $key->observaciones,$key->flag_direciones,$key->tipo_dias, $key->requiereRespuesta, $key->fecha_recep_fisica, $key->hora_recep_fisica, $key->fecha_emision, $key->hora_emision, $key->codigo_archivistico, $key->valor_doc, $key->vigencia_doc, $key->clasificacion_info, $key->tipo_doc_archivistico);

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
										$correos = $this->Modelo_recepcion->obtenerCorreoMultiple($value2);
										foreach ($correos as $llave) {

											$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
											$this->email->to($llave->email);
					 //Agregar el correo personal de los usuarios 
											$this->email->cc($llave->email_personal);
											$this->email->subject('Nuevo Oficio');
											$this->email->message('<h2>Has recibido el oficio externo: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
											$this->email->send();
					 //con esto podemos ver el resultado
											var_dump($this->email->print_debugger());
										}
										

										$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
										foreach ($query as $key) {

											$actualizar = $this->Modelo_recepcion->modificarRegistro($key->id_recepcion,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable,$codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta, $fecha_termino_a);
										}

               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
										if($actualizar)
										{ 	
											$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
											redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
										}

										else
										{
											$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
											redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
										}
									}
									else
										{
											$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
											redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
										}
								}
							}

						}	
						else
							if ($num_datos_bd > $num_datos_formulario) {


							foreach ($dirconsultadas as $dirbd) {
									$encontrado=false;
									foreach ($direccionesFormulario as $dirform) {
										if ($dirbd == $dirform){
											$encontrado=true;
											$break;
										}
									}
									if ($encontrado == false){
										
										$eliminarDireccion = $this->Modelo_recepcion->EliminarDireccion($dirbd);
									}
								}

							if ($eliminarDireccion) {
								# code...
								$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
								foreach ($query as $key) {

									$actualizar = $this->Modelo_recepcion->modificarRegistro($key->id_recepcion,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable,$codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta, $fecha_termino_a);
								}

               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
								if($actualizar)
								{ 	
									$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}

								else
								{
									$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}
							}
							else
								{
									$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}
						}
					}
				}
		// 	public function ModificarOficio_COPIA_SEGURIDAD()
		// 	{
		// # code..

		// 		$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
		// 		$this -> form_validation -> set_rules('asunto_a','Asunto','required');
		// 		$this -> form_validation -> set_rules('emisor_a','Emisor','required');
		// 		$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

		// 		if ($this->form_validation->run() == FALSE) {
		// 	# code...
		// 			$data['titulo'] = 'Recepción de Oficios';
		// 			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
		// 			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
		// 			$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
		// 			$this->load->view('plantilla/header', $data);
		// 			$this->load->view('recepcion/entradas/recepcion');
		// 			$this->load->view('plantilla/footer');	


		// 		}
		// 		else
		// 		{
		// 			$data =  array(
		// 				$id =  $this -> input -> post('txt_idoficio'),
		// 				$num_oficio = $this -> input -> post('num_oficio_a'),
		// 				$asunto = $this -> input -> post('asunto_a'),
		// 				$tipo_recepcion = $this -> input -> post('tipo_recepcion_a'),
		// 				$tipo_documento = $this -> input -> post('tipo_documento_a'),
		// 				$emisor = $this -> input -> post('emisor_a'),
		// 				$direccion = $this -> input -> post('direccion_a'),
		// 				$fecha_termino = $this -> input -> post('fecha_termino_a'),
		// 				$status = $this -> input -> post('status_a'),
		// 				$prioridad = $this -> input -> post('prioridad_a'),
		// 				$observaciones = $this -> input -> post('observaciones_a'),
		// 				$tipo_dias = $this -> input -> post('tipo_dias_a')
		// 			);


		// 			if (isset($_POST['btn_enviar_a']))
		// 			{
		// 	// Cargamos la libreria Upload
		// 				$this->load->library('upload');

  //       //CARGANDO SLIDER
		// 				if (!empty($_FILES['archivo_a']['name']))
		// 				{
  //           // Configuración para el Archivo 1
		// 					$config['upload_path'] = './doctos/';
		// 					$config['allowed_types'] = 'pdf|docx';
		// 					$config['remove_spaces']=FALSE;
		// 					$config['max_size']    = '2048';
		// 					$config['overwrite'] = TRUE;

		// 					if ($config['allowed_types'] = 'pdf|PDF') {
		// 						$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
		// 						$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'pdf';
		// 						$archivo_actualizable = $pdf_formateado.'.'.'pdf';
		// 					}
		// 					else
		// 						if ($config['allowed_types'] = 'docx|DOCX') {
		// 							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
		// 							$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'docx';
		// 							$archivo_actualizable = $pdf_formateado.'.'.'docx';
		// 						}

  //           				// Cargamos la configuración del Archivo 1
		// 						$this->upload->initialize($config);

  //          				 // Subimos archivo 1
		// 						if ($this->upload->do_upload('archivo_a'))
		// 						{
		// 							$data = $this->upload->data();
		// 						}
		// 						else
		// 						{
		// 							$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
		// 							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
		// 						}

		// 					}

		// 				}

		// 				$this -> load -> model('Modelo_recepcion');
		// 				$query = $this->Modelo_recepcion->getAllsByNumOficio($num_oficio);
		// 				foreach ($query as $key) {

		// 					$actualizar = $this->Modelo_recepcion->modificarRegistro($key->id_recepcion,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $key->direccion_destino, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable);
		// 				}

  //              //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
		// 				if($actualizar)
		// 				{ 	
		// 					$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
		// 					redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
		// 				}

		// 				else
		// 				{
		// 					$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
		// 					redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
		// 				}		
		// 			}	

		// 		}

				public function ModificarOficioInformativo()
				{
		# code..

					$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
					$this -> form_validation -> set_rules('asunto_a','Asunto','required');
					$this -> form_validation -> set_rules('emisor_a','Emisor','required');
					$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

					if ($this->form_validation->run() == FALSE) {
			# code...
						$data['titulo'] = 'Recepción de Oficios';
						$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
						$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
						$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
						$this->load->view('plantilla/header', $data);
						$this->load->view('recepcion/entradas/recepcion');
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
										redirect(base_url() . 'RecepcionGral/Entradas/OficiosInformativos/');
									}

								}

							}

							$actualizar = $this->Modelo_recepcion->modificarRegistro($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo_actualizable);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
							if($actualizar)
							{ 	
								$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
								redirect(base_url() . 'RecepcionGral/Entradas/OficiosInformativos/');
							}

							else
							{
								$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
								redirect(base_url() . 'RecepcionGral/Entradas/OficiosInformativos/');
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
							$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
							$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
							$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
							$this->load->view('plantilla/header', $data);
							$this->load->view('recepcion/entradas/recepcion');
							$this->load->view('plantilla/footer');	

						}
						else
						{
							$data =  array(
								$direccion_destino = $this -> input -> post('direccion_a'),
								$id_oficio = $this -> input -> post('txt_idoficio'),
								$num_oficio = $this -> input -> post('txt_num_oficio'),
								$observaciones = $this -> input -> post('observaciones_a'),
								$nombre_emisor = $this -> input -> post('emisor_h')
							);

							$consulta = $this->Modelo_recepcion->seleccionarDir($id_oficio);
							foreach ($consulta as $key) {
								$direccion = $key->id_direccion_destino;
							}

							if ($direccion_destino != $direccion) {

								$turnar = $this->Modelo_recepcion->TurnarADireccion($direccion_destino,$id_oficio,$observaciones,$nombre_emisor);

								if($turnar)
								{ 	
						// ENVIO DE NOTIFICACION VIA CORREO 
									$this->load->library("email");
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

									$this->email->initialize($configGmail);
									$this->email->from('Sistema de Gestion de Oficios del CSEIIO');

									$correos = $this ->Modelo_recepcion->obtenerCorreos($direccion_destino);
									foreach ($correos as $key) {
										$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
										$this->email->cc($key->email_personal);
									}					
									$this->email->subject('Copia turnada a esta dirección');
									$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para su conocimiento o atención. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Oficios con Copia a esta Dirección."</h2><hr><br> Correo informativo libre de SPAM');
									$this->email->send();
					 //con esto podemos ver el resultado
									var_dump($this->email->print_debugger());

						//enviar correo a la direccion en turno indicandole que se le ha turnado una copia del oficio
									$this->session->set_flashdata('actualizado', 'Se ha turnado copia a la dirección seleccionada');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}

								else
								{
									$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia a la direccion seleccionada, verifique');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}
							}
							else
							{
								$this->session->set_flashdata('error', ' Se esta tratando de turnar copia la misma dirección.');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
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
							$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
							$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
							$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
							$this->load->view('plantilla/header', $data);
							$this->load->view('recepcion/entradas/recepcion');
							$this->load->view('plantilla/footer');	


						}
						else
						{
							$data =  array(
								$depto_destino = $this -> input -> post('area_destino'),
								$id_oficio = $this -> input -> post('txt_idoficio'),
								$observaciones = $this -> input -> post('observaciones_a'),
								$num_oficio = $this -> input -> post('txt_num_oficio'),
								$nombre_emisor = $this -> input -> post('emisor_h'),
								$id_direccion = $this -> input -> post('txt_id_direccion')
							);

							if ($observaciones == 'atencion') {
						# code...

								$consulta = $this->Modelo_direccion->seleccionarDepto($id_oficio);
								foreach ($consulta as $key) {
									$area = $key->id_area;
								}

								date_default_timezone_set('America/Mexico_City');
								$fecha_recepcion = date('Y-m-d');
								$hora_recepcion =  date("H:i:s");
								$observaciones = 'Para su atención y respuesta';

								if ($depto_destino != $area) {
						# code...
									$turnar = $this->Modelo_recepcion->TurnarADeptos($depto_destino,$id_oficio,$observaciones,$nombre_emisor);

									$modificarObservacion = $this->Modelo_recepcion->modificarObservacionGeneral($id_oficio,$observaciones);

									if($turnar)
									{ 	
						//Asigna el oficio
										$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$depto_destino,$id_oficio,$observaciones,$fecha_recepcion,$hora_recepcion);


										$habilitar = $this->Modelo_recepcion->cambiarBanderaHabilitado($id_oficio);

								// ENVIO DE NOTIFICACION VIA CORREO 
										$this->load->library("email");
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

										$this->email->initialize($configGmail);
										$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
								// Obtención de corres del departamento
										$correos = $this ->Modelo_recepcion->obtenerCorreosPorDepartamento($depto_destino);
										foreach ($correos as $key) {
											$this->email->to($key->email);
								 //Agregar el correo personal de los usuarios 
											$this->email->cc($key->email_personal);
										}					
										$this->email->subject('Copia turnada este departamento');
										$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para antención o respuesta. Solicita que tu Dirección habilite el oficio para su respuesta. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Buzón de Oficios."</h2><hr><br> Correo informativo libre de SPAM');
										$this->email->send();
					 			//con esto podemos ver el resultado
										var_dump($this->email->print_debugger());

								//enviar correo a la direccion en turno indicandole que se le ha turnado una copia del oficio

										$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
										redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
									}

									else
									{
										$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
										redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
									}	

								}
								else
								{
									$this->session->set_flashdata('error', ' Se esta tratando de turnar copia al mismo departamento');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}
							}
							else
								if ($observaciones == 'conocimiento') {
									$consulta = $this->Modelo_direccion->seleccionarDepto($id_oficio);
									foreach ($consulta as $key) {
										$area = $key->id_area;
									}

									date_default_timezone_set('America/Mexico_City');
									$fecha_recepcion = date('Y-m-d');
									$hora_recepcion =  date("H:i:s");
									$observaciones = 'Para su conocimiento';

									if ($depto_destino != $area) {
						# code...
										$turnar = $this->Modelo_recepcion->TurnarADeptos($depto_destino,$id_oficio,$observaciones,$nombre_emisor);

										$modificarObservacion = $this->Modelo_recepcion->modificarObservacionGeneral($id_oficio,$observaciones);

										if($turnar)
										{ 	

								// ENVIO DE NOTIFICACION VIA CORREO 
											$this->load->library("email");
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

											$this->email->initialize($configGmail);
											$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
								// Obtención de corres del departamento
											$correos = $this ->Modelo_recepcion->obtenerCorreosPorDepartamento($depto_destino);
											foreach ($correos as $key) {
												$this->email->to($key->email);
								 //Agregar el correo personal de los usuarios 
												$this->email->cc($key->email_personal);
											}					
											$this->email->subject('Copia turnada este departamento');
											$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para conocimiento. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="'.base_url().'">aquí</a> y revisa el panel "Turnado de Copias."</h2><hr><br> Correo informativo libre de SPAM');
											$this->email->send();
					 			//con esto podemos ver el resultado
											var_dump($this->email->print_debugger());


											$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
											redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
										}

										else
										{
											$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
											redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
										}	

									}
									else
									{
										$this->session->set_flashdata('error', ' Se esta tratando de turnar copia al mismo departamento');
										redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
									}
								}
							}
						}


						public function Descargar($name)
						{
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

			 public function llenarInputEmisor()
			 {
					//Consulta el nombre de la dependencia en conjunto con los datos de 
					//la dependencia 
			 	$dependencia =  $_POST["dependencia"];
			 	if ($dependencia) 
			 	{
			 		$informacion = $this->Modelo_recepcion->getInfoDependencias($dependencia);

			 		foreach ($informacion as $row)
			 		{
			 			$options="<input name='emisor' class='form-control' value='".$row->titular."' required>"; 
			 			echo $options; 
			 		}
			 	}
			 }

			 public function llenarInputCargo()
			 {
					//Consulta el nombre de la dependencia en conjunto con los datos de 
					//la dependencia cargo dependencia
			 	$dependencia =  $_POST["dependencia"];
			 	if ($dependencia) 
			 	{
			 		$informacion = $this->Modelo_recepcion->getInfoDependencias($dependencia);

			 		foreach ($informacion as $row)
			 		{
			 			$options="<input name='cargo' class='form-control' value='".$row->cargo."' required>"; 
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
			 		$data['titulo'] = 'Recepción de Oficios';
			 		$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			 		$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			 		$data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			 		$this->load->view('plantilla/header', $data);
			 		$this->load->view('recepcion/entradas/recepcion');
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
			 			redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
			 		}
			 		else
			 		{
			 			$this->session->set_flashdata('error', 'La dependencia: <strong> '.$nombre_dependencia. ' </strong> no se registró, verifique la información');
			 			redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
			 		}
			 	}
			 }

			 public function CambiaEstatus()
			 {
			 	$consulta = $this->Modelo_recepcion->getAllEntradas();

			 	foreach ($consulta as $key) {
			 		$idoficio = $key->id_recepcion;

			 		if($this->db->query("CALL comparar_fechas('".$idoficio."')"))
			 		{
			 			echo 'Ejecutando Cambios';
			 		}else{
			 			show_error('Error! al ejecutar');
			 		}
			 	}

			 	redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
			 }

			}