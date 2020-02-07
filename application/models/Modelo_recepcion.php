<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_recepcion extends CI_Model {

	function insertarEntrada($num_oficio, $fecha_recepcion, $hora_recepcion, $asunto, $tipo_recepcion,  $tipo_documento, $emisor, $dependencia, $cargo, $direccion, $fecha_termino, $archivo, $status, $prioridad, $observaciones, $flag_direccion, $tipo_dias, $requiereRespuesta, $fecha_recepcion_fisica, $hora_recepcion_fisica, $fecha_emision_fisica, $hora_emision_fisica, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_recepcion' => $fecha_recepcion,
				'hora_recepcion' => $hora_recepcion,
				'asunto' => $asunto,
				'tipo_recepcion' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'dependencia_emite' => $dependencia,
				'cargo' => $cargo,
				'direccion_destino' => $direccion,
				'fecha_termino' =>  $fecha_termino,
				'archivo_oficio' =>  $archivo,
				'status' =>  $status,
				'prioridad' =>  $prioridad,
				'observaciones' =>  $observaciones,
				'flag_direciones' =>  $flag_direccion,
				'tipo_dias' =>  $tipo_dias,
				'requiereRespuesta' => $requiereRespuesta,
				'fecha_recep_fisica' => $fecha_recepcion_fisica,
				'hora_recep_fisica' => $hora_recepcion_fisica,
				'fecha_emision' => $fecha_emision_fisica,
				'hora_emision' => $hora_emision_fisica,
				'codigo_archivistico' => $codigo, 
				'valor_doc' => $valor_doc, 
				'vigencia_doc' => $vigencia_doc, 
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);

			return $this -> db -> insert('recepcion_oficios', $data);
	}
