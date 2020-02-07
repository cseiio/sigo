<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
    $this -> load -> model('Modelo_direccion');
    $this -> load -> model('Modelo_departamentos');
    $this -> load -> model('Modelo_recepcion');
  }

  public function index()
  {
    if ($this->session->userdata('nombre')) {

            //$data['inforecepcion'] = $this -> Modelo_recepcion-> getInfoDepartamento($this->session->userdata('id_area'));

     $data['titulo'] = 'Reportes';
     $data['dependencias'] = $this -> Modelo_recepcion-> getAllDependencias();
     $this->load->view('plantilla/header', $data);
     $this->load->view('recepcion/entradas/reportes');
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


function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
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

                                                            // REPORTES GENERALES
// TODOS LOS OFICIOS
            public function reporteAllOficiosExt() {


              $this->load->library('Excel');
              $objPHPExcel = new PHPExcel();

              date_default_timezone_set('America/Mexico_City');
              $time = time();
              $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

              $inicio = $this->input->post('date_inicio');
              $final = $this->input->post('date_final');
              $dependencia = $this->input->post('dependencia');

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

              $objDrawingGob->setCoordinates('R1');
              $objDrawingGob->setHeight(1000);
              $objDrawingGob->setWidth(306);
              $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

              $objPHPExcel->getProperties()->setCreator("CSEIIO")
              ->setLastModifiedBy("CSEIIO")
              ->setTitle("Reporte del Total de Oficios Recibidos-Modalidad Externa")
              ->setSubject("Reporte de Oficialia")
              ->setDescription("Reporte que contiene el total de oficios recibidos por la Unidad Central de Correspondencia, Modalidad Externa.")
              ->setKeywords("cseiio reporte oficios oficialia externos")
              ->setCategory("Reporte");

              $tituloReporte = "Reporte de oficios recibidos, comprendido del periodo:  ".$inicio."  al ".$final."";
              $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
              $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN FÍSICA', 'HORA DE RECEPCIÓN FÍSICA', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','N° OFICIO DE RESPUESTA','PERSONA QUE CONTESTO EL OFICIO','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA DEL OFICIO AL SISTEMA','HORA DE SUBIDA DEL OFICIO AL SISTEMA','VALOR','VIGENCIA','CLASIFICACIÓN','TIPO DE DOCUMENTO ARCHIVISTICO');
              //COMBINACIÓN DE CELDAS
              $objPHPExcel->getActiveSheet(0)->mergeCells('A3:V3');
              $objPHPExcel->getActiveSheet(0)->mergeCells('A4:V4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
              $objPHPExcel->setActiveSheetIndex(0)
              ->mergeCells('A1:V1');
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
    ->setCellValue('U6',  $titulosColumnas[20])
    ->setCellValue('V6',  $titulosColumnas[21]);

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
   $objPHPExcel->getActiveSheet()->getStyle('A6:V6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:V6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

    if ($dependencia == 'todas') {
      
    $oficios = $this->Modelo_reportes->getAllOficiosExternos($inicio, $final);

    $i = 7;
    $j = 7;

    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'V'.$i)->applyFromArray($style_contenido);

      if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') {

        $infor_contestados = $this->Modelo_reportes->getAllOficiosExternosByID($fila->id_recepcion);


        foreach ($infor_contestados  as $key) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $key->num_oficio)
          ->setCellValue('B'.$i, $key->fecha_recep_fisica)
          ->setCellValue('C'.$i, $key->hora_recep_fisica)
          ->setCellValue('D'.$i, $key->asunto)
          ->setCellValue('E'.$i, $key->emisor_externo)
          ->setCellValue('F'.$i, $key->dependencia_emite)
          ->setCellValue('G'.$i, $key->cargo_externo)
          ->setCellValue('H'.$i, $key->fecha_termino)
          ->setCellValue('I'.$i, $key->status)
          ->setCellValue('J'.$i, $key->nombre_direccion)
          ->setCellValue('K'.$i, $key->observaciones)
          ->setCellValue('L'.$i, $key->num_oficio_salida)
          ->setCellValue('M'.$i, $key->emisor)
          ->setCellValue('N'.$i, $key->codigo)
          ->setCellValue('O'.$i, $key->fecha_respuesta)
          ->setCellValue('P'.$i, $key->hora_respuesta)
          ->setCellValue('Q'.$i, $key->fecha_respuesta_fisica)
          ->setCellValue('R'.$i, $key->hora_respuesta_fisica)
          ->setCellValue('S'.$i, $key->valor_doc)
          ->setCellValue('T'.$i, $key->vigencia_doc)
          ->setCellValue('U'.$i, $key->clasificacion_info)
          ->setCellValue('V'.$i, $key->tipo_doc_archivistico);

          
        }

      }

      else {

       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $fila->num_oficio)
       ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
       ->setCellValue('C'.$i, $fila->hora_recep_fisica)
       ->setCellValue('D'.$i, $fila->asunto)
       ->setCellValue('E'.$i, $fila->emisor)
       ->setCellValue('F'.$i, $fila->dependencia_emite)
       ->setCellValue('G'.$i, $fila->cargo_externo)
       ->setCellValue('H'.$i, $fila->fecha_termino)
       ->setCellValue('I'.$i, $fila->status)
       ->setCellValue('J'.$i, $fila->nombre_direccion)
       ->setCellValue('K'.$i, $fila->observaciones)
      ->setCellValue('N'.$i, $fila->codigo_archivistico)
       ->setCellValue('Q'.$i, $fila->fecha_recepcion)
       ->setCellValue('R'.$i, $fila->hora_recepcion)
       ->setCellValue('S'.$i, $fila->valor_doc)
          ->setCellValue('T'.$i, $fila->vigencia_doc)
          ->setCellValue('U'.$i, $fila->clasificacion_info)
          ->setCellValue('V'.$i, $fila->tipo_doc_archivistico);

     }
     //Contador de celdas
     $i++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios Recibidos');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_RECIBIDOS:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;

   }
   else
   {

    $oficios = $this->Modelo_reportes->getAllOficiosExternosByDepedendencia($inicio, $final, $dependencia);

    $i = 7;
    $j = 7;

    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'V'.$i)->applyFromArray($style_contenido);

      if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') {

        $infor_contestados = $this->Modelo_reportes->getAllOficiosExternosByID($fila->id_recepcion);


        foreach ($infor_contestados  as $key) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $key->num_oficio)
          ->setCellValue('B'.$i, $key->fecha_recep_fisica)
          ->setCellValue('C'.$i, $key->hora_recep_fisica)
          ->setCellValue('D'.$i, $key->asunto)
          ->setCellValue('E'.$i, $key->emisor_externo)
          ->setCellValue('F'.$i, $key->dependencia_emite)
          ->setCellValue('G'.$i, $key->cargo_externo)
          ->setCellValue('H'.$i, $key->fecha_termino)
          ->setCellValue('I'.$i, $key->status)
          ->setCellValue('J'.$i, $key->nombre_direccion)
          ->setCellValue('K'.$i, $key->observaciones)
          ->setCellValue('L'.$i, $key->num_oficio_salida)
          ->setCellValue('M'.$i, $key->emisor)
          ->setCellValue('N'.$i, $key->codigo)
          ->setCellValue('O'.$i, $key->fecha_respuesta)
          ->setCellValue('P'.$i, $key->hora_respuesta)
          ->setCellValue('Q'.$i, $key->fecha_respuesta_fisica)
          ->setCellValue('R'.$i, $key->hora_respuesta_fisica)
          ->setCellValue('S'.$i, $key->valor_doc)
          ->setCellValue('T'.$i, $key->vigencia_doc)
          ->setCellValue('U'.$i, $key->clasificacion_info)
          ->setCellValue('V'.$i, $key->tipo_doc_archivistico);

          
        }

      }

      else {

       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $fila->num_oficio)
       ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
       ->setCellValue('C'.$i, $fila->hora_recep_fisica)
       ->setCellValue('D'.$i, $fila->asunto)
       ->setCellValue('E'.$i, $fila->emisor)
       ->setCellValue('F'.$i, $fila->dependencia_emite)
       ->setCellValue('G'.$i, $fila->cargo_externo)
       ->setCellValue('H'.$i, $fila->fecha_termino)
       ->setCellValue('I'.$i, $fila->status)
       ->setCellValue('J'.$i, $fila->nombre_direccion)
       ->setCellValue('K'.$i, $fila->observaciones)
       ->setCellValue('Q'.$i, $fila->fecha_recepcion)
       ->setCellValue('R'.$i, $fila->hora_recepcion)
       ->setCellValue('S'.$i, $fila->valor_doc)
       ->setCellValue('T'.$i, $fila->vigencia_doc)
        ->setCellValue('U'.$i, $fila->clasificacion_info)
       ->setCellValue('V'.$i, $fila->tipo_doc_archivistico);

     }
     //Contador de celdas
     $i++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios Recibidos');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_ENTRADA_RECIBIDOS:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;
   }

 }
    // OFICIOS CONTESTADOS
 public function reporteContestadoExt() {


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

  $objDrawingGob->setCoordinates('R1');
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
  $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA','HORA DE SUBIDA');
 //COMBINACIÓN DE CELDAS
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

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getOficiosContestados($inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);
     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_recepcion)
     ->setCellValue('S'.$i, $fila->hora_recepcion);

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
    //OFICIOS PENDIENTES
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
  ->setTitle("Reporte del Total de Oficios Pendientes-Modalidad Externa")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios pendientes por Oficialia de Partes, Modalidad Externa.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios pendientes, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN RESPONSABLE ','OBSERVACIONES','DÍAS RESTANTES PARA RESPUESTA');
