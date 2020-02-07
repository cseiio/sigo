     <?php date_default_timezone_set('America/Mexico_City');  ?>
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
                    <li class="active">
                        <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles"><i class="fa fa-plus"></i> Oficios de Salida</a>
                    </li>


                    <li>
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
                            <?php echo $this->session->userdata('nombre_direccion'); ?>  <small>Oficios de Salida</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Oficios de Salida
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
                <p style="text-align: center;">Tabla de información de oficios externos</p>
            </strong>
            <div class="table-responsive">
              <table id="tabla" class="table table-bordered table-hover table-responsive">
                <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                    <tr>
                        <th>Folio</th>
                        <th>Número de Oficio</th>
                        <th>Código Archivístico</th>
                        <th>Fecha de Emisión Física</th>
                        <th>Hora de Emisión Física</th>
                        <th>Asunto</th>
                        <th>Tipo de Emisión</th>
                        <th>Tipo de Documento</th>
                        <th>Emisor Principal</th>
                        <th>Dependencia Origen</th>  
                        <th>Cargo</th>
                        <th>Remitente</th>
                        <th>Cargo Remitente</th>
                        <th>Dependencia Remitente</th>
                        <th>Fecha de Acuse</th>
                        <th>Hora de Acuse</th>
                        <th>Estatus</th>
                        <th>Archivo</th>
                        <th>Valores primarios</th>
                        <th>Vigencia</th>
                        <th>Tipo de documento archivístico</th>
                        <th>Clasificación</th>            
                        <th>Observaciones</th>
                        <th>Fecha de Subida del Oficio al Sistema</th>
                        <th>Hora de Subida del Oficio al Sistema</th>
                        <th>Adjuntar Respuesta</th>
                        <th>Operaciones</th>
                        <th>Turnar copias a otras dependencias</th>
                    </tr>
                </thead >
                <tbody style="font-size:smaller; font-weight: bold ;">
                    <?php foreach ($salidas as $row) { 
                        ?>
                        <tr>
                            <td><?php echo $row->id_oficio_salida; ?></td>
                            <td><?php echo $row->num_oficio; ?></td>
                            <td><?php echo $row->codigo; ?></td>
                            <td><?php echo $row->fecha_emision; ?></td>
                            <td><?php echo $row->hora_emision; ?></td>
                            <td><?php echo $row->asunto; ?></td>
                            <td><?php echo $row->tipo_emision; ?></td>
                            <td><?php echo $row->tipo_documento; ?></td>
                            <td><?php echo $row->emisor; ?></td>

                            <td><?php echo $row->bachillerato; ?></td>

                            <td><?php echo $row->cargo; ?></td>
                            <td><?php echo $row->remitente; ?></td>
                            <td><?php echo $row->cargo_remitente; ?></td>
                            <td><?php echo $row->dependencia_remitente; ?></td>
                            <td><?php echo $row->fecha_acuse; ?></td>
                            <td><?php echo $row->hora_acuse; ?></td>
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
                            <a href="<?php echo base_url()?>Direcciones/Externos/Planteles/RecepcionPlanteles/DescargarSalidas/<?php echo $row->archivo; ?>">
                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                         </a>
                     </td>

                     <td><?php echo $row->valor_doc; ?></td>
                     <td><?php echo $row->vigencia_doc; ?></td>
                     <td><?php echo $row->tipo_doc_archivistico; ?></td>
                     <td><?php echo $row->clasificacion_info; ?></td>

                     <td><?php echo $row->observaciones; ?></td>
                     <td><?php echo $row->fecha_subida; ?></td>
                     <td><?php echo $row->hora_subida; ?></td>
                     <?php if ($row->tieneRespuesta == 1 ) { 
                       if($row->fue_respondido == 0 ){?>
                       <td>
                        <button type="button" onclick="mostrarModalRespuestas('<?php echo $row->id_oficio_salida; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->remitente; ?>','<?php echo $row->cargo_remitente; ?>','<?php echo $row->dependencia_remitente; ?>');" class="form-control btn btn-success btn-sm">
                           <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Adjuntar Respuesta
                       </button>
                   </td> 
                   <?php } else { ?>
                   <td>
                       <?php echo "El oficio ya fue contestado"; ?>
                   </td>
                   <?php } ?>
                   <?php } else { ?>
                   <td>
                    <?php echo "El oficio no requiere respuesta"; ?>
                </td>
                <?php } ?>

                <td>
                    <button type="button" onclick="EditarOficio('<?php echo $row->id_oficio_salida; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_emision; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->remitente; ?>','<?php echo $row->cargo_remitente; ?>','<?php echo $row->dependencia_remitente; ?>','<?php echo $row->fecha_acuse; ?>','<?php echo $row->hora_acuse; ?>','<?php echo $row->id_codigo; ?>','<?php echo $row->valor_doc; ?>','<?php echo $row->vigencia_doc; ?>','<?php echo $row->tipo_doc_archivistico; ?>', '<?php echo $row->clasificacion_info; ?>' ,'<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                   </button>
               </td>

               <td>
                  <button type="button" onclick="mostrarTurnadoDependencias('<?php echo $row->id_oficio_salida; ?>');" class="form-control btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Otras dependencias
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

<!-- MODAL DE NUEVA ENTRADA DE OFICIO-->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles/agregarEntrada">
        <div class="col-lg-12">
          <br>

          <input type="hidden" name="id_bachillerato" value="<?php echo $this->session->userdata('id_direccion'); ?>">

          <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="noficio" class="control-label">Número de Oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="num_oficio" id="noficio" class="form-control" placeholder="Ej. OFICIO-BIC01-0001-2018" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
            <span class="label label-danger">*El formato del número de oficio debe ser el siguiente: OFICIO-BIC01-0001-2018.</span>
             <button type="button" onclick="mostrarModalNumsOficio();" class="btn btn-warning btn-sm">
               <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consulta N° de Oficio Usados
           </button>
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
            <label>Tipo de Emisón</label>
            <select class="form-control" name="tipo_emision">
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
            <input name="emisor_principal_v" class="form-control" placeholder="Dirección General" value="<?php echo $this->session->userdata('nombre'); ?>"  required disabled>
        </div>
        
        <input type="hidden" name="emisor_principal" value="<?php echo $this->session->userdata('nombre'); ?>">


        <div class="form-group">
            <label>Bachillerato que emite</label>
            <input name="dependencia_v" class="form-control" value=" <?php echo $this->session->userdata('nombre_direccion'); ?>"  required disabled>
        </div>

        <input type="hidden" name="dependencia" value=" <?php echo $this->session->userdata('nombre_direccion'); ?>">

        <div class="form-group">
            <label>Cargo</label>
            <input name="cargo_v" class="form-control" value=" <?php echo $this->session->userdata('descripcion'); ?>"  required disabled>
        </div>

        <input type="hidden" name="cargo" value=" <?php echo $this->session->userdata('descripcion'); ?>">

        <div class="form-group has-feedback">
            <label for="remitente" class="control-label">Remitente</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="remitente" id="remitente" class="form-control" placeholder="Lic. Juan Jimenez Garnica"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>

        <div class="form-group has-feedback">
            <label for="cargo_remitente" class="control-label">Cargo Remitente</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_remitente" id="cargo_remitente" class="form-control" placeholder="Director de la Secretaria de Asuntos Internos"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="dependencia_remitente" class="control-label">Dependencia Remitente</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="dependencia_remitente" id="dependencia_remitente" class="form-control" placeholder="Secretaria de Asuntos Internos"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>

        <div class="form-group has-feedback">
          <label for="fecha_emision_fisica" class="control-label">Fecha de Emisión Física del Oficio:</label>
          <div class="input-group">
            <span class="input-group-addon"></span>
            <input type="date" id="fecha_emision_fisica" name="fecha_emision_fisica" class="form-control" required>
        </div>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group has-feedback">
      <label for="hora_emision_fisica" class="control-label">Hora de Emisión Física del Oficio:</label>
      <div class="input-group">
       <span class="input-group-addon"></span>
       <input type="time" id="hora_emision_fisica" name="hora_emision_fisica"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
   </div>
   <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
   <div class="help-block with-errors"></div>  
</div>

<div class="form-group has-feedback">
  <label for="fecha_acuse" class="control-label">Fecha de Acuse:</label>
  <div class="input-group">
    <span class="input-group-addon"></span>
    <input type="date" id="fecha_acuse" name="fecha_acuse" class="form-control" required>
</div>
<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
<div class="help-block with-errors"></div>
</div>

<div class="form-group has-feedback">
  <label for="hora_acuse" class="control-label">Hora de Acuse:</label>
  <div class="input-group">
   <span class="input-group-addon"></span>
   <input type="time" id="hora_acuse" name="hora_acuse"  class="form-control"  value="<?php echo date("H:i:s") ?>" required>
</div>
<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
<div class="help-block with-errors"></div>  
</div>


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
    <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
    <div class="input-group">
        <label class="radio-inline">
            <input type="radio" name="ReqRespuesta" value="1">Si
        </label>
        <label class="radio-inline">
            <input type="radio" name="ReqRespuesta" value="0">No
        </label>
    </div>
</div>

<div class="form-group has-feedback">
    <label for="archivo" class="control-label">Archivo Escaneado</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" id="archivo" name="archivo" class="form-control"  required>

    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div>  
    <span class="label label-danger">*El archivo debe estar en formato PDF</span>
    <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
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

<!-- ADJUNTAR RESPUESTA A UN OFICIO -->


<div class="modal fade" id="modalRespuestas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Respuesta a Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRespuesta" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Respuesta_salidas/agregarRespuesta">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <label>Número de Oficio de Salida</label>
            <input name="num_oficio" class="form-control" placeholder="Ej. CDI/DP/078/2017" required disabled>
        </div>

        <input type="hidden" name="num_oficio_h" value="">


        <div class="form-group">
            <label>Asunto</label>
            <input name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required disabled>
        </div>

        <input type="hidden" name="asunto_h" value="">

        <div class="form-group">
            <label>Tipo de Emisión</label>
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
            <label for="noficio" class="control-label">Número de oficio de respuesta exterior</label>

            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="numoficio_salida" id="noficio" class="form-control" placeholder="IAIP/DG/3409/2017" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group">
            <label>Funcionario que emite</label>
            <input name="emisor" class="form-control" placeholder="Ej. Dir Planeación" required disabled>
        </div>

        <div class="form-group">
            <label>Cargo</label>
            <input name="cargo" class="form-control" placeholder="Director de Planeación" required disabled>
        </div>

        <input type="hidden" name="cargo_h">

        <div class="form-group">
            <label>Dependencia</label>
            <input name="dependencia" class="form-control" placeholder="CSEIIO" value="CSEIIO" required disabled>
        </div>

        <input type="hidden" name="dependencia_h" value="CSEIIO">

        <input type="hidden" name="emisor_h">

        <div class="form-group has-feedback">
            <label for="fecha_dependencia" class="control-label">Fecha de Respuesta de la Dependencia</label>
            <div class="input-group">
             <span class="input-group-addon"></span>
             <input type="date" id="fecha_dependencia" name="fecha_dependencia" class="form-control" required>
         </div>
         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
         <div class="help-block with-errors"></div>  
     </div>


     <div class="form-group has-feedback">
        <label for="hora_dependencia" class="control-label">Hora de Respuesta de la Dependencia</label>
        <div class="input-group">
         <span class="input-group-addon"></span>
         <input type="time" id="hora_dependencia" name="hora_dependencia"  class="form-control"  value="<?php echo date("H:i:s") ?>" required>
     </div>
     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     <div class="help-block with-errors"></div>  
 </div>


 <div class="form-group">
    <label>Receptor</label>
    <input name="receptor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre'); ?>" required disabled>
</div>

<input type="hidden" value="<?php echo $this->session->userdata('nombre'); ?>" name="receptor_h">

<div class="form-group">
   <?php 
   echo "<p><label for='codigo_archivistico'>Código Archivístico </label>";
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
    <label for="ofrespuesta_f" class="control-label">Oficio de respuesta</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" id="ofrespuesta_f" name="ofrespuesta" class="form-control"  required>
    </div>
    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    <div class="help-block with-errors"></div> 
    <span class="label label-danger">*El archivo debe estar en formato PDF</span>
    <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
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



<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles/ModificarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio" class="form-control" placeholder="Ej. CSEIIO/DG/178/2017" required>
        </div>


        <div class="form-group">
            <label>Asunto</label>
            <input name="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required>
        </div>

        <div class="form-group">
            <label>Tipo de Emisón</label>
            <select class="form-control" name="tipo_emision">
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
            <label>Remitente</label>
            <input name="remitente" class="form-control" placeholder="Lic. Juan García Garnica"  required>
        </div>

        <div class="form-group">
            <label>Cargo Remitente</label>
            <input name="cargo_remitente" class="form-control" placeholder="Director de la Secretaria de Asuntos Internos"  required>
        </div>

        <div class="form-group">
            <label>Dependencia Remitente</label>
            <input name="dependencia_remitente" class="form-control" placeholder="Director de la Secretaria de Asuntos Internos"  required>
        </div>

        <div class="form-group has-feedback">
            <label for="fecha_acuse_a" class="control-label">Fecha de Acuse de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="date" id="fecha_acuse_a" name="fecha_acuse_a" class="form-control" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group has-feedback">
          <label for="hora_acuse_a" class="control-label">Hora de Acuse de la Dependencia</label>
          <div class="input-group">
             <span class="input-group-addon"></span>
             <input type="time" id="hora_acuse_a" name="hora_acuse_a"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
         </div>
         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
         <div class="help-block with-errors"></div>  
     </div>

     <div class="form-group">
         <?php 
         echo "<p><label for='codigo_archivistico'>Código Archivístico </label>";
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
        <label for="ofrespuesta_f" class="control-label">Oficio de acuse</label>
        <div class="input-group">
            <span class="input-group-addon"></span>
            <input type="file" id="ofrespuesta_f" name="archivo" class="form-control" required="">
        </div>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <div class="help-block with-errors"></div> 
        <span class="label label-danger">*El archivo debe estar en formato PDF</span>
        <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
    </div>

    <div class="form-group">
       <label>Observaciones</label>
       <textarea name="observaciones" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
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
        <h4 align="center" class="modal-title">Turnar Copia a Dependencias</h4>
    </div>
    <form data-toggle="validator"  enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDir" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles/TurnarCopiaDependencias">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">


          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">


        <div class="form-group has-feedback">
            <label for="dependencia" class="control-label">Nombre de la dependencia:</label>
            
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="dependencia" id="dependencia" class="form-control" placeholder="Ej. Regiduria de Asuntos Indígenas" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">

        <div class="form-group has-feedback">
            <label for="observaciones_a" class="control-label">Observaciones:</label>
            
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="observaciones_a" id="observaciones_a" class="form-control" placeholder="Ej. Para su conocimiento" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
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
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles/TurnarCopiaDependencias">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">


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


<div class="modal fade" id="modalNumsOficio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Numeros de Oficio Usados</h4>
    </div>

          <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroDependencia" action="">
        <div class="col-lg-12">
          <br>
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#memos">N° de Oficio Usados</a></li>
          </ul>
          
          <div class="tab-content">
            <div id="memos" class="tab-pane fade in active">
             <table id="tabla" class="table table-bordered table-hover table-responsive">
              <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                 
                  <th>Números de oficio usados</th>
                </tr>
              </thead >
              <tbody style="font-size:smaller; font-weight: bold ;">
                <?php 
                $this -> load -> model('Modelo_direccion');
                $nums_memorandums = $this->Modelo_direccion->getNumsMemorandumsPlantelesGenerales($this->session->userdata('area_trabajo'));
                foreach ($nums_memorandums as $row) { 
                  ?>
                  <tr>
                  
                    <td><?php echo $row->num_oficio; ?></td>
                  </tr>
                <?php
              } ?>
              </tbody>
            </table>
          </div>

        </div>
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

function mostrarModalNumsOficio() {
     $('#modalNumsOficio').modal('show');
 }

function mostrarTurnadoDependencias(id)
{
    document.frmTurnarDir.txt_idoficio.value = id;
    $('#modalDir').modal('show');
}

function mostrarTurnadoDepartamentos(id)
{
    document.frmTurnarDepto.txt_idoficio.value = id;
    $('#modalDeptos').modal('show');
}

function EditarOficio(id,num_oficio, asunto, tipo_emision,  tipo_documento, remitente,cargo_remitente, dependencia_remitente, fecha_acuse, hora_acuse, codigo, valor_doc, vigencia_doc, tipo_doc_archivistico, clasificacion_info, observaciones)
{
    document.frmEditarOficio.txt_idoficio.value = id;
    document.frmEditarOficio.num_oficio.value = num_oficio;
    document.frmEditarOficio.asunto.value = asunto;
    document.frmEditarOficio.tipo_emision.value = tipo_emision;
    document.frmEditarOficio.tipo_documento.value = tipo_documento;
    document.frmEditarOficio.remitente.value = remitente;
    document.frmEditarOficio.cargo_remitente.value = cargo_remitente;
    document.frmEditarOficio.dependencia_remitente.value = dependencia_remitente;
    document.frmEditarOficio.fecha_acuse_a.value = fecha_acuse;
    document.frmEditarOficio.hora_acuse_a.value = hora_acuse;
    document.frmEditarOficio.codigo_archivistico.value = codigo;
    document.frmEditarOficio.valor_doc.value = valor_doc;
    document.frmEditarOficio.vigencia_doc.value = vigencia_doc;
    document.frmEditarOficio.tipo_doc_archivistico.value = tipo_doc_archivistico;
    document.frmEditarOficio.clasificacion_info.value = clasificacion_info;
    document.frmEditarOficio.observaciones.value = observaciones;

    $('#modalActualizar').modal('show');
}
//

function mostrarModalRespuestas(id_oficio_salida, num_oficio, asunto, remitente, cargo, dependencia)
{
    document.frmRespuesta.txt_idoficio.value = id_oficio_salida;
    document.frmRespuesta.num_oficio.value = num_oficio;
    document.frmRespuesta.num_oficio_h.value = num_oficio;
    document.frmRespuesta.asunto.value = asunto;
    document.frmRespuesta.asunto_h.value = asunto;
    document.frmRespuesta.emisor.value = remitente;
    document.frmRespuesta.emisor_h.value = remitente;
    document.frmRespuesta.cargo.value = cargo;
    document.frmRespuesta.cargo_h.value = cargo;
    document.frmRespuesta.dependencia.value = dependencia;
    document.frmRespuesta.dependencia_h.value = dependencia;
    $('#modalRespuestas').modal('show');

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
