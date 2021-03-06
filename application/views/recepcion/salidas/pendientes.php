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
                            <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
                        </li>
                        <li >
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas"><i class="fa fa-plus"></i> Oficios de Salida</a>
                        </li>

                        <li class="active">
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Pendientes"><i class="fa fa-check-circle"></i> Pendientes</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/ContestadosFueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                        </li>

                         <li >
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/NoContestados"><i class="fa fa-check-circle"></i> No Contestados</a>
                        </li>

                        <li  >
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                        </li>

                          <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Dependencias"><i class="fa fa-building"></i> Dependencias</a>
                        </li>
                       
                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Reportes"><i class="fa fa-book"></i> Reportes</a>
                        </li>

                        <li>
                            <a target="_blank" href="http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_unidad_central.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
                        </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>


            <div id="page-wrapper">

                <div class="container-fluid">
                    <br><br><br><br><br><br>
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                                <?php echo $this->session->userdata('descripcion'); ?>  <small>Oficios Pendientes por Responder</small>
                            </h2>
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-dashboard"></i> Módulo de oficios pendientes
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->

                    <!-- /.row -->
                    <div class="row">
                        <?php

                        $exito = $this->session->flashdata('exito');
                        $error = $this->session->flashdata('error');
                        $actualizado = $this->session->flashdata('actualizado');
                        $error_actualizacion = $this->session->flashdata('error_actualizacion');
                        $errornoarchivo = $this->session->flashdata('errorarchivo');

                        if($exito) { ?>

                        <div class="alert alert-success alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Éxito!</strong> <?php echo $exito;  ?>
                        </div>

                        <?php } 
                        if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo validation_errors();  ?>
                        </div>
                        <?php }
                        if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $error; ?>
                        </div>
                        <?php } 
                        if ($actualizado) { ?>
                        <div class="alert alert-success alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Éxito!</strong> <?php echo $actualizado; ?>
                        </div>
                        <?php } 
                        if ($errornoarchivo) { 
                            ?>  <!-- Seccion de errores -->
                            <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $errornoarchivo; ?>
                            </div>
                            <?php } 
                            if ($error_actualizacion) {     
                             ?>

                             <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $error_actualizacion; ?>
                            </div>

                            <?php  } ?>
                        </div>

                        <div align="left" class="row">
                         <div class="col-lg-12">
                            <h4>Simbología de estatus</h4>
                            <span class="label label-success">Oficio Contestado</span>
                            <span style="background-color: #FFEA3C;" class="label label-warning">Oficio Pendiente por Responder</span>
                            <span style="background-color: #FF9752;" class="label label-danger">Oficio Contestado Fuera de Tiempo</span>
                            <span class="label label-danger">Oficio No Contestado</span>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="table-responsive">
                          <table id="tabla" class="table table-bordered table-hover table-responsive">
                            <thead style="background-color:#B2B2B2; color:#FFFFFF; font-size: smaller; text-aling:center;">
                                <tr>
                                    <th>Folio</th>
                                    <th>Número de Oficio</th>
                                    <th>Asunto</th>
                                    <th>Tipo de Recepción</th>
                                    <th>Funcionario que emite</th>
                                    <th>Cargo</th>
                                    <th>Dependencia</th>
                                    <th>Dependencia Destino</th>
                                    <th>Fecha de Termino</th>
                                    <th>Archivo del emisor</th>
                                    <th>Estatus</th>
                                    <th>Días Restantes</th>

                                </tr>
                            </thead >
                            <tbody style="font-size:smaller; font-weight: bold ;">
                                <?php foreach ($pendientes as $row) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $row->id_oficio_salida; ?></td>
                                        <td><?php echo $row->num_oficio; ?></td>
                                        <td><?php echo $row->asunto; ?></td>
                                        <td><?php echo $row->tipo_emision; ?></td>
                                        <td><?php echo $row->titular; ?></td>
                                        <td><?php echo $row->emisor_principal; ?></td>
                                        <td><?php echo 'CSEIIO' ?></td>
                                        <td><?php echo $row->dependencia_remitente; ?></td>
                                        <td><?php echo $row->fecha_termino; ?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>RecepcionGral/Salidas/Pendientes/Descargar/<?php echo $row->archivo; ?>">
                                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                                         </a>
                                     </td>

                                     <?php if ($row->status == 'Pendiente'): ?>
                                        <td style="background-color: #FFEA3C;"></td>
                                    <?php endif ?>
                                    <?php if ($row->status == 'Contestado'): ?>
                                       <td style="background-color: #5CB85C;"></td>
                                   <?php endif ?>
                                   <?php if ($row->status == 'No Contestado'): ?>
                                       <td style="background-color: #D9534F;"></td>
                                   <?php endif ?>
                                   <?php if ($row->status == 'Fuera de Tiempo'): ?>
                                       <td style="background-color: #FF9752;"></td>
                                   <?php endif ?>

                                   <td>
                                    <?php

                                    if ($row->tipo_dias == 0) 
                                    {
                                        if ($row->tieneRespuesta == 1) {


                                           date_default_timezone_set('America/Mexico_City');
                                           $hoy = date('Y-m-d');

                                           $date1 = $hoy;
                                           $date2 = $row->fecha_termino;
                                           $diff = abs(strtotime($date2) - strtotime($date1));

                                           $years = floor($diff / (365*60*60*24));
                                           $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                           $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                           if ( $row->status == 'Fuera de Tiempo') {
                                             printf("El oficio fué contestado fuera de tiempo");
                                         }


                                         else
                                            if ( $row->status == 'Contestado') {
                                             printf("Oficio contestado a tiempo");
                                         }

                                         else
                                            if ($date2 < $date1) {
                                             printf("Se han agotado los días de respuesta");

                                         }

                                         else
                                         {
                                          printf("%d días naturales\n", $days );  
                                      } 


                                  }   
                                  else
                                  {
                                    echo "El oficio no requiere respuesta";
                                }

                            }
                            else
                                if ($row->tipo_dias == 1) {

                                    if ($row->tieneRespuesta == 1) {



                                        date_default_timezone_set('America/Mexico_City');
                                        $hoy = date('Y-m-d');

                                        $date1 = $hoy;
                                        $date2 = $row->fecha_termino;
                                        $dias_habiles = getDiasHabiles($date1 , $date2);

                                        if ( $row->status == 'Fuera de Tiempo') {
                                           printf("El oficio fué contestado fuera de tiempo");
                                       }


                                       else
                                        if ( $row->status == 'Contestado') {
                                         printf("Oficio contestado a tiempo");
                                     }

                                     else
                                       if ($date2 < $date1) {
                                         printf("Se han agotado los días de respuesta");
                                     }
                                     else
                                     {
                                        $num_dias = count($dias_habiles);
                                        if ($num_dias == 1) {
                                            echo $num_dias." día hábil";
                                        }
                                        else
                                        {
                                            echo $num_dias." días hábiles";
                                        }

                                    }
                                }

                            }
                            else
                            {
                                echo "El oficio no requiere respuesta";
                            }



                            ?>        
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


<div class="modal fade" id="modalAlertas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Emitir alerta</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/emitirAlertas">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <p>La emisión de alertas tienen como fin recordar el termino de tiempo de contestación de un oficio</p>
        </div>


        <div class="form-group">
            <label>Mensaje: </label>
            <textarea name="mensaje" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
            </textarea>
        </div>   

        <button name="btn_enviar_a" type="submit" class="btn btn-danger">
            <span class="glyphicon glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Enviar Alerta
        </button>

    </div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    function mostrarAlertas(id)
    {
        document.frmTurnarDepto.txt_idoficio.value = id;
        $('#modalAlertas').modal('show');
    }
</script>