//COMBINACIÓN DE CELDAS
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



    $oficios = $this->Modelo_reportes->getOficiosPendientes($inicio, $final);

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

        if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {


          if ($days != 0) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
            ->setCellValue('C'.$i, $fila->hora_recep_fisica)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->dependencia_emite)
            ->setCellValue('G'.$i, $fila->cargo)
            ->setCellValue('H'.$i, $fila->fecha_termino)
            ->setCellValue('I'.$i, $fila->status)
            ->setCellValue('J'.$i, $fila->nombre_direccion)
            ->setCellValue('K'.$i, $fila->observaciones)
            ->setCellValue('L'.$i, $days);

          }
          else
          {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
            ->setCellValue('C'.$i, $fila->hora_recep_fisica)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->dependencia_emite)
            ->setCellValue('G'.$i, $fila->cargo)
            ->setCellValue('H'.$i, $fila->fecha_termino)
            ->setCellValue('I'.$i, $fila->status)
            ->setCellValue('J'.$i, $fila->nombre_direccion)
            ->setCellValue('K'.$i, $fila->observaciones)
            ->setCellValue('L'.$i, '0');
          }
        }
        else
          if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {

            date_default_timezone_set('America/Mexico_City');
            $hoy = date('Y-m-d');

            $subida = $fila->fecha_recep_fisica ;
            $recepcion = $fila->fecha_recepcion;
            $diferencia = abs(strtotime($recepcion) - strtotime($subida));

            $years = floor($diferencia / (365*60*60*24));
            $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
            $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


            $date1 = $hoy;
            $date2 = $fila->fecha_termino;
            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $total_dias = $days-$dias_entre_fechas;

            if ($days != 0) {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, $total_dias);

            }
            else
            {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, '0');
            }

          }

        }
        else
          if ($fila->tipo_dias == 1) {

          // DIAS HÁBILES
          // Si el oficio viene configurado con días hábiles
          // entonces, llamar a la funcion  getDiasHabiles
          // si $dias_habiles = 0 
          // entonces imprimir : 0
            if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {
             date_default_timezone_set('America/Mexico_City');
             $dia_actual = date('Y-m-d');
             $date1 = $dia_actual;
             $date2 = $fila->fecha_termino;
             $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
             $num_dias = count($dias_habiles);

             if ($dias_habiles != 0) {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, $num_dias);
            }
            else
            {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, '0');
            }
          }
          else
            if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {

              date_default_timezone_set('America/Mexico_City');
              $hoy = date('Y-m-d');

              $subida = $fila->fecha_recep_fisica ;
              $recepcion = $fila->fecha_recepcion;
              $diferencia = abs(strtotime($recepcion) - strtotime($subida));

              $years = floor($diferencia / (365*60*60*24));
              $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
              $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

              date_default_timezone_set('America/Mexico_City');
              $dia_actual = date('Y-m-d');
              $date1 = $dia_actual;
              $date2 = $fila->fecha_termino;
              $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
              $num_dias = count($dias_habiles);

              if ($dias_habiles != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                ->setCellValue('D'.$i, $fila->asunto)
                ->setCellValue('E'.$i, $fila->emisor)
                ->setCellValue('F'.$i, $fila->dependencia_emite)
                ->setCellValue('G'.$i, $fila->cargo)
                ->setCellValue('H'.$i, $fila->fecha_termino)
                ->setCellValue('I'.$i, $fila->status)
                ->setCellValue('J'.$i, $fila->nombre_direccion)
                ->setCellValue('K'.$i, $fila->observaciones)
                ->setCellValue('L'.$i, $num_dias-$dias_entre_fechas);
              }
              else
              {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                ->setCellValue('D'.$i, $fila->asunto)
                ->setCellValue('E'.$i, $fila->emisor)
                ->setCellValue('F'.$i, $fila->dependencia_emite)
                ->setCellValue('G'.$i, $fila->cargo)
                ->setCellValue('H'.$i, $fila->fecha_termino)
                ->setCellValue('I'.$i, $fila->status)
                ->setCellValue('J'.$i, $fila->nombre_direccion)
                ->setCellValue('K'.$i, $fila->observaciones)
                ->setCellValue('L'.$i, '0');
              }
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

//REPORTES DE OFICIOS CONTESTADOS FUERA DE TIEMPO
      public function reporteContestadoFueraDeTiempo() {


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

        $objDrawingGob->setCoordinates('R1');
        $objDrawingGob->setHeight(1000);
        $objDrawingGob->setWidth(306);
        $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getProperties()->setCreator("CSEIIO")
        ->setLastModifiedBy("CSEIIO")
        ->setTitle("Reporte de oficios contestados fuera del rango de tiempo-Modalidad Externa")
        ->setSubject("Reporte de Oficialia")
        ->setDescription("Reporte que contiene el total de oficios contestados fuera de tiempo - Modalidad Externa.")
        ->setKeywords("cseiio reporte oficios oficialia externos")
        ->setCategory("Reporte");

        $tituloReporte = "Reporte de oficios fuera de tiempo, comprendido del periodo:  ".$inicio."  al ".$final."";
        $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
        $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA','HORA DE SUBIDA');

        //COMBINACIÓN DE CELDAS
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



    $oficios = $this->Modelo_reportes->getOficiosFueradeTiempo($inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_respuesta)
     ->setCellValue('S'.$i, $fila->hora_respuesta);

     $i++;
     $j++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios Fuera de Tiempo');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_FUERA_DE_TIEMPO:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;


 }

//REPORTES DE OFICIOS NO CONTESTADOS
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
  ->setTitle("Reporte del Total de Oficios No Contestados-Modalidad Externa")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios no contestados, Modalidad Externa.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios no contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES');

   //COMBINACIÓN DE CELDAS
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


    $oficios = $this->Modelo_reportes->getOficiosNoContestados($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('C'.$i, $fila->hora_recep_fisica)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->emisor)
     ->setCellValue('F'.$i, $fila->dependencia_emite)
     ->setCellValue('G'.$i, $fila->cargo)
     ->setCellValue('H'.$i, $fila->fecha_termino)
     ->setCellValue('I'.$i, $fila->status)
     ->setCellValue('J'.$i, $fila->nombre_direccion)
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
                       // REPORTES POR DIRECCIONES
 public function reporteAllPorDirecciones()
 {
   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_direccion = $this->input->post('direccion');

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

   $objDrawingGob->setCoordinates('Q1');
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

   $tituloReporte = "Reporte de oficios recibidos, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','N° OFICIO DE RESPUESTA','PERSONA QUE CONTESTO EL OFICIO','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA', 'HORA DE SUBIDA');

$objPHPExcel->getActiveSheet(0)->mergeCells('A3:R3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:R4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
   $objPHPExcel->setActiveSheetIndex(0)
   ->mergeCells('A1:R1');
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
    ->setCellValue('R6',  $titulosColumnas[17]);

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
   $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');


    $oficios = $this->Modelo_reportes->getAllOficiosDirecciones($id_direccion, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
       $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'R'.$i)->applyFromArray($style_contenido);

      if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') 
      {
       $infor_contestados = $this->Modelo_reportes->getOficiosContestadosDirbyID($fila->id_recepcion);


       foreach ($infor_contestados as $key) {

          $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $key->num_oficio)
         ->setCellValue('B'.$i, $key->fecha_recep_fisica)
         ->setCellValue('C'.$i, $key->hora_recep_fisica)
         ->setCellValue('D'.$i, $key->asunto)
         ->setCellValue('E'.$i, $key->emisor_externo)
         ->setCellValue('F'.$i, $key->dependencia_emite)
         ->setCellValue('G'.$i, $key->cargo_externo)
         ->setCellValue('H'.$i, $key->fecha_termino)
         ->setCellValue('I'.$i, $key->status)
         ->setCellValue('J'.$i, $key->nombre_direccion)
         ->setCellValue('K'.$i, $key->observaciones)
         ->setCellValue('L'.$i, $key->num_oficio_salida)
         ->setCellValue('M'.$i, $key->emisor)
         ->setCellValue('N'.$i, $key->ca)
         ->setCellValue('O'.$i, $key->fecha_respuesta_fisica)
         ->setCellValue('P'.$i, $key->hora_respuesta_fisica)
         ->setCellValue('Q'.$i, $key->fecha_recepcion)
         ->setCellValue('R'.$i, $key->hora_recepcion);

       }
     }
     else
     {
      $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $fila->num_oficio)
      ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
      ->setCellValue('C'.$i, $fila->hora_recep_fisica)
      ->setCellValue('D'.$i, $fila->asunto)
      ->setCellValue('E'.$i, $fila->emisor)
      ->setCellValue('F'.$i, $fila->dependencia_emite)
      ->setCellValue('G'.$i, $fila->cargo_externo)
      ->setCellValue('H'.$i, $fila->fecha_termino)
      ->setCellValue('I'.$i, $fila->status)
      ->setCellValue('J'.$i, $fila->nombre_direccion)
      ->setCellValue('K'.$i, $fila->observaciones)
       ->setCellValue('N'.$i, $fila->ca)
      ->setCellValue('Q'.$i, $fila->fecha_recepcion)
      ->setCellValue('R'.$i, $fila->hora_recepcion);
    }


    $i++;

  }

           // Se asigna el nombre a la hoja
  $objPHPExcel->getActiveSheet()->setTitle('Oficios Recibidos');

  $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Reporte_de_oficios_RECIBIDOS:'.$hoy.'.xlsx"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  exit;

}


    // REPORTE DE TODOS LOS OFICIOS CONTESTADOS POR UNA DIRECCION X
    // 
    // OFICIOS CONTESTADOS
