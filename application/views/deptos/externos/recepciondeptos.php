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
                            <a href="<?php echo base_url(); ?>Departamentos/PanelDeptos"><i class="fa fa-desktop"></i> Inicio</a>
                        </li>
                        <li class="active">
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/RecepcionDeptos"><i class="fa fa-plus"></i> Recepción de Oficios</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/PendientesDeptos"><i class="fa fa-clock-o"></i> Pendientes</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/ContestadosDeptos"><i class="fa fa-check-circle"></i> Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/ContestadosFueraTiempoDeptos"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/NoContestadosDeptos"><i class="fa  fa-times-circle"></i> No Contestados</a>
                        </li>

                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                            <ul class="dropdown-menu" role="menu">
                             <li><a href="<?php echo base_url(); ?>Departamentos/Externo/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a este Departamento</a></li>
                         </ul>
                     </li>


                     <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Externo/ReportesDepto"><i class="fa  fa-times-circle"></i> Reportes</a>
                    </li>

                    <li>
                        <a target="_blank" href="http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_departamentos.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
                    </li>

                </ul>
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
                            <?php 
                            foreach ($infodepto as $row) {
                                echo $row->nombre_area;
                            }
                            ?> <small>Oficios Externos</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Recepción de Oficios Externos
                            </li>
                        </ol>
                    </div>
                </div>
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
                    <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo validation_errors();  ?>
                    </div>
                    <?php }
                    if ($error) { ?>
                    <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
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
                        <div class="alert alert-danger alert-dismissible" style="text-aling:center;color:#FF1E1E"  role="alert">
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
                    <strong>
                        <p style="text-align: center;">Tabla de información de oficios recepcionados</p>
                    </strong>
                    <div class="table-responsive">
                      <table id="tabla" class="table table-bordered table-hover table-responsive">
                        <thead style="background-color:#4d8585; color:#FFFFFF; font-size: smaller; text-aling:center;">
                            <tr>
                                <th>Folio</th>
                                <th>Número de Oficio</th>
                                <th>Fecha de Recepcion Física</th>
                                <th>Hora de Recepcion Física</th>
                                <th>Asunto</th>
                                <th>Tipo de Recepción</th>
                                <th>Tipo de Documento</th>
                                <th>Fecha de Subida del Oficio al Sistema</th>
                                <th>Hora de Subida del Oficio al Sistema</th>
                                <th>Funcionario que emite</th>
                                <th>Cargo</th>
                                <th>Dependencia</th>
                                <th>Fecha de Termino</th>
                                <th>Archivo</th>
                                <th>Prioridad</th>
                                <th>Código Archivístico</th>
                                <th>Valores primarios</th>
                                <th>Vigencia</th>
                                <th>Tipo de documento archivístico</th>
                                <th>Clasificación</th>
                                <th>Observaciones</th>
                                <th>Días Restantes</th>
                                <th>Responder</th>
                            </tr>
                        </thead >
                        <tbody style="font-size:smaller; font-weight: bold ;">
                            <?php foreach ($entradas as $row) { 
                                ?>
                                <tr>
                                    <td><?php echo $row->id_recepcion; ?></td>
                                    <td><?php echo $row->num_oficio; ?></td>

                                    <td><?php echo $row->fecha_recep_fisica; ?></td>
                                    <td><?php echo $row->hora_recep_fisica; ?></td>
                                    <td><?php echo $row->asunto; ?></td>
                                    <td><?php echo $row->tipo_recepcion; ?></td>
                                    <td><?php echo $row->tipo_documento; ?></td>
                                    <td><?php echo $row->fecha_recepcion; ?></td>
                                    <td><?php echo $row->hora_recepcion; ?></td>
                                    <td><?php echo $row->emisor; ?></td>
                                    <td><?php echo $row->cargo; ?></td>
                                    <td><?php echo $row->dependencia_emite; ?></td>
                                    <td><?php echo $row->fecha_termino; ?></td>
                                    <td>
                                        <a href="<?php echo base_url()?>Departamentos/Externo/RecepcionDeptos/Descargar/<?php echo $row->archivo_oficio; ?>">
                                         <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                                     </a>
                                 </td>
                                 <td><?php echo $row->prioridad; ?></td>
                                 <td><?php echo $row->codigo_archivistico; ?></td>
                                 <td><?php echo $row->valor_doc; ?></td>
                                 <td><?php echo $row->vigencia_doc; ?></td>
                                 <td><?php echo $row->tipo_doc_archivistico; ?></td>
                                 <td><?php echo $row->clasificacion_info; ?></td>
                                 <td><?php echo $row->observaciones; ?></td>
                                 <td>
                                    <?php

                                    if ($row->tipo_dias == 0) 
                                    {
                                        if ($row->requiereRespuesta == 1) {

                                            if ($row->fecha_recepcion == $row->fecha_recep_fisica) {
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
                                                if ($row->status == 'Informativo') {
                                                  printf("El oficio informativo, no requiere respuesta");
                                              }

                                              else
                                              {
                                                  printf("%d días naturales\n", $days );  
                                              } 
                                      }
                                      else 
                                        if($row->fecha_recep_fisica < $row->fecha_recepcion)
                                        {
                                           date_default_timezone_set('America/Mexico_City');
                                           $hoy = date('Y-m-d');

                                           $subida = $row->fecha_recepcion;
                                           $recepcion = $row->fecha_recep_fisica;
                                           $diferencia = abs(strtotime($recepcion) - strtotime($subida));

                                           $years = floor($diferencia / (365*60*60*24));
                                           $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
                             //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
                                           $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                             // días que hay entre el día de hoy y la fecha de termino
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
                                                if ($row->status == 'Informativo') {
                                                  printf("El oficio informativo, no requiere respuesta");
                                              }

                                         else
                                         {
                                          printf("%d días naturales\n", $days-$dias_entre_fechas);  
                                      } 

                                  }


                              }   
                              else
                              {
                                echo "El oficio no requiere respuesta";
                            }

                        }
                        else
                            if ($row->tipo_dias == 1) {

                                if ($row->requiereRespuesta == 1) {

                                 if ($row->fecha_recepcion == $row->fecha_recep_fisica) {

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
                            else
                                if ($row->fecha_recep_fisica < $row->fecha_recepcion) {
                                   date_default_timezone_set('America/Mexico_City');
                                   $hoy = date('Y-m-d');

                                   $subida = $row->fecha_recepcion;
                                   $recepcion = $row->fecha_recep_fisica;
                                   $diferencia = abs(strtotime($recepcion) - strtotime($subida));

                                   $years = floor($diferencia / (365*60*60*24));
                                   $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
                             //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
                                   $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

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
                                    $total_dias = $num_dias - $dias_entre_fechas;
                                    if ($num_dias == 1) {
                                        echo $total_dias." día hábil";
                                    }
                                    else
                                        if($total_dias < 1)
                                        {
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

                                     }
                                     else
                                     {
                                       echo $total_dias." días hábiles";
                                   }


                               }

                           }
                       }
                       else
                       {
                        echo "El oficio no requiere respuesta";
                    }

                }

                ?>        
            </td>

            <?php if ($row->asignado == 0) { ?>
            <td>
                <?php echo "Tu dirección no te ha asignado este oficio"; ?>
            </td>
            <?php } else { ?>
            <?php if($row->requiereRespuesta == 1){ ?>
            <td>
               
                <button type="button" onclick="mostrarModalRespuestas('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->emisor; ?>');" class="form-control btn btn-success btn-sm">
                 <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Responder 
             </button>
         </td>
         <?php }else { ?>
         <td>
            <?php echo "Oficio Informativo. No requiere respuesta." ?>
        </td>

        <?php } ?>
        
        <?php } ?>
        
    </tr>
    <?php } ?>
</tbody>
</table>
</div>

<!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- MODAL DE NUEVA ENTRADA DE OFICIO-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Respuesta a Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRespuesta" action="<?php echo base_url(); ?>Departamentos/Externo/RecepcionDeptos/agregarRespuesta">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required disabled>
        </div>

        <input type="hidden" name="num_oficio_h" value="">


        <div class="form-group">
            <label>Asunto</label>
            <input name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required disabled>
        </div>

        <input type="hidden" name="asunto_h" value="">

        <div class="form-group">
            <label>Tipo de Respuesta</label>
            <select class="form-control" name="tipo_recepcion">
                <option value="Externo">Externo</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tipo de Documento</label>
            <select class="form-control" name="tipo_documento">
                <option value="Oficio">Oficio</option>
                <option value="Memorandúm">Memorandúm</option>
                <option value="Circular">Circular</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="ofrespuesta_f" class="control-label">Número de oficio de salida</label>
            <div  class="input-group">
                <span class="input-group-addon"></span>
                <input name="numoficio_salida" id="ofrespuesta_f" class="form-control" placeholder="Ej. OFICIO-CSEIIO-DG-0001-2018" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
            <span class="label label-danger">*El formato del número de oficio debe ser el siguiente: OFICIO-CSEIIO-DG-0001-2018.</span>
             <button type="button" onclick="mostrarModalNumsOficio();" class="btn btn-warning btn-sm">
               <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consulta N° de Oficio Usados
           </button>
        </div>

        <div class="form-group">
            <label>Funcionario que emite</label>
            <input name="emisor" class="form-control" placeholder="Ej. Dir Planeación" value="<?php echo $this->session->userdata('nombre'); ?>" required disabled>
        </div>

        <div class="form-group">
            <label>Cargo</label>
            <input name="cargo" class="form-control" placeholder="Director de Planeación" value="<?php echo $this->session->userdata('descripcion'); ?>" required disabled>
        </div>

        <input type="hidden" name="cargo_h" value="<?php echo $this->session->userdata('descripcion'); ?>">

        <div class="form-group">
            <label>Dependencia</label>
            <input name="dependencia" class="form-control" placeholder="CSEIIO" value="CSEIIO" required disabled>
        </div>

        <input type="hidden" name="dependencia_h" value="CSEIIO">

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre'); ?>">

        <div class="form-group">
            <label>Receptor</label>
            <input name="receptor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required disabled>
        </div>

        <input type="hidden" name="receptor_h">

        <div class="form-group">
           <?php 
           echo "<p><label for='codigo_archivistico'>Código Archivístico  </label>";
           echo "<select class='form-control' name='codigo_archivistico' id='codigo_archivistico'>";
           if (count($codigos)) {
            foreach ($codigos as $list) {
              echo "<option value='". $list->id_codigo. "'>" . $list->codigo . " - ". $list->descripcion . " - ". $list->seccion ."</option>";
          } 
      }
      echo "</select><br/>";
      ?>
  </div> 


  <div class="form-group">
   <?php 
   echo "<p><label for='valor_doc'>Valores primarios </label>";
   echo "<select class='form-control' name='valor_doc' id='valor_doc'>";
   if (count($valores_doc)) {
    foreach ($valores_doc as $list) {
      echo "<option value='". $list->descripcion_valor_doc. "'>" . $list->descripcion_valor_doc . "</option>";
  }
}
echo "</select><br/>";
?>
</div>


<div class="form-group">
   <?php 
   echo "<p><label for='vigencia_doc'>Vigencia</label>";
   echo "<select class='form-control' name='vigencia_doc' id='vigencia_doc'>";
   if (count($vigencia_doc)) {
    foreach ($vigencia_doc as $list) {
      echo "<option value='". $list->descripcion_vigencia_doc. "'>" . $list->descripcion_vigencia_doc . "</option>";
  }
}
echo "</select><br/>";
?>
</div>


<div class="form-group">
   <?php 
   echo "<p><label for='tipo_doc_archivistico'>Tipo de documento</label>";
   echo "<select class='form-control' name='tipo_doc_archivistico' id='tipo_doc_archivistico'>";
   if (count($tipo_documento)) {
    foreach ($tipo_documento as $list) {
      echo "<option value='". $list->descripcion_tipo. "'>" . $list->descripcion_tipo . "</option>";
  }
}
echo "</select><br/>";
?>
</div>

<div class="form-group">
   <?php 
   echo "<p><label for='clasificacion_info'>Clasificación de información</label>";
   echo "<select class='form-control' name='clasificacion_info' id='clasificacion_info'>";
   if (count($clasificacion_informacion)) {
    foreach ($clasificacion_informacion as $list) {
      echo "<option value='". $list->descripcion_clasificacion. "'>" . $list->descripcion_clasificacion . "</option>";
  }
}
echo "</select><br/>";
?>
</div>


         <div class="form-group has-feedback">
            <label for="fecha_res_fisica" class="control-label">Fecha de Respuesta Física</label>
            <div class="input-group">
               <span class="input-group-addon"></span>
               <input type="date" id="fecha_res_fisica" name="fecha_res_fisica" class="form-control" required>
           </div>
           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           <div class="help-block with-errors"></div>  
       </div>


        <div class="form-group has-feedback">
            <label for="hora_res_fisica" class="control-label">Hora de Respuesta Física</label>
            <div class="input-group">
               <span class="input-group-addon"></span>
               <input type="time" id="hora_res_fisica" name="hora_res_fisica"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
           </div>
           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           <div class="help-block with-errors"></div>  
       </div>

  <div class="form-group has-feedback">
    <label for="ofrespuesta_d" class="control-label">Oficio de respuesta</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" name="ofrespuesta" class="form-control"  required>
    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>
</div>

<div class="form-group">
    <label>Anexos</label>
    <input type="file" name="anexos" class="form-control">
</div>


<button name="btn_enviar" type="submit" class="btn btn-info">
  <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
</button>

</div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modalNumsOficio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Numeros de Oficio Usados</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroDependencia" action="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas/AgregarDependencia">
        <div class="col-lg-12">
          <br>


          <table id="tabla" class="table table-bordered table-hover table-responsive">
            <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                    <th>Números de Oficio</th>
                </tr>
            </thead >
            <tbody style="font-size:smaller; font-weight: bold ;">
                <?php 
                 $this -> load -> model('Modelo_direccion');
                $query = $this->Modelo_direccion->getAllsByNumOficioSalida();
                foreach ($query as $row) { 
                    ?>
                    <tr>
                        <td><?php echo $row->num_oficio; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
  </div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<!-- JAVASCRITP PARA MOSTRAR MODALES -->
<script type="text/javascript">
  function mostrarModalRespuestas(idrecepcion, num_oficio, asunto, receptor)
  {
    document.frmRespuesta.txt_idoficio.value = idrecepcion;
    document.frmRespuesta.num_oficio.value = num_oficio;
    document.frmRespuesta.num_oficio_h.value = num_oficio;
    document.frmRespuesta.asunto.value = asunto;
    document.frmRespuesta.asunto_h.value = asunto;
    document.frmRespuesta.receptor.value = receptor;
    document.frmRespuesta.receptor_h.value = receptor;
    //receptor_h
    $('#modal').modal('show');
}

  function mostrarModalNumsOficio() {
     $('#modalNumsOficio').modal('show');
 }


function mostrarModaldeAsignacion(idrecepcion, num_oficio, asunto, receptor)
{
    document.frmAsignar.txt_idoficio_a.value = idrecepcion;
    document.frmAsignar.num_oficio_h.value = num_oficio;
    document.frmAsignar.asunto_a.value = asunto;
    document.frmAsignar.emisor_a.value = receptor;
    $('#modalAsignar').modal('show');
}
</script>

<script type="text/javascript">
  function confirma(){
    if (confirm("¿Realmente desea eliminarlo?")){ 
    }
    else { 
      return false
  }
}

</script>
<script>
    function enviar(){
     document.frmActualizar.submit();
 }
</script>
