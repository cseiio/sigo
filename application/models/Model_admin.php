<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_admin extends CI_Model {

	function __construct()
	{
		
	}

	public function getAllDirectoresArea()
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('empleados', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('empleados.isDir', 1);
		$this->db->where('direcciones.esOfCentrales', 1);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllDirectoresPlantel()
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('empleados', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('empleados.isDir', 1);
		$this->db->where('direcciones.esOfCentrales', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllJefesDepto()
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('empleados', 'departamentos.id_area = empleados.departamento');
		$this->db->join('direcciones', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('isNull', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllAccesos()
	{
		$this->db->select('*');
		$this->db->from('crtl_acceso');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllUsuarios()
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		$consulta = $this->db->get();
		return $consulta -> result();
	}




	// -------------  ---- Empleados ----- ----------------
	// Agregar Jefe de Departamento
	
	public function getDeptosByIdDireccion($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getClaveArea($clave_area)
	{
		$this->db->select('*');
		$this->db->from('empleados');
		$this->db->where('clave_area', $clave_area);
		$consulta = $this->db->get();
		return $consulta -> result();
	}	


	public function addJefeDepto($clave_area,$nombre_empleado,$direccion,$departamento_adsc,$cargo, $email, $email_personal, $isDir)
	{
		$data = array(
				'clave_area' => $clave_area,
				'nombre_empleado' => $nombre_empleado,
				'direccion' => $direccion,
				'departamento' => $departamento_adsc,
				'descripcion' => $cargo,
				'email' => $email,
				'email_personal' => $email_personal,
				'isDir'=> $isDir
				);

			return $this->db->insert('empleados', $data);
			
	}

	//Actualizar o modificar informacion de un jefe de Departamento
	public function updateJefeDepto($clave_area,$nombre_empleado,$direccion,$departamento_adsc,$cargo, $email, $email_personal, $isDir)
	{
		$data = array(
				'clave_area' => $clave_area,
				'nombre_empleado' => $nombre_empleado,
				'direccion' => $direccion,
				'departamento' => $departamento_adsc,
				'descripcion' => $cargo,
				'email' => $email,
				'email_personal' => $email_personal,
				'isDir'=> $isDir
				);

			$this->db->where('clave_area', $clave_area);
			return $this->db->update('empleados', $data);
			
	}



	//Eliminar la información de un jefe de departamento
	public function deleteJefeDepto($id)
	{
		$this->db->where('clave_area',$id);
			return $this->db->delete('empleados');
	}

	// -------------- ---- Directores de Área ---------------

	//Actualizar o modificar Director de Área
	public function updateDirectorArea($id,$nombre,$direccion,$descripcion, $email, $email_personal)
	{
		$data = array(
				'nombre_empleado' => $nombre,
				'direccion' => $direccion,
				'descripcion' => $descripcion,
				'email' => $email,
				'email_personal' => $email_personal
				);

			$this->db->where('clave_area', $id);
			return $this -> db -> update('empleados', $data);
	}


	// -------------- ---- Director de Plantel ---------------

	//Actualizar o modificar Director de Área
	public function updateDirectorPlantel( $id,$nombre,$direccion,$descripcion, $email, $email_personal )
	{
		$data = array(
				'nombre_empleado' => $nombre,
				'direccion' => $direccion,
				'descripcion' => $descripcion,
				'email' => $email,
				'email_personal' => $email_personal
				);

			$this->db->where('clave_area', $id);
			return $this -> db -> update('empleados', $data);
	}

	// -------------- --------- GESTIÓN DE USUARIOS ----------------

	public function getUsuariosPorDarDeAlta()
	{
		$this->db->select('*');
		$this->db->from('empleados');
		$this->db->where('activo', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function addUsuario($clave_area,$password,$nivel)
	{
		$data = array(
				'clave_area' => $clave_area,
				'password' => $password,
				'nivel' => $nivel
				);

			return $this->db->insert('usuarios', $data);
			
	}

	public function cambiarBanderaActivacion($clave_area)
	{	
			$data = array(
                'activo' => 1
                );

            $this->db->where('clave_area', $clave_area);
            return $this->db->update('empleados', $data);
	}

	public function updateUsuario($clave_area,$password,$nivel)
	{
		$data = array(
				
				'password' => $password,
				'nivel' => $nivel
				);

		$this->db->where('clave_area', $clave_area);
		return $this->db->update('usuarios', $data);
	}


	//Eliminar la información de un jefe de departamento
	public function deleteUsuario($id)
	{
		$this->db->where('clave_area',$id);
			return $this->db->delete('usuarios');
	}

	public function cambiarBanderaBaja($clave_area)
	{	
			$data = array(
                'activo' => 0
                );

            $this->db->where('clave_area', $clave_area);
            return $this->db->update('empleados', $data);
	}

	// ------------ PANEL ESTADÍSTICO --------------
	

    public function total_empleados_registrados()
    {
        return $this->db->count_all_results('empleados');
    }

    public function total_usuarios_en_alta()
    {
        return $this->db->count_all_results('usuarios');
    }

    public function total_accesos_registrados()
    {
        return $this->db->count_all_results('crtl_acceso');
    }

    public function total_oficios_externos()
    {
        return $this->db->count_all_results('recepcion_oficios');
    }

    public function total_oficios_internos()
    {
        return $this->db->count_all_results('emision_interna');
    }


}

/* End of file Model_admin.php */
/* Location: ./application/models/Model_admin.php */