public function reporteContestadosPorDirecciones() {


  $this->load->library('Excel');
  $objPHPExcel = new PHPExcel();

  date_default_timezone_set('America/Mexico_City');
  $time = time();
  $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

  $inicio = $this->input->post('date_inicio');
  $final = $this->input->post('date_final');
  $id_direccion = $this->input->post('direccion');

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

  $objDrawingGob->setCoordinates('R1');
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
  $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA','HORA DE SUBIDA');

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


    $oficios = $this->Modelo_reportes->getOficiosContestadosDir($id_direccion,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_recepcion)
     ->setCellValue('S'.$i, $fila->hora_recepcion);

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

    //OFICIOS NO CONTESTADOS
    //

 public function reporteNoContestadosDir() {


  $this->load->library('Excel');
  $objPHPExcel = new PHPExcel();

  date_default_timezone_set('America/Mexico_City');
  $time = time();
  $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

  $inicio = $this->input->post('date_inicio');
  $final = $this->input->post('date_final');
  $id_direccion = $this->input->post('direccion');

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
  ->setTitle("Reporte del Total de Oficios No Contestados-Modalidad Externa")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios no contestados, Modalidad Externa.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios no contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES');

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

    $oficios = $this->Modelo_reportes->getOficiosNoContestadosDir($id_direccion, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('C'.$i, $fila->hora_recep_fisica)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->emisor)
     ->setCellValue('F'.$i, $fila->dependencia_emite)
     ->setCellValue('G'.$i, $fila->cargo)
     ->setCellValue('H'.$i, $fila->fecha_termino)
     ->setCellValue('I'.$i, $fila->status)
     ->setCellValue('J'.$i, $fila->nombre_direccion)
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

    //Oficios pendientes por responder de direcciones
    //
 public function reportePendientesDir() {


  $this->load->library('Excel');
  $objPHPExcel = new PHPExcel();

  date_default_timezone_set('America/Mexico_City');
  $time = time();
  $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

  $inicio = $this->input->post('date_inicio');
  $final = $this->input->post('date_final');
  $id_direccion = $this->input->post('direccion');

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
  ->setTitle("Reporte del Total de Oficios Pendientes-Modalidad Externa")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios pendientes por Oficialia de Partes, Modalidad Externa.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios pendientes, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','DÍAS RESTANTES');

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


        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getOficiosPendientesDir( $id_direccion, $inicio, $final);

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

        if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {

          if ($days != 0) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
            ->setCellValue('C'.$i, $fila->hora_recep_fisica)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->dependencia_emite)
            ->setCellValue('G'.$i, $fila->cargo)
            ->setCellValue('H'.$i, $fila->fecha_termino)
            ->setCellValue('I'.$i, $fila->status)
            ->setCellValue('J'.$i, $fila->nombre_direccion)
            ->setCellValue('K'.$i, $fila->observaciones)
            ->setCellValue('L'.$i, $days);

          }
          else
          {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
            ->setCellValue('C'.$i, $fila->hora_recep_fisica)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->dependencia_emite)
            ->setCellValue('G'.$i, $fila->cargo)
            ->setCellValue('H'.$i, $fila->fecha_termino)
            ->setCellValue('I'.$i, $fila->status)
            ->setCellValue('J'.$i, $fila->nombre_direccion)
            ->setCellValue('K'.$i, $fila->observaciones)
            ->setCellValue('L'.$i, '0');
          }
        }
        else
          if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {
            date_default_timezone_set('America/Mexico_City');
            $hoy = date('Y-m-d');

            $subida = $fila->fecha_recep_fisica ;
            $recepcion = $fila->fecha_recepcion;
            $diferencia = abs(strtotime($recepcion) - strtotime($subida));

            $years = floor($diferencia / (365*60*60*24));
            $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
            $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


            $date1 = $hoy;
            $date2 = $fila->fecha_termino;
            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $total_dias = $days-$dias_entre_fechas;

            if ($days != 0) {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, $total_dias);

            }
            else
            {
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $fila->num_oficio)
              ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
              ->setCellValue('C'.$i, $fila->hora_recep_fisica)
              ->setCellValue('D'.$i, $fila->asunto)
              ->setCellValue('E'.$i, $fila->emisor)
              ->setCellValue('F'.$i, $fila->dependencia_emite)
              ->setCellValue('G'.$i, $fila->cargo)
              ->setCellValue('H'.$i, $fila->fecha_termino)
              ->setCellValue('I'.$i, $fila->status)
              ->setCellValue('J'.$i, $fila->nombre_direccion)
              ->setCellValue('K'.$i, $fila->observaciones)
              ->setCellValue('L'.$i, '0');
            }

          }

        }
        else
          if($fila->tipo_dias == 1)
          {

          // DIAS HÁBILES
          // Si el oficio viene configurado con días hábiles
          // entonces, llamar a la funcion  getDiasHabiles
          // si $dias_habiles = 0 
          // entonces imprimir : 0
            if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {
              date_default_timezone_set('America/Mexico_City');
              $dia_actual = date('Y-m-d');
              $date1 = $dia_actual;
              $date2 = $fila->fecha_termino;
              $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
              $num_dias = count($dias_habiles);

              if ($dias_habiles != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                ->setCellValue('D'.$i, $fila->asunto)
                ->setCellValue('E'.$i, $fila->emisor)
                ->setCellValue('F'.$i, $fila->dependencia_emite)
                ->setCellValue('G'.$i, $fila->cargo)
                ->setCellValue('H'.$i, $fila->fecha_termino)
                ->setCellValue('I'.$i, $fila->status)
                ->setCellValue('J'.$i, $fila->nombre_direccion)
                ->setCellValue('K'.$i, $fila->observaciones)
                ->setCellValue('L'.$i, $num_dias);
              }
              else
              {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $fila->num_oficio)
                ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                ->setCellValue('D'.$i, $fila->asunto)
                ->setCellValue('E'.$i, $fila->emisor)
                ->setCellValue('F'.$i, $fila->dependencia_emite)
                ->setCellValue('G'.$i, $fila->cargo)
                ->setCellValue('H'.$i, $fila->fecha_termino)
                ->setCellValue('I'.$i, $fila->status)
                ->setCellValue('J'.$i, $fila->nombre_direccion)
                ->setCellValue('K'.$i, $fila->observaciones)
                ->setCellValue('L'.$i, '0');
              }
            }
            else
              if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {
                date_default_timezone_set('America/Mexico_City');
                $hoy = date('Y-m-d');

                $subida = $fila->fecha_recep_fisica ;
                $recepcion = $fila->fecha_recepcion;
                $diferencia = abs(strtotime($recepcion) - strtotime($subida));

                $years = floor($diferencia / (365*60*60*24));
                $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
                $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                date_default_timezone_set('America/Mexico_City');
                $dia_actual = date('Y-m-d');
                $date1 = $dia_actual;
                $date2 = $fila->fecha_termino;
                $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
                $num_dias = count($dias_habiles);

                if ($dias_habiles != 0) {
                  $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$i, $fila->num_oficio)
                  ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                  ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                  ->setCellValue('D'.$i, $fila->asunto)
                  ->setCellValue('E'.$i, $fila->emisor)
                  ->setCellValue('F'.$i, $fila->dependencia_emite)
                  ->setCellValue('G'.$i, $fila->cargo)
                  ->setCellValue('H'.$i, $fila->fecha_termino)
                  ->setCellValue('I'.$i, $fila->status)
                  ->setCellValue('J'.$i, $fila->nombre_direccion)
                  ->setCellValue('K'.$i, $fila->observaciones)
                  ->setCellValue('L'.$i, $num_dias-$dias_entre_fechas);
                }
                else
                {
                  $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$i, $fila->num_oficio)
                  ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
                  ->setCellValue('C'.$i, $fila->hora_recep_fisica)
                  ->setCellValue('D'.$i, $fila->asunto)
                  ->setCellValue('E'.$i, $fila->emisor)
                  ->setCellValue('F'.$i, $fila->dependencia_emite)
                  ->setCellValue('G'.$i, $fila->cargo)
                  ->setCellValue('H'.$i, $fila->fecha_termino)
                  ->setCellValue('I'.$i, $fila->status)
                  ->setCellValue('J'.$i, $fila->nombre_direccion)
                  ->setCellValue('K'.$i, $fila->observaciones)
                  ->setCellValue('L'.$i, '0');
                }
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

        public function reporteContestadoFueraDeTiempoDir() {


          $this->load->library('Excel');
          $objPHPExcel = new PHPExcel();

          date_default_timezone_set('America/Mexico_City');
          $time = time();
          $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

          $inicio = $this->input->post('date_inicio');
          $final = $this->input->post('date_final');
          $id_direccion = $this->input->post('direccion');

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

          $objDrawingGob->setCoordinates('R1');
          $objDrawingGob->setHeight(1000);
          $objDrawingGob->setWidth(306);
          $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

          $objPHPExcel->getProperties()->setCreator("CSEIIO")
          ->setLastModifiedBy("CSEIIO")
          ->setTitle("Reporte de oficios contestados fuera de tiempo-Modalidad Externa")
          ->setSubject("Reporte de Oficialia")
          ->setDescription("Reporte que contiene el total de oficios contestados fuera de tiempo - Modalidad Externa.")
          ->setKeywords("cseiio reporte oficios oficialia externos")
          ->setCategory("Reporte");

          $tituloReporte = "Reporte de oficios contestados fuera de tiempo, comprendido del periodo:  ".$inicio."  al ".$final."";
          $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
          $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA','HORA DE SUBIDA');

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

    $oficios = $this->Modelo_reportes->getOficiosFueradeTiempoDir($id_direccion,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_recepcion)
     ->setCellValue('S'.$i, $fila->hora_recepcion);

     $i++;
     $j++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios Fuera de Tiempo');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_FUERADETIEMPO:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;


 }

                                            // REPORTES DE DEPARTAMENTOS 
