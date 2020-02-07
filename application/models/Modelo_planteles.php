<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_planteles extends CI_Model {

	public function __construct()
	{
		parent::__construct();		
	}

	function getAllOficiosSalidaPlanteles($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
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

	function getAllInformativosSalida($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('oficios_salida_planteles');
			$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
			$this->db->where('tieneRespuesta', 0);
			$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllRespuestasASalidas($id_direccion)
	{
		$this->db->select('*');
		$this->db->select('oficios_salida_planteles.cargo as cargoemisor');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_salida_planteles', 'oficios_salida_planteles.id_oficio_salida = respuesta_salida_planteles.oficio_emision');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	//OPERACIONES
	
	public function agregarOficioSalida($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$dependencia,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo,$observaciones,$status, $codigo_archivistico, $requiere_respuesta, $id_direccion, $fecha_subida, $hora_subida, $fecha_acuse, $hora_acuse, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_emision,
				'hora_emision' => $hora_emision,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor_principal,
				'bachillerato' => $dependencia,
				'cargo' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'archivo' => $archivo,
				'observaciones' =>  $observaciones,
				'status' =>  $status,
				'codigo_archivistico' => $codigo_archivistico,
				'tieneRespuesta' => $requiere_respuesta,
				'id_direccion' => $id_direccion,
				'fecha_subida' => $fecha_subida,
				'hora_subida' => $hora_subida,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'area_trabajo' => $area_trabajo,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);	

		return $this -> db -> insert('oficios_salida_planteles', $data);
	}

		public function modificarOficioSalida($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento,  $remitente, $cargo_remitente, $dependencia_remitente, $observaciones,$fecha_acuse, $hora_acuse, $archivo_of, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico )
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'observaciones' =>  $observaciones,
				'fecha_acuse' => $fecha_acuse,
				'hora_acuse' => $hora_acuse,
				'archivo' => $archivo_of,
				'codigo_archivistico' => $codigo_archivistico,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico

				);	

		$this->db->where('id_oficio_salida', $id);
		return $this -> db -> update('oficios_salida_planteles', $data);
	}


	   public function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $fecha_subida, $hora_subida, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico )
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
				'dependencia_emisor' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico,
				'fecha_subida' => $fecha_subida,
				'hora_subida' => $hora_subida,
				'area_trabajo' => $area_trabajo,
				'valor_doc' => $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);
		//
			return $this -> db -> insert('respuesta_salida_planteles', $data);
    }

    function actualizarStatusContesado($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_salida_planteles', $data);
	}

	function actualizarBandera($id_oficio_recepcion)
	{
			$data = array(
                'fue_respondido' => 1
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_salida_planteles', $data);
	}

	//ESTADISTICA
	
	public function conteo_totalExt($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
		return $this->db->count_all_results();
	}

	 public function conteo_totalInt($id_direccion)
    {
    		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			 return $this->db->count_all_results();
    }


     function emitidosInt($id_direccion)
	{


			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

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
	//Proceso interno del plantel: Relación Docentes - Director 
	public function getAllOficiosDocentes($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_docentes.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllRespuestaDocentes($id_direccion)
	{
		$this->db->select('*');
		//$this->db->select('oficios_docentes.cargo as cargoemisor');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_docentes', 'oficios_docentes.id_oficio_salida = respuesta_docentes.oficio_emision');
		$this->db->where('oficios_docentes.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}



	public function agregarOficioDocentes($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$dependencia,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo,$observaciones,$status, $codigo_archivistico, $requiere_respuesta, $id_direccion, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_emision,
				'hora_emision' => $hora_emision,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor_docente' => $emisor_principal,
				'bachillerato' => $dependencia,
				'cargo_docente' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'archivo' => $archivo,
				'observaciones' =>  $observaciones,
				'status' =>  $status,
				'codigo_archivistico' => $codigo_archivistico,
				'tieneRespuesta' => $requiere_respuesta,
				'id_direccion' => $id_direccion,
				'area_trabajo' => $area_trabajo,
				'valor_doc' =>  $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);	

		return $this -> db -> insert('oficios_docentes', $data);
	}

	public function modificarOficioPlanteles($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento, $emisor, $cargo_emisor, $bachillerato_emisor, $remitente, $cargo_remitente, $dependencia_remitente, $observaciones, $archivo, $codigo_archivistico, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor_docente' => $emisor,
				'cargo_docente' => $cargo_emisor,
				'bachillerato' => $bachillerato_emisor,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'observaciones' =>  $observaciones,
				'archivo' => $archivo,
				'codigo_archivistico' => $codigo_archivistico,
				'valor_doc' =>  $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);	

		$this->db->where('id_oficio_salida', $id);
		return $this -> db -> update('oficios_docentes', $data);
	}

	public function agregarRespuestaDocentes($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $cargo_receptor, $plantel_receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico, $area_trabajo, $valor_doc, $vigencia_doc, $clasificacion_info, $tipo_doc_archivistico)
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
				'dependencia_emisor' => $dependencia,
				'receptor' => $receptor,
				'cargo_receptor' => $cargo_receptor,
				'bachillerato_receptor' => $plantel_receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico,
				'area_trabajo' => $area_trabajo,
				'valor_doc' =>  $valor_doc,
				'vigencia_doc' => $vigencia_doc,
				'clasificacion_info' => $clasificacion_info,
				'tipo_doc_archivistico' => $tipo_doc_archivistico
				);
		//
			return $this -> db -> insert('respuesta_docentes', $data);
    }

    function actualizarBanderaDocentes($id_oficio_recepcion)
	{
			$data = array(
                'fue_respondido' => 1
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_docentes', $data);
	}

	 function actualizarStatusContesadoDocentes($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_docentes', $data);
	}

	public function getAllCopiasADependencias()
	{
		$this->db->select('*');
		$this->db->from('turnado_dependencias');
		$this->db->join('oficios_salida_planteles', 'turnado_dependencias.id_oficio = oficios_salida_planteles.id_oficio_salida');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 public function getAllsByNumOficioDocentes()
	 {
	 		$this->db->select('num_oficio');
			$this->db->from('oficios_docentes');	
			$consulta = $this->db->get();
			return $consulta -> result();
	 }

	  public function getAllsByNumOficioSalidaPlanteles()
	 {
	 		$this->db->select('num_oficio');
			$this->db->from('oficios_salida_planteles');	
			$consulta = $this->db->get();
			return $consulta -> result();
	 }

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

}

/* End of file Modelo_planteles.php */
/* Location: ./application/models/Modelo_planteles.php */