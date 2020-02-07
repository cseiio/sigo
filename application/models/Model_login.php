<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Model_login extends CI_Model 
	{
		
    	public function  login($clave_area, $password)
    	{
  
    		//return $this -> db -> insert('libros', $data);
    		 $this->db->where('clave_area',$clave_area);
    		 $this->db->where('password',$password);
    		 $busqueda = $this->db->get('usuarios');
    		
    		 if ($busqueda->num_rows()>0) {
    		 	return true;
    		 }
			 else
			 {
			 	return false;
			 }
    	}

    	public function getUsuario($clave_area)
    	{
   
    		$this->db->select("*");
            $this->db->select("empleados.departamento as isDir");
    		$this->db->from('usuarios');
            $this->db->join('empleados', 'usuarios.clave_area = empleados.clave_area');
            $this->db->join('direcciones', 'empleados.direccion = direcciones.id_direccion');
    		$this->db->where('usuarios.clave_area',$clave_area);
    		$seleccion = $this->db->get();
    		$resultado = $seleccion->row();
    		return $resultado;
    	}

        public function Registra_acceso($clave_area, $nombre, $hora, $fecha){

          $consulta=$this->db->query("INSERT INTO crtl_acceso(clave_area,nombre,hora_acceso,fecha_acceso) VALUES('$clave_area','$nombre','$hora','$fecha');");
            if($consulta==true){
              return true;
          }else{
            return false;
        }

    }
}

 ?>