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
                        <li class="active">
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion"><i class="fa fa-plus"></i> Recepción de Oficios</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Pendientes"><i class="fa fa-clock-o"></i> Pendientes</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/ContestadosFueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/NoContestados"><i class="fa  fa-times-circle"></i> No Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                        </li>

                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                            <ul class="dropdown-menu" role="menu">
                             <li><a href="<?php echo base_url(); ?>RecepcionGral/Entradas/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                             <li><a href="<?php echo base_url(); ?>RecepcionGral/Entradas/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                         </ul>
                     </li>

                     <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Dependencias"><i class="fa fa-building"></i> Dependencias</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes"><i class="fa fa-book"></i> Reportes</a>
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
            <br><br><br><br><br><br>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            <?php echo $this->session->userdata('descripcion'); ?>  <small>Recepción de Oficios</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Oficios recepcionados
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
                    <div class="alert alert-danger alert-dismissible" onchange="mostrarModal();" style="text-aling:center; color:#FF1E1E"  role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo validation_errors();  ?>
                    </div>
                    <?php }
                    if ($error) { ?>
                    <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong><?php echo $error; ?>
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
                        <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
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

                    <div align="right" class="row">
                     <div class="col-lg-12">
                       <button type="button" onclick="mostrarModal();"  class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                        <strong>Nuevo Oficio</strong>
                    </button>
                </div>
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
                <thead style="background-color:#B2B2B2; color:#FFFFFF; font-size:smaller; ; text-aling:center; font-weight: bold;">
                    <tr>
                        <th>Folio</th>
                        <th>Número de Oficio</th>
                        <th>Fecha y Hora de Emisión en la Dependencia</th>
                        <th>Fecha y Hora de Recepcion Física</th>
                        <th>Asunto</th>
                        <th>Tipo de Recepción</th>
                        <th>Tipo de Documento</th>
                        <th>Fecha y Hora de Subida</th>
                        <th>Funcionario que emite</th>
                        <th>Cargo</th>
                        <th>Dependencia</th>
                        <th>Dirección asignada a responder</th>
                        <th>Departamento asignado a responder</th>
                        <th>Fecha de Termino</th>
                        <th>Archivo</th>
                        <th>Código Archivístico</th>
                        <th>Valores primarios</th>
                        <th>Vigencia</th>
                        <th>Tipo de documento archivístico</th>
                        <th>Clasificación</th>
                        <th>Observaciones</th>
                        <th>Días Restantes</th>
                        <th>Editar</th>
                        <th>C.c.p Direcciones</th>
                        <th>Direcciones con copias turnadas</th>
                        <th>C.c.p Departamentos</th>  
                        <th>Departamentos con copias turnadas</th> 
                    </tr>
                </thead >
                <tbody style="font-size:smaller; font-weight: bold ;">
                    <?php foreach ($entradas as $row) { 
                        ?>

                        <tr>
                            <td><?php echo $row->id_recepcion; ?></td>
                            <td><?php echo $row->num_oficio; ?></td>
                            <td><?php echo $row->fecha_emision.' '.$row->hora_emision; ?></td>
                            <td><?php echo $row->fecha_recep_fisica.' '.$row->hora_recep_fisica; ?></td>
                            <td><?php echo $row->asunto; ?></td>
                            <td><?php echo $row->tipo_recepcion; ?></td>
                            <td><?php echo $row->tipo_documento; ?></td>
                            <td><?php echo $row->fecha_recepcion.' '.$row->hora_recepcion; ?></td>
                            <td><?php echo $row->emisor; ?></td>
                            <td><?php echo $row->cargo; ?></td>
                            <td><?php echo $row->dependencia_emite; ?></td>

                            <?php  if ($row->status == 'Informativo') { ?>                <?php $is_informativo='si'; ?>                      
                            <td>
                                <?php 
                                $this -> load -> model('Modelo_recepcion');
                                $query = $this->Modelo_recepcion->getAllInformativosByNumOficio($row->num_oficio);
                                foreach ($query as $key) {
                                 echo $key->nombre_direccion.',';
                             }
                             ?></td>

                             <?php } 
                             else { ?>

                             <td>
                                <?php 
                                $this -> load -> model('Modelo_recepcion');
                                $query = $this->Modelo_recepcion->getAllsByNumOficio($row->num_oficio);
                                foreach ($query as $key) {
                                   echo $key->nombre_direccion.',';
                               }
                               ?>

                           </td>
                           <?php $is_informativo='no'; ?>
                           <?php } ?>
                           <td>
                            <?php if ($row->flag_deptos == 1) {

                                $this -> load -> model('Modelo_direccion');
                                $nombre_depto = $this -> Modelo_direccion -> getAsignacionById($row->id_recepcion);
                                foreach ($nombre_depto as $nombre) {
                                    echo "Oficio asignado al ".$nombre->nombre_area;
                                }

                            } 
                            else if ($row->flag_deptos == 0) {
                                echo "Sin asignación a departamentos";
                            }
                            ?>
                        </td> 
                        <td><?php echo $row->fecha_termino; ?></td>
                        <td>
                            <a href="<?php echo base_url()?>RecepcionGral/Entradas/Recepcion/Descargar/<?php echo $row->archivo_oficio; ?>">
                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                         </a>
                     </td>
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
<td>

  <button type="button" onclick="EditarOficio('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_recepcion; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->emisor; ?>','<?php 
    if($row->status == 'Informativo'){
      $this -> load -> model('Modelo_recepcion');
      $query = $this->Modelo_recepcion->getAllInformativosByNumOficio($row->num_oficio);
      foreach ($query as $key) {
         echo $arraydir[] =$key->direccion_destino;
     }
 }else{
    $this -> load -> model('Modelo_recepcion');
    $query = $this->Modelo_recepcion->getAllsByNumOficio($row->num_oficio);
    foreach ($query as $key) {
       echo $arraydir[] =$key->direccion_destino;
    }
}
?>','<?php echo $row->fecha_termino; ?>','<?php echo $row->prioridad; ?>','<?php echo $is_informativo; ?>','<?php echo $row->codigo_archivistico; ?>', '<?php echo $row->valor_doc; ?>','<?php echo $row->vigencia_doc; ?>','<?php echo $row->tipo_doc_archivistico; ?>','<?php echo $row->clasificacion_info; ?>','<?php echo $row->requiereRespuesta; ?>','<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
</button>
                    
                   
</td>

<td>
    <button type="button" onclick="mostrarTurnadoDirecciones('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>');" class="form-control btn btn-warning btn-sm">
     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Direcciones
 </button>
</td>
<td>
    <?php 

    $this -> load -> model('Modelo_recepcion');
    $nombre_depto = $this -> Modelo_recepcion -> getBuzonDeCopiasDirById($row->id_recepcion);
    foreach ($nombre_depto as $nombre) {
        echo $nombre->nombre_direccion."\n\n";
    }
    ?>
</td> 
<!--  <td>Oficio turnado a X dirección</td> -->
<td>
    <button type="button" onclick="mostrarTurnadoDepartamentos('<?php echo $row->id_recepcion; ?>','<?php echo $row->direccion_destino; ?>','<?php echo $row->num_oficio; ?>');" class="form-control btn btn-primary btn-sm">
     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Deptos  
 </button>
</td>
<td>
    <?php 

    $this -> load -> model('Modelo_recepcion');
    $nombre_depto = $this -> Modelo_recepcion -> getBuzonDeCopiasDeptoById($row->id_recepcion);
    foreach ($nombre_depto as $nombre) {

        echo $nombre->nombre_area."\n\n";

    }

    ?>
</td>

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
        <h4 align="center" class="modal-title">Registrar Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/agregarEntrada">
        <div class="col-lg-12">
          <br>

          <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="noficio" class="control-label">Número de Oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="num_oficio" id="noficio" class="form-control" placeholder="Ej. SA-DP-005-2018" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
            <span class="label label-danger">*El formato del número de oficio debe ser el siguiente: SA-DP-005-2018.</span>
           
        </div>

        <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="asunto" class="control-label">Asunto</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="asunto" id="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group">
            <label>Tipo de Recepción</label>
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


        <div class="form-group">
         <?php 
         echo "<p><label for='dependencia'>Dependencia Remitente </label>";
         echo "<select class='form-control' name='dependencia' id='dependencia'>";
         if (count($dependencias)) {
            echo "<option>Seleccione una dependencia</option>";
            foreach ($dependencias as $list) {
              echo "<option value='". $list->nombre_dependencia. "'>" . $list->nombre_dependencia . "</option>";
          }
      }
      echo "</select><br/>";
      ?>
  </div>

  <div>
     <span class="label label-warning">*Si la dependencia no aparece en la lista, da clic en el botón para agregarla</span>
     <button type="button" onclick="mostrarModalDependencias();" class="btn btn-primary btn-sm">
         <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Dependencia
     </button>
 </div>


      <br>

      <label for="emis" class="control-label">Funcionario que emite el oficio</label>
      <div id="emis"  class="form-group">
          <input class="form-control" placeholder="Lic. Juan Jimenez Garnica">
      </div> 

      <label for="cargemi" class="control-label">Cargo del funcionario que emite</label>
      <div id="cargemi"  class="form-group">
          <input class="form-control" placeholder="Secretario de Administración">
      </div> 




    <div class="form-group has-feedback">
        <label for="fecha_emision_fisica" class="control-label">Fecha de Emisión Física</label>
        <div class="input-group">
           <span class="input-group-addon"></span>
           <input type="date" id="fecha_emision_fisica" name="fecha_emision_fisica" class="form-control" required>
       </div>
       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
       <div class="help-block with-errors"></div>  
   </div>


   <div class="form-group has-feedback">
    <label for="hora_emision_fisica" class="control-label">Hora de Emisión Física</label>
    <div class="input-group">
       <span class="input-group-addon"></span>
       <input type="time" id="hora_emision_fisica" name="hora_emision_fisica"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
   </div>
   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
   <div class="help-block with-errors"></div>  
</div>


<div class="form-group has-feedback">
    <label for="fecha_fisica" class="control-label">Fecha de Recepción Física</label>
    <div class="input-group">
       <span class="input-group-addon"></span>
       <input type="date" id="fecha_fisica" name="fecha_recepcion_fisica" class="form-control" required>
   </div>
   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
   <div class="help-block with-errors"></div>  
</div>


<div class="form-group has-feedback">
    <label for="hora_fisica" class="control-label">Hora de Recepción Física</label>
    <div class="input-group">
       <span class="input-group-addon"></span>
       <input type="time" id="hora_fisica" name="hora_recepcion_fisica"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
   </div>
   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
   <div class="help-block with-errors"></div>  
</div>




<div class="form-group has-feedback">
    <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
    <div class="input-group">
        <label class="radio-inline">
            <input  type="radio" onclick="enable_a();" name="ReqRespuesta" value="1" required>Si
        </label>
        <label class="radio-inline">
            <input  type="radio" onclick="disable_a();" name="ReqRespuesta" value="0" required>No
        </label>
    </div>
</div>

<script>
    function disable_a() {
        document.getElementById("fecha_termino_div").style.display = "none";
        document.getElementById("tipo_dias_div").style.display = "none";
        //tipo_dias
    }
    function enable_a() {
        document.getElementById("fecha_termino_div").style.display = "block";
        document.getElementById("tipo_dias_div").style.display = "block";
    }
</script>


<div class="form-group">
    <label>Dirección de Destino</label><br>
    <div class="checkbox" required>
      <label>
        <input type="checkbox" name="direccion[]"  id="dir" value="1">
        Dirección General<br>
        <input type="checkbox" name="direccion[]"  id="dir" value="2">
        Dirección Administrativa<br>
        <input type="checkbox" name="direccion[]"  id="dir" value="3">
        Dirección de Estudios Superiores<br>
        <input type="checkbox" name="direccion[]"  id="dir" value="4">
        Dirección de Planeación<br>
        <input type="checkbox" name="direccion[]"  id="dir" value="5">
        Unidad Jurídica<br>
        <input type="checkbox" name="direccion[]"  id="dir" value="6">
        Unidad de Acervo<br>
        <input type="checkbox" name="direccion[]"  id="dir" data-error="Seleccione al menos una dirección"  value="7">
        Dirección de Desarrollo Académico<br>
    </label>
    <div class="help-block with-errors"></div>
</div>
<span class="label label-danger">*Seleccione al menos una dirección.</span>
</div>

<!-- <span class="label label-danger">*Para hacer una selección multiple, deja presiona la tecla 'Crtl', mientras das clic en las direcciones.</span> -->


<div id="tipo_dias_div" style="display: block;" class="form-group">
    <label>Tipo de días para termino</label>
    <select   class="form-control" name="tipo_dias">
     <option value="1">Días Hábiles</option>
     <option value="0">Días Naturales</option>       
 </select>
</div>



<div id="fecha_termino_div" style="display: block;"  class="form-group has-feedback">
    <label for="fecha" class="control-label">Fecha de Termino</label>
    <div class="input-group">
     <span class="input-group-addon"></span>
     <input type="date"  name="fecha_termino" class="form-control" >
 </div>
 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
 <div class="help-block with-errors"></div>  
</div>

<div class="form-group">
           <?php 
           echo "<p><label for='codigo'>Código Archivístico  </label>";
           echo "<select class='form-control' name='codigo' id='codigo'>";
           if (count($codigos)) {
            foreach ($codigos as $list) {
              echo "<option value='". $list->codigo. "'>" . $list->codigo . " - ". $list->descripcion . " - ". $list->seccion ."</option>";
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
    <label for="archivof" class="control-label">Archivo Escaneado</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" id="archivof" name="archivo" class="form-control"  required>

    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>  
    <span class="label label-danger">*El archivo debe estar en formato PDF</span>
    <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
</div>


<div class="form-group">
    <label>Prioridad</label>
    <select class="form-control" name="prioridad">
        <option value="Alta">Alta</option>
        <option value="Media">Media</option>
        <option value="Baja">Baja</option>
    </select>
</div>


<div class="form-group">
   <label>Observaciones</label>
   <textarea name="observaciones" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
   </textarea>
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


<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="btnCerrar" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/ModificarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group has-feedback">
            <label for="noficio_a" class="control-label">Número de Oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="num_oficio_a" id="noficio_a" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="asunto_af" class="control-label">Asunto</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="asunto_a" id="asunto_af" class="form-control" placeholder="Ej. Solicitud de Información" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group">
            <label>Tipo de Recepción</label>
            <select class="form-control" name="tipo_recepcion_a">
                <option value="Externo">Externo</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tipo de Documento</label>
            <select class="form-control" name="tipo_documento_a">
                <option value="Oficio">Oficio</option>
                <option value="Memorandúm">Memorandúm</option>
                <option value="Circular">Circular</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="emisorf" class="control-label">Emisor</label>
            <div class="input-group">
             <span class="input-group-addon"></span>
             <input name="emisor_a" id="emisorf" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required>
         </div>
         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
         <div class="help-block with-errors"></div>
     </div>

   <!--     <div class="form-group">
        <label>Dirección de Destino</label>
        <select class="form-control" name="direccion_a">
            <option value="1">Dirección General</option>
            <option value="2">Dirección Administrativa</option>
            <option value="3">Dirección de Estudios Superiores</option>
            <option value="4">Dirección de Planeación</option>
            <option value="5">Unidad Jurídica</option>
            <option value="6">Unidad de Acervo</option>
            <option value="7">Dirección de Desarrollo Académico</option>
            <option value="8">No requiere respuesta</option>
        </select>
    </div>
-->
<div class="form-group">
    <label>Dirección de Destino</label><br>
    <div class="checkbox">
      <label>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="1">
        Dirección General<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="2">
        Dirección Administrativa<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="3">
        Dirección de Estudios Superiores<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="4">
        Dirección de Planeación<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="5">
        Unidad Jurídica<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" value="6">
        Unidad de Acervo<br>
        <input type="checkbox" name="direccion_a[]"  class="dir" data-error="Seleccione al menos una dirección"  value="7">
        Dirección de Desarrollo Académico<br>
    </label>
    <div class="help-block with-errors"></div>
</div>
<span class="label label-danger">*Seleccione al menos una dirección.</span>
</div>



<div class="form-group">
    <label>Tipo de días para termino</label>
    <select class="form-control" name="tipo_dias_a">
        <option value="1">Días Hábiles</option>
        <option value="0">Días Naturales</option>
    </select>
</div>

<div class="form-group has-feedback">
    <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
    <div class="input-group">
        <label class="radio-inline">
            <input  type="radio" onclick="enable();" name="ReqRespuesta_a" value="1" required>Si
        </label>
        <label class="radio-inline">
            <input  type="radio" onclick="disable();" name="ReqRespuesta_a" value="0" required>No
        </label>
    </div>
</div>


<script>
    function disable() {
        document.getElementById("fecha_termino_div_a").style.display = "none";
        document.getElementById("tipo_dias_div_a").style.display = "none";
        //tipo_dias
    }
    function enable() {
        document.getElementById("fecha_termino_div_a").style.display = "block";
        document.getElementById("tipo_dias_div_a").style.display = "block";
    }
</script>


<div id="tipo_dias_div_a" style="display: block;" class="form-group">
    <label>Tipo de días para termino</label>
    <select   class="form-control" name="tipo_dias_a">
     <option value="1">Días Hábiles</option>
     <option value="0">Días Naturales</option>       
 </select>
</div>



<div id="fecha_termino_div_a" style="display: block;"  class="form-group has-feedback">
    <label for="fecha" class="control-label">Fecha de Termino</label>
    <div class="input-group">
     <span class="input-group-addon"></span>
     <input type="date"  name="fecha_termino_a" class="form-control" >
 </div>
 <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
 <div class="help-block with-errors"></div>  
</div>



<div class="form-group">
    <label>Prioridad</label>
    <select class="form-control" name="prioridad_a">
        <option value="Alta">Alta</option>
        <option value="Media">Media</option>
        <option value="Baja">Baja</option>
    </select>
</div>

<div class="form-group">
           <?php 
           echo "<p><label for='codigo_a'>Código Archivístico  </label>";
           echo "<select class='form-control' name='codigo_a' id='codigo_a'>";
           if (count($codigos)) {
            foreach ($codigos as $list) {
              echo "<option value='". $list->codigo. "'>" . $list->codigo . " - ". $list->descripcion . " - ". $list->seccion ."</option>";
          } 
      }
      echo "</select><br/>";
      ?>
  </div> 

  <div class="form-group">
   <?php 
   echo "<p><label for='valor_doc_a'>Valores primarios </label>";
   echo "<select class='form-control' name='valor_doc_a' id='valor_doc_a'>";
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
   echo "<p><label for='vigencia_doc_a'>Vigencia</label>";
   echo "<select class='form-control' name='vigencia_doc_a' id='vigencia_doc_a'>";
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
   echo "<p><label for='tipo_doc_archivistico_a'>Tipo de documento</label>";
   echo "<select class='form-control' name='tipo_doc_archivistico_a' id='tipo_doc_archivistico'>";
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
   echo "<p><label for='clasificacion_info_a'>Clasificación de información</label>";
   echo "<select class='form-control' name='clasificacion_info_a' id='clasificacion_info_a'>";
   if (count($clasificacion_informacion)) {
    foreach ($clasificacion_informacion as $list) {
      echo "<option value='". $list->descripcion_clasificacion. "'>" . $list->descripcion_clasificacion . "</option>";
  }
}
echo "</select><br/>";
?>
</div>


<div class="form-group has-feedback">
    <label for="archivof" class="control-label">Archivo Escaneado</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" id="archivof" name="archivo_a" class="form-control">

    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>  
    <span class="label label-danger">*El archivo debe estar en formato PDF</span>
    <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
</div>

<div class="form-group">
 <label>Observaciones</label>
 <textarea name="observaciones_a" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
 </textarea>
</div>   


<button name="btn_enviar_a" type="submit" class="btn btn-info">
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


<div class="modal fade" id="modalDir" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Turnar Copia a Direcciones</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDir" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/TurnarCopiaDir">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">
          <input  type="hidden" name="txt_num_oficio">

          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">



        <div class="form-group">
            <label>Dirección:</label>
            <select class="form-control" name="direccion_a">
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>



        <div class="form-group">
            <label>Observaciones</label>
            <input name="observaciones_a" class="form-control" placeholder="Para su conocimiento"  required>
        </div>

        <button name="btn_enviar_a" type="submit" class="btn btn-info">
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


<div class="modal fade" id="modalDeptos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Turnar Copia a Departamentos</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/TurnarCopiaDeptos">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">
          <input  type="hidden" name="txt_id_direccion">
          <input  type="hidden" name="txt_num_oficio">

          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">



        <div class="form-group">
           <?php 
           echo "<p><label for='area_destino'>Área de destino </label>";
           echo "<select class='form-control' name='area_destino' id='area_destino'>";
           if (count($deptos)) {
            foreach ($deptos as $list) {
              echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
          }
      }
      echo "</select><br/>";
      ?>
  </div>


  <div class="form-group">
    <label>Observaciones</label>
    <select class="form-control" name="observaciones_a">
        <option value="conocimiento">Para su conocimiento</option>
        <option value="atencion">Para su atención</option>
    </select>
</div>

<!-- <div class="form-group">
    <label>Observaciones</label>
    <input name="observaciones_a" class="form-control" placeholder="Para su conocimiento"  required>
</div> -->

<button name="btn_enviar_a" type="submit" class="btn btn-info">
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

<div class="modal fade" id="modalDependencias" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar una Nueva Dependencia</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroDependencia" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/AgregarDependencia">
        <div class="col-lg-12">
          <br>

          <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="nombre_dependencia" class="control-label">Nombre de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_dependencia" id="nombre_dependencia" class="form-control" placeholder="Ej. Secretaría de Asuntos Indígenas" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="nombre_titular" class="control-label">Nombre del Titular de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_titular" id="nombre_titular" class="form-control" placeholder="Ej. Lic. Anel Méndez Barragán" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="cargo_titular" class="control-label">Cargo del Titular</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_titular" id="cargo_titular" class="form-control" placeholder="Ej. Secretária de Asuntos Indígenas" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>


        <div class="form-group has-feedback">
            <label for="direccion_dependencia" class="control-label">Dirección de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="direccion_dependencia" id="direccion_dependencia" class="form-control" placeholder="Ej. Calle Sauces #123, Col. Fresnos, Edificio 2" required > 
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="telefono" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ej. 513455">
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="email" class="control-label">Correo de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Ej. coordinador@cseiio.edu.mx">
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="pagina_web" class="control-label">Página Web</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input  name="pagina_web" id="pagina_web" class="form-control" placeholder="Ej. http://www.sedesoh.com.mx" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <button name="btn_enviar" type="submit" class="btn btn-info">
          <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Dependencia
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
            <thead style="background-color:#B2B2B2; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                    <th>Números de Oficio</th>
                </tr>
            </thead >
            <tbody style="font-size:smaller; font-weight: bold ;">
                <?php foreach ($entradas as $row) { 
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
  function mostrarModal()
  {
    $('#modal').modal('show');
}


function mostrarTurnadoDirecciones(id,$num_oficio)
{
    document.frmTurnarDir.txt_idoficio.value = id;
    document.frmTurnarDir.txt_num_oficio.value = $num_oficio;
    $('#modalDir').modal('show');
}

function mostrarTurnadoDepartamentos(id,id_direccion,num_oficio)
{
    //txt_id_direccion
    document.frmTurnarDepto.txt_idoficio.value = id;
    document.frmTurnarDepto.txt_id_direccion.value = id_direccion;
    document.frmTurnarDepto.txt_num_oficio.value = num_oficio;
    $('#modalDeptos').modal('show');
}



function EditarOficio(id,num_oficio, asunto, tipo_recepcion,  tipo_documento, emisor, direccion, fecha_termino, prioridad, is_informativo, codigo, valor_doc, vigencia_doc, tipo_doc_archivistico, clasificacion_info, requiereRespuesta, observaciones)
{
    if (is_informativo == 'no') 
    {
        document.frmEditarOficio.txt_idoficio.value = id;
        document.frmEditarOficio.num_oficio_a.value = num_oficio;
        document.frmEditarOficio.asunto_a.value = asunto;
        document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
        document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
        document.frmEditarOficio.emisor_a.value = emisor;
        for (x=0;x<direccion.length;x++){ 
            $("input[name^=direccion_a][value='"+direccion[x]+"']").prop("checked",true);
            //'input[name^="pages_title"]'
        } 
        document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
        document.frmEditarOficio.prioridad_a.value = prioridad;
        document.frmEditarOficio.codigo_a.value = codigo;
        document.frmEditarOficio.valor_doc_a.value = valor_doc;
        document.frmEditarOficio.vigencia_doc_a.value = vigencia_doc;
        document.frmEditarOficio.tipo_doc_archivistico_a.value = tipo_doc_archivistico;
        document.frmEditarOficio.clasificacion_info_a.value = clasificacion_info;
        document.frmEditarOficio.ReqRespuesta_a.value = requiereRespuesta;
        document.frmEditarOficio.observaciones_a.value = observaciones;

        $('#modalActualizar').modal('show');
    }
    else
     if (is_informativo == 'si') {
      
      document.frmEditarOficio.txt_idoficio.value = id;
      document.frmEditarOficio.num_oficio_a.value = num_oficio;
      document.frmEditarOficio.asunto_a.value = asunto;
      document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
      document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
      document.frmEditarOficio.emisor_a.value = emisor;
      for (x=0;x<direccion.length;x++){ 
        $("input[name^=direccion_a][value='"+direccion[x]+"']").prop("checked",true);
    }
    document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
    document.frmEditarOficio.prioridad_a.value = prioridad;
    document.frmEditarOficio.codigo_a.value = codigo;
    document.frmEditarOficio.valor_doc_a.value = valor_doc;
    document.frmEditarOficio.vigencia_doc_a.value = vigencia_doc;
    document.frmEditarOficio.tipo_doc_archivistico_a.value = tipo_doc_archivistico;
    document.frmEditarOficio.clasificacion_info_a.value = clasificacion_info;
    document.frmEditarOficio.ReqRespuesta_a.value = requiereRespuesta;
    document.frmEditarOficio.observaciones_a.value = observaciones;

      $('#modalActualizar').modal('show');
  }
}

function mostrarModalDependencias() {
   $('#modalDependencias').modal('show');
}
// Limpiar las direcciones de la ventana modal anterior, derivado de la lectura del num de oficio
$(document).ready(function(){
    $("#btnCerrar").click(function(){
        $("#modalActualizar").modal("hide");
    });
    $("#modalActualizar").on('hidden.bs.modal', function () {
           var dirs = document.getElementsByName('direccion_a[]');
           for (i=0; i<dirs.length; i++){
            if(dirs[i].checked = true){
                dirs[i].checked = false;
            }
        }
    });

});

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

