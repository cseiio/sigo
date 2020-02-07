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
              <li>
                        <a href="<?php 
                        if ($this->session->userdata('nivel') == 2) {
                          echo base_url().'Direcciones/PanelDir';
                      }
                      else
                          if($this->session->userdata('nivel') == 6)
                          {
                            echo base_url().'Direcciones/Externos/Planteles/PanelPlanteles';
                        }
                        ?>">Inicio</a>
                    </li>
                  
                     <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                    </li>
                  
                     <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/PendientesInternos"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/ContestadosInterno"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/FueraDeTiempoInterno"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/NoContestadosInterno"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>

                     <li class="active">
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
                    </li>

                     <li>
                      <a href="<?php echo base_url(); ?>Direcciones/Interno/Informativos"><i class="fa  fa-info-circle"></i> Informativos</a>
                  </li>


                   
                    <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                     <ul class="dropdown-menu" role="menu">
                         <li><a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a esta Dirección</a></li>
                     </ul>
                </li>
                 <li>
                       <a href="<?php echo base_url(); ?>Direcciones/Interno/ReportesDirInt"><i class="fa fa-book"></i> Reportes</a>
                   </li>

                   <li>
                      <a target="_blank" href="<?php 
                      if ($this->session->userdata('nivel') == 2) {
                        echo 'http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_direcciones_de_area.pdf';
                      }
                      else
                      if($this->session->userdata('nivel') == 6)
                      {
                        echo 'http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_planteles.pdf';
                      }
                      ?>"><i class="fa fa-question-circle"></i> Ayuda</a>
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
                        <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Asignaciones a Departamentos</small>
                    </h2>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Módulo de asignaciones
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
                    <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                        <tr>
                            <th>Folio de asignación</th>
                            <th>Dirección que asigna</th>
                            <th>Departamento asignado</th>
                            <th>Numero de oficio</th>
                            <th>Asunto</th>
                            <th>Emisor</th>
                            <th>Cargo</th>
                            <th>Fecha de Termino</th>
                            <th>Fecha de Asignación</th>
                            <th>Hora de Asignación</th>
                            <th>Observaciones</th>
                            <th>Editar Asignación</th>
                       
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($asignaciones as $row) { 
                            ?>
                            <tr>
                              <td><?php echo $row->id_asignacion_int; ?></td>
                              <td><?php echo $row->nombre_direccion; ?></td>
                              <td><?php echo $row->nombre_area; ?></td>
                              <td><?php echo $row->num_oficio; ?></td>
                              <td><?php echo $row->asunto; ?></td>
                              <td><?php echo $row->emisor; ?></td>
                              <td><?php echo $row->cargo; ?></td>
                              <td><?php echo $row->fecha_termino; ?></td>
                              <td><?php echo $row->hora_asignacion; ?></td>
                              <td><?php echo $row->fecha_asignacion; ?></td>
                              <td><?php echo $row->obsinternas; ?></td>
                                <td>
                                  <button type="button" onclick="editarAsignacion('<?php echo $row->id_asignacion_int; ?>','<?php echo $row->nombre_area; ?>');" class="form-control btn btn-warning" >
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
      <form enctype="multipart/form-data" role="form" method="POST" name="frmModAsignacion" action="<?php echo base_url(); ?>Direcciones/Interno/Asignaciones/editarAsignacion">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="id_asignacion">

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
            <label>Director que asigna</label>
            <input name="dir_asigna" class="form-control" placeholder="Ej. Dirección de Planeación" value="<?php echo $this->session->userdata('nombre'); ?>" required disabled>
          </div>

          <input  type="hidden" name="iddir"  value="<?php echo $this->session->userdata('id_direccion'); ?>">

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
  function editarAsignacion(idasignacion, departamento)
  {

    document.frmModAsignacion.id_asignacion.value = idasignacion;
    document.frmModAsignacion.area_destino.value = departamento;
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