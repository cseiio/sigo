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
                   <li >
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/PanelPlanteles"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles"><i class="fa fa-plus"></i> Oficios de Salida</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/TurnadoCopiasDependencias"><i class="fa fa-plus"></i> Copias Turnadas a Dependencias</a>
                    </li>

                      <li class="active">
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
            <?php echo $this->session->userdata('nombre_direccion'); ?>  <small> Respuestas a oficios externos</small>
          </h2>
          <ol class="breadcrumb">
            <li class="active">
              <i class="fa fa-dashboard"></i> Módulo de visualización de respuestas a oficios externos 
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
                <th>Folio de Respuesta</th>
                <th>Número de Oficio</th>
                <th>Código Archivístico</th>
                <th>Asunto</th>
                <th>Tipo de Recepción</th>
                <th>Emisor del oficio</th>
                <th>Dependencia</th>
                <th>Cargo</th>
                <th>Fecha de Emisión Física</th>
                <th>Hora de Emisión Física</th>
                <th>Oficio emitido</th>
                <th>Num. Oficio de Respuesta</th>
                 <th>Fecha de Respuesta Física</th>
                <th>Hora de Respuesta Física</th>
                <th>Funcionario que responde el oficio</th>
                <th>Cargo</th>
                <th>Dependencia</th>
                <th>Archivo de Respuesta</th>
                <th>Anexos</th>
                <th>Fecha de Subida</th>
                <th>Hora de Subida</th>
              </tr>
            </thead >
            <tbody style="font-size:smaller; font-weight: bold ;">
              <?php foreach ($res_salidas as $row) { 
                ?>
                <tr>
                  <td><?php echo $row->id_oficio_salida; ?></td>
                  <td><?php echo $row->num_oficio; ?></td>
                  <td><?php echo $row->codigo; ?></td>
                  <td><?php echo $row->asunto; ?></td>
                  <td><?php echo $row->tipo_respuesta; ?></td>
                  <td><?php echo $row->emisor; ?></td>
                  <td><?php echo $row->bachillerato; ?></td>
                  <td><?php echo $row->cargoemisor; ?></td>
                  <td><?php echo $row->fecha_emision; ?></td>
                  <td><?php echo $row->hora_emision; ?></td>
                 <td>
                            <a href="<?php echo base_url()?>Direcciones/Externos/Planteles/RecepcionPlanteles/DescargarSalidas/<?php echo $row->archivo; ?>">
                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                         </a>
                     </td>
                     
                  <td><?php echo $row->num_oficio_salida; ?></td>
                  <td><?php echo $row->fecha_respuesta; ?></td>
                  <td><?php echo $row->hora_respuesta; ?></td>
                  <td><?php echo $row->emisor; ?></td>
                  <td><?php echo $row->cargo; ?></td>
                  <td><?php echo $row->dependencia_emisor; ?></td>
                  <td>
                    <a href="<?php echo base_url()?>Direcciones/Externos/Planteles/Respuesta_salidas/DescargarRespuesta/<?php echo $row->acuse_respuesta; ?>">
                     <img src="<?php echo base_url(); ?>assets/img/respuesta.png" alt="Descargar">
                   </a>
                 </td>

                 <!-- ANEXOS DescargarRespuesta -->
                 <td>
                  <a href="<?php echo base_url()?>Direcciones/Externos/Planteles/Respuesta_salidas/DescargarAnexos/<?php echo $row->anexos; ?>">
                   <img src="<?php echo base_url(); ?>assets/img/anexos.png" alt="Descargar">
                 </a>
               </td>
               
               <td><?php echo $row->fecha_subida; ?></td>
               <td><?php echo $row->hora_subida; ?></td>
               
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
