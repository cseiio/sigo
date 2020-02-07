   <?php 

   function bussiness_days($begin_date, $end_date, $type = 'array') {
    $date_1 = date_create($begin_date);
    $date_2 = date_create($end_date);
    if ($date_1 > $date_2) return FALSE;
    $bussiness_days = array();
    while ($date_1 <= $date_2) {
        $day_week = $date_1->format('w');
        if ($day_week > 0 && $day_week < 6) {
            $bussiness_days[$date_1->format('Y-m')][] = $date_1->format('d');
        }
        date_add($date_1, date_interval_create_from_date_string('1 day'));
    }
    if (strtolower($type) === 'sum') {
        array_map(function($k) use(&$bussiness_days) {
            $bussiness_days[$k] = count($bussiness_days[$k]);
        }, array_keys($bussiness_days));
    }
    return $bussiness_days;
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


        ?>


        <div id="wrapper">
                        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="container-fluid">
            <div class="col-lg-12" style="background-image: url('<?php echo base_url(); ?>/assets/img/banner.png'); background-color: #F9F9F9; text-align: center;">
                <div style="float: left;"> 
                    <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/appletouch-sigo-blue.png">
                </div>
                <div style="display: inline-block;"> 
                    <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/appletouch200xauto-oaxsigo.png">
                </div>
                <div style="float: right;">                     
                    <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/apple-touch-icon-76x76.png">                
                </div>
            </div>
            <!-- Top Menu Items -->
            <div class="col-lg-12" style="background-color: #F9F9F9; text-align: center; ">

                <div style="float: right;">
                    <ul  text-align: center;" class="nav navbar-right top-nav">
                        <li class="dropdown">
                            <a style="color: #FC8A62;" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nombre'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo base_url() ?>Login/salir"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul style="font-size: small;" class="nav navbar-nav">
                   <li >
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/PanelPlanteles"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles"><i class="fa fa-plus"></i> Oficios de Salida</a>
                    </li>


                    <li class="active">
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/TurnadoCopiasDependencias"><i class="fa fa-plus"></i> Copias Turnadas a Dependencias</a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Respuesta_salidas"><i class="fa fa-book"></i> Respuestas a Oficios de Salida</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Reportes"><i class="fa fa-book"></i> Reportes</a>
                    </li>
                    <li>
                <a target="_blank" href="http://cseiio.edu.mx/sigo/manuales/manual_de_operacion_sigo_planteles.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</div>
</nav>


        <div id="page-wrapper">
            <br><br><br><br>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       <h2 class="page-header">
                        <?php echo $this->session->userdata('nombre_direccion'); ?>  <small>Oficios Informativos</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Módulo de oficios informativos
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                    <div class="table-responsive">
                      <table id="tabla" class="table table-bordered table-hover table-responsive">
                        <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                            <tr>
                                <th>Folio</th>
                                <th>Número de Oficio</th>
                                <th>Asunto</th>
                                <th>Tipo de Emisión</th>
                                <th>Emisor del oficio</th>
                           
                                <th>Cargo</th>
                                <th>Remitente</th>
                                <th>Cargo del Remitente</th>
                                <th>Dependencia del Remitente</th>
                                <th>Código Archivistico</th>
                                <th>Archivo</th>
                            </tr>
                        </thead >
                        <tbody style="font-size:smaller; font-weight: bold ;">
                            <?php foreach ($informativos as $row) { 
                                ?>
                                <tr>
                                    <td><?php echo $row->id_oficio_salida; ?></td>
                                    <td><?php echo $row->num_oficio; ?></td>
                                    <td><?php echo $row->asunto; ?></td>
                                    <td><?php echo $row->tipo_emision; ?></td>
                                    <td><?php echo $row->emisor; ?></td>
                          
                                    <td><?php echo $row->cargo; ?></td>
                                    <td><?php echo $row->remitente; ?></td>
                                    <td><?php echo $row->cargo_remitente; ?></td>
                                    <td><?php echo $row->dependencia_remitente; ?></td>
                                    <td><?php echo $row->codigo; ?></td>
                                    <td>
                                        <a href="<?php echo base_url()?>RecepcionGral/Entradas/OficiosInformativos/Descargar/<?php echo $row->archivo; ?>">
                                         <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                                     </a>
                                 </td>    
                             </tr>
                             <?php } ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
     </div>
     <!-- /#page-wrapper -->
 </div>
<!-- /#wrapper -->