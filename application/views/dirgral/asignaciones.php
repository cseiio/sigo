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
                <li>
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
                <li class="active">
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
                        <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Asignaciones</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Asignaciones de oficios a Direcciones
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
                    <span class="label label-danger">Oficio No Respondido</span>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table id="tabla" class="table table-bordered table-hover table-responsive">
                    <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; text-aling:center;">
                        <tr>
                            <th>Folio</th>
                            <th>Dirección a quien se asigna oficio</th>
                            <th>Numero de oficio</th>
                            <th>Asunto</th>
                            <th>Funcionario que emite</th>
                            <th>Fecha de Termino</th>
                            <th>Cargo</th>
                            <th>Dependencia</th>
                            <th>Archivo</th>
                            <th>Estatus</th>
                            <th>Fecha de Asignacion</th>
                            <th>Hora de asignación</th>
                            <th>Editar Asignación</th>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($asignaciones as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->id_recepcion; ?></td>
                                <td><?php echo $row->nombre_direccion; ?></td>
                                <td><?php echo $row->num_oficio; ?></td>
                                <td><?php echo $row->asunto; ?></td>
                                <td><?php echo $row->fecha_termino; ?></td>
                                <td><?php echo $row->emisor; ?></td>
                                <td><?php echo $row->cargo; ?></td>
                                <td><?php echo $row->dependencia_emite; ?></td>
                                <td>
                                    <a href="<?php echo base_url()?>DirGral/Asignaciones/Descargar/<?php echo $row->archivo_oficio; ?>">
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
                         <td><?php echo $row->hora_asignacion; ?></td>
                         <td><?php echo $row->fecha_asignacion; ?></td>
                         <td>
                          <button type="button" onclick="editarAsignacion('<?php echo $row->id_asignacion; ?>','<?php echo $row->nombre_direccion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->emisor; ?>','<?php echo $row->cargo; ?>','<?php echo $row->dependencia_emite; ?>');" class="form-control btn btn-warning" >
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</div>
<!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar asignación de oficios</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmModAsignacion" action="<?php echo base_url(); ?>DirGral/Asignaciones/editarAsignacion">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="id_asignacion">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required disabled>
        </div>


        <div class="form-group">
            <label>Asunto</label>
            <input name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required disabled>
        </div>

        <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Dir Planeación" required disabled>
        </div>


        <div class="form-group">
            <label>Cargo del funcionario que emite</label>
            <input name="cargo" class="form-control" placeholder="Ej. Coordinador Estatal de la SEMS"  required disabled>
        </div>

        <div class="form-group">
            <label>Dependencia que emite</label>
            <input name="dependencia" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" required disabled>
        </div>

    
        <div class="form-group">
            <label>Dirección de Destino</label>
            <select class="form-control" name="direccion_a">
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>
        <button name="btn_enviar" type="submit" class="btn btn-info">
          <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Modificar Asignación
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
  function editarAsignacion(idasignacion, direccion, num_oficio, asunto, emisor, cargo, dependencia_emite )
  {

    document.frmModAsignacion.id_asignacion.value = idasignacion;
    document.frmModAsignacion.direccion_a.value = direccion;
    document.frmModAsignacion.num_oficio.value = num_oficio;
    document.frmModAsignacion.asunto.value = asunto;
    document.frmModAsignacion.emisor.value = emisor;
    document.frmModAsignacion.cargo.value = cargo;
    document.frmModAsignacion.dependencia.value = dependencia_emite;
    $('#modalAsignar').modal('show');
}

function eliminarAsigacion(idasignacion)
{

    $('#modalEliminar').modal('show');
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