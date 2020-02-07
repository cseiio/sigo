<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
     $this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {

			$data['titulo'] = 'Reportes';
      $data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/reportes');
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


     //   reporteAllCapturadosSalidas

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
             $dependencia =  $this->input->post('dependencia');

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
             ->setTitle("Reporte del Total de Oficios Recibidos-Modalidad Externa")
             ->setSubject("Reporte de Oficialia")
             ->setDescription("Reporte que contiene el total de oficios recibidos por Oficialia de Partes, Modalidad Externa.")
             ->setKeywords("cseiio reporte oficios oficialia externos")
             ->setCategory("Reporte");

             $tituloReporte = "Reporte de oficios salientes, capturados por la Unidad, comprendido del periodo:  ".$inicio."  al ".$final."";
             $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
             $titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR PRINCIPAL','TITULAR','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES', '¿REQUIERE RESPUESTA?');

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

    if ($dependencia == 'todas') {
      
    
    $oficios = $this->Modelo_reportes->getAllOficiosSalida($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'P'.$i)->applyFromArray($style_contenido);
    	if ($fila->tieneRespuesta == 1) {

       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $fila->num_oficio)
       ->setCellValue('B'.$i, $fila->codigo)
       ->setCellValue('C'.$i, $fila->fecha_emision)
       ->setCellValue('D'.$i, $fila->hora_emision)
       ->setCellValue('E'.$i, $fila->asunto)
       ->setCellValue('F'.$i, $fila->tipo_emision)
       ->setCellValue('G'.$i, $fila->tipo_documento)
       ->setCellValue('H'.$i, 'CSEIIO')
       ->setCellValue('I'.$i, $fila->titular)
       ->setCellValue('J'.$i, $fila->quien_realiza_oficio)
       ->setCellValue('K'.$i, $fila->cargo)
       ->setCellValue('L'.$i, $fila->remitente)
       ->setCellValue('M'.$i, $fila->cargo_remitente)
       ->setCellValue('N'.$i, $fila->dependencia_remitente)
       ->setCellValue('O'.$i, $fila->observaciones)
       ->setCellValue('P'.$i, 'Si');

     }

     else 
      if($fila->tieneRespuesta == 0){


        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $fila->num_oficio)
        ->setCellValue('B'.$i, $fila->codigo)
        ->setCellValue('C'.$i, $fila->fecha_emision)
        ->setCellValue('D'.$i, $fila->hora_emision)
        ->setCellValue('E'.$i, $fila->asunto)
        ->setCellValue('F'.$i, $fila->tipo_emision)
        ->setCellValue('G'.$i, $fila->tipo_documento)
        ->setCellValue('H'.$i, 'CSEIIO')
        ->setCellValue('I'.$i, $fila->titular)
        ->setCellValue('J'.$i, $fila->quien_realiza_oficio)
        ->setCellValue('K'.$i, $fila->cargo)
        ->setCellValue('L'.$i, $fila->remitente)
        ->setCellValue('M'.$i, $fila->cargo_remitente)
        ->setCellValue('N'.$i, $fila->dependencia_remitente)
        ->setCellValue('O'.$i, $fila->observaciones)
        ->setCellValue('P'.$i, 'No');
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
  else
  {
    $oficios = $this->Modelo_reportes->getAllOficiosSalidaByDependencia($inicio, $final, $dependencia);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'P'.$i)->applyFromArray($style_contenido);
      if ($fila->tieneRespuesta == 1) {

       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $fila->num_oficio)
       ->setCellValue('B'.$i, $fila->codigo)
       ->setCellValue('C'.$i, $fila->fecha_emision)
       ->setCellValue('D'.$i, $fila->hora_emision)
       ->setCellValue('E'.$i, $fila->asunto)
       ->setCellValue('F'.$i, $fila->tipo_emision)
       ->setCellValue('G'.$i, $fila->tipo_documento)
       ->setCellValue('H'.$i, 'CSEIIO')
       ->setCellValue('I'.$i, $fila->titular)
       ->setCellValue('J'.$i, $fila->quien_realiza_oficio)
       ->setCellValue('K'.$i, $fila->cargo)
       ->setCellValue('L'.$i, $fila->remitente)
       ->setCellValue('M'.$i, $fila->cargo_remitente)
       ->setCellValue('N'.$i, $fila->dependencia_remitente)
       ->setCellValue('O'.$i, $fila->observaciones)
       ->setCellValue('P'.$i, 'Si');

     }

     else 
      if($fila->tieneRespuesta == 0){


        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $fila->num_oficio)
        ->setCellValue('B'.$i, $fila->codigo)
        ->setCellValue('C'.$i, $fila->fecha_emision)
        ->setCellValue('D'.$i, $fila->hora_emision)
        ->setCellValue('E'.$i, $fila->asunto)
        ->setCellValue('F'.$i, $fila->tipo_emision)
        ->setCellValue('G'.$i, $fila->tipo_documento)
        ->setCellValue('H'.$i, 'CSEIIO')
        ->setCellValue('I'.$i, $fila->titular)
        ->setCellValue('J'.$i, $fila->quien_realiza_oficio)
        ->setCellValue('K'.$i, $fila->cargo)
        ->setCellValue('L'.$i, $fila->remitente)
        ->setCellValue('M'.$i, $fila->cargo_remitente)
        ->setCellValue('N'.$i, $fila->dependencia_remitente)
        ->setCellValue('O'.$i, $fila->observaciones)
        ->setCellValue('P'.$i, 'No');
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

  }
  // Informativos - salida
  public function reporteContestadoSalida()
  {

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

    $objDrawingGob->setCoordinates('S1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte de oficios contestados-Modalidad Salientes")
    ->setSubject("Reporte de Oficialia")
    ->setDescription("Reporte que contiene el total de oficios contestados - Modalidad Salientes.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios contestados en modalidad salientes, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE EMISIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE EMISIÓN','HORA DE EMISIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE RECEPCIÓN EN DEPENDENCIA','HORA DE RECEPCIÓN EN DEPENDENCIA','OBSERVACIONES');

       $objPHPExcel->getActiveSheet(0)->mergeCells('A3:T3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:T4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:T1');
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
    ->setCellValue('T6',  $titulosColumnas[19]);

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
   $objPHPExcel->getActiveSheet()->getStyle('A6:T6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:T6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllContestadosSalidas($inicio, $final);

    $i = 7;
    $j = 1;
        
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'T'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_emision)
     ->setCellValue('F'.$i, $fila->titular)
     ->setCellValue('G'.$i, 'CSEIIO')
     ->setCellValue('H'.$i, $fila->emisor_principal)
     ->setCellValue('I'.$i, $fila->fecha_emision)
     ->setCellValue('J'.$i, $fila->hora_emision)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta)
     ->setCellValue('Q'.$i, $fila->hora_respuesta)
     ->setCellValue('R'.$i, $fila->fecha_acuse)
     ->setCellValue('S'.$i, $fila->hora_acuse)
     ->setCellValue('T'.$i, $fila->observaciones);

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


 public function reporteContestadoFueraDeTiempo()
 {

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

  $objDrawingGob->setCoordinates('S1');
  $objDrawingGob->setHeight(1000);
  $objDrawingGob->setWidth(306);
  $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

  $objPHPExcel->getProperties()->setCreator("CSEIIO")
  ->setLastModifiedBy("CSEIIO")
  ->setTitle("Reporte de oficios contestados fuera de tiempo-Modalidad Salientes")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios contestados fuera de tiempo- Modalidad Salientes.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios contestados fuera de tiempo en modalidad salientes, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE EMISIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE EMISIÓN','HORA DE EMISIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE RECEPCIÓN EN DEPENDENCIA','HORA DE RECEPCIÓN EN DEPENDENCIA','OBSERVACIONES');

     $objPHPExcel->getActiveSheet(0)->mergeCells('A3:T3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:T4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('A1:T1');
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
    ->setCellValue('T6',  $titulosColumnas[19]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:T6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:T6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');


    $oficios = $this->Modelo_reportes->getAllContestadosFueraTiempoSalidas($inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'T'.$i)->applyFromArray($style_contenido);

          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->codigo)
          ->setCellValue('B'.$i, $j)
          ->setCellValue('C'.$i, $fila->num_oficio)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->tipo_emision)
          ->setCellValue('F'.$i, $fila->titular)
          ->setCellValue('G'.$i, 'CSEIIO')
          ->setCellValue('H'.$i, $fila->emisor_principal)
          ->setCellValue('I'.$i, $fila->fecha_emision)
          ->setCellValue('J'.$i, $fila->hora_emision)
          ->setCellValue('K'.$i, $fila->fecha_termino)
          ->setCellValue('L'.$i, $fila->status)
          ->setCellValue('M'.$i, $fila->num_oficio_salida)
          ->setCellValue('N'.$i, $fila->emisor)
          ->setCellValue('O'.$i, $fila->cargo)
          ->setCellValue('P'.$i, $fila->fecha_respuesta)
          ->setCellValue('Q'.$i, $fila->hora_respuesta)
          ->setCellValue('R'.$i, $fila->fecha_acuse)
          ->setCellValue('S'.$i, $fila->hora_acuse)
          ->setCellValue('T'.$i, $fila->observaciones);
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

      public function reporteOficiosInformativos()
      {

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

        $objDrawingGob->setCoordinates('N1');
        $objDrawingGob->setHeight(1000);
        $objDrawingGob->setWidth(306);
        $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getProperties()->setCreator("CSEIIO")
        ->setLastModifiedBy("CSEIIO")
        ->setTitle("Reporte del Total de Oficios Informativos-Modalidad Externa")
        ->setSubject("Reporte de Oficialia")
        ->setDescription("Reporte que contiene el total de oficios informativos recibidos por Unidad de Correspondencia del CSEIIO, Modalidad Externa.")
        ->setKeywords("cseiio reporte oficios oficialia externos")
        ->setCategory("Reporte");

        $tituloReporte = "Reporte de oficios informativos, capturados por la Unidad, comprendido del periodo:  ".$inicio."  al ".$final."";
        $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
        $titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR PRINCIPAL','CARGO','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES');

    $objPHPExcel->getActiveSheet(0)->mergeCells('A3:O3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:O4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:O1');
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
    ->setCellValue('O6',  $titulosColumnas[14]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');


    $oficios = $this->Modelo_reportes->getAllInformativosSalida($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'O'.$i)->applyFromArray($style_contenido);

      $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $fila->num_oficio)
      ->setCellValue('B'.$i, $fila->codigo)
      ->setCellValue('C'.$i, $fila->fecha_emision)
      ->setCellValue('D'.$i, $fila->hora_emision)
      ->setCellValue('E'.$i, $fila->asunto)
      ->setCellValue('F'.$i, $fila->tipo_emision)
      ->setCellValue('G'.$i, $fila->tipo_documento)
      ->setCellValue('H'.$i, $fila->titular)
      ->setCellValue('I'.$i, 'CSEIIO')
      ->setCellValue('J'.$i, $fila->quien_realiza_oficio)
      ->setCellValue('K'.$i, $fila->cargo)
      ->setCellValue('L'.$i, $fila->remitente)
      ->setCellValue('M'.$i, $fila->cargo_remitente)
      ->setCellValue('N'.$i, $fila->dependencia_remitente)
      ->setCellValue('O'.$i, $fila->observaciones);

     //Contador de celdas
      $i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Informativos Salientes');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_SALIENTESINFORMATIVOS:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function reportePendientes() {


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

    $objDrawingGob->setCoordinates('K1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte del Total de Oficios Pendientes-Modalidad Salientes")
    ->setSubject("Reporte de Oficialia")
    ->setDescription("Reporte que contiene el total de oficios pendientes por responder.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios pendientes por responder, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DEPENDENCIA DE DESTINO','OBSERVACIONES','DÍAS RESTANTES PARA RESPUESTA');

     $objPHPExcel->getActiveSheet(0)->mergeCells('A3:L3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:L4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:L1');
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
    ->setCellValue('L6',  $titulosColumnas[11]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:L6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    $oficios = $this->Modelo_reportes->getAllPendientesSalidas($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'L'.$i)->applyFromArray($style_contenido);


      if ($fila->tipo_dias == 0) {
        // DIAS NATURALES
        // Obteniendo dias naturales restantes entre la fecha de termino
        // y la fecha actual, si el oficio viene configurado con dias
        // naturales
        date_default_timezone_set('America/Mexico_City');
        $dia_actual = date('Y-m-d');

        $date1 = $dia_actual;
        $date2 = $fila->fecha_termino;
        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


        if ($days != 0) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->titular)
          ->setCellValue('F'.$i, 'CSEIIO')
          ->setCellValue('G'.$i, $fila->dependencia)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->dependencia_remitente)
          ->setCellValue('K'.$i, $fila->observaciones)
          ->setCellValue('L'.$i, $days);

        }
        else
        {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->titular)
          ->setCellValue('F'.$i, 'CSEIIO')
          ->setCellValue('G'.$i, $fila->dependencia)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->dependencia_remitente)
          ->setCellValue('K'.$i, $fila->observaciones)
          ->setCellValue('L'.$i, '0');
        }



      }
      else
        if ($fila->tipo_dias == 1) {

          // DIAS HÁBILES
          // Si el oficio viene configurado con días hábiles
          // entonces, llamar a la funcion  getDiasHabiles
          // si $dias_habiles = 0 
          // entonces imprimir : 0

         date_default_timezone_set('America/Mexico_City');
         $dia_actual = date('Y-m-d');
         $date1 = $dia_actual;
         $date2 = $fila->fecha_termino;
         $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
         $num_dias = count($dias_habiles);

         if ($dias_habiles != 0) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->titular)
          ->setCellValue('F'.$i, 'CSEIIO')
          ->setCellValue('G'.$i, $fila->dependencia)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->dependencia_remitente)
          ->setCellValue('K'.$i, $fila->observaciones)
          ->setCellValue('L'.$i, $num_dias);
        }
        else
        {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->titular)
          ->setCellValue('F'.$i, 'CSEIIO')
          ->setCellValue('G'.$i, $fila->dependencia)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->dependencia_remitente)
          ->setCellValue('K'.$i, $fila->observaciones)
          ->setCellValue('L'.$i, '0');
        }



      }

      $i++;
    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Pendientes');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_PENDIENTES:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;


  }


  public function reporteNoContestados() {


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

    $objDrawingGob->setCoordinates('J1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte del Total de Oficios No Contestados-Modalidad Salientes")
    ->setSubject("Reporte de Oficialia")
    ->setDescription("Reporte que contiene el total de oficios no contestados, Modalidad Salientes.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios no contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
    $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DEPENDENCIA DE DESTINO','OBSERVACIONES');

     $objPHPExcel->getActiveSheet(0)->mergeCells('A3:K3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:K4');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:K1');
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
    ->setCellValue('K6',  $titulosColumnas[10]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllNoContestadosSalidas($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_emision)
     ->setCellValue('C'.$i, $fila->hora_emision)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->titular)
     ->setCellValue('F'.$i, 'CSEIIO')
     ->setCellValue('G'.$i, $fila->dependencia)
     ->setCellValue('H'.$i, $fila->fecha_termino)
     ->setCellValue('I'.$i, $fila->status)
     ->setCellValue('J'.$i, $fila->dependencia_remitente)
     ->setCellValue('K'.$i, $fila->observaciones);

     $i++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios No Contestados');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_NO_CONTESTADOS:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;


 }

}

/* End of file Reportes.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Reportes.php */