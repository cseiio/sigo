<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {

			$data['titulo'] = 'Reportes';
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/reportes');
			$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'startcolor' => array(
       'rgb' => $color
     )
    ));
  }

  function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) 
{
        // Convirtiendo en timestamp las fechas
  	$fechainicio = strtotime($fechainicio);
  	$fechafin = strtotime($fechafin);

        // Incremento en 1 dia
  	$diainc = 24*60*60;

        // Arreglo de dias habiles, inicianlizacion
  	$diashabiles = array();

        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
  	for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                	if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                		array_push($diashabiles, date('Y-m-d', $midia));
                	}
                }
            }

            return $diashabiles;
    }


    
    public function reporteAllCapturadosSalidas()
    {
    	

    	$this->load->library('Excel');
    	$objPHPExcel = new PHPExcel();

    	date_default_timezone_set('America/Mexico_City');
    	$time = time();
    	$hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

    	$inicio = $this->input->post('date_inicio');
    	$final = $this->input->post('date_final');
        $id_direccion = $this->session->userdata('id_direccion');

        // DIBUJANDO EL LOGO DEL CSEIIO0
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

    	$objDrawingGob->setCoordinates('R1');
    	$objDrawingGob->setHeight(1000);
    	$objDrawingGob->setWidth(306);
    	$objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    	$objPHPExcel->getProperties()->setCreator("CSEIIO")
    	->setLastModifiedBy("CSEIIO")
    	->setTitle("Reporte del Total de Oficios Capturados por Plantel-Modalidad Externa")
    	->setSubject("Reporte de Planteles")
    	->setDescription("Reporte que contiene el total de oficios capturados por el plantel, Modalidad Externa.")
    	->setKeywords("cseiio reporte oficios bic uesa externos")
    	->setCategory("Reporte");

    	$tituloReporte = "Reporte de oficios salientes, capturados por el Plantel, comprendido del periodo:  ".$inicio."  al ".$final."";
    	$tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    	$titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'FECHA DE ACUSE','HORA DE ACUSE', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR DEL OFICIO','CARGO','PLANTEL','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES', '¿REQUIERE RESPUESTA?','HORA DE SUBIDA','FECHA DE SUBIDA');

           $objPHPExcel->getActiveSheet(0)->mergeCells('A3:S3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:S4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    	->mergeCells('A1:S1');
// Se agregan los titulos del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A3',  $tituloCseiio) // Titulo del Reporte
    ->setCellValue('A4',  $tituloReporte) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14])
    ->setCellValue('P6',  $titulosColumnas[15])
    ->setCellValue('Q6',  $titulosColumnas[16])
    ->setCellValue('R6',  $titulosColumnas[17])
    ->setCellValue('S6',  $titulosColumnas[18]);


   //DEFINICION DE ESTILOS
    
    // Centrando texto, aplicando fuente tamaño 18, letra negritas y color negro de fuente. Titulo del CSEIIO
    $styleA3 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')));

    // Centrando texto, aplicando fuente tamaño 16, letra negritas y color negro de fuente. Titulo de definición del reportes 
    $styleA4 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 16,'bold' => true,'color' => array('rgb' => '000000')));

    // Aplicando fuente tamaño 11, letra negritas y color blanco de fuente. Titulo de campos
    $styleA6R6 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),'font' => array('size' => 12,'bold' => true,'color' => array('rgb' => 'ffffff')));

  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

      $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

      $sheet = $objPHPExcel->getActiveSheet();
      $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(true);
      /** @var PHPExcel_Cell $cell */
      foreach ($cellIterator as $cell) {
          $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
      }
  }
  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  $style_contenido = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 12,'bold' => false,'color' => array('rgb' => '000000')));

    //APLICACION DE ESTILO A LOS TITULOS PRINCIPALES
   $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleA3);
   $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleA4);
   $objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:S6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllOficiosSalidaPlanteles($id_direccion,$inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

    	if ($fila->tieneRespuesta == 1) {
 	
    			$objPHPExcel->setActiveSheetIndex(0)
    			->setCellValue('A'.$i, $fila->num_oficio)
    			->setCellValue('B'.$i, $fila->codigo)
    			->setCellValue('C'.$i, $fila->fecha_emision)
    			->setCellValue('D'.$i, $fila->hora_emision)
                ->setCellValue('E'.$i, $fila->fecha_acuse)
                ->setCellValue('F'.$i, $fila->hora_acuse)
    			->setCellValue('G'.$i, $fila->asunto)
    			->setCellValue('H'.$i, $fila->tipo_emision)
    			->setCellValue('I'.$i, $fila->tipo_documento)
    			->setCellValue('J'.$i, $fila->emisor)
    			->setCellValue('K'.$i, $fila->cargo)
    			->setCellValue('L'.$i, $fila->bachillerato)
    			->setCellValue('M'.$i, $fila->remitente)
    			->setCellValue('N'.$i, $fila->cargo_remitente)
    			->setCellValue('O'.$i, $fila->dependencia_remitente)
    			->setCellValue('P'.$i, $fila->observaciones)
    			->setCellValue('Q'.$i, 'Si')
                ->setCellValue('R'.$i, $fila->fecha_subida)
                ->setCellValue('S'.$i, $fila->hora_subida);
    
    	}

    	else 
    		if($fila->tieneRespuesta == 0){

    		
    		$objPHPExcel->setActiveSheetIndex(0)
    	 		 ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->codigo)
                ->setCellValue('C'.$i, $fila->fecha_emision)
                ->setCellValue('D'.$i, $fila->hora_emision)
                ->setCellValue('E'.$i, $fila->fecha_acuse)
                ->setCellValue('F'.$i, $fila->hora_acuse)
                ->setCellValue('G'.$i, $fila->asunto)
                ->setCellValue('H'.$i, $fila->tipo_emision)
                ->setCellValue('I'.$i, $fila->tipo_documento)
                ->setCellValue('J'.$i, $fila->emisor)
                ->setCellValue('K'.$i, $fila->cargo)
                ->setCellValue('L'.$i, $fila->bachillerato)
                ->setCellValue('M'.$i, $fila->remitente)
                ->setCellValue('N'.$i, $fila->cargo_remitente)
                ->setCellValue('O'.$i, $fila->dependencia_remitente)
                ->setCellValue('P'.$i, $fila->observaciones)
                ->setCellValue('Q'.$i, 'No')
                ->setCellValue('R'.$i, $fila->fecha_subida)
                ->setCellValue('S'.$i, $fila->hora_subida);
    	}
     //Contador de celdas
    	$i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Salientes Capturados');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_SALIENTESCAPTURADOS:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;


}

 public function informativos()
    {
        

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();

        date_default_timezone_set('America/Mexico_City');
        $time = time(); 
        $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

        $inicio = $this->input->post('date_inicio');
        $final = $this->input->post('date_final');
        $id_direccion = $this->session->userdata('id_direccion');

        // DIBUJANDO EL LOGO DEL CSEIIO0
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

        $objDrawingGob->setCoordinates('R1');
        $objDrawingGob->setHeight(1000);
        $objDrawingGob->setWidth(306);
        $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getProperties()->setCreator("CSEIIO")
        ->setLastModifiedBy("CSEIIO")
        ->setTitle("Reporte del Total de Oficios informativos por Plantel-Modalidad Externa")
        ->setSubject("Reporte de Planteles")
        ->setDescription("Reporte que contiene el total de oficios informativos por el plantel, Modalidad Externa.")
        ->setKeywords("cseiio reporte oficios bic uesa externos")
        ->setCategory("Reporte");

        $tituloReporte = "Reporte de oficios informativos, capturados por el Plantel, comprendido del periodo:  ".$inicio."  al ".$final."";
         $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";

            $titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'FECHA DE ACUSE','HORA DE ACUSE', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR DEL OFICIO','CARGO','PLANTEL','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES', '¿REQUIERE RESPUESTA?','HORA DE SUBIDA','FECHA DE SUBIDA');

                 $objPHPExcel->getActiveSheet(0)->mergeCells('A3:S3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:S4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:S1');
// Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A3',  $tituloCseiio) // Titulo del Reporte
    ->setCellValue('A4',  $tituloReporte) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14])
    ->setCellValue('P6',  $titulosColumnas[15])
    ->setCellValue('Q6',  $titulosColumnas[16])
    ->setCellValue('R6',  $titulosColumnas[17])
    ->setCellValue('S6',  $titulosColumnas[18]);

   //DEFINICION DE ESTILOS
    
    // Centrando texto, aplicando fuente tamaño 18, letra negritas y color negro de fuente. Titulo del CSEIIO
    $styleA3 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')));

    // Centrando texto, aplicando fuente tamaño 16, letra negritas y color negro de fuente. Titulo de definición del reportes 
    $styleA4 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 16,'bold' => true,'color' => array('rgb' => '000000')));

    // Aplicando fuente tamaño 11, letra negritas y color blanco de fuente. Titulo de campos
    $styleA6R6 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),'font' => array('size' => 12,'bold' => true,'color' => array('rgb' => 'ffffff')));

  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

      $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

      $sheet = $objPHPExcel->getActiveSheet();
      $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(true);
      /** @var PHPExcel_Cell $cell */
      foreach ($cellIterator as $cell) {
          $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
      }
  }
  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  $style_contenido = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 12,'bold' => false,'color' => array('rgb' => '000000')));

    //APLICACION DE ESTILO A LOS TITULOS PRINCIPALES
   $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleA3);
   $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleA4);
   $objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:S6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllOficiosInformativosPlanteles($id_direccion, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);
        
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->codigo)
                ->setCellValue('C'.$i, $fila->fecha_emision)
                ->setCellValue('D'.$i, $fila->hora_emision)
                ->setCellValue('E'.$i, $fila->fecha_acuse)
                ->setCellValue('F'.$i, $fila->hora_acuse)
                ->setCellValue('G'.$i, $fila->asunto)
                ->setCellValue('H'.$i, $fila->tipo_emision)
                ->setCellValue('I'.$i, $fila->tipo_documento)
                ->setCellValue('J'.$i, $fila->emisor)
                ->setCellValue('K'.$i, $fila->cargo)
                ->setCellValue('L'.$i, $fila->bachillerato)
                ->setCellValue('M'.$i, $fila->remitente)
                ->setCellValue('N'.$i, $fila->cargo_remitente)
                ->setCellValue('O'.$i, $fila->dependencia_remitente)
                ->setCellValue('P'.$i, $fila->observaciones)
                ->setCellValue('Q'.$i, 'No')
                ->setCellValue('R'.$i, $fila->fecha_subida)
                ->setCellValue('S'.$i, $fila->hora_subida);
     //Contador de celdas
        $i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Informativos');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_INFORMATIVOS:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;


}

