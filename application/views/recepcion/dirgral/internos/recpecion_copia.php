    <script type="text/javascript">
      
              
    </script>
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
                  <a class="navbar-brand" href="<?php 
                  if ($this->session->userdata('nivel') == 2) {
                    echo base_url().'Direcciones/PanelDir';
                  }
                  else
                    if($this->session->userdata('nivel') == 6)
                    {
                      echo base_url().'Direcciones/Externos/Planteles/PanelPlanteles';
                    }
                    ?>">SGOCSEIIO</a>
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
                      <li >
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                      </li>

                      <li class="active">
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                      </li>

                      <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/RespuestasEmitidos"><i class="fa fa-plus"></i> Respuestas a Oficios Emitidos</a>
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

                      <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
                      </li>
                      <li class="dropdown">
                        <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                        <ul class="dropdown-menu" role="menu">
                         <li><a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a esta Dirección</a></li>
                         <li><a href="<?php echo base_url(); ?>Direcciones/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                         <li><a href="<?php echo base_url(); ?>Direcciones/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                       </ul>
                     </li>
                     <li>
                       <a href="<?php echo base_url(); ?>Direcciones/Interno/ReportesDirInt"><i class="fa fa-book"></i> Reportes</a>
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
                        <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Oficios Emitidos por la Dirección</small>
                      </h1>
                      <ol class="breadcrumb">
                        <li class="active">
                          <i class="fa fa-dashboard"></i> Oficios Emitidos
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


                    <div align="right" class="row">
                     <div class="col-lg-12">
                       <button type="button" onclick="mostrarNuevoOficio();"  class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                        <strong>Nuevo Oficio</strong>
                      </button>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-hover table-responsive">
                      <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; ">
                        <tr>
                          <th>Folio</th>
                          <th>Número de Oficio</th>
                          <th>Fecha de Emisión Física</th>
                          <th>Hora de Emisión Física</th>
                          <th>Asunto</th>
                          <th>Tipo de Recepción</th>
                          <th>Tipo de Documento</th>
                          <th>Funcionario que emite</th>
                          <th>Cargo</th>
                          <th>Dirección a donde se dirige el oficio</th>
                          <th>Fecha de Termino</th>
                          <th>Archivo</th>
                          <th>Fecha de Acuse</th>
                          <th>Hora de Acuse </th> 
                          <th>Observaciones</th>
                          <th>Días Restantes</th>
                          <th>Fecha de Subida</th>
                          <th>Hora de Subida</th>
                          <th>Editar</th>
                          <th>C.c.p Direcciones</th>
                          <th>Copias turnadas a direcciones</th>
                          <th>C.c.p Departamentos</th>
                          <th>Copias turnadas a departamentos</th>
                        </tr>
                      </thead >
                      <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($entradas as $row) { 
                          ?>
                          <tr>
                            <td><?php echo $row->id_recepcion_int; ?></td>
                            <td><?php echo $row->num_oficio; ?></td>
                            <td><?php echo $row->fecha_emision; ?></td>
                            <td><?php echo $row->hora_emision; ?></td>
                            <td><?php echo $row->asunto; ?></td>
                            <td><?php echo $row->tipo_recepcion; ?></td>
                            <td><?php echo $row->tipo_documento; ?></td>
                            <td><?php echo $row->emisor; ?></td>
                            <td><?php echo $row->cargo; ?></td>
                             <?php  if ($row->status == 'Informativo') { ?>
                             <td><?php //echo 'Es informativo' 
                                  $this -> load -> model('Modelo_direccion');
                                       $query = $this->Modelo_direccion->getAllInformativosByNumOficio($row->num_oficio);
                                       foreach ($query as $key) {
                                           echo $key->nombre_direccion.',';
                                       }
                                ?></td>
                               
                                <?php } 
                                    else { ?>
                                
                                 <td><?php echo $row->nombre_direccion; ?></td>
                                
                                 <?php } ?>
                            <td><?php echo $row->nombre_direccion; ?></td>

                            <td><?php echo $row->fecha_termino; ?></td>
                            <td>
                              <a href="<?php echo base_url()?>Direcciones/Interno/RecepcionInterna/Descargar/<?php echo $row->archivo_oficio; ?>">
                               <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                             </a>
                           </td>
                           <td><?php echo $row->fecha_acuse; ?></td>
                           <td><?php echo $row->hora_acuse; ?></td>
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
                             printf("Oficio contestado fuera de tiempo");
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
                            if ($row->tipo_dias == 1) {

                              date_default_timezone_set('America/Mexico_City');
                              $hoy = date('Y-m-d');

                              $date1 = $hoy;
                              $date2 = $row->fecha_termino;
                              $dias_habiles = getDiasHabiles($date1 , $date2);

                              if ( $row->status == 'Fuera de Tiempo') {
                               printf("Oficio contestado fuera de tiempo");
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

                            ?>        
                          </td>
                          <td><?php echo $row->fecha_subida; ?></td>
                          <td><?php echo $row->hora_subida; ?></td>
                          <td>
                            <button type="button" onclick="EditarOficio('<?php echo $row->id_recepcion_int; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_recepcion; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->emisor; ?>','<?php echo $row->direccion_destino; ?>','<?php echo $row->fecha_termino; ?>','<?php echo $row->status; ?>','<?php echo $row->prioridad; ?>','<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
                             <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                           </button>
                         </td>
                         <td>
                          <button type="button" onclick="mostrarTurnadoDirecciones('<?php echo $row->id_recepcion_int; ?>');" class="form-control btn btn-warning btn-sm">
                           <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Direcciones
                         </button>
                       </td>

                       <td>
                        <?php 

                        $this -> load -> model('Modelo_direccion');
                        $nombre_direccion = $this -> Modelo_direccion -> getBuzonDeCopiasDirById($row->id_recepcion_int);
                        foreach ($nombre_direccion as $nombre) {
                          echo $nombre->nombre_direccion."\n\n";
                        }
                        ?>
                      </td>

                      <td>
                        <button type="button" onclick="mostrarTurnadoDepartamentos('<?php echo $row->id_recepcion_int; ?>');" class="form-control btn btn-primary btn-sm">
                         <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Deptos  
                       </button>
                     </td>

                     <td>
                      <?php 

                      $this -> load -> model('Modelo_direccion');
                      $nombre_depto = $this -> Modelo_direccion -> getBuzonDeCopiasDeptoById($row->id_recepcion_int);
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


    <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 align="center" class="modal-title">Registrar Oficio</h4>
          </div>
          <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/agregarEntrada">
            <div class="col-lg-12">
              <br>

              <!-- Numero de oficio: -->
              <div class="form-group has-feedback">
                <label for="noficio" class="control-label">Número de Oficio</label>
                <div class="input-group">
                  <span class="input-group-addon"></span>
                  <input name="num_oficio" id="noficio" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
                </div>  
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div> 
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
                  <option value="Interno">Interno</option>
                </select>
              </div>

              <div class="form-group">
                <label>Tipo de Documento</label>
                <select class="form-control" name="tipo_documento">
                 <option value="Memorandúm">Memorandúm</option>
                 <option value="Oficio">Oficio</option>
                 <option value="Circular">Circular</option>
               </select>
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

            <hr>
            <div class="form-group has-feedback">
              <label for="turnadoDirecto" class="control-label">¿Requiere turnar directamente el oficio a algún departamento?</label>
              <div class="input-group">
                <label class="radio-inline">
                  <input type="radio" id="habilitar" name="turnadoDirecto" value="1">Si
                </label>
                <label class="radio-inline">
                  <input type="radio" id="deshabilitar" name="turnadoDirecto" value="0" >No (Solo direcciones)
                </label>
              </div>
            </div>
            <hr>

            <script>

              $( document ).ready(function() {
                $("#selecciones_individuales2").hide();
                $("#selecciones_multiples2").hide();
              });
              
              $(document).ready(function() {
                $("#habilitar").click(function() {
                  $("#selecciones_individuales2").show();
                  $("#selecciones_multiples2").hide();

                });

                $("#deshabilitar").click(function() {
                 $("#selecciones_multiples2").show();
                 $("#selecciones_individuales2").hide();

               });
              });
            </script>

            <!-- HABILITAR METODO DE ENVIO MULTIPLE -->
            <div id="selecciones_multiples2">
              <div class="form-group">
                <label>Selección Multiple de Direcciones</label>
                <select style="height: 400px; width: auto;" class="form-control" id="dirinternos" name="direccion[]" multiple>
                  <option value="1">Dirección General</option>
                  <option value="2">Dirección Administrativa</option>
                  <option value="3">Dirección de Estudios Superiores</option>
                  <option value="4">Dirección de Planeación</option>
                  <option value="5">Unidad Jurídica</option>
                  <option value="6">Unidad de Acervo</option>
                  <option value="10">BIC 01 GUELATAO DE JUÁREZ</option>
                  <option value="11">BIC 02 SANTA MARIA ALOTEPEC</option>
                  <option value="12">BIC 03 ELOXOCHITLÁN DE FLORES MAGÓN</option>
                  <option value="13">BIC 04 SANTA MARIA CHIMALAPA</option>
                  <option value="14">BIC 05 SANTIAGO CHOAPAM</option>
                  <option value="15">BIC 06 SAN CRISTOBAL LACHIRIOAG</option>
                  <option value="16">BIC 07 SANTIAGO NUYOO</option>
                  <option value="17">BIC 08 SANTA MARÍA NUTIO</option>
                  <option value="18">BIC 09 SANTIAGO XOCHILTEPEC</option>
                  <option value="19">BIC 11 MAZATLÁN VILLA DE FLORES</option>
                  <option value="20">BIC 12 SAN MIGUEL CHIMALAPA</option>
                  <option value="21">BIC 13 SANTIAGO XANICA</option>
                  <option value="22">BIC 14 JALTEPEC DE CANDAYOC</option>
                  <option value="23">BIC 15 SAN ANTONIO HUITEPEC</option>
                  <option value="24">BIC 16 SANTO DOMINGO TEPUXTEPEC</option>
                  <option value="25">BIC 17 SANTIAGO LALOPA </option>
                  <option value="26">BIC 18 SAN AGUSTÍN TLACOTEPEC</option>
                  <option value="27">BIC 19 SANTA MARÍA TEOPOXCO</option>
                  <option value="28">BIC 20 SAN PEDRO SOCHIAPAM</option>
                  <option value="29">BIC 21 SANTIAGO IXTAYUTLA</option>
                  <option value="30">BIC 22 SAN JOSÉ DE LAS FLORES</option>
                  <option value="31">BIC 23 SAN BARTOLOMÉ AYAUTLA</option>
                  <option value="32">BIC 24 SANTIAGO TETEPEC</option>
                  <option value="33">BIC 25 SAN MARTÍN PERAS</option>
                  <option value="34">BIC 26 SAN ANDRÉS SOLAGA </option>
                  <option value="35">BIC 27 ÁLVARO OBREGÓN</option>
                  <option value="36">BIC 28 SANTOS REYES PAPALO</option>
                  <option value="37">BIC 29 TEOTITLÁN DEL VALLE</option>
                  <option value="38">BIC 30 SAN JERONIMO NUCHITA</option>
                  <option value="39">BIC 31 SAN MIGUEL AHUEAHUETITLAN</option>
                  <option value="40">BIC 32 SANTIAGO XOCHILTEPEC</option>
                  <option value="41">BIC 33 LÁZARO CARDENAS</option>
                  <option value="42">BIC 34 SAN LORENZO CUAUNECUITITLA</option>
                  <option value="43">BIC 35 SAN VICENTE COATLÁN</option>
                  <option value="44">BIC 36 EL CARRIZAL</option>
                  <option value="45">BIC 37 LLANO VIBORA</option>
                  <option value="46">BIC 38 ARROYO SÚCHIL</option>
                  <option value="47">BIC 39 SANTA MARIA TEMAXCALAPA</option>
                  <option value="48">BIC 40 SAN BARTOLOMÉ ZOOGOCHO</option>
                  <option value="49">BIC 41 BENITO JUÁREZ</option>
                  <option value="50">BIC 42 EL GACHUPÍN</option>
                  <option value="51">BIC 43 LA BLANCA </option>
                  <option value="52">BIC 44 SANTA MARÍA YAVICHE</option>
                  <option value="53">BIC 45 SAN PEDRO ÑUMI </option>
                  <option value="54">BI 46 COATECAS ALTAS</option>
                  <option value="55">BI 47 LA VENTOSA</option>
                  <option value="56">BI 48 AQUILES SERDÁN </option>
                  <option value="57">BI 49 SAN MIGUEL LACHIXOLA</option>
                  <option value="58">UESA</option>
                </select>
                <span class="label label-danger">*Para hacer una selección multiple, deja presiona la tecla 'Crtl', mientras das clic en las direcciones.</span>
              </div>

          </div>
 
          <div id="selecciones_individuales2">
              <div class="form-group">
                <label>Selección Individual de Dirección</label>
                <select class="form-control" id="dirinternos_single" name="dirinternos_single" >
                  <option value="1">Dirección General</option>
                  <option value="2">Dirección Administrativa</option>
                  <option value="3">Dirección de Estudios Superiores</option>
                  <option value="4">Dirección de Planeación</option>
                  <option value="5">Unidad Jurídica</option>
                  <option value="6">Unidad de Acervo</option>
                  <option value="10">BIC 01 GUELATAO DE JUÁREZ</option>
                  <option value="11">BIC 02 SANTA MARIA ALOTEPEC</option>
                  <option value="12">BIC 03 ELOXOCHITLÁN DE FLORES MAGÓN</option>
                  <option value="13">BIC 04 SANTA MARIA CHIMALAPA</option>
                  <option value="14">BIC 05 SANTIAGO CHOAPAM</option>
                  <option value="15">BIC 06 SAN CRISTOBAL LACHIRIOAG</option>
                  <option value="16">BIC 07 SANTIAGO NUYOO</option>
                  <option value="17">BIC 08 SANTA MARÍA NUTIO</option>
                  <option value="18">BIC 09 SANTIAGO XOCHILTEPEC</option>
                  <option value="19">BIC 11 MAZATLÁN VILLA DE FLORES</option>
                  <option value="20">BIC 12 SAN MIGUEL CHIMALAPA</option>
                  <option value="21">BIC 13 SANTIAGO XANICA</option>
                  <option value="22">BIC 14 JALTEPEC DE CANDAYOC</option>
                  <option value="23">BIC 15 SAN ANTONIO HUITEPEC</option>
                  <option value="24">BIC 16 SANTO DOMINGO TEPUXTEPEC</option>
                  <option value="25">BIC 17 SANTIAGO LALOPA </option>
                  <option value="26">BIC 18 SAN AGUSTÍN TLACOTEPEC</option>
                  <option value="27">BIC 19 SANTA MARÍA TEOPOXCO</option>
                  <option value="28">BIC 20 SAN PEDRO SOCHIAPAM</option>
                  <option value="29">BIC 21 SANTIAGO IXTAYUTLA</option>
                  <option value="30">BIC 22 SAN JOSÉ DE LAS FLORES</option>
                  <option value="31">BIC 23 SAN BARTOLOMÉ AYAUTLA</option>
                  <option value="32">BIC 24 SANTIAGO TETEPEC</option>
                  <option value="33">BIC 25 SAN MARTÍN PERAS</option>
                  <option value="34">BIC 26 SAN ANDRÉS SOLAGA </option>
                  <option value="35">BIC 27 ÁLVARO OBREGÓN</option>
                  <option value="36">BIC 28 SANTOS REYES PAPALO</option>
                  <option value="37">BIC 29 TEOTITLÁN DEL VALLE</option>
                  <option value="38">BIC 30 SAN JERONIMO NUCHITA</option>
                  <option value="39">BIC 31 SAN MIGUEL AHUEAHUETITLAN</option>
                  <option value="40">BIC 32 SANTIAGO XOCHILTEPEC</option>
                  <option value="41">BIC 33 LÁZARO CARDENAS</option>
                  <option value="42">BIC 34 SAN LORENZO CUAUNECUITITLA</option>
                  <option value="43">BIC 35 SAN VICENTE COATLÁN</option>
                  <option value="44">BIC 36 EL CARRIZAL</option>
                  <option value="45">BIC 37 LLANO VIBORA</option>
                  <option value="46">BIC 38 ARROYO SÚCHIL</option>
                  <option value="47">BIC 39 SANTA MARIA TEMAXCALAPA</option>
                  <option value="48">BIC 40 SAN BARTOLOMÉ ZOOGOCHO</option>
                  <option value="49">BIC 41 BENITO JUÁREZ</option>
                  <option value="50">BIC 42 EL GACHUPÍN</option>
                  <option value="51">BIC 43 LA BLANCA </option>
                  <option value="52">BIC 44 SANTA MARÍA YAVICHE</option>
                  <option value="53">BIC 45 SAN PEDRO ÑUMI </option>
                  <option value="54">BI 46 COATECAS ALTAS</option>
                  <option value="55">BI 47 LA VENTOSA</option>
                  <option value="56">BI 48 AQUILES SERDÁN </option>
                  <option value="57">BI 49 SAN MIGUEL LACHIXOLA</option>
                  <option value="58">UESA</option>
                </select>
               
              </div>

              <div class="form-group">
              </select>
              <label for="deptos_combo" class="control-label">Departamentos del CSEIIO: </label>
              <div>
                <select class="form-control" name="deptos_combo" id="deptos_combo">
                 
                </select>
              </div>
            </div>

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
         <input type="time" id="hora_acuse" name="hora_acuse"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
       </div>
       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
       <div class="help-block with-errors"></div>  
     </div>


     <div class="form-group">
      <label>Tipo de días para termino</label>
      <select class="form-control" name="tipo_dias">
        <option value="1">Días Hábiles</option>
        <option value="0">Días Naturales</option>
      </select>
    </div>

    <div class="form-group has-feedback">
      <label for="fecha_termino" class="control-label">Fecha de Termino</label>
      <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="date" id="fecha_termino" name="fecha_termino" class="form-control" required>
      </div>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors"></div>
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


<!-- MODAL PARA EDITAR LA INFORMACION DEL OFICIO -->

<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
      </div>
      <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/ModificarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio_a" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
          </div>


          <div class="form-group">
            <label>Asunto</label>
            <input name="asunto_a" class="form-control" placeholder="Ej. Solicitud de Información" required>
          </div>

          <div class="form-group">
            <label>Tipo de Recepción</label>
            <select class="form-control" name="tipo_recepcion_a">
              <option value="Interno">Interno</option>
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

          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
          </div>

          <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">


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
            </select>
          </div>


          <div class="form-group">
            <label>Tipo de días para termino</label>
            <select class="form-control" name="tipo_dias_a">
              <option value="1">Días Hábiles</option>
              <option value="0">Días Naturales</option>
            </select>
          </div>

          <div class="form-group">
            <label>Fecha de Termino</label>
            <input type="date" name="fecha_termino_a" class="form-control" required>
          </div>


          <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="status_a">
              <option value="Pendiente">Pendiente</option>
              <option value="Contestado">Contestado</option>
              <option value="Fuera de Tiempo">Contestado Fuera de Timpo</option>
              <option value="No Contestado">No Contestado</option>
            </select>
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
      <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDir" action="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/TurnarCopiaDir">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">


          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
          </div>

          <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">


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
      <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/TurnarCopiaDeptos">
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

<!-- JAVASCRITP PARA MOSTRAR MODALES -->
<script type="text/javascript">

 function mostrarNuevoOficio()
 {
  $('#modalNuevo').modal('show');
}

function mostrarTurnadoDirecciones(id)
{
  document.frmTurnarDir.txt_idoficio.value = id;
  $('#modalDir').modal('show');
}

function mostrarTurnadoDepartamentos(id)
{
  document.frmTurnarDepto.txt_idoficio.value = id;
  $('#modalDeptos').modal('show');
}

function EditarOficio(id,num_oficio, asunto, tipo_recepcion,  tipo_documento, emisor, direccion, fecha_termino,status, prioridad, observaciones)
{
  document.frmEditarOficio.txt_idoficio.value = id;
  document.frmEditarOficio.num_oficio_a.value = num_oficio;
  document.frmEditarOficio.asunto_a.value = asunto;
  document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
  document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
  document.frmEditarOficio.emisor_h.value = emisor;
  document.frmEditarOficio.direccion_a.value = direccion;
  document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
  document.frmEditarOficio.status_a.value = status;
  document.frmEditarOficio.prioridad_a.value = prioridad;
  document.frmEditarOficio.observaciones_a.value = observaciones;

  $('#modalActualizar').modal('show');
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
