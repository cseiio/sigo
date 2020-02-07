<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_departamentos extends CI_Model {

	public function __construct()
	{
		parent::__construct();		
	}

	function getAllEntradas($iddepartamento)
	{
			// $this->db->select('*');
			// $this->db->select('count(*) as cuantos');
			// $this->db->from('emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $this->db->where('emision_interna.emisor', $nombre);
			// $this->db->order_by('emision_interna.id_recepcion_int', 'desc');
			// $this->db->group_by('num_oficio');
			// $this->db->having("cuantos > 0", null, false);
			// $consulta = $this->db->get();
			// return $consulta -> result();

			

			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.respondido', '0');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	

	function getInfoDepartamento($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
			$this->db->where('id_area', $iddepartamento);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

    function getAllPendientes($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Pendiente');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestados($iddepartamento)
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
		    
		     $where = "asignacion_oficio.id_area = '".$iddepartamento."' AND recepcion_oficios.status = 'Contestado'";
			$this->db->where($where, NULL, FALSE);	

			//$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllNoContestados($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'No Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempo($iddepartamento)
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
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

	function asignarOf($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones
				);	

		return $this -> db -> insert('asignacion_oficio', $data);
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

    // FUNCIONES PARA EL PROCESO INTERNO DE EMISION Y RESPUESTA OFICIOS PARA DIRECCIONES
    // 
    	function getDeptos($id_direccion) {
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 function getAllEntradasInternas($area_trabajo)
	{
		
			$this->db->select('*');
			$this->db->select('count(*) as cuantos');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.area_trabajo', $area_trabajo);
				$this->db->group_by('num_oficio');
			$this->db->having("cuantos > 0", null, false);
			$consulta = $this->db->get();
			return $consulta -> result();

			// $this->db->select('*');
			// $this->db->from(getBuzonDeCopiasDir'emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $this->db->where('emision_interna.emisor', $nombre);
			// $consulta = $this->db->get();
			// return $consulta -> result();
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

		function getAllInformativosRecepcionados($iddepartamento)
	{
			// $this->db->select('*');
			// $this->db->from('departamentos');
		 //    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		 //    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		 //    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			// //$this->db->where('asignacion_interna.id_area', $iddepartamento);
			// $where = "emision_interna.status = 'Informativo' AND asignacion_interna.id_area = '".$iddepartamento."'";
			// $this->db->where($where, NULL, FALSE);
			// $consulta = $this->db->get();
			// return $consulta -> result();


			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $where = "emision_interna.status = 'Informativo' AND departamentos.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			//$this->db->where('departamentos.id_area', $iddepartamento);
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getBuzonDeOficiosEntrantes($iddepartamento)
	{
		
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			$this->db->where('departamentos.id_area', $iddepartamento);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllPendientesInternos($iddepartamento)
	{
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

	}

	function getAllPendientesEmitidos($area_trabajo)
	{
		// $this->db->select('*');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND emision_interna.emisor = '".$nombre."'";
		// 	$this->db->where($where, NULL, FALSE);
		// 	$consulta = $this->db->get();
		// 	return $consulta -> result();

			$this->db->select('*');
			//$this->db->select('count(*) as cuantos');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'Pendiente' and emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestadosInternos2($iddepartamento)
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
			$where = "emision_interna.status = 'Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

		 
	}

	function getAllContestadosInternos($iddepartamento)
	{
			$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
		
		    $this->db->from('emision_interna');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		  //  $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Contestado' AND respuesta_interna.id_area_responde = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllNoContestadosInternos($iddepartamento)
	{
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	function getAllNoContestadosEmitidos($area_trabajo)
	{
		$this->db->select('*');
			//$this->db->select('count(*) as cuantos');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$where = "emision_interna.status = 'No Contestado' and emision_interna.area_trabajo = '".$area_trabajo."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
		// $this->db->select('*');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		// 	$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND emision_interna.emisor = '".$nombre."'";
		// 	$this->db->where($where, NULL, FALSE);
		// 	$consulta = $this->db->get();
		// 	return $consulta -> result();
	}



	function getAllFueraTiempoInternos2($iddepartamento)
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
			$where = "emision_interna.status = 'Fuera de Tiempo' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempoInternos($iddepartamento)
	{
			$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
		
		    $this->db->from('emision_interna');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		  //  $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND respuesta_interna.id_area_responde = '".$iddepartamento."'";
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
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$where = "emision_interna.status = 'Fuera de Tiempo' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		$this->db->where($where, NULL, FALSE);
		$consulta = $this->db->get();
		return $consulta -> result();

	
	}

	function insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $direccion, $fecha_termino, $archivo, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $reqRespuesta, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $num_oficio_id, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
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
			'tieneRespuesta' => $reqRespuesta,
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
		$this->db->from('direcciones');
		$this->db->join('departamentos', 'direcciones.id_direccion = departamentos.direccion');
		$this->db->join('asignacion_interna', 'departamentos.id_area = asignacion_interna.id_area');
		$this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
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

//$id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias

	function modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias)
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
				'tipo_dias'  =>  $tipo_dias
				);

			$this->db->where('id_recepcion_int', $id);
			return $this -> db -> update('emision_interna', $data);
	}

	function asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones
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

    function getAllDeptos() {
		$this->db->select('*');
		$this->db->from('departamentos');
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

	function getBuzonDeCopias($id_depto)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area = turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('turnado_copias_deptos.id_depto_destino', $id_depto);
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

	public function getCodigos()
	{
		$this->db->select('*');
		$this->db->from('codigos_archivisticos');
		//$this->db->order_by('seccion', 'asc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	function getBuzonDeCopiasExt($id_depto)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_depto_externa', 'departamentos.id_area = turnado_copias_depto_externa.id_depto_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_depto_externa.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_depto_externa.id_depto_destino', $id_depto);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDirExt($nombre)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion= turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getBuzonDeCopiasDeptoExt($nombre)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area= turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	/* CONSULTAS PARA PANEL ESTADISTICO */


	function conteo_totalExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.respondido');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.respondido', '0');
			return $this->db->count_all_results();
	}

    function pendientesExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Pendiente');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function contestadosExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function nocontestadosExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'No Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function fuera_de_tiempoExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
}

// PROCESO INTERNO

	 function emitidosInt($area_trabajo)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.area_trabajo', $area_trabajo);
			return $this->db->count_all_results();
	}

	function conteo_totalInt($iddepartamento)
	{
		
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			$this->db->where('asignacion_interna.id_area', $iddepartamento);
			return $this->db->count_all_results();
	}

	function pendientesInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //   $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Pendiente');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		
		return $this->db->count_all_results();
	}

	function contestadosInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $this->db->select('*');
		// $this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		//     $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		// 	$where = "emision_interna.status = 'Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
		// 	$this->db->where($where, NULL, FALSE);
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
		
		    $this->db->from('emision_interna');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		  //  $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Contestado' AND respuesta_interna.id_area_responde = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function nocontestadosInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'No Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
// $this->db->select('*');
// 			$this->db->from('departamentos');
// 		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
// 		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
// 		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
// 			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
// 			$where = "emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
// 			$this->db->where($where, NULL, FALSE);
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function fuera_de_tiempoInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Fuera de Tiempo');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $this->db->select('*');
		// $this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		// 	$this->db->from('departamentos');
		//     $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		//     $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		//     $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		//     $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		//     $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
		// 	//$this->db->where('asignacion_interna.id_area', $iddepartamento);
		// 	$where = "emision_interna.status = 'Fuera de Tiempo' AND asignacion_interna.id_area = '".$iddepartamento."'";
		// 	$this->db->where($where, NULL, FALSE);
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		
		
		    $this->db->from('emision_interna');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		  //  $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND respuesta_interna.id_area_responde = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

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

	function getRespuestaAEmitidos($area_trabajo)
	{
		
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->select('respuesta_interna.fecha_subida as fecha_ressubida, respuesta_interna.hora_subida as hora_ressubida, respuesta_interna.fecha_acuse as fecha_acuse_res, respuesta_interna.hora_acuse as hora_acuse_res ');
		$this->db->from('emision_interna');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$where = "emision_interna.status = 'Contestado' AND emision_interna.area_trabajo = '".$area_trabajo."'";
		$this->db->where($where, NULL, FALSE);
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

	public function existeNumDeOficioRespuestaExt($num_oficio_salida)
	{
		$this->db->where('num_oficio_salida',$num_oficio_salida);
    	$busqueda = $this->db->get('respuesta_oficios');

    	if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	public function comprobarSielAreaYaRespondio($iddepartamento, $numoficio)
	{
		$where = "id_area_responde = '".$iddepartamento."' AND num_oficio = '".$numoficio."'";
		$this->db->where($where, NULL, FALSE);
		$busqueda = $this->db->get('respuesta_interna');

		if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}



	public function comprobarSiYaExisteRespuestaByIdOficio($id_oficio)
	{
		$where = "oficio_emision = '".$id_oficio."'";
		$this->db->where($where, NULL, FALSE);
		$busqueda = $this->db->get('respuesta_interna');

		if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	 // Numeros de memorandum
	 
	 public function getNumsMemorandums($nombre)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.emisor = '".$nombre."' AND tipo_documento='Memorandúm'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.emisor = '".$nombre."' AND tipo_documento='Memorandúm'";
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
	 public function getNumsOficiosUsados($nombre)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.emisor = '".$nombre."' AND tipo_documento='Oficio'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.emisor = '".$nombre."' AND tipo_documento='Oficio'";
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
	  public function getNumsCircular($nombre)
	 {
	 	//Consulta numeros de oficios emitidos
	 	$this->db->select('num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('emision_interna');
	 	$where = "emision_interna.emisor = '".$nombre."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('emision_interna.id_recepcion_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta1 = $this->db->get()->result();

		// Consulta numeros de oficios de respuesta

	 	$this->db->select('num_oficio_respuesta as num_oficio');
	 	$this->db->select('count(*) as cuantos');
	 	$this->db->from('respuesta_interna');
	 	$where = "respuesta_interna.emisor = '".$nombre."' AND tipo_documento='Circular'";
	 	$this->db->where($where, NULL, FALSE);
	 	$this->db->order_by('respuesta_interna.id_respuesta_int', 'desc');
	 	$this->db->group_by('num_oficio');
	 	$this->db->having("cuantos > 0", null, false);
	 	$consulta2 = $this->db->get()->result();

		// Union de ambas consultas

	 	$queryprincipal = array_merge($consulta1, $consulta2);
	 	return $queryprincipal;
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

}

/* End of file Modelo_departamentos.php */
/* Location: ./application/models/Modelo_departamentos.php */