// Funcion para llenar el combo de departamentos 
 public function llenarCombo()
 {
  $options="";
  if ($_POST["dir"]== 1) 
  {
   $deptos = $this->Modelo_reportes->getDeptosByIdDireccion(1);

   foreach ($deptos as $row){
     $options= '
     <option value='.$row->id_area.'>'.$row->nombre_area.'</option>
     ';    
     echo $options; 
   }
 }
 if ($_POST["dir"]==2) {
  $deptos = $this->Modelo_reportes->getDeptosByIdDireccion(2);

  foreach ($deptos as $row){
   $options= '
   <option value='.$row->id_area.'>'.$row->nombre_area.'</option>
   ';    
   echo $options;  
 }
}

if ($_POST["dir"]==3) {
  $deptos = $this->Modelo_reportes->getDeptosByIdDireccion(3);

  foreach ($deptos as $row){
   $options= '
   <option value='.$row->id_area.'>'.$row->nombre_area.'</option>
   ';   
   echo $options;   
 }
}


if ($_POST["dir"]==4) {
  $deptos = $this->Modelo_reportes->getDeptosByIdDireccion(4);

  foreach ($deptos as $row){
   $options= '
   <option value='.$row->id_area.'>'.$row->nombre_area.'</option>
   ';   
   echo $options;   
 }   
}


if ($_POST["dir"]==7) {
 $deptos = $this->Modelo_reportes->getDeptosByIdDireccion(7);

 foreach ($deptos as $row){
   $options= '
   <option value='.$row->id_area.'>'.$row->nombre_area.'</option>
   ';   
   echo $options;   
 }  
}


}