//Para obtener el correo se debe de pasar como parametro la clave del area
	public function obtenerCorreoDireccion($id_direccion)
	{
		$this->db->select('email');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreoPersonal($id_direccion)
	{
		$this->db->select('email_personal');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreos($id_direccion)
	{
		$this->db->select('email,email_personal');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

   public function obtenerCorreo($id_recpecion)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('empleados', 'recepcion_oficios.direccion_destino = empleados.direccion');
		$where = "recepcion_oficios.id_recepcion='".$id_recpecion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreosPorDepartamento($id_area)
	{
		$this->db->select('email,email_personal');
		$this->db->from('empleados');
		$where = "departamento='".$id_area."'";
		$this->db->where($where, NULL, FALSE);
		$this->db->limit(1);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}



	function asignarOf($id_direccion,$id_oficio_recepcion,$observaciones,$fecha,$hora)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones,
				'hora_asignacion' => $hora,
				'fecha_asignacion' => $fecha
				);	

		return $this -> db -> insert('asignacion_direcciones', $data);
	}



	function modificarRegistro($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $prioridad, $observaciones, $tipo_dias, $archivo, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico, $status, $bandera_contestado, $fecha_termino_a)
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
				'codigo_archivistico' => $codigo, 
				'valor_doc' => $valor_doc, 
				'vigencia_doc' => $vigencia_doc, 
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico,
				'status' => $status,
				'requiereRespuesta' => $bandera_contestado, 
				'fecha_termino' => $fecha_termino_a
				);

			$this->db->where('id_recepcion', $id);
			return $this -> db -> update('recepcion_oficios', $data);
	}

	function getAllEntradas()
	{
			$this->db->select('*');
			$this->db->select('count(*) as cuantos');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$this->db->order_by('recepcion_oficios.id_recepcion', 'desc');
			$this->db->group_by('num_oficio');
			$this->db->having("cuantos > 0", null, false);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllEntradasLimitInformativos()
	{
			$this->db->select('*');
			$this->db->select('count(*) as cuantos');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$this->db->order_by('recepcion_oficios.id_recepcion', 'desc');
			$this->db->group_by('num_oficio');
			$this->db->having("cuantos > 0", null, false);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllEntradasLimit()
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$this->db->order_by('recepcion_oficios.id_recepcion', 'desc');
			$this->db->where('status', 'Informativo');
			$this->db->limit(1);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllRespuestasASalidas()
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');

		$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllTimeStamp()
	{
			$this->db->select('*');
			$this->db->select('concat(fecha_recepcion, " ", hora_recepcion) as timestamp');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$this->db->order_by('timestamp', 'desc limit 1');
			$consulta = $this->db->get();
			return $consulta -> result();
	}



	function getAllPendientes()
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
		$where = "recepcion_oficios.status = 'Pendiente' OR recepcion_oficios.status = 'No Contestado'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
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

	function getAllContestados()
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			$where = "recepcion_oficios.status = 'Contestado'";
			$this->db->where($where, NULL, FALSE);	
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

		function getAllContestadosbyFecha($fecha_hoy)
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');

			$where = "respuesta_oficios.fecha_respuesta='".$fecha_hoy."' AND recepcion_oficios.status = 'Contestado'";

			$this->db->where($where, NULL, FALSE);	

			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllInformativos()
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$this->db->where('requiereRespuesta', 0);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

		function getAllInformativosSalida()
	{
			$this->db->select('*');
			$this->db->from('oficios_salida');
			$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
			$this->db->where('tieneRespuesta', 0);
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

	function getAllNoContestados()
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			$this->db->where('recepcion_oficios.status', 'No Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempo()
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllOficiosSalida()
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$consulta = $this->db->get();
			return $consulta -> result();
	}


	function TurnarADireccion($id_depto, $id_oficio, $observaciones, $nombre_emisor)
	{
		$data = array(
				'id_direccion_destino' => $id_depto,
				'id_recepcion' => $id_oficio,
				'observaciones' => $observaciones,
				'nombre_emisor' => $nombre_emisor
				);	

		return $this -> db -> insert('turnado_copias_dir_externas', $data);
	}

	function TurnarADeptos($id_depto, $id_oficio, $observaciones, $nombre_emisor)
	{
		$data = array(
				'id_depto_destino' => $id_depto,
				'id_recepcion' => $id_oficio,
				'observaciones' => $observaciones,
				'nombre_emisor' => $nombre_emisor
				);	

		return $this -> db -> insert('turnado_copias_depto_externa', $data);
	}

	public function getBuzonDeCopiasDir($nombre)
	{
		$this->db->select('*');
		$this->db->select('turnado_copias_dir_externas.nombre_emisor as emisor_copia, turnado_copias_dir_externas.observaciones as ob ');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir_externas', 'direcciones.id_direccion= turnado_copias_dir_externas.id_direccion_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_dir_externas.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_dir_externas.nombre_emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDepto($nombre)
	{
		$this->db->select('*');
		$this->db->select('turnado_copias_depto_externa.nombre_emisor as emisor_copia, turnado_copias_depto_externa.observaciones as ob ');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_depto_externa', 'departamentos.id_area= turnado_copias_depto_externa.id_depto_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_depto_externa.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_depto_externa.nombre_emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

//  OBTENER EL BUZON DE COPIAS POR ID 

		public function getBuzonDeCopiasDirById($id_recepcion)
	{
		$this->db->select('*');
		$this->db->select('turnado_copias_dir_externas.nombre_emisor as emisor_copia, turnado_copias_dir_externas.observaciones as ob ');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir_externas', 'direcciones.id_direccion= turnado_copias_dir_externas.id_direccion_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_dir_externas.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_dir_externas.id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDeptoById($id_recepcion)
	{
		$this->db->select('*');
		$this->db->select('turnado_copias_depto_externa.nombre_emisor as emisor_copia, turnado_copias_depto_externa.observaciones as ob ');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_depto_externa', 'departamentos.id_area= turnado_copias_depto_externa.id_depto_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_depto_externa.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_depto_externa.id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	// OFICIOS DE SALIDA
	

	public function agregarOficioSalida($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$titular, $dependencia,$fun_emisor,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo,$observaciones,$codigo_archivistico, $requiere_respuesta, $fecha_termino, $status, $tipo_dias, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_emision,
				'hora_emision' => $hora_emision,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor_principal' => $emisor_principal,
				'titular' => $titular,
				'dependencia' => $dependencia,
				'quien_realiza_oficio' => $fun_emisor,
				'cargo' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'archivo' => $archivo,
				'observaciones' =>  $observaciones,
				'codigo_archivistico' => $codigo_archivistico,
				'tieneRespuesta' => $requiere_respuesta,
				'fecha_termino' => $fecha_termino,
				'status' => $status,
				'tipo_dias' => $tipo_dias,
				'fecha_subida' => $fecha_subida,
				'hora_subida' => $hora_subida,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'valor_doc' => $valor_doc, 
				'vigencia_doc' => $vigencia_doc, 
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);	

		return $this -> db -> insert('oficios_salida', $data);
	}

	public function modificarOficioSalida($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento, $fun_emisor,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $observaciones, $fecha_acuse, $hora_acuse, $archivo_of, $codigo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'quien_realiza_oficio' => $fun_emisor,
				'cargo' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'observaciones' =>  $observaciones,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'archivo' => $archivo_of,
				'codigo_archivistico' => $codigo,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);	

		$this->db->where('id_oficio_salida', $id);
		return $this -> db -> update('oficios_salida', $data);
	}

	public function getCodigos()
	{
		$this->db->select('*');
		$this->db->from('codigos_archivisticos');
		//$this->db->order_by('seccion', 'asc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function conteo_total()
    {
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function contestados()
    {
        $this->db->where('status','Contestado');
        $this->db->where('requiereRespuesta', 1);
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function pendientes()
    {
    	$this->db->where('status','Pendiente');
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function nocontestados()
    {
    	$this->db->where('status','No Contestado');
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function fuera_de_tiempo()
    {
    	$this->db->where('status','Fuera de Tiempo');
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function total_salientes()
    {
        return $this->db->count_all_results('oficios_salida');
    }

    function total_informativos()
	{
		$this->db->where('requiereRespuesta',0);
        return $this->db->count_all_results('recepcion_oficios');
	}

    public function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_dependencia, $hora_dependencia, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
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
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico,
				'fecha_subida'  => $fecha_dependencia,
				'hora_subida' => $hora_dependencia,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);
		//
			return $this -> db -> insert('respuesta_oficios_salida', $data);
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

		 function cambiarBanderaHabilitado($id_recepcion)
    {
    	$data = array(
                'asignadoPorUnidad' => 1
                );

            $this->db->where('id_recepcion', $id_recepcion);
            return $this->db->update('recepcion_oficios', $data);
    }

    	function seleccionarDir($id_recepcion)
	{
		$this->db->select('id_direccion_destino');
		$this->db->from('turnado_copias_dir_externas');
		$this->db->where('id_recepcion', $id_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	// --- MONITOREO DE SALIDAS
	
	function getAllContestadosSalidas()
	{
			$this->db->select('*');
			// $this->db->select('oficios_salida.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('oficios_salida');
			 $this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
			$where = "oficios_salida.status = 'Contestado'";
			$this->db->where($where, NULL, FALSE);	
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('oficios_salida.id_oficio_salida');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraDeTiempoSalidas()
	{
			$this->db->select('*');
			// $this->db->select('oficios_salida.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('oficios_salida');
			 $this->db->join('respuesta_oficios_salida', 'oficios_salida.id_oficio_salida = respuesta_oficios_salida.oficio_emision');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
			$where = "oficios_salida.status = 'Fuera de Tiempo'";
			$this->db->where($where, NULL, FALSE);	
			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('oficios_salida.id_oficio_salida');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllPendientesSalidas()
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$where = "oficios_salida.status = 'Pendiente'";
			$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllNoContestadosSalidas()
	{
		$this->db->select('*');
		$this->db->from('oficios_salida');
		$this->db->join('codigos_archivisticos', 'oficios_salida.codigo_archivistico = codigos_archivisticos.id_codigo');
		$where = "oficios_salida.status = 'No Contestado'";
			$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	function consultarFechaEmision($id_oficio_salida)
	{
		$this->db->select('fecha_termino');
		$this->db->from('oficios_salida');
		$this->db->where('id_oficio_salida', $id_oficio_salida);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function actualizarStatusFueraDeTiempo($id_oficio_salida)
	{
		$data = array(
                'status' => 'Fuera de Tiempo'
                );

            $this->db->where('id_oficio_salida', $id_oficio_salida);
            return $this->db->update('oficios_salida', $data);
	}

	function actualizarStatusContesado($id_oficio_salida)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_oficio_salida', $id_oficio_salida);
            return $this->db->update('oficios_salida', $data);
	}

	
	function actualizarBandera($id_oficio_recepcion)
	{
			$data = array(
                'respondido' => 1
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_salida', $data);
	}

	public function getAllDependencias()
	{
		$this->db->select('*');
		$this->db->from('dependencias');
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	public function addDependencia($nombre_dependencia,$nombre_titular,$cargo_titular,$direccion_dependencia, $telefono, $email, $pagina_web)

	{
		$data = array(
				'nombre_dependencia' => $nombre_dependencia,
				'titular' => $nombre_titular,
				'cargo' => $cargo_titular,
				'direccion' => $direccion_dependencia,
				'telefono' => $telefono,
				'email' => $email,
				'pagina_web' => $pagina_web
				);
		//
			return $this -> db -> insert('dependencias', $data);
	}

	public function updateDependencia($id_dependencia, $nombre_dependencia,$nombre_titular,$cargo_titular,$direccion_dependencia, $telefono, $email, $pagina_web)
	{
		$data = array(
				'nombre_dependencia' => $nombre_dependencia,
				'titular' => $nombre_titular,
				'cargo' => $cargo_titular,
				'direccion' => $direccion_dependencia,
				'telefono' => $telefono,
				'email' => $email,
				'pagina_web' => $pagina_web
				);

		$this->db->where('id_dependencia', $id_dependencia);
        return $this->db->update('dependencias', $data);
}

public function deleteDependencia($id)
{
	$this->db->where('id_dependencia',$id);
	return $this->db->delete('dependencias');
}


 public function GetRow($keyword) {        
        $this->db->select('nombre_dependencia');
        $this->db->order_by('id_dependencia', 'desc');
        $this->db->like('nombre_dependencia', $keyword);
        return $this->db->get('dependencias')->result_array();
    }

    public function getFuncionariosCseiio()
    {
    	$this->db->select('*');
    	$this->db->from('empleados');
    	$this->db->where('isOfCentrales', 0);
    	$consulta = $this->db->get();
    	return $consulta -> result();
    }

    public function getInfoEmpleados($clave_area)
    {
    	$this->db->select('*');
    	$this->db->from('empleados');
    	$where = "isOfCentrales = 0 and nombre_empleado = '".$clave_area."'";
			$this->db->where($where, NULL, FALSE);	

    	//$this->db->where('isOfCentrales', 0);
    	$consulta = $this->db->get();
    	return $consulta -> result();
    }

    // public function getAllDependencias()
    // {
    // 	$this->db->select('*');
    // 	$this->db->from('dependencias');
    // 	$consulta = $this->db->get();
    // 	return $consulta -> result();
    // }

    public function getInfoDependencias($nombre_dependencia)
    {
    	$this->db->select('*');
    	$this->db->from('dependencias');
    	$where = "nombre_dependencia = '".$nombre_dependencia."'";
			$this->db->where($where, NULL, FALSE);	
    	$consulta = $this->db->get();
    	return $consulta -> result();
    }

    public function existeNumDeOficio($numoficio)
    {
    	$this->db->where('num_oficio',$numoficio);
    	$busqueda = $this->db->get('recepcion_oficios');

    	if ($busqueda->num_rows()>0) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

     public function existeNumDeOficioSalida($numoficio)
    {
    	$this->db->where('num_oficio',$numoficio);
    	$busqueda = $this->db->get('oficios_salida');

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
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "status = 'Informativo' AND num_oficio = '".$numoficio."'";
			$this->db->where($where, NULL, FALSE);	
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	 public function getAllsByNumOficio($numoficio)
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "num_oficio = '".$numoficio."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('direccion_destino', 'asc');	
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	 public function getAllsByNumOficioLimitado1($numoficio)
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "num_oficio = '".$numoficio."'";
			$this->db->where($where, NULL, FALSE);
			$this->db->order_by('direccion_destino', 'asc');	
			$this->db->limit(1);
			$consulta = $this->db->get();
			return $consulta -> result();
	}


 	public function getAllInformativosSinReptir()
	{
			$this->db->select('*');
			$this->db->from('recepcion_oficios');
			$this->db->join('direcciones', 'direccion_destino = id_direccion');
			$where = "status = 'Informativo'";
			$this->db->where($where, NULL, FALSE);	
			$this->db->group_by('num_oficio');
			$this->db->having("count('*')>0");
			$consulta = $this->db->get();
			return $consulta -> result();
	}


	public function obtenerInformativosRepetidos($numoficio)
	{
		// Subconsulta
		$this->db->select('num_oficio')->from('recepcion_oficios')->where("status ='Informativos' ")->group_by('num_oficio')->having(count('num_oficio')>1);
		$subQuery =  $this->db->get_compiled_select();
		// Consulta principal
		$this->db->select('*')
		->from('recepcion_oficios')
		->join('direcciones', 'direccion_destino = id_direccion')
		->where("num_oficio IN ($subQuery) AND num_oficio = '".$numoficio."'", NULL, FALSE)
		->limit(1);
		$consulta = $this->db->get();
    	return $consulta -> result();
	}

	public function EliminarDireccion($id_direccion)
	{
		$this->db->where('direccion_destino',$id_direccion);
			return $this->db->delete('recepcion_oficios');
	}

	public function getNumerosDeOficioUsados2()
	{
		$this->db->select('num_oficio');
			$this->db->from('oficios_salida');	
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getNumerosDeOficioUsados()
	{
		$this->db->select('num_oficio');
		$this->db->from('oficios_salida');	
		$consulta1 = $this->db->get()->result();

		$this->db->select('num_oficio_salida as num_oficio');
		$this->db->from('respuesta_oficios');	
		$consulta2 = $this->db->get()->result();

		$queryprincipal = array_merge($consulta1, $consulta2);
		return $queryprincipal;
	}

	public function modificarObservacionGeneral($id_recepcion, $observacion)
	{
		$data = array(
                'observaciones' => $observacion
                );

            $this->db->where('id_recepcion', $id_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

	public function getAllValoresDoc()
	{
		$this->db->select('*');
		$this->db->from('valores_doc');	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllVigenciaDoc()
	{
		$this->db->select('*');
		$this->db->from('vigencia_doc');	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllClasificacionInfo()
	{
		$this->db->select('*');
		$this->db->from('clasificacion_informacion');	
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	public function getAllTipoDocumento()
	{
		$this->db->select('*');
		$this->db->from('tipo_documentos');	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getArchivoActual($id)
	{
		$this->db->select('archivo_oficio');
		$this->db->from('recepcion_oficios');	
		$this->db->where('id_recepcion', $id);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getArchivoActualSalida($id)
	{
		$this->db->select('archivo');
		$this->db->from('oficios_salida');
		$this->db->where('id_oficio_salida', $id);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 
}
/* End of file Modelo_recepcion.php */
/* Location: ./application/models/Modelo_recepcion.php */