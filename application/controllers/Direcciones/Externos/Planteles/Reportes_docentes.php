<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_docentes extends CI_Controller {

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
			$this->load->view('directores/externos/planteles/reportes_docentes');
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


    
    public function reporteAllCapturadosDocentes()
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

    	$objDrawingGob->setCoordinates('O1');
    	$objDrawingGob->setHeight(1000);
    	$objDrawingGob->setWidth(306);
    	$objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    	$objPHPExcel->getProperties()->setCreator("CSEIIO")
    	->setLastModifiedBy("CSEIIO")
    	->setTitle("Reporte del Total de Oficios Capturados por Plantel-Modalidad Docente")
    	->setSubject("Reporte de Planteles")
    	->setDescription("Reporte que contiene el total de oficios capturados por el plantel, Modalidad Docente.")
    	->setKeywords("cseiio reporte oficios bic uesa externos")
    	->setCategory("Reporte");

    	$tituloReporte = "Reporte de oficios salientes, capturados por el Plantel, comprendido del periodo:  ".$inicio."  al ".$final."";
    	$tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    	$titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR DEL OFICIO', 'PLANTEL DEL EMISOR','CARGO DEL EMISOR','ESTATUS','OBSERVACIONES','N° OFICIO DE RESPUESTA','PERSONA QUE CONTESTO EL OFICIO','CARGO','PLANTEL','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA', 'HORA DE RESPUESTA');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A3:P3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:P4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    	->mergeCells('A1:P1');
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
    ->setCellValue('P6',  $titulosColumnas[15]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllOficiosSalidaDocentes($id_direccion,$inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'P'.$i)->applyFromArray($style_contenido);

        if ($fila->status == 'Contestado') {

           $infor_contestados = $this->Modelo_reportes->getAllOficiosDocentesByID($fila->id_oficio_salida);

            foreach ($infor_contestados as $key) {

            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $key->num_oficio)
            ->setCellValue('B'.$i, $key->fecha_emision)
            ->setCellValue('C'.$i, $key->hora_emision)
            ->setCellValue('D'.$i, $key->asunto)
            ->setCellValue('E'.$i, $key->emisor_docente)
            ->setCellValue('F'.$i, $key->bachillerato)
            ->setCellValue('G'.$i, $key->cargo_docente)
            ->setCellValue('H'.$i, $key->status)
            ->setCellValue('I'.$i, $key->observaciones)
            ->setCellValue('J'.$i, $key->num_oficio_salida)
            ->setCellValue('K'.$i, $key->emisor)
            ->setCellValue('L'.$i, $key->cargo)
            ->setCellValue('M'.$i, $key->dependencia_emisor)
            ->setCellValue('N'.$i, $key->codigo)
            ->setCellValue('O'.$i, $key->fecha_respuesta)
            ->setCellValue('P'.$i, $key->hora_respuesta);
             }
        }
        else
        {
              $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_emision)
            ->setCellValue('C'.$i, $fila->hora_emision)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor_docente)
            ->setCellValue('F'.$i, $fila->bachillerato)
            ->setCellValue('G'.$i, $fila->cargo_docente)
            ->setCellValue('H'.$i, $fila->status)
            ->setCellValue('I'.$i, $fila->observaciones);
        }
     //Contador de celdas
    	$i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Capturados');

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

        $objDrawingGob->setCoordinates('O1');
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
        $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
        $titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR DEL OFICIO','CARGO','PLANTEL','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES', '¿REQUIERE RESPUESTA?');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:O1');
// Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('I3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('I4',  $tituloCseiio) // Titulo del Colegio
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
    ->setCellValue('O6',  $titulosColumnas[14]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllOficiosInformativosPlanteles($id_direccion, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
        
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->codigo)
                ->setCellValue('C'.$i, $fila->fecha_emision)
                ->setCellValue('D'.$i, $fila->hora_emision)
                ->setCellValue('E'.$i, $fila->asunto)
                ->setCellValue('F'.$i, $fila->tipo_emision)
                ->setCellValue('G'.$i, $fila->tipo_documento)
                ->setCellValue('H'.$i, $fila->emisor)
                ->setCellValue('I'.$i, $fila->cargo)
                ->setCellValue('J'.$i, $fila->bachillerato)
                ->setCellValue('K'.$i, $fila->remitente)
                ->setCellValue('L'.$i, $fila->cargo_remitente)
                ->setCellValue('M'.$i, $fila->dependencia_remitente)
                ->setCellValue('N'.$i, $fila->observaciones)
                ->setCellValue('O'.$i, 'No');
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

    $objDrawingGob->setCoordinates('O1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte de oficios contestados-Modalidad Docentes")
    ->setSubject("Reporte de Oficialia")
    ->setDescription("Reporte que contiene el total de oficios contestados, emitidos por docentes - Modalidad Docentes.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios contestados emitidos por docentes, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR DEL OFICIO', 'PLANTEL DEL EMISOR','CARGO DEL EMISOR','ESTATUS','OBSERVACIONES','N° OFICIO DE RESPUESTA','PERSONA QUE CONTESTO EL OFICIO','CARGO','PLANTEL','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA', 'HORA DE RESPUESTA');

     $objPHPExcel->getActiveSheet(0)->mergeCells('A3:P3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:P4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:P1');
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
    ->setCellValue('P6',  $titulosColumnas[15]);

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
   $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllRespuestasADocentes($id_direccion,$inicio, $final);

    $i = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $key)
    {
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'P'.$i)->applyFromArray($style_contenido);

            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $key->num_oficio)
            ->setCellValue('B'.$i, $key->fecha_emision)
            ->setCellValue('C'.$i, $key->hora_emision)
            ->setCellValue('D'.$i, $key->asunto)
            ->setCellValue('E'.$i, $key->emisor_docente)
            ->setCellValue('F'.$i, $key->bachillerato)
            ->setCellValue('G'.$i, $key->cargo_docente)
            ->setCellValue('H'.$i, $key->status)
            ->setCellValue('I'.$i, $key->observaciones)
            ->setCellValue('J'.$i, $key->num_oficio_salida)
            ->setCellValue('K'.$i, $key->emisor)
            ->setCellValue('L'.$i, $key->cargo)
            ->setCellValue('M'.$i, $key->dependencia_emisor)
            ->setCellValue('N'.$i, $key->codigo)
            ->setCellValue('O'.$i, $key->fecha_respuesta)
            ->setCellValue('P'.$i, $key->hora_respuesta);
     $i++;

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