// TODOS LOS OFICIOS RESPONDIDOS POR EL DEPARTAMENTO SELECCIONADO

public function reporteAllPorDepartamento()
{
 $this->load->library('Excel');
 $objPHPExcel = new PHPExcel();

 date_default_timezone_set('America/Mexico_City');
 $time = time();
 $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

 $inicio = $this->input->post('date_inicio');
 $final = $this->input->post('date_final');
 $id_direccion = $this->input->post('direccion');
 $id_depto = $this->input->post('departamentos_cmb');

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

 $objDrawingGob->setCoordinates('Q1');
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

 $tituloReporte = "Reporte de oficios recibidos, comprendido del periodo:  ".$inicio."  al ".$final."";
 $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
 $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DEPARTAMENTO DE DESTINO','OBSERVACIONES','N° OFICIO DE RESPUESTA','PERSONA QUE CONTESTO EL OFICIO','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA', 'HORA DE SUBIDA');

$objPHPExcel->getActiveSheet(0)->mergeCells('A3:R3');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A4:R4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
 $objPHPExcel->setActiveSheetIndex(0)
 ->mergeCells('A1:R1');
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
    ->setCellValue('R6',  $titulosColumnas[17]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');


    $oficios = $this->Modelo_reportes->getAllOficiosDeptos($id_depto, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'R'.$i)->applyFromArray($style_contenido);

     if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') {

      $infor_contestados = $this->Modelo_reportes->getOficiosContestadosDeptoByID($fila->id_recepcion);

      foreach ($infor_contestados as $key) {
       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $key->num_oficio)
       ->setCellValue('B'.$i, $key->fecha_recep_fisica)
       ->setCellValue('C'.$i, $key->hora_recep_fisica)
       ->setCellValue('D'.$i, $key->asunto)
       ->setCellValue('E'.$i, $key->emisor_externo)
       ->setCellValue('F'.$i, $key->dependencia_emite)
       ->setCellValue('G'.$i, $key->cargo_externo)
       ->setCellValue('H'.$i, $key->fecha_termino)
       ->setCellValue('I'.$i, $key->status)
       ->setCellValue('J'.$i, $key->nombre_area)
       ->setCellValue('K'.$i, $key->observaciones)
       ->setCellValue('L'.$i, $key->num_oficio_salida)
       ->setCellValue('M'.$i, $key->emisor)
       ->setCellValue('N'.$i, $key->codigo)
       ->setCellValue('O'.$i, $key->fecha_respuesta_fisica)
       ->setCellValue('P'.$i, $key->hora_respuesta_fisica)
       ->setCellValue('Q'.$i, $key->fecha_recepcion)
       ->setCellValue('R'.$i, $key->hora_recepcion);
     }

   }
   else
   {
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, $fila->num_oficio)
    ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
    ->setCellValue('C'.$i, $fila->hora_recep_fisica)
    ->setCellValue('D'.$i, $fila->asunto)
    ->setCellValue('E'.$i, $fila->emisor)
    ->setCellValue('F'.$i, $fila->dependencia_emite)
    ->setCellValue('G'.$i, $fila->cargo)
    ->setCellValue('H'.$i, $fila->fecha_termino)
    ->setCellValue('I'.$i, $fila->status)
    ->setCellValue('J'.$i, $fila->nombre_area)
    ->setCellValue('K'.$i, $fila->observaciones)
    ->setCellValue('N'.$i, $fila->ca)
    ->setCellValue('Q'.$i, $fila->fecha_recepcion)
    ->setCellValue('R'.$i, $fila->hora_recepcion);
  }



  $i++;

}

 // Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Oficios Recibidos');

$objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_de_oficios_RECIBIDOS:'.$hoy.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

}

public function reporteContestadosPorDepartamento()
{
 $this->load->library('Excel');
 $objPHPExcel = new PHPExcel();

 date_default_timezone_set('America/Mexico_City');
 $time = time();
 $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

 $inicio = $this->input->post('date_inicio');
 $final = $this->input->post('date_final');
 $id_direccion = $this->input->post('direccion');
 $id_depto = $this->input->post('departamentos_cmb1');

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

 $objDrawingGob->setCoordinates('P1');
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
 $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA', 'HORA DE SUBIDA');

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

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getOficiosContestadosDepto($id_depto,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_recepcion)
     ->setCellValue('S'.$i, $fila->hora_recepcion);

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

 public function reporteNoContestadosDepto() {


   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_direccion = $this->input->post('direccion');
   $id_depto = $this->input->post('departamentos_cmb2');

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
   ->setTitle("Reporte del Total de Oficios No Contestados-Modalidad Externa")
   ->setSubject("Reporte de Oficialia")
   ->setDescription("Reporte que contiene el total de oficios no contestados, Modalidad Externa.")
   ->setKeywords("cseiio reporte oficios oficialia externos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios no contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DEPARTAMENTO','OBSERVACIONES');

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

    $oficios = $this->Modelo_reportes->getOficiosNoContestadosDepto($id_depto, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'K'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('C'.$i, $fila->hora_recep_fisica)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->emisor)
     ->setCellValue('F'.$i, $fila->dependencia_emite)
     ->setCellValue('G'.$i, $fila->cargo)
     ->setCellValue('H'.$i, $fila->fecha_termino)
     ->setCellValue('I'.$i, $fila->status)
     ->setCellValue('J'.$i, $fila->nombre_area)
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


 public function reportePendientesDepto() {


   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_direccion = $this->input->post('direccion');
   $id_depto = $this->input->post('departamentos_cmb3');

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
   ->setTitle("Reporte del Total de Oficios Pendientes-Modalidad Externa")
   ->setSubject("Reporte de Oficialia")
   ->setDescription("Reporte que contiene el total de oficios pendientes, Modalidad Externa.")
   ->setKeywords("cseiio reporte oficios oficialia externos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios pendientes, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DEPARTAMENTO','OBSERVACIONES','DÍAS RESTANTES');

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

    $oficios = $this->Modelo_reportes->getOficiosPendientesDepto($id_depto, $inicio, $final);

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

       if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {

         if ($days != 0) {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, $days);
         }
         else
         {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, '0');
         }
       }
       else
        if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {

          date_default_timezone_set('America/Mexico_City');
          $hoy = date('Y-m-d');

          $subida = $fila->fecha_recep_fisica ;
          $recepcion = $fila->fecha_recepcion;
          $diferencia = abs(strtotime($recepcion) - strtotime($subida));

          $years = floor($diferencia / (365*60*60*24));
          $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
          $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


          $date1 = $hoy;
          $date2 = $fila->fecha_termino;
          $diff = abs(strtotime($date2) - strtotime($date1));

          $years = floor($diff / (365*60*60*24));
          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
          $total_dias = $days-$dias_entre_fechas;

          if ($days != 0) {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, $total_dias);
         }
         else
         {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, '0');
         }

       }

     }
     else
      if ($fila->tipo_dias == 1) {
                      // DIAS HÁBILES
          // Si el oficio viene configurado con días hábiles
          // entonces, llamar a la funcion  getDiasHabiles
          // si $dias_habiles = 0 
          // entonces imprimir : 0
        if ($fila->fecha_recepcion == $fila->fecha_recep_fisica) {
          date_default_timezone_set('America/Mexico_City');
          $dia_actual = date('Y-m-d');
          $date1 = $dia_actual;
          $date2 = $fila->fecha_termino;
          $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
          $num_dias = count($dias_habiles);

          if ($dias_habiles != 0) {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->hora_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, $num_dias);
         }
         else
         {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->hora_recep_fisica)
          ->setCellValue('C'.$i, $fila->hora_recep_fisica)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->emisor)
          ->setCellValue('F'.$i, $fila->dependencia_emite)
          ->setCellValue('G'.$i, $fila->cargo)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->nombre_area)
          ->setCellValue('K'.$i, $fila->obgenerales)
          ->setCellValue('L'.$i, '0');
        }
      }
      else
        if ($fila->fecha_recep_fisica < $fila->fecha_recepcion) {

          date_default_timezone_set('America/Mexico_City');
          $hoy = date('Y-m-d');

          $subida = $fila->fecha_recep_fisica ;
          $recepcion = $fila->fecha_recepcion;
          $diferencia = abs(strtotime($recepcion) - strtotime($subida));

          $years = floor($diferencia / (365*60*60*24));
          $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
          //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
          $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

          date_default_timezone_set('America/Mexico_City');
          $dia_actual = date('Y-m-d');
          $date1 = $dia_actual;
          $date2 = $fila->fecha_termino;
          $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
          $num_dias = count($dias_habiles);


          if ($dias_habiles != 0) {
           $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$i, $fila->num_oficio)
           ->setCellValue('B'.$i, $fila->hora_recep_fisica)
           ->setCellValue('C'.$i, $fila->hora_recep_fisica)
           ->setCellValue('D'.$i, $fila->asunto)
           ->setCellValue('E'.$i, $fila->emisor)
           ->setCellValue('F'.$i, $fila->dependencia_emite)
           ->setCellValue('G'.$i, $fila->cargo)
           ->setCellValue('H'.$i, $fila->fecha_termino)
           ->setCellValue('I'.$i, $fila->status)
           ->setCellValue('J'.$i, $fila->nombre_area)
           ->setCellValue('K'.$i, $fila->obgenerales)
           ->setCellValue('L'.$i, $num_dias-$dias_entre_fechas);
         }
         else
         {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->hora_recep_fisica)
          ->setCellValue('C'.$i, $fila->hora_recep_fisica)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->emisor)
          ->setCellValue('F'.$i, $fila->dependencia_emite)
          ->setCellValue('G'.$i, $fila->cargo)
          ->setCellValue('H'.$i, $fila->fecha_termino)
          ->setCellValue('I'.$i, $fila->status)
          ->setCellValue('J'.$i, $fila->nombre_area)
          ->setCellValue('K'.$i, $fila->obgenerales)
          ->setCellValue('L'.$i, '0');
        }
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