public function reporteContestados() {


    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();

    date_default_timezone_set('America/Mexico_City');
    $time = time();
    $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

    $inicio = $this->input->post('date_inicio');
    $final = $this->input->post('date_final');
    $id_direccion = $this->session->userdata('id_direccion');

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

    $objDrawingGob->setCoordinates('T1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte de oficios contestados-Modalidad Externa")
    ->setSubject("Reporte de Oficialia")
    ->setDescription("Reporte que contiene el total de oficios contestados - Modalidad Externa.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";

    $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','PLANTEL','CARGO','FECHA DE EMISIÓN','HORA DE EMISIÓN','FECHA DE ACUSE','HORA DE ACUSE','ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE RESPONDE EL OFICIO','CARGO','DEPENDENCIA', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA', 'FECHA SUBIDA', 'HORA DE SUBIDA');

     $objPHPExcel->getActiveSheet(0)->mergeCells('A3:U3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:U4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:U1');
// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A3',  $tituloCseiio) // Titulo del Reporte
    ->setCellValue('A4',  $tituloReporte) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14])
    ->setCellValue('P6',  $titulosColumnas[15])
    ->setCellValue('Q6',  $titulosColumnas[16])
    ->setCellValue('R6',  $titulosColumnas[17])
    ->setCellValue('S6',  $titulosColumnas[18])
    ->setCellValue('T6',  $titulosColumnas[19])
    ->setCellValue('U6',  $titulosColumnas[20]);

 //DEFINICION DE ESTILOS
    
    // Centrando texto, aplicando fuente tamaño 18, letra negritas y color negro de fuente. Titulo del CSEIIO
    $styleA3 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')));

    // Centrando texto, aplicando fuente tamaño 16, letra negritas y color negro de fuente. Titulo de definición del reportes 
    $styleA4 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 16,'bold' => true,'color' => array('rgb' => '000000')));

    // Aplicando fuente tamaño 11, letra negritas y color blanco de fuente. Titulo de campos
    $styleA6R6 = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),'font' => array('size' => 12,'bold' => true,'color' => array('rgb' => 'ffffff')));

  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

      $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

      $sheet = $objPHPExcel->getActiveSheet();
      $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(true);
      /** @var PHPExcel_Cell $cell */
      foreach ($cellIterator as $cell) {
          $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
      }
  }
  // AUTO AJUSTAR EL TAMAÑO DE LA COLUMNA SEGUN SU CONTENIDO
  $style_contenido = array('alignment'=> array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 12,'bold' => false,'color' => array('rgb' => '000000')));

    //APLICACION DE ESTILO A LOS TITULOS PRINCIPALES
   $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleA3);
   $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleA4);
   $objPHPExcel->getActiveSheet()->getStyle('A6:U6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:U6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllRespuestasASalidas($id_direccion,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'U'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_emision)
     ->setCellValue('F'.$i, $fila->emisorplantel)
     ->setCellValue('G'.$i, $fila->bachillerato)
     ->setCellValue('H'.$i, $fila->cargoplantel)
     ->setCellValue('I'.$i, $fila->fecha_emision)
     ->setCellValue('J'.$i, $fila->hora_emision)
     ->setCellValue('K'.$i, $fila->hora_acuse)
     ->setCellValue('L'.$i, $fila->fecha_acuse)
     ->setCellValue('M'.$i, $fila->status)
     ->setCellValue('N'.$i, $fila->num_oficio_salida)
     ->setCellValue('O'.$i, $fila->emisorres)
     ->setCellValue('P'.$i, $fila->cargores)
     ->setCellValue('Q'.$i, $fila->dependencia_emisor)
     ->setCellValue('R'.$i, $fila->fecha_respuesta)
     ->setCellValue('S'.$i, $fila->hora_respuesta)
     ->setCellValue('T'.$i, $fila->fecha_subida)
     ->setCellValue('U'.$i, $fila->hora_subida);

     $i++;
     $j++;

 }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficios Contestados');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_CONTESTADOS:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;


}

}

/* End of file Reportes.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Reportes.php */