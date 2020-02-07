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
                <a class="navbar-brand" href="<?php echo base_url(); ?>DirGral/PanelDirGral">SGOCSEIIO</a>
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
                    <li >
                        <a href="<?php echo base_url(); ?>DirGral/PanelDirGral"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo base_url(); ?>DirGral/RecepcionDirGral"><i class="fa fa-plus"></i> Recepción de Oficios</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>DirGral/PendientesDirGral"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>DirGral/ContestadosDirGral"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>DirGral/ContestadosFueraTiempoDirGral"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>DirGral/NoContestadosDirGral"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>DirGral/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
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
                            <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Buzón de Oficios</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Recepción de Oficios
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
                        <span class="label label-danger">Oficio No Respondido</span>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="table-responsive">
                      <table id="tabla" class="table table-bordered table-hover table-responsive">
                        <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; ">
                            <tr>
                                <th>Folio</th>
                                <th>Número de Oficio</th>
                                <th>Fecha de Recepción</th>
                                <th>Hora de Recepción</th>
                                <th>Asunto</th>
                                <th>Tipo de Recepción</th>
                                <th>Tipo de Documento</th>
                                <th>Funcionario que emite</th>
                                <th>Cargo</th>
                                <th>Dependencia</th>
                                <th>Fecha de Termino</th>
                                <th>Archivo</th>
                                <th>Prioridad</th>
                                <th>Observaciones</th>
                                <th>Días Restantes</th>
                                <th>Asignar</th>
                            </tr>
                        </thead >
                        <tbody style="font-size:smaller; font-weight: bold ;">
                            <?php foreach ($entradas as $row) { 
                                ?>
                                <tr>
                                    <td><?php echo $row->id_recepcion; ?></td>
                                    <td><?php echo $row->num_oficio; ?></td>
                                    <td><?php echo $row->fecha_recepcion; ?></td>
                                    <td><?php echo $row->hora_recepcion; ?></td>
                                    <td><?php echo $row->asunto; ?></td>
                                    <td><?php echo $row->tipo_recepcion; ?></td>
                                    <td><?php echo $row->tipo_documento; ?></td>
                                    <td><?php echo $row->emisor; ?></td>
                                    <td><?php echo $row->cargo; ?></td>
                                    <td><?php echo $row->dependencia_emite; ?></td>
                                    <td><?php echo $row->fecha_termino; ?></td>
                                    <td>
                                        <a href="<?php echo base_url()?>DirGral/RecepcionDirGral/Descargar/<?php echo $row->archivo_oficio; ?>">
                                           <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                                       </a>
                                   </td>


                                   <td><?php echo $row->prioridad; ?></td>
                                   <td><?php echo $row->observaciones; ?></td>
                                   <td>
                                    <?php

                                    if ($row->tipo_dias == 0) 
                                    {
                                        date_default_timezone_set('America/Mexico_City');
                                        $hoy = date('Y-m-d');

                                        $date1 = $hoy;
                                        $date2 = $row->fecha_termino;
                                        $diff = abs(strtotime($date2) - strtotime($date1));

                                        $years = floor($diff / (365*60*60*24));
                                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                        if ( $row->status == 'Fuera de Tiempo') {
                                           printf("Oficio respondido fuera de tiempo");
                                       }

                                       else
                                        if ( $row->status == 'Contestado') {
                                           printf("Oficio respondido a tiempo");
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
                                    if ($row->tipo_dias == 1) {

                                        date_default_timezone_set('America/Mexico_City');
                                        $hoy = date('Y-m-d');

                                        $date1 = $hoy;
                                        $date2 = $row->fecha_termino;
                                        $dias_habiles = bussiness_days($date1 , $date2);

                                        if ( $row->status == 'Fuera de Tiempo') {
                                           printf("Oficio respondido fuera de tiempo");
                                       }

                                       else
                                        if ( $row->status == 'Contestado') {
                                         printf("Oficio respondido a tiempo");
                                     }

                                     else
                                       if ($date2 < $date1) {
                                         printf("Se han agotado los días de respuesta");
                                     }

                                     else
                                     {
                                        foreach ($dias_habiles as $anio_mes => $dias) 
                                        {
                                            $dias_mes = count($dias);
                                            $mensaje = "{$dias_mes}";
                                            echo ($dias_mes > 1) ? "{$mensaje} dias hábiles<br>" : "{$mensaje} dia<br>";
                                        }   

                                    }

                                }

                                ?>        
                            </td>
                           <td>
                            <button type="button"  onclick="mostrarModaldeAsignacion('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->emisor; ?>');" class="form-control btn btn-danger btn-sm">
                               <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> Asignar 
                           </button>
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

<!-- NUEVO OFICIO -->

    <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 align="center" class="modal-title">Registrar Oficio</h4>
          </div>
          <form enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>RecepcionGral/Recepcion/agregarEntrada">
            <div class="col-lg-12">
              <br>
              <div class="form-group">
                <label>Número de Oficio</label>
                <input name="num_oficio" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
              </div>

               <div class="form-group">
                <label>Asunto</label>
                <input name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required>
              </div>

                 <div class="form-group">
                <label>Tipo de Recepción</label>
                <select class="form-control" name="tipo_recepcion">
                    <option value="Interno">Interno</option>
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
                <label>Emisor</label>
                <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required>
              </div>

                 <div class="form-group">
                <label>Dirección de Destino</label>
                <select class="form-control" name="direccion">
                    <option value="2">Dirección Administrativa</option>
                    <option value="3">Dirección de Estudios Superiores</option>
                    <option value="4">Dirección de Planeación</option>
                    <option value="5">Unidad Jurídica</option>
                    <option value="6">Unidad de Acervo</option>
                    <option value="7">Dirección de Desarrollo Académico</option>
                </select>
              </div>

                <div class="form-group">
                <label>Tipo de días para termino</label>
                <select class="form-control" name="tipo_dias">
                    <option value="0">Días Naturales</option>
                    <option value="1">Días Hábiles</option>
                </select>
              </div>


                 <div class="form-group">
                <label>Fecha de Termino</label>
                <input type="date" name="fecha_termino" class="form-control" required>
              </div>


              <div class="form-group">
                <label>Archivo Escaneado</label>
                <input type="file" name="archivo" class="form-control"  required>
                <span class="label label-danger">*El archivo debe estar en formato PDF</span>
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
                <input name="observaciones" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia"  required>
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


<!-- MODAL DE NUEVA ENTRADA DE OFICIO-->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Respuesta a Oficio</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmRespuesta" action="<?php echo base_url(); ?>Direcciones/RecepcionDir/agregarRespuesta">
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
                <option value="Interno">Interno</option>
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
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Dir Planeación" value="<?php echo $this->session->userdata('nombre'); ?>" required disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre'); ?>">

        <div class="form-group">
            <label>Receptor</label>
            <input name="receptor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required disabled>
        </div>

        <input type="hidden" name="receptor_h">

        <div class="form-group">
            <label>Oficio de respuesta</label>
            <input type="file" name="ofrespuesta" class="form-control"  required>
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


<div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Asignación de Oficios a Direcciones</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmAsignar" action="<?php echo base_url(); ?>DirGral/RecepcionDirGral/asignarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio_a">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio_a" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" disabled required>
        </div>

        <input  type="hidden" name="num_oficio_h">

        <div class="form-group">
            <label>Asunto</label>
            <input name="asunto_a" class="form-control" placeholder="Ej. Solicitud de Información" disabled required>
        </div>

        <div class="form-group">
            <label>Emisor</label>
            <input name="emisor_a" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required disabled>
        </div>

        <div class="form-group">
            <label>Asigna: </label>
            <input name="dir_asigna" class="form-control" placeholder="Ej. Dirección de Planeación" value="<?php echo $this->session->userdata('nombre'); ?>" required disabled>
        </div>

        <input  type="hidden" name="iddir"  value="<?php echo $this->session->userdata('id_direccion'); ?>">

        <!-- SE MOSTRARÁN UNICAMENTE LAS AREAS QUE CONFORMEN LA DIRECCION EN TURNO -->

        <div class="form-group">
                <label>Dirección de Destino</label>
                <select class="form-control" name="direccion">
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
   <textarea name="observaciones" class="form-control" placeholder="Observaciones sobre la asignacion del oficio" >    
   </textarea>
</div>              

<button name="btn_enviar_a" type="submit" class="btn btn-info">
  <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Asignar Oficio
</button>

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
    $('#modalNuevo').modal('show');
  }

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
