<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		$this -> load -> model('Modelo_reportes');
		//Load Dependencies

	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Monitor de Accesos';
			$data['accesos'] = $this -> Model_admin-> getAllAccesos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/accesos/monitor');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}


	public function reporteAllAccesos() {


		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();

		date_default_timezone_set('America/Mexico_City');
		$time = time();
		$hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

		$inicio = $this->input->post('date_inicio');
		$final = $this->input->post('date_final');

        // DIBUJANDO EL LOGO DEL CSEIIO
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('./assets/img/apple-touch-icon.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setHeight(100);
		$objDrawing->setWidth(100);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
		$objDrawingGob = new PHPExcel_Worksheet_Drawing();
		$objDrawingGob->setName('LogoGob');
		$objDrawingGob->setDescription('Logo');
		$objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

		$objDrawingGob->setCoordinates('G1');
		$objDrawingGob->setHeight(1000);
		$objDrawingGob->setWidth(306);
		$objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

		$objPHPExcel->getProperties()->setCreator("CSEIIO")
		->setLastModifiedBy("CSEIIO")
		->setTitle("Reporte de Accesos al Sistema de Gestión Oficios")
		->setSubject("Reporte de Administrador")
		->setDescription("Reporte que contiene el total de accesos registrados al Sistema de gestión de Oficios del CSEIIO.")
		->setKeywords("cseiio reporte oficios oficialia externos")
		->setCategory("Reporte");

		$tituloReporte = "Reporte de accesos realizados al Sistema de Gestión de Oficios del CSEIIO en el periodo:  ".$inicio."  al ".$final."";
		$tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
		$titulosColumnas = array('FOLIO DE ACCESO', 'USUARIO', 'NOMBRE', 'HORA DE ACCESO', 'FECHA DE ACCESO');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
		$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:E1');
// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('B4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:E6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllAccesos($inicio, $final);

    $i = 7;

    foreach($oficios as $fila)
    {
    	

    		$objPHPExcel->setActiveSheetIndex(0)
    		->setCellValue('A'.$i, $fila->id_acceso)
    		->setCellValue('B'.$i, $fila->clave_area)
    		->setCellValue('C'.$i, $fila->nombre)
    		->setCellValue('D'.$i, $fila->hora_acceso)
    		->setCellValue('E'.$i, $fila->fecha_acceso);
    
     //Contador de celdas
    	$i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Accesos Realizados');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_ACCESOS:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;


}

}

/* End of file Monitor.php */
/* Location: ./application/controllers/Admin/Accesos/Monitor.php */