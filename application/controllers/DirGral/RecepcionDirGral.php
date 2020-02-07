<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RecepcionDirGral extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$this -> load -> model('Model_dirgral');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Recepción de Oficios';
		$data['entradas'] = $this -> Model_dirgral -> getAllEntradas($this->session->userdata('id_direccion'));
		$data['deptos'] = $this -> Model_dirgral -> getDeptos($this->session->userdata('id_direccion'));
		$consulta = $this->Model_dirgral->getAllEntradas($this->session->userdata('id_direccion'));
		foreach ($consulta as $key) {
    		$idoficio = $key->id_recepcion;
    		if (!$key->status == 'Fuera de Tiempo') {
    			$this->db->query("CALL comparar_fechas('".$idoficio."')");
    		}
    		
    	}
		$this->load->view('plantilla/header', $data);
		$this->load->view('dirgral/recepciondirgral');
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

        redirect(base_url() . 'RecepcionGral/Recepcion/');
    }

    	public function asignarOficio()
	{
		$this -> form_validation -> set_rules('direccion','Dirección','required');
		//$this -> form_validation -> set_rules('area_destino','Departamento','required');
		$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Model_dirgral -> getAllEntradas($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Model_dirgral -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/recepciondir');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			$data =  array(
				$num_oficio = $this-> input -> post('num_oficio_h'),
				$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
				$id_direccion = $this -> input -> post('direccion'),
				$observaciones = $this -> input -> post('observaciones'),
				);

			date_default_timezone_set('America/Mexico_City');
			$fecha_recepcion = date('Y-m-d');
			$hora_recepcion =  date("H:i:s");

			$dir = $this->Model_dirgral->consultarNombreDir($id_direccion);
					foreach ($dir as $key) {
						
						$nombre_dir= $key->nombre_direccion;
    				}
            
			
				$asignar = $this->Model_dirgral->asignarOf($id_direccion,$id_oficio_recepcion,$observaciones,$fecha_recepcion,$hora_recepcion);

				if($asignar)
					{ 	
						$this->Model_dirgral->cambiarBanderaAsignacion($id_oficio_recepcion);
						$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado al: <strong> ' .$nombre_dir. ' </strong> con éxito');
						redirect(base_url() . 'DirGral/RecepcionDirGral/');
					}
					else
					{
						$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_dir.' </strong> verifique su información.');
						redirect(base_url() . 'DirGral/RecepcionDirGral/');
					}
		}
		
	}


}

/* End of file RecepcionDirGral.php */
/* Location: ./application/controllers/RecepcionDirGral.php */