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

                    <li class="active">
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/NoContestados"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>
                    
                    <li>
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
                    <?php echo $this->session->userdata('descripcion'); ?> <small>Oficios No Contestados</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Oficios No Contestados
                    </li>
                </ol>
            </div>
        </div>

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
                        <th>Número de Oficio</th>
                        <th>Asunto</th>
                        <th>Tipo de Recepción</th>
                        <th>Funcionario que emite</th>
                        <th>Cargo</th>
                        <th>Dependencia</th>
                        <th>Dirección de Destino</th>
                        <th>Fecha de Termino</th>
                        <th>Archivo del emisor</th>
                        <th>Estatus</th>
                        <th>Días Restantes</th>
                        <th>Área responsable de responder oficio</th>
                    </tr>
                </thead >
                <tbody style="font-size:smaller; font-weight: bold ;">
                    <?php foreach ($nocontestados as $row) { ?>
                    <tr>
                        <td><?php echo $row->id_recepcion; ?></td>
                        <td><?php echo $row->num_oficio; ?></td>
                        <td><?php echo $row->asunto; ?></td>
                        <td><?php echo $row->tipo_recepcion; ?></td>
                        <td><?php echo $row->emisor; ?></td>
                        <td><?php echo $row->cargo; ?></td>
                        <td><?php echo $row->dependencia_emite; ?></td>
                        <td><?php echo $row->nombre_direccion; ?></td>
                        <td><?php echo $row->fecha_termino; ?></td>
                        <td>
                            <a href="<?php echo base_url()?>RecepcionGral/Entradas/Pendientes/Descargar/<?php echo $row->archivo_oficio; ?>">
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
                        date_default_timezone_set('America/Mexico_City');
                        $hoy = date('Y-m-d');

                        $date1 = $hoy;
                        $date2 = $row->fecha_termino;
                        $diff = abs(strtotime($date2) - strtotime($date1));

                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                        if ($date2 < $date1) {
                         printf("Se han agotado los días de respuesta");
                         $row->status == 'No Contestado';
                     }

                     else
                        if ( $row->status == 'Contestado') {
                         printf("El oficio ya fue respondido");
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


                    if ($date2 < $date1) {
                       printf("Se han agotado los días de respuesta");
                   }

                   else
                    if ( $row->status == 'Contestado') {
                       printf("El oficio ya fue respondido");
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
            <?php if ($row->flag_deptos == 1) {

                $this -> load -> model('Modelo_recepcion');
                $nombre_depto = $this -> Modelo_recepcion -> getAsignacionById($row->id_recepcion);
                foreach ($nombre_depto as $nombre) {
                    echo "Oficio asignado al ".$nombre->nombre_area;
                }

            } 
            else if ($row->flag_deptos == 0) {
                printf($row->nombre_direccion);
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


<div class="modal fade" id="modalAlertas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Emitir alerta</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/emitirAlertasNC">
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