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

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>Admin/PanelAdmin/">SGOCSEIIO</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
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
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/PanelAdmin/"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/PanelOfExternos"><i class="fa fa-plus"></i> Oficios Externos</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Pendientes"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li >
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/FueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li >
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/NoContestados"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>
                    
                    <li class="active">
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Informativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Reportes"><i class="fa fa-book"></i> Reportes</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $this->session->userdata('descripcion'); ?>  <small>Oficios Informativos</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Oficios Informativos
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                    <div class="table-responsive">
                      <table id="tabla" class="table table-bordered table-hover table-responsive">
                        <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; text-aling:center;">
                            <tr>
                                <th>Folio</th>
                                <th>Número de Oficio</th>
                                <th>Asunto</th>
                                <th>Tipo de Recepción</th>
                                <th>Funcionario que emite</th>
                                <th>Cargo</th>
                                <th>Dependencia</th>
                                <th>Dirección de Destino</th>
                                <th>Archivo del emisor</th>
                            </tr>
                        </thead >
                        <tbody style="font-size:smaller; font-weight: bold ;">
                            <?php foreach ($informativos as $row) { 
                                ?>
                                <tr>
                                    <td><?php echo $row->id_recepcion; ?></td>
                                    <td><?php echo $row->num_oficio; ?></td>
                                    <td><?php echo $row->asunto; ?></td>
                                    <td><?php echo $row->tipo_recepcion; ?></td>
                                    <td><?php echo $row->emisor; ?></td>
                                    <td><?php echo $row->cargo; ?></td>
                                    <td><?php echo $row->dependencia_emite; ?></td>
                                    <td><?php echo $row->nombre_direccion; ?></td>
                                    <td>
                                        <a href="<?php echo base_url()?>RecepcionGral/Entradas/OficiosInformativos/Descargar/<?php echo $row->archivo_oficio; ?>">
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