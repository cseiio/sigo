<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FueraDeTiempoInterno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
			if ($this->session->userdata('nombre')) {

		$data['titulo'] = 'Contestados Fuera de Tiempo';
		$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
		$data['fueratiempo'] = $this -> Modelo_departamentos -> getAllFueraTiempoInternos($this->session->userdata('id_area'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('deptos/internos/fueradetiempodir');
		$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	public function Descargar($name)
	{
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
	}

	  function DescargarAnexos($name)
		{
			//$this->folder = './doctosanexos/';
			$data = file_get_contents(base_url().'doctosanexosinternos/'.$name); 
        	force_download($name,$data); 
		}
			function DescargarRespuesta($name)
		{
			//$this->folder = './doctosrespuesta/';
			$data = file_get_contents(base_url().'doctosrespuestainterna/'.$name); 
        	force_download($name,$data); 
		}

		public function ModificarArchivos()
	{
		$data =  array(

			$id_recepcion = $this -> input -> post('txt_idoficio'),
			$num_oficio = $this -> input -> post('num_oficio')

		);

		if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
			if (!empty($_FILES['ofrespuesta']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosrespuestainterna/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
				    $config['file_name'] = 'Folio_'.$id_recepcion.'_'.'Oficio_de_respuesta';
					
            				// Cargamos la configuración del Archivo 1
					$this->upload->initialize($config);

           				 // Subimos archivo 1
					if ($this->upload->do_upload('ofrespuesta'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}
					$respuesta = $this->upload->data('file_name');

				}
					if (!empty($_FILES['anexos']['name']))
				{
             // La configuración del Archivo 2, debe ser diferente del archivo 1
            // si configuras como el Archivo 1 no hará nada
					$config['upload_path'] = './doctosanexosinternos/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_'.'Anexos';
					
            // Cargamos la nueva configuración
					$this->upload->initialize($config);

            // Subimos el segundo Archivo
					if ($this->upload->do_upload('anexos'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}

					$anexos = $this->upload->data('file_name');
				}
				else
				{
					$anexos = 'default.pdf';
				}

				$actualizarArchivos = $this->Modelo_departamentos->actualizarArchivosdeRespuestaInterno($id_recepcion, $respuesta, $anexos);

				if ($actualizarArchivos) {
					$this->session->set_flashdata('exito', 'Se ha enviado actualizado los archivos de respuesta y anexos correctamente');
						redirect(base_url() . 'Departamentos/Interno/FueraDeTiempoInterno/');
				}
				else
				{
					$this->session->set_flashdata('error', 'Al actualizar los archivos de respuesta y anexos, verifique');
						redirect(base_url() . 'Departamentos/Interno/FueraDeTiempoInterno/');
				}
		}
	}
}

/* End of file FueraDeTiempoInterno.php */
/* Location: ./application/controllers/FueraDeTiempoInterno.php */