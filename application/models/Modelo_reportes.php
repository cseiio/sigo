<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_reportes extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();	
	}

													// REPORTES GENERALES

	public function getAllOficiosExternos($inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllOficiosExternosByDepedendencia($inicio, $final, $nombre_dependencia)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND dependencia_emite = '".$nombre_dependencia."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllOficiosInformativos($inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND requiereRespuesta = '0'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllOficiosExternosByID($id_recepcion)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
		$where = "recepcion_oficios.id_recepcion = '".$id_recepcion."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getOficiosContestados($inicio, $final)
	{
		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Contestado'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getOficiosNoContestados($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND status = 'No Contestado' OR status = 'Pendiente'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getOficiosPendientes($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND status = 'Pendiente' ";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();

	}

		public function getOficiosFueradeTiempo($inicio, $final)
	{
		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Fuera de Tiempo'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}


														// REPORTES POR DIRECCIONES
	//Todos los oficios
	
	public function getAllOficiosDirecciones($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.codigo_archivistico as ca');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND id_direccion ='".$id_direccion."' ";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	//Obtener la informacion de oficios contestado basado en el id de recepcion por direcciones 
	
	public function getOficiosContestadosDirbyID($id_recepcion)
	{

		$this->db->select('*');
		$this->db->select('recepcion_oficios.codigo_archivistico as ca');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			//  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$where = "recepcion_oficios.id_recepcion = '".$id_recepcion."'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();													# code...
	}
	// Oficios descargados por direccion 
	public function getOficiosContestadosDir($id_direccion,$inicio, $final)
	{

		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();													# code...
	}	
	// Oficios no contestados por la direcion x
	
		public function getOficiosNoContestadosDir($id_direccion, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND status = 'No Contestado' AND id_direccion ='".$id_direccion."' ";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}	

	//Oficios pendientes por la direccion x
	
    public function getOficiosPendientesDir($id_direccion, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$where = "fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND status = 'Pendiente' AND id_direccion ='".$id_direccion."' ";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}	

	//Oficio fuera de tiempo por la direccion x
	
		public function getOficiosFueradeTiempoDir($id_direccion, $inicio, $final)
	{
		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}
		

	// REPORTES POR DEPARTAMENTOS
	//Todos los oficios	
	
	public function getDeptosByIdDireccion($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}	


	public function getAllOficiosDeptos($id_depto, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.codigo_archivistico as ca');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND departamentos.id_area = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by('recepcion_oficios.fecha_recepcion', 'desc');	
		$consulta = $this->db->get();
		return $consulta -> result();
	}	

	public function getOficiosContestadosDepto($id_depto, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
		$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Contestado' AND departamentos.id_area  = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	// Obtener oficios contestados por id del oficio
	public function getOficiosContestadosDeptoByID($id_recepcion)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
		$where = "recepcion_oficios.id_recepcion = '".$id_recepcion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	//getOficiosNoContestadosDepto
						
	public function getOficiosNoContestadosDepto($id_depto, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'No Contestado' AND departamentos.id_area  = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();

	}	

	//Oficios pendientes por la direccion x
	
    public function getOficiosPendientesDepto($id_depto, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.observaciones as obgenerales');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Pendiente' AND departamentos.id_area  = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getOficiosContestadosFuera($id_depto, $inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'asignacion_oficio.id_area = departamentos.id_area');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			//$this->db->where('recepcion_oficios.status', 'Contestado');
		$where = "recepcion_oficios.fecha_recepcion BETWEEN '".$inicio."' AND '".$final."' AND recepcion_oficios.status = 'Fuera de Tiempo' AND departamentos.id_area  = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	//----------------------------------------- REPORTES INTERNOS -----------------------------------------------------
	
	public function getAllOficiosDireccionesInt($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('emision_interna');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND direcciones.id_direccion ='".$id_direccion."' ";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();

	}

	public function getAllOficiosDireccionesIntByID($id_recepcion_int)
	{
		$this->db->select('*');

		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');

		$this->db->from('emision_interna');

		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');

		//$this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');

		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');

		$where = "emision_interna.id_recepcion_int = '".$id_recepcion_int."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();

	}



	 

	function getAllPendientesInternos($id_direccion,$inicio, $final)
	{
		

			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestadosInternos($id_direccion,$inicio, $final)
	{
		// $this->db->select('*');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Contestado' AND emision_interna.emisor ='".$nombre."' ";
		// 	$this->db->where($where, NULL, FALSE);
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		 $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		//$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();


	}

	function getAllNoContestadosInternos($id_direccion,$inicio, $final)
	{
		// $this->db->select('*');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='No Contestado' AND emision_interna.emisor ='".$nombre."' ";
		// $this->db->where($where, NULL, FALSE);
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();


		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			//$where = "emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempoInternos($id_direccion,$inicio, $final)
	{
		// $this->db->select('*');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //     $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo' AND emision_interna.emisor ='".$nombre."' ";
		// 	$this->db->where($where, NULL, FALSE);
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			//$where = "emision_interna.status = 'Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	// DEPARTAMENTOS

	 function getAllEntradasInternasDepto($nombre,$inicio, $final)
	{
			// $this->db->select('*');
			// $this->db->from('emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.emisor ='".$nombre."' ";
			// $this->db->where($where, NULL, FALSE);
			// $this->db->order_by('emision_interna.fecha_emision', 'desc');
			// $consulta = $this->db->get();
			// return $consulta -> result();
			
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.emisor = '".$nombre."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getBuzonDeOficiosEntrantesDepto($iddepartamento,$inicio, $final)
	{


		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		$this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		$this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND  asignacion_interna.id_area = '".$iddepartamento."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();

		// $this->db->select('*');
		// $this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		// $this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		//     $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		// 	$where = "asignacion_interna.id_area = '".$iddepartamento."'";
		// 	$this->db->where($where, NULL, FALSE);
		// 	$consulta = $this->db->get();
		// 	return $consulta -> result();
		
		
	}

	function getAllOficiosEntrantesByDeptoIntByID($idrecepcion)
	{

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.id_recepcion_int = '".$idrecepcion."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	function getAllPendientesInternosDepto($id_area,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		$this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		$this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		//$this->db->where('asignacion_interna.id_area', $iddepartamento)
		$where = "emision_interna.status = 'Pendiente' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND departamentos.id_area ='".$id_area."' ";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	
	}

	function getAllContestadosInternosDepto($id_area,$inicio, $final)
	{
		

		$this->db->select('*');
			$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
		    
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');

		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');

		    $this->db->join('departamentos', 'respuesta_interna.id_area_responde = departamentos.id_area');

		    $where = "emision_interna.status = 'Contestado' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND departamentos.id_area ='".$id_area."' ";

			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();


	}

	function getAllNoContestadosInternosDepto($id_area,$inicio, $final)
	{
		// $this->db->select('*');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //       $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='No Contestado' AND emision_interna.emisor ='".$nombre."' ";
		// $this->db->where($where, NULL, FALSE);
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();
		
		// $this->db->select('*');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		// 	$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'  AND asignacion_interna.id_area = '".$id_area."'";
		// 	$this->db->where($where, NULL, FALSE);
		// 	$consulta = $this->db->get();
		// 	return $consulta -> result();
		$this->db->select('*');
			$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
		    
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');

		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');

		    $this->db->join('departamentos', 'respuesta_interna.id_area_responde = departamentos.id_area');

		    $where = "emision_interna.status = 'No Contestado' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND departamentos.id_area ='".$id_area."' ";

			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempoInternosDepto($id_area,$inicio, $final)
	{
		// $this->db->select('*');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo' AND emision_interna.emisor ='".$nombre."' ";
		// 	$this->db->where($where, NULL, FALSE);
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();
		
		// $this->db->select('*');
		// $this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		// $this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');

		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		// $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status = 'Fuera de Tiempo' AND respuesta_interna.id_area_responde = '".$id_area."'";
		// $this->db->where($where, NULL, FALSE);
		// $consulta = $this->db->get();
		// return $consulta -> result();

		$this->db->select('*');
			$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
		    
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');

		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');

		    $this->db->join('departamentos', 'respuesta_interna.id_area_responde = departamentos.id_area');

		    $where = "emision_interna.status = 'Fuera de Tiempo' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND departamentos.id_area ='".$id_area."' ";

			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	//Obteniendo el departamento al que se le ha asignado el oficio
	
	function getAsignacionById($id_recepcion)
	{
		$this->db->select('departamentos.nombre_area');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'departamentos.id_area = asignacion_oficio.id_area');
		$this->db->where('recepcion_oficios.id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	function getAllOficiosSalida($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
		$this->db->order_by('oficios_salida.fecha_emision', 'desc');
		$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllOficiosSalidaByDependencia($inicio, $final, $nombre_dependencia)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
		$this->db->order_by('oficios_salida.fecha_emision', 'desc');
		$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND dependencia_remitente = '".$nombre_dependencia."'";
		//$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllOficiosSalidaPlanteles($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
		$this->db->order_by('oficios_salida_planteles.fecha_emision', 'desc');
		$where = "oficios_salida_planteles.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida_planteles.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllOficiosInformativosPlanteles($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
		$this->db->order_by('oficios_salida_planteles.fecha_emision', 'desc');
		$where = "oficios_salida_planteles.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida_planteles.tieneRespuesta = '0' AND oficios_salida_planteles.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllRespuestasASalidas($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('oficios_salida_planteles.emisor as emisorplantel, oficios_salida_planteles.cargo as cargoplantel, respuesta_salida_planteles.cargo as cargores, respuesta_salida_planteles.emisor as emisorres');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_salida_planteles', 'oficios_salida_planteles.id_oficio_salida = respuesta_salida_planteles.oficio_emision');
		$where = "oficios_salida_planteles.status = 'Contestado' AND oficios_salida_planteles.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida_planteles.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getAllOficiosSalidaDocentes($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->order_by('oficios_docentes.fecha_emision', 'desc');
		$where = "oficios_docentes.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_docentes.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getAllOficiosDocentesByID($id_recepcion)
	{
		$this->db->select('*');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_docentes', 'oficios_docentes.id_oficio_salida = respuesta_docentes.oficio_emision');
		$where = "oficios_docentes.id_oficio_salida = '".$id_recepcion."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('oficios_docentes.id_oficio_salida');
		$this->db->order_by('oficios_docentes.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllRespuestasADocentes($id_direccion,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_docentes', 'oficios_docentes.id_oficio_salida = respuesta_docentes.oficio_emision');
		$where = "oficios_docentes.status = 'Contestado' AND oficios_docentes.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_docentes.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('oficios_docentes.id_oficio_salida');
		$this->db->order_by('oficios_docentes.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	//Obtener los oficios informativos (Aquellos que no poseen respuesta.)
    function getAllInformativosSalida()
	{
			$this->db->select('*');
			$this->db->from('oficios_salida');
			$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
			$this->db->where('status', 'Informativo');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	// --------- REPORTES DE ADMINISTRADOR - INTERNOS ------------------
	
	public function getFullOficiosDireccionesInt($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('emision_interna');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();

	}

	function getFullContestadosInternos($inicio, $final)
	{

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		 $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Contestado'";
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();

	}

		function getFullNoContestadosInternos($inicio, $final)
	{
	

		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='No Contestado'";

			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getFullPendientesInternos($inicio, $final)
	{
		

			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	

			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getFullFueraTiempoInternos($inicio, $final)
	{
		
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	// ---------  REPORTE DE ACCESOS ------------
	// 
	
	public function getAllAccesos($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('crtl_acceso');
		$where = "fecha_acceso BETWEEN '".$inicio."' AND '".$final."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('fecha_acceso', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	// ---- REPORTES DE OFICIOS DE SALIDA 
	
	
	// public function getAllContestadosSalidas2($inicio, $final)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('oficios_salida');

	// 	$this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');

	// 	$this->db->join('codigos_archivisticos', 'respuesta_oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');

	// 	$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida.status='Contestado'";

	// 	$this->db->where($where, NULL, FALSE);	
	// 	$this->db->group_by('oficios_salida.id_oficio_salida');
	// 	$consulta = $this->db->get();
	// 	return $consulta -> result();
	// }


    function getAllContestadosSalidas($inicio, $final)
	{
		$this->db->select('*');

		$this->db->from('oficios_salida');
		$this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		 $where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida.status='Contestado'";
		$this->db->where($where , NULL, FALSE);
	
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	public function getAllContestadosFueraTiempoSalidas($inicio, $final)
	{
			$this->db->select('*');
			$this->db->from('oficios_salida');
			 $this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
			  $where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida.status='Fuera de Tiempo'";
			//$where = "oficios_salida.status = 'Contestado'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('oficios_salida.id_oficio_salida');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

		public function getAllPendientesSalidas($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida.status='Pendiente'";
			$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
			return $consulta -> result();
	}

		public function getAllNoContestadosSalidas($inicio, $final)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$where = "oficios_salida.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND oficios_salida.status='No Contestado'";
			$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getAllOficiosEmitidosDirInt($area_trabajo,$inicio, $final)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('emision_interna.emisor', $nombre);
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.area_trabajo ='".$area_trabajo."' ";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllOficiosEmitidosDirIntByDependencias($area_trabajo,$inicio, $final, $dependencia)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('emision_interna.emisor', $nombre);
			$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.area_trabajo ='".$area_trabajo."' AND emision_interna.dependencia ='".$dependencia."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.fecha_emision', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

		function getAllOficiosPendientesEmitidos($area_trabajo,$inicio, $final)
	{
		

			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'Pendiente' AND emision_interna.area_trabajo = '".$area_trabajo."' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestadosEmitidos($area_trabajo,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		//$this->db->where('emision_interna.area_trabajo', $area_trabajo);
		$where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status = 'Contestado' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();

		
		// $this->db->select('*');
		// $this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		// $this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $where = "emision_interna.status = 'Contestado' AND emision_interna.emisor = '".$nombre."'";
		// $this->db->where($where, NULL, FALSE);
		// $consulta = $this->db->get();
		// return $consulta -> result();


	}

	function getAllFueraTiempoEmitidos($area_trabajo,$inicio, $final)
	{
	
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	//	$this->db->where('direcciones.id_direccion', $id_direccion);
		 $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		//$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();


	// 	$this->db->select('*');
	// 	$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
	// 	$this->db->from('emision_interna');
	// 	$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
	// 	$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
	// 	$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	// //	$this->db->where('direcciones.id_direccion', $id_direccion);
	// 	 $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Contestado' AND emision_interna.emisor = '".$nombre."'";
	// 	//$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
	// 	$this->db->where($where, NULL, FALSE);
	// 	$this->db->order_by('emision_interna.fecha_emision', 'desc');
	// 	$consulta = $this->db->get();
	// 	return $consulta -> result();

	}

	function getAllNoContestadosEmitidos($area_trabajo,$inicio, $final)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'No Contestado' AND emision_interna.area_trabajo = '".$area_trabajo."' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getAllOficiosPendientesEmitidosDepto($area_trabajo,$inicio, $final)
	{
		$this->db->select('*');
			//$this->db->select('count(*) as cuantos');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Pendiente' and emision_interna.area_trabajo = '".$area_trabajo."' AND emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllOficiosFueraDeTiempoEmitidosDepto($area_trabajo,$inicio, $final)
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	//	$this->db->where('direcciones.id_direccion', $id_direccion);
		 $where = "emision_interna.fecha_emision BETWEEN '".$inicio."' AND '".$final."' AND emision_interna.status='Fuera de Tiempo' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		//$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by('emision_interna.fecha_emision', 'desc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	
	
	public function buscador($abuscar)
	{
 //usamos after para decir que empiece a buscar por
 //el principio de la cadena
 //ej SELECT localidad from localidades_es 
 //WHERE localidad LIKE '%$abuscar' limit 12
		$this->db->select('emisor, count(DISTINCT emisor)');
		$this->db->where('area_trabajo', 'DIRECCIÓN GENERAL');
		$this->db->like('emisor',$abuscar);
		$resultados = $this->db->get('emision_interna');

 //si existe algún resultado lo devolvemos
		if($resultados->num_rows() > 0)
		{

			return $resultados->result();

 //en otro caso devolvemos false
		}else{

			return FALSE;

		}

	}


}

/* End of file Modelo_reportes.php */
/* Location: ./application/models/Modelo_reportes.php */