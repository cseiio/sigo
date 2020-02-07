<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//Añadiendo librerias URL y FORM_ VALIDATION
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->clear_cache();
	}

	public function index()
	{
		
		if (!isset($_POST['password'])) {

			if ($this->session->userdata('logueado') == FALSE) {
				$data['titulo'] = 'Login';
				$this->load->view('plantilla/header', $data);
				$this->load->view('index');
				$this->load->view('plantilla/footer');			
			}
			else
			{
				if ($this->session->userdata('nivel') == 1)
					{
						redirect(base_url() . 'RecepcionGral/PanelRecepGral/');
					}
					else
						if($this->session->userdata('nivel') == 2)
						{
							redirect(base_url() . 'Direcciones/PanelDir/');
						}
						else
							if ($this->session->userdata('nivel') == 3) 
							{
								redirect(base_url() . 'Departamentos/PanelDeptos/');
							}

							else
								if ($this->session->userdata('nivel') == 4)
								{
									redirect(base_url() . 'Admin/PanelAdmin/');
								}
								else
									if ($this->session->userdata('nivel') == 5)
									{
										redirect(base_url() . 'DirGral/PanelDirGral/');
									}
									else
										if ($this->session->userdata('nivel') == 6)
										{
											redirect(base_url() . 'Direcciones/Externos/Planteles/PanelPlanteles');
										}
										else
									{
										$this->session->set_flashdata('invalido', 'El usuario:  "'.$clave_area.'", no tiene acceso, verifique su información.');
										redirect('Login');

									}
			}

		}
		else
		{
			$this -> form_validation -> set_rules('user','usuario','trim|required|xss_clean');
			$this -> form_validation -> set_rules('password','password','trim|required|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
				$data['titulo'] = 'Login';
				$this->load->view('plantilla/header', $data);
				$this->load->view('index');
				$this->load->view('plantilla/footer');
			}
			else
			{
				$this->load->model('Model_login');
				$clave_area = $_POST['user'];
				$password = $_POST['password'];

				date_default_timezone_set('America/Mexico_City');
				$hora = date('H:i:s');
				$fecha = date('Y-m-d');

				if($this->Model_login->login($clave_area, $password))
				{
					$consulta = $this->Model_login->getUsuario($clave_area);
					$datos_usuario = array(
						'clave_area' => $clave_area,
						'nombre' => $consulta->nombre_empleado,
						'nivel' => $consulta->nivel,
						'id_direccion' => $consulta->direccion,
						'nombre_direccion' => $consulta->nombre_direccion,
						'id_area' => $consulta->departamento,
						'nombre_area' => $consulta->nombre_area,
						'isDepartamento'  => $consulta->isDir,
						'descripcion' => $consulta->descripcion,
						'area_trabajo' => $consulta->area_trabajo,
						'logueado' => TRUE
					);

					$this->session->set_userdata($datos_usuario);

					$this->Model_login->Registra_acceso($clave_area, $consulta->nombre_empleado, $hora, $fecha);

					if ($this->session->userdata('nivel') == 1)
					{
						redirect(base_url() . 'RecepcionGral/PanelRecepGral/');
					}
					else
						if($this->session->userdata('nivel') == 2)
						{
							redirect(base_url() . 'Direcciones/PanelDir/');
						}
						else
							if ($this->session->userdata('nivel') == 3) 
							{
								redirect(base_url() . 'Departamentos/PanelDeptos/');
							}

							else
								if ($this->session->userdata('nivel') == 4)
								{
									redirect(base_url() . 'Admin/PanelAdmin/');
								}
								else
									if ($this->session->userdata('nivel') == 5)
									{
										redirect(base_url() . 'DirGral/PanelDirGral/');
									}
									else
										if ($this->session->userdata('nivel') == 6)
										{
											redirect(base_url() . 'Direcciones/Externos/Planteles/PanelPlanteles');
										}
									}
									else
									{
										$this->session->set_flashdata('invalido', 'El usuario:  "'.$clave_area.'", no tiene acceso, verifique su información.');
										redirect('Login');

									}
								}

							} 
						}

	public function salir()
	{
		$this->session->sess_destroy();
		$this->session->set_userdata(array('user' => '', 'nombre' => '', 'logueado' => FALSE));
		$this->clear_cache();
		redirect('Login','refresh');
	}
	
	function clear_cache()
    {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }	
    
}