public function reporteContestadosFueraDepartamento()
{
 $this->load->library('Excel');
 $objPHPExcel = new PHPExcel();

 date_default_timezone_set('America/Mexico_City');
 $time = time();
 $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

 $inicio = $this->input->post('date_inicio');
 $final = $this->input->post('date_final');
 $id_direccion = $this->input->post('direccion');
 $id_depto = $this->input->post('departamentos_cmb4');

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

 $objDrawingGob->setCoordinates('P1');
 $objDrawingGob->setHeight(1000);
 $objDrawingGob->setWidth(306);
 $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

 $objPHPExcel->getProperties()->setCreator("CSEIIO")
 ->setLastModifiedBy("CSEIIO")
 ->setTitle("Reporte de oficios contestados fuera de tiempo-Modalidad Externa")
 ->setSubject("Reporte de Oficialia")
 ->setDescription("Reporte que contiene el total de oficios contestados fuera de tiempo- Modalidad Externa.")
 ->setKeywords("cseiio reporte oficios oficialia externos")
 ->setCategory("Reporte");

 $tituloReporte = "Reporte de oficios contestados fuera de tiempo, comprendido del periodo:  ".$inicio."  al ".$final."";
 $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
 $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA','FECHA DE SUBIDA', 'HORA DE SUBIDA');

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

    $oficios = $this->Modelo_reportes->getOficiosContestadosFuera($id_depto,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'S'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisor_externo)
     ->setCellValue('G'.$i, $fila->dependencia_externo)
     ->setCellValue('H'.$i, $fila->cargo_externo)
     ->setCellValue('I'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('J'.$i, $fila->hora_recep_fisica)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_salida)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->fecha_respuesta_fisica)
     ->setCellValue('Q'.$i, $fila->hora_respuesta_fisica)
     ->setCellValue('R'.$i, $fila->fecha_recepcion)
     ->setCellValue('S'.$i, $fila->hora_recepcion);


     $i++;
     $j++;

   }

           // Se asigna el nombre a la hoja
   $objPHPExcel->getActiveSheet()->setTitle('Oficios Fuera de Tiempo');

   $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Reporte_de_oficios_FUERADETIEMPO:'.$hoy.'.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   $objWriter->save('php://output');
   exit;

 }

 //OFICIOS INFORMATIVOS
 public function reporteInformativosExternos() {


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

  $objDrawingGob->setCoordinates('L1');
  $objDrawingGob->setHeight(1000);
  $objDrawingGob->setWidth(306);
  $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

  $objPHPExcel->getProperties()->setCreator("CSEIIO")
  ->setLastModifiedBy("CSEIIO")
  ->setTitle("Reporte del Total de Oficios Informativos-Modalidad Externa")
  ->setSubject("Reporte de Oficialia")
  ->setDescription("Reporte que contiene el total de oficios informativos capturados por la Unidad Central de Correspondencia, Modalidad Externa.")
  ->setKeywords("cseiio reporte oficios oficialia externos")
  ->setCategory("Reporte");

  $tituloReporte = "Reporte de oficios informativos, comprendido del periodo:  ".$inicio."  al ".$final."";
  $tituloCseiio = "Colegio Superior para la Educación Integral Intercultural de Oaxaca";
  $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE RECEPCIÓN', 'HORA DE RECEPCIÓN', 'ASUNTO', 'EMISOR', 'DEPENDENCIA','CARGO','TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','FECHA DE SUBIDA','HORA DE SUBIDA');

  $objPHPExcel->getActiveSheet(0)->mergeCells('A3:M3');
  $objPHPExcel->getActiveSheet(0)->mergeCells('A4:M4');
        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('A1:R1');
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
    ->setCellValue('M6',  $titulosColumnas[12]);


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
   $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($styleA6R6);

    $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');
    $oficios = $this->Modelo_reportes->getAllOficiosInformativos($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'M'.$i)->applyFromArray($style_contenido);

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_recep_fisica)
     ->setCellValue('C'.$i, $fila->hora_recep_fisica)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->emisor)
     ->setCellValue('F'.$i, $fila->dependencia_emite)
     ->setCellValue('G'.$i, $fila->cargo)
     ->setCellValue('H'.$i, $fila->fecha_termino)
     ->setCellValue('I'.$i, $fila->status)
     ->setCellValue('J'.$i, $fila->nombre_direccion)
     ->setCellValue('K'.$i, $fila->observaciones)
     ->setCellValue('L'.$i, $fila->fecha_recepcion)
     ->setCellValue('M'.$i, $fila->hora_recepcion);

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


}

/* End of file Reportes.php */
/* Location: ./application/controllers/Reportes.php */