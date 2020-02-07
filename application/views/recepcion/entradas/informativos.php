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
      <li>
        <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
    </li>
    <li>
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

    <li class="active">
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

            <div class="container-fluid">
                <br><br><br><br><br><br>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            <?php echo $this->session->userdata('descripcion'); ?>  <small>Oficios Informativos</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Módulo de oficios informativos recibidos
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
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
                                <th>Dirección de Destino</th>
                                <th>Archivo del emisor</th>
                                <th>Editar</th>
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
                                 <td>
                                     <button type="button" onclick="EditarOficio('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_recepcion; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->emisor; ?>','<?php echo $row->direccion_destino; ?>','<?php echo $row->fecha_termino; ?>','<?php echo $row->prioridad; ?>','<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
                                         <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                     </button>
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


<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/ModificarOficioInformativo">
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

       <div class="form-group">
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


    <div class="form-group">
        <label>Tipo de días para termino</label>
        <select class="form-control" name="tipo_dias_a">
            <option value="1">Días Hábiles</option>
            <option value="0">Días Naturales</option>
        </select>
    </div>

    <div class="form-group has-feedback">
        <label for="emisorf" class="control-label">Fecha de Termino</label>
        <div class="input-group">
           <span class="input-group-addon"></span>
           <input type="date" name="fecha_termino_a" class="form-control" required>
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


<div class="form-group has-feedback">
    <label for="archivof" class="control-label">Archivo Escaneado</label>
    <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="file" id="archivof" name="archivo_a" class="form-control"  required>

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


<script type="text/javascript">
    function EditarOficio(id,num_oficio, asunto, tipo_recepcion,  tipo_documento, emisor, direccion, fecha_termino, prioridad, observaciones)
    {
        document.frmEditarOficio.txt_idoficio.value = id;
        document.frmEditarOficio.num_oficio_a.value = num_oficio;
        document.frmEditarOficio.asunto_a.value = asunto;
        document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
        document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
        document.frmEditarOficio.emisor_a.value = emisor;
        document.frmEditarOficio.direccion_a.value = direccion;
        document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
        document.frmEditarOficio.prioridad_a.value = prioridad;
        document.frmEditarOficio.observaciones_a.value = observaciones;

        $('#modalActualizar').modal('show');
    }
</script>