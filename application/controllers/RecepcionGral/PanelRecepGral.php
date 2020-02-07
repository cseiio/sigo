<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelRecepGral extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {

			$data['titulo'] = 'Panel de Recepción General';
			$data['conteoTotal'] = $this->Modelo_recepcion->conteo_total();
			$data['contestados'] = $this->Modelo_recepcion->contestados();
			$data['pendientes'] = $this->Modelo_recepcion->pendientes();
			$data['nocontestados'] = $this->Modelo_recepcion->nocontestados();
			$data['fueratiempo'] = $this->Modelo_recepcion->fuera_de_tiempo();
			$data['totalsalientes'] = $this->Modelo_recepcion->total_salientes();
			$data['totalinformativos'] = $this->Modelo_recepcion->total_informativos();
			//Para consultar los oficios asignados por día, se realiza la consulta pasando como parametro la fecha actual del servidor configurado con el date_time de Mexico, de tal manera que realice la consulta de los oficios recibidos en el día que arroje el date_time()
			//FECHA
			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			$data['contestadosDatos'] = $this ->Modelo_recepcion-> getAllContestadosbyFecha($fecha_hoy);
			
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/index');
			$this->load->view('plantilla/footer');

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

