<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_direccion extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();		
	}


	function getAllEntradas($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('direcciones');
		    $this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
			//$this->db->where('recepcion_oficios.flag_deptos', '0');
			//$this->db->where('recepcion_oficios.respondido', '0');
			//$this->db->where('requiereRespuesta', '0');
			$where = "recepcion_oficios.respondido = '0'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getAllEntradasbyTime($id_direccion)
	{
			$this->db->select('*');
			$this->db->select('concat(recepcion_oficios.fecha_recepcion, " ",recepcion_oficios.hora_recepcion) as timestamp');
			$this->db->from('direcciones');
		    $this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
			//$this->db->where('recepcion_oficios.flag_deptos', '0');
			$this->db->where('recepcion_oficios.respondido', '0');
			$this->db->order_by('timestamp', 'desc limit 1');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllPendientes($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
	   // $this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
		//$this->db->where('recepcion_oficios.status', 'Pendiente');
		$where = "recepcion_oficios.direccion_destino = '" .$id_direccion."' AND recepcion_oficios.status = 'Pendiente'";
		$this->db->where($where, NULL, FALSE);
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllContestados($id_direccion)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('direcciones');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		 $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
	    $this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
		$this->db->where('recepcion_oficios.status', 'Contestado');
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllContestadosByFecha($fecha_hoy)
	{
		$this->db->select('*');
		$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('direcciones');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		 $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');

	    	$where = "recepcion_oficios.fecha_recepcion='".$fecha_hoy."' AND recepcion_oficios.status = 'Contestado'";

			$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllNoContestados($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
	    $this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
		$this->db->where('recepcion_oficios.status', 'No Contestado');
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllFueraTiempo($id_direccion)
	{
		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('direcciones');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
	   	$this->db->where('recepcion_oficios.direccion_destino', $id_direccion);
		$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}




	function getDeptos($id_direccion) {
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_respuesta_fisica, $hora_respuesta_fisica, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'num_oficio_salida' => $oficio_salida,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_recepcion' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico,
				'fecha_respuesta_fisica' => $fecha_respuesta_fisica,
				'hora_respuesta_fisica' => $hora_respuesta_fisica,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);
		//
			return $this -> db -> insert('respuesta_oficios', $data);
	}

	function actualizarBandera($id_oficio_recepcion)
	{
			$data = array(
                'respondido' => 1
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

 	function consultarFechaRecepcion($id_oficio_recepcion)
	{
		$this->db->select('fecha_termino');
		$this->db->from('recepcion_oficios');
		$this->db->where('id_recepcion', $id_oficio_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function actualizarStatusFueraDeTiempo($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Fuera de Tiempo'
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

	function actualizarStatusContesado($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

	function asignarOf($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones,$fecha,$hora)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones,
				'hora_asignacion' => $hora,
				'fecha_asignacion' => $fecha
				);	

		return $this -> db -> insert('asignacion_oficio', $data);
	}

	function seleccionarDepto($id_recepcion)
	{
		$this->db->select('id_area');
		$this->db->from('asignacion_oficio');
		$this->db->where('id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function seleccionarDeptoInterno($id_recepcion)
	{
		$this->db->select('id_area');
		$this->db->from('asignacion_interna');
		$this->db->where('id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

    function consultarNombreDepartamento($id_depto)
    {
    	$this->db->select('nombre_area');
		$this->db->from('departamentos');
		$this->db->where('id_area', $id_depto);
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function ModificarBanderaDeptos($idoficio)
    {
    	$data = array(
                'flag_deptos' => 1
                );

            $this->db->where('id_recepcion', $idoficio);
            return $this->db->update('recepcion_oficios', $data);
    }

     function getAsignaciones($id_direccion)
    {
    	$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('departamentos', 'direcciones.id_direccion = departamentos.direccion');
		$this->db->join('asignacion_oficio', 'departamentos.id_area = asignacion_oficio.id_area');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$this->db->where('recepcion_oficios.flag_deptos', '1');
		$this->db->where('recepcion_oficios.respondido', '0');
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function eliminarAsignacionOf($idasignacion)
    {
    	$this->db->where('id_asignacion',$idasignacion);
		return $this->db->delete('asignacion_oficio');
    }

    function editarAsignacion($idasignacion, $depto)
    {
    	$data = array(
                'id_area' => $depto
                );

            $this->db->where('id_asignacion', $idasignacion);
            return $this->db->update('asignacion_oficio', $data);
    }

    function obtenerOficiosEmitidos($nombre)
    {
    		$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->where('emisor', $nombre);
			$consulta = $this->db->get();
			return $consulta -> result();
    }



	// FUNCIONES PARA EL PROCESO INTERNO DE EMISION Y RESPUESTA OFICIOS PARA DIRECCIONES
	 function getAllEntradasInternas($area_trabajo)
	{
			$this->db->select('*');
			$this->db->select('count(*) as cuantos');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.area_trabajo', $area_trabajo);
			$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
			$this->db->group_by('num_oficio');
			$this->db->having("cuantos > 0", null, false);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getBuzonDeOficiosEntrantes($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('emision_interna');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		//	$this->db->where('direcciones.id_direccion', $id_direccion);
		$where = "direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllPendientesInternos($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	function getAllPendientesEmitidos($area_trabajo)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'Pendiente' AND emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}


	function getAllContestadosInternos($id_direccion)
	{

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
				$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();

	}



		function getRespuestaAEmitidos($area_trabajo)
	{

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		//$this->db->where('emision_interna.area_trabajo', $area_trabajo);
		$where = "emision_interna.status = 'Contestado' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();

	
	}

	function getAllNoContestadosInternos($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	function getAllNoContestadosEmitidos($area_trabajo)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		//	$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'No Contestado' AND emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	function getAllFueraTiempoInternos($id_direccion)
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
				$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	
	}

	function getAllFueraTiempoEmitidos($area_trabajo)
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
				$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('emision_interna.emisor', $nombre);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	
	}

	function getAllInformativosInternos($area_trabajo)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Informativo' AND emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

		function getAllInformativosRececepcionados($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Informativo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	    function insertarEntrada($num_oficio, $fecha_recepcion, $hora_recepcion, $asunto, $tipo_recepcion,  $tipo_documento, $emisor, $cargo, $dependencia, $direccion, $fecha_termino, $archivo, $status, $prioridad, $observaciones, $flag_direccion, $tipo_dias, $requiere_respuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio_id, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_recepcion,
				'hora_emision' => $hora_recepcion,
				'asunto' => $asunto,
				'tipo_recepcion' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia' => $dependencia,
				'direccion_destino' => $direccion,
				'fecha_termino' =>  $fecha_termino,
				'archivo_oficio' =>  $archivo,
				'status' =>  $status,
				'prioridad' =>  $prioridad,
				'observaciones' =>  $observaciones,
				'flag_direciones' =>  $flag_direccion,
				'tipo_dias' =>  $tipo_dias,
				'tieneRespuesta' => $requiere_respuesta,
				'fecha_subida' => $fecha_subida,
				'hora_subida' => $hora_subida,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'area_trabajo' => $area_trabajo,
				'num_oficio_id' => $num_oficio_id,
				'codigo_archivistico' => $codigo_archivistico,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);
		//
			return $this -> db -> insert('emision_interna', $data);
	}


     function getAsignacionesInternas($id_direccion)
    {
    	$this->db->select('*');
    	$this->db->select('asignacion_interna.observaciones as obsinternas');
		$this->db->from('direcciones');
		$this->db->join('departamentos', 'direcciones.id_direccion = departamentos.direccion');
		$this->db->join('asignacion_interna', 'departamentos.id_area = asignacion_interna.id_area');
		$this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$this->db->where('emision_interna.respondido', '0');
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function eliminarAsignacionOfInternas($idasignacion)
    {
    	$this->db->where('id_asignacion_int',$idasignacion);
		return $this->db->delete('asignacion_interna');
    }

    function editarAsignacionInternas($idasignacion, $depto)
    {
    	$data = array(
                'id_area' => $depto
                );

            $this->db->where('id_asignacion_int', $idasignacion);
            return $this->db->update('asignacion_interna', $data);
    }

    public function editarAsignacionInternasConDir($idasignacion, $id_direccion, $depto)
    {
    	$data = array(
                'id_direccion' => $id_direccion,
                'id_area' => $depto
                );

            $this->db->where('id_asignacion_int', $idasignacion);
            return $this->db->update('asignacion_interna', $data);
    }

    public function getIdAsignacionByDepto($id)
    {
    	$this->db->select('*');
    	$this->db->from('asignacion_interna');
    	$this->db->where('id_recepcion', $id);
    	$consulta = $this->db->get();
		return $consulta -> result();
    }

    function agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $id_del_area, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'num_oficio_respuesta' => $numoficio_salida,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico,
				'fecha_subida' => $fecha_subida,
				'hora_subida' => $hora_subida,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'id_area_responde' => $id_del_area,
				'area_trabajo' => $area_trabajo,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				
				);
		//
			return $this -> db -> insert('respuesta_interna', $data);
	}

	function actualizarBanderaInt($id_oficio_recepcion)
	{
			$data = array(
                'respondido' => 1
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}

 	function consultarFechaRecepcionInt($id_oficio_recepcion)
	{
		$this->db->select('fecha_termino');
		$this->db->from('emision_interna');
		$this->db->where('id_recepcion_int', $id_oficio_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function actualizarStatusFueraDeTiempoInt($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Fuera de Tiempo'
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}

	function actualizarStatusContesadoInt($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}


	function modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_respuesta)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_recepcion' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'direccion_destino' => $direccion,
				'fecha_termino' =>  $fecha_termino,
				'prioridad' =>  $prioridad,
				'observaciones' =>  $observaciones, 
				'tipo_dias'  =>  $tipo_dias,
				'archivo_oficio' => $archivo,
				'codigo_archivistico' => $codigo_archivistico,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico,
				'status' => $status,
				'tieneRespuesta' => $bandera_respuesta
				);

			$this->db->where('id_recepcion_int', $id);
			return $this -> db -> update('emision_interna', $data);
	}


		function modificarInfoOficioInternoDirGral($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $cargo_h, $dependencia_h, $status, $bandera_respuesta)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_recepcion' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'direccion_destino' => $direccion,
				'fecha_termino' =>  $fecha_termino,
				'prioridad' =>  $prioridad,
				'observaciones' =>  $observaciones, 
				'tipo_dias'  =>  $tipo_dias,
				'archivo_oficio' => $archivo,
				'codigo_archivistico' => $codigo_archivistico,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico,
				'cargo' => $cargo_h,
				'dependencia' => $dependencia_h,
				'status' => $status,
				'tieneRespuesta' => $bandera_respuesta
				);

			$this->db->where('id_recepcion_int', $id);
			return $this -> db -> update('emision_interna', $data);
	}

		function asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones, $hora, $fecha)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones,
				'hora_asignacion' => $hora,
				'fecha_asignacion' => $fecha
				);	

		return $this -> db -> insert('asignacion_interna', $data);
	}

	 function ModificarBanderaDeptosInt($idoficio)
    {
    	$data = array(
                'flag_deptos' => 1
                );

            $this->db->where('id_recepcion_int', $idoficio);
            return $this->db->update('emision_interna', $data);
    }

    	function getBuzonDeCopias($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion = turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('turnado_copias_dir.id_direccion_destino', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDir($area_trabajo)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion= turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.area_trabajo', $area_trabajo);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getBuzonDeCopiasDepto($area_trabajo)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area= turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.area_trabajo', $area_trabajo);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

public function getAllDeptos()
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('isNull', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		function TurnarADireccion($id_depto, $id_oficio, $observaciones)
	{
		$data = array(
				'id_direccion_destino' => $id_depto,
				'id_oficio_emitido' => $id_oficio,
				'observacion' => $observaciones
				);	

		return $this -> db -> insert('turnado_copias_dir', $data);
	}

	function TurnarADeptos($id_depto, $id_oficio, $observaciones)
	{
		$data = array(
				'id_depto_destino' => $id_depto,
				'id_oficio_emitido' => $id_oficio,
				'observacion' => $observaciones
				);	

		return $this -> db -> insert('turnado_copias_deptos', $data);
	}

	public function getCodigos()
	{
		$this->db->select('*');
		$this->db->from('codigos_archivisticos');
		//$this->db->order_by('seccion', 'asc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 	function getBuzonDeCopiasExt($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir_externas', 'direcciones.id_direccion = turnado_copias_dir_externas.id_direccion_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_dir_externas.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_dir_externas.id_direccion_destino', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	/* PANELES ESTADISTICOS DE PROCESOS INTERNOS Y EXTERNOS */

	//EXTERNOS	
	public function conteo_totalExt($id_direccion)
    {
    	$this->db->where('direccion_destino',$id_direccion);
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function contestadosExt($id_direccion)
    {
        $this->db->where('status','Contestado');
        $this->db->where('direccion_destino',$id_direccion);
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function pendientesExt($id_direccion)
    {
    	$this->db->where('status','Pendiente');
    	$this->db->where('direccion_destino',$id_direccion);
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function nocontestadosExt($id_direccion)
    {
    	$this->db->where('status','No Contestado');
    	$this->db->where('direccion_destino',$id_direccion);
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function fuera_de_tiempoExt($id_direccion)
    {
    	$this->db->where('status','Fuera de Tiempo');
    	$this->db->where('direccion_destino',$id_direccion);
        return $this->db->count_all_results('recepcion_oficios');
    }

    //INTERNOS
    //
    public function conteo_totalInt($id_direccion)
    {
    		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			 return $this->db->count_all_results();
    }


     function emitidosInt($area_trabajo)
	{

			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.area_trabajo', $area_trabajo);
			

			// $this->db->select('*');
			// $this->db->from('emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $this->db->where('direcciones.id_direccion', $id_direccion);

			// $this->db->select('*');
			// $this->db->from('emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $this->db->where('emision_interna.emisor', $nombre);
			return $this->db->count_all_results();
	}

	function pendientesInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //   $this->db->where('emision_interna.emisor', $nombre);
		// $where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado'";
		// $this->db->where($where, NULL, FALSE);
		// //$this->db->where('emision_interna.status', 'Pendiente');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function contestadosInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		
			$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		
		return $this->db->count_all_results();
	}

	function nocontestadosInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'No Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function fuera_de_tiempoInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Fuera de Tiempo');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

		public function obtenerCorreoDepto($area_destino)
	{
		$this->db->select('email');
		$this->db->from('empleados');
		$this->db->where('departamento', $area_destino);
		$this->db->limit('1');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function obtenerCorreoDeptoPersonal($area_destino)
	{
		$this->db->select('email_personal');
		$this->db->from('empleados');
		$this->db->where('departamento', $area_destino);
		$this->db->limit('1');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

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

	function getAsignacionId($id_recepcion)
	{
		$this->db->select('departamentos.id_area');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->join('departamentos', 'departamentos.id_area = asignacion_oficio.id_area');
		$this->db->where('recepcion_oficios.id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreoDireccion($id_recpecion)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('empleados', 'recepcion_oficios.direccion_destino = empleados.direccion');
		$where = "recepcion_oficios.id_recepcion='".$id_recpecion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}
//obtenerCorreoDeptoByID
	public function obtenerCorreoDeptoByID($id_recepcion, $id_departamento)
	{

		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('asignacion_oficio', 'asignacion_oficio.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->join('departamentos', 'departamentos.direccion = recepcion_oficios.direccion_destino');
		$this->db->join('empleados', 'departamentos.id_area = empleados.departamento');
		$where = "asignacion_oficio.id_recepcion='".$id_recepcion."' AND departamentos.id_area ='".$id_departamento."'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->limit(1);
		$consulta = $this->db->get();
		return $consulta -> result();
	}
// Correos Internos

	public function obtenerCorreoDireccionInterno($id_direccion)
	{
		$this->db->select('email');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreoPersonalInterno($id_direccion)
	{
		$this->db->select('email_personal');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreoMultiple($id_direccion)
	{
		$this->db->select('email_personal, email');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreosInternos($id_recepcion)
	{
		$this->db->select('email_personal, email');
		$this->db->from('emision_interna');
		$this->db->join('empleados', 'emision_interna.direccion_destino = empleados.direccion');
		$where = "emision_interna.id_recepcion_int ='".$id_recepcion."' AND empleados.isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 function cambiarBanderaHabilitado($id_recepcion)
    {
    	$data = array(
                'asignado' => 1
                );

            $this->db->where('id_recepcion', $id_recepcion);
            return $this->db->update('recepcion_oficios', $data);
    }

    function cambiarBanderaAsignacion($id_recepcion)
    {
    	$data = array(
                'flag_deptos' => 1
                );

            $this->db->where('id_recepcion', $id_recepcion);
            return $this->db->update('recepcion_oficios', $data);
    }

							//ADMINISTRADORES
     function getaAllBuzonDeOficiosEntrantes()
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			//$this->db->where('direcciones.id_direccion', $id_direccion);
		    //$this->db->where('emision_interna.respondido', '0');
			//$this->db->where('emision_interna.flag_deptos', '0');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getFullPendientesInterno()
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getFullContestadosInternos()
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	
		$where = "emision_interna.status = 'Contestado'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getFullFueraTiempoInternos()
	{
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Fuera de Tiempo'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
			
	}

	function getFullNoContestadosInternos()
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'No Contestado'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
		
	}

	public function getBuzonDeCopiasDirById($id_oficio_emitido)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion= turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('turnado_copias_dir.id_oficio_emitido', $id_oficio_emitido);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDeptoById($id_oficio_emitido)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area= turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('turnado_copias_deptos.id_oficio_emitido', $id_oficio_emitido);
		$consulta = $this->db->get();
		return $consulta -> result();
	
	}

	public function TurnarADependencia($dependencia,$id_oficio,$observaciones,$emisor_h)
	{
		$data = array(
				'dependencia' => $dependencia,
				'id_oficio' => $id_oficio,
				'observaciones' => $observaciones,
				'emisor' => $emisor_h
				);	

		return $this -> db -> insert('turnado_dependencias', $data);
	}


	public function getDeptosByIdDireccion($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}	

	public function ObtenerUltimoIDOficioInterno()
	{
		$this->db->select('id_recepcion_int');
		$this->db->from('emision_interna');
		$this->db->order_by('id_recepcion_int', 'DESC');
		$this->db->limit('1');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function ObtenerUltimoNumOficioOficioInterno()
	{
		$this->db->select('num_oficio');
		$this->db->from('emision_interna');
		$this->db->order_by('id_recepcion_int', 'DESC');
		$this->db->limit('1');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function idsPorNumDeOficio($num_oficio)
	{
		$this->db->select('*');
		$this->db->from('emision_interna');
		$this->db->where('num_oficio', $num_oficio);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function deptosByIdDireccion($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function consultaSiTieneDeptos($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$where = "conDeptos = '0' AND id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}



	public function existeNumDeOficioDirInterno($numoficio)
    {
    	$this->db->where('num_oficio',$numoficio);
    	$busqueda = $this->db->get('emision_interna');

    	if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function existeNumDeOficioRespuestaInterna($num_oficio)
    {
    	
    	$this->db->where('num_oficio',$num_oficio);
    	$busqueda = $this->db->get('emision_interna');

    	if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

	public function existeNumDeOficioRespuesta($num_oficio_salida)
	{
		$this->db->where('num_oficio_respuesta',$num_oficio_salida);
    	$busqueda = $this->db->get('respuesta_interna');

    	if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	public function getAllInformativosByNumOficio($numoficio)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "status = 'Informativo' AND num_oficio = '".$numoficio."'";
			$this->db->where($where, NULL, FALSE);	
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	 public function getAllsByNumOficio($num_oficio)
	{
		$this->db->select('*');
			$this->db->from('emision_interna');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "num_oficio = '".$num_oficio."'";
			$this->db->where($where, NULL, FALSE);	
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	public function ConsultarEmailsdeDeptos($id_departamento)
	{
		$this->db->select('*');
		$this->db->from('empleados');
		$where = "departamento = '".$id_departamento."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllAsignacionesInternas($id_recepcion)
	{
		$this->db->select('*');
		$this->db->from('asignacion_interna');
		$where = "id_recepcion = '".$id_recepcion."'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
		//return $consulta->result_array();
	}

	 public function getAllsByNumOficioAjax($num_oficio_id)
	{
		$this->db->select('*');
			$this->db->from('emision_interna');
			//$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "num_oficio_id = '".$num_oficio_id."'";
			$this->db->where($where, NULL, FALSE);	
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	// 	 public function getAllsByNumOficioLimitado1($numoficio)
	// {
	// 		$this->db->select('*');
	// 		$this->db->from('recepcion_oficios');
	// 		$this->db->join('direcciones', 'direccion_destino = id_direccion');
	// 		$where = "num_oficio = '".$numoficio."'";
	// 		$this->db->where($where, NULL, FALSE);
	// 		$this->db->order_by('direccion_destino', 'asc');	
	// 		$this->db->limit(1);
	// 		$consulta = $this->db->get();
	// 		return $consulta -> result();
	// }

	public function getAllsByNumOficioLimitado1($num_oficio)
	{
		$this->db->select('*');
			$this->db->from('emision_interna');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "num_oficio = '".$num_oficio."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('direccion_destino', 'asc');	
			$this->db->limit(1);	
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	public function direccionDelDeptoAsignar($id_depto)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$where = "id_area = '".$id_depto."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	// ELIMINACIONES MEDIANTE CHECKBOXES
	// Eliminacion de direcciones cuando no hay departamentos elegidos en el formulario
	 public function eliminarDirCuandoNoHayDeptos($id_oficio,$id_direccion)
	 {
	 	$this->db->where('id_recepcion_int',$id_oficio);
	 	$this->db->where('direccion_destino',$id_direccion);
			return $this->db->delete('emision_interna');
	 }

	 public function eliminarDeptoCuandoSeModificanDirs($id_oficio,$id_departamento)
	 {
	 	$this->db->where('id_recepcion',$id_oficio);
	 	$this->db->where('id_area',$id_departamento);
			return $this->db->delete('asignacion_interna');
	 }

	 //Calcular el numero de asignaciones
	 public function numAsignaciones($id_recepcion)
	 {
	 	$this->db->where('id_recepcion',$id_recepcion);
        return $this->db->count_all_results('asignacion_oficio');
	 }

	 public function obtenerDepartamentosAsignadosByIDrecepcion($id_recpecion)
	 {
	 	$this->db->select('*');
		$this->db->from('asignacion_oficio');
		$where = "id_recepcion = '".$id_recpecion."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	 }

	 public function eliminarAsignacionDeptoExterna($id_oficio,$id_departamento)
	 {
	 		$this->db->where('id_recepcion',$id_oficio);
	 		$this->db->where('id_area',$id_departamento);
			return $this->db->delete('asignacion_oficio');
	 }

	 public function numAsignacionesInternos($id_recepcion)
	 {
	 	$this->db->where('id_recepcion',$id_recepcion);
        return $this->db->count_all_results('asignacion_interna');
	 }

	  public function obtenerDepartamentosAsignadosByIDrecepcionInt($id_recpecion)
	 {
	 	$this->db->select('*');
		$this->db->from('asignacion_interna');
		$where = "id_recepcion = '".$id_recpecion."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();
	 }

	  public function eliminarAsignacionDeptoInterna($id_oficio_recepcion, $id_departamento)
	 {
	 		$this->db->where('id_recepcion',$id_oficio_recepcion);
	 		$this->db->where('id_area',$id_departamento);
			return $this->db->delete('asignacion_interna');
	 }

	 public function getAllsByNumOficioSalida()
	 {
	 	$this->db->select('num_oficio');
		$this->db->from('oficios_salida');	
		$consulta1 = $this->db->get()->result();

		$this->db->select('num_oficio_salida as num_oficio');
		$this->db->from('respuesta_oficios');	
		$consulta2 = $this->db->get()->result();

		$queryprincipal = array_merge($consulta1, $consulta2);
		return $queryprincipal;
	 	// 	$this->db->select('num_oficio_salida');
			// $this->db->from('respuesta_oficios');	
			// $consulta = $this->db->get();
			// return $consulta -> result();
	 }

	 public function getAllsByNumOficioSalidaPlanteles()
	 {
	 		$this->db->select('num_oficio');
			$this->db->from('oficios_salida_planteles');	
			$consulta = $this->db->get();
			return $consulta -> result();
	 }
	 // Numeros de memorandum
	 
	 public function getNumsMemorandums($area_trabajo)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta2 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2);
	 	return $queryprincipal;
	 }
	 //Numeros de oficios
	 public function getNumsOficiosUsados($area_trabajo)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta2 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2);
	 	return $queryprincipal;
	 }

	 //numeros de circular
	  public function getNumsCircular($area_trabajo)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta2 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2);
	 	return $queryprincipal;
	 }
	 
	 // numeros de oficios para planteles seccionado
	 
	 // Numeros de memorandum
	 
	 public function getNumsMemorandumsPlanteles($area_trabajo)
	 {
	 	//Consulta los numeros de memo usados en el proceso externo del plantel
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_salida_planteles');
	 	$where = "oficios_salida_planteles.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta1 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para docentes
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_docentes');
	 	$where = "oficios_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta2 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para respuestas 
	 	
	 	$this->db->select('num_oficio_salida as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_docentes');
	 	$where = "respuesta_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta3 = $this->db->get()->result();

	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta4 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta5 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2, $consulta3, $consulta4, $consulta5);
	 	return $queryprincipal;
	 }
	 //Numeros de oficios
	 public function getNumsOficiosUsadosPlanteles($area_trabajo)
	 {
	 	//Consulta los numeros de memo usados en el proceso externo del plantel
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_salida_planteles');
	 	$where = "oficios_salida_planteles.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta1 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para docentes
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_docentes');
	 	$where = "oficios_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta2 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para respuestas docentes
	 	$this->db->select('num_oficio_salida as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_docentes');
	 	$where = "respuesta_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta3 = $this->db->get()->result();

	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta4 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta5 = $this->db->get()->result();
		// Union de ambas consultas
	 	$queryprincipal = array_merge($consulta1, $consulta2, $consulta3, $consulta4, $consulta5);
	 	return $queryprincipal;
	 }

	 //numeros de circular
	  public function getNumsCircularPlanteles($area_trabajo)
	 {
	 	 	//Consulta los numeros de memo usados en el proceso externo del plantel
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_salida_planteles');
	 	$where = "oficios_salida_planteles.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta1 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para docentes
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_docentes');
	 	$where = "oficios_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta2 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para respuestas docentes
	 	$this->db->select('num_oficio_salida as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_docentes');
	 	$where = "respuesta_docentes.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta3 = $this->db->get()->result();

	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta4 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta5 = $this->db->get()->result();
		// Union de ambas consultas
	 	$queryprincipal = array_merge($consulta1, $consulta2, $consulta3, $consulta4, $consulta5);
	 	return $queryprincipal;
	 }

	 //Numeros de oficio por planteles generales
	 public function getNumsMemorandumsPlantelesGenerales($area_trabajo)
	 {
	 	//Consulta los numeros de memo usados en el proceso externo del plantel
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_salida_planteles');
	 	$where = "oficios_salida_planteles.area_trabajo = '".$area_trabajo."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta1 = $this->db->get()->result();

	 	//Consulta los numeros de oficio usados para docentes
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('oficios_docentes');
	 	$where = "oficios_docentes.area_trabajo = '".$area_trabajo."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta2 = $this->db->get()->result();
	 	//Consultar los oficios usados para respuesta de docentes
	 	
	 	$this->db->select('num_oficio_salida as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_docentes');
	 	$where = "respuesta_docentes.area_trabajo = '".$area_trabajo."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->group_by('num_oficio');
	 	$consulta3 = $this->db->get()->result();

	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.area_trabajo = '".$area_trabajo."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta4 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.area_trabajo = '".$area_trabajo."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta5 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2, $consulta3, $consulta4, $consulta5);
	 	return $queryprincipal;
	 }

	 public function isOfCentrales($id_direccion)
	 {
	 	$this->db->select('esOfCentrales');
	 	$this->db->from('direcciones');	
	 	$where = "id_direccion = '".$id_direccion."'";
	 	$this->db->where($where, NULL, FALSE);
	 	$consulta = $this->db->get();
	 	return $consulta -> result();
	 }

	 public function actualizarArchivosdeRespuestaExterno($id_recepcion, $respuesta, $anexos)
	 {
	 	$data = array(
	 		'acuse_respuesta' => $respuesta,
	 		'anexos' => $anexos
	 	);

	 	$this->db->where('oficio_recepcion', $id_recepcion);
	 	return $this->db->update('respuesta_oficios', $data);
	 }

	 public function actualizarArchivosdeRespuestaInterno($id_recepcion, $respuesta, $anexos)
	 {
	 	$data = array(
	 		'acuse_respuesta' => $respuesta,
	 		'anexos' => $anexos
	 	);

	 	$this->db->where('oficio_emision', $id_recepcion);
	 	return $this->db->update('respuesta_interna', $data);
	 }

	 public function getArchivoInternoActual($id)
	{
		$this->db->select('archivo_oficio');
		$this->db->from('emision_interna');
		$this->db->where('id_recepcion_int', $id);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllDependenciasCSEIIO()
	{
		$this->db->select('dependencia');
		$this->db->select('count(*) as cuantos');
		$this->db->from('emision_interna');
		$this->db->where('area_trabajo', 'DIRECCIÓN GENERAL');
		$this->db->group_by('dependencia');
		$this->db->having("cuantos > 0", null, false);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function ObtenerDireccionDelDepto($depto)
	{
		$this->db->select('direccion');
		$this->db->from('departamentos');
		$this->db->where('id_area', $depto);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function ConsultarDireccionByNumOficio($num_oficio,$direccion)
	{
		//return $this -> db -> insert('libros', $data);
    		 $this->db->where('num_oficio',$num_oficio);
    		 $this->db->where('direccion_destino',$direccion);
    		 $busqueda = $this->db->get('emision_interna');
    		
    		 if ($busqueda->num_rows()>0) {
    		 	return true;
    		 }
			 else
			 {
			 	return false;
			 }
	}

}