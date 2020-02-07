<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dirgral extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();		
	}

	function getAllEntradas($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'direccion_destino = id_direccion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$this->db->where('recepcion_oficios.respondido', '0');
		$this->db->where('recepcion_oficios.asignado', '0');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllPendientes()
	{
		$this->db->select('*');
		$this->db->from('recepcion_oficios');
		$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
		//$this->db->where('recepcion_oficios.status', 'Pendiente');
		$where = "recepcion_oficios.status = 'Pendiente' OR recepcion_oficios.status = 'No Contestado'";
		$this->db->where($where, NULL, FALSE);	
		$this->db->group_by('recepcion_oficios.id_recepcion');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function getAllContestados()
	{
		$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
		$this->db->from('recepcion_oficios');
		$this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
		$this->db->where('recepcion_oficios.status', 'Contestado');
		$this->db->group_by('recepcion_oficios.id_recepcion');
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
		$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
		$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
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


	function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $receptor, $respuesta, $anexos, $id_oficio_recepcion)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_recepcion' =>  $id_oficio_recepcion
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

	public function cambiarBanderaAsignacion($id_oficio_recepcion)
	{
		$data = array(
                'asignado' => 1
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

    function consultarNombreDir($id_dir)
    {
    	$this->db->select('nombre_direccion');
		$this->db->from('direcciones');
		$this->db->where('id_direccion', $id_dir);
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

    function getAsignaciones()
    {
    	$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('asignacion_direcciones', 'direcciones.id_direccion = asignacion_direcciones.id_direccion');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_direcciones.id_recepcion');
		$this->db->where('recepcion_oficios.asignado', '1');
		$this->db->where('recepcion_oficios.respondido', '0');
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function eliminarAsignacionOf($idasignacion)
    {
    	$this->db->where('id_asignacion',$idasignacion);
		return $this->db->delete('asignacion_direcciones');
    }

    function editarAsignacion($idasignacion, $depto)
    {
    	$data = array(
                'id_direccion' => $depto
                );

            $this->db->where('id_asignacion', $idasignacion);
            return $this->db->update('asignacion_direcciones', $data);
    }

}

/* End of file Model_dirgral.php */
/* Location: ./application/models/Model_dirgral.php */