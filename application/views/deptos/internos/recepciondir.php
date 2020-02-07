            <?php date_default_timezone_set('America/Mexico_City'); ?>
              <script>
            // DIRECCION DE PLANEACIÓN
            $(function() {
              habilitarplan();
              $("#dirplaneacion").click(habilitarplan);
            });

            function habilitarplan() {
              if (this.checked) {
                $("input.deptoplan").removeAttr("disabled");
              } else {
                $("input.deptoplan").attr("disabled", true);
              }
            }
              // DIRECCION DE ADMINISTRATIVA
            $(function() {
              habilitaradmin();
              $("#diradmin").click(habilitaradmin);
            });

            function habilitaradmin() {
              if (this.checked) {
                $("input.deptoadmin").removeAttr("disabled");
              } else {
                $("input.deptoadmin").attr("disabled", true);
              }
            }

               // DIRECCION DE ESTUDIOS SUPERIORES
            $(function() {
              habilitaruesa();
              $("#uesa").click(habilitaruesa);
            });

            function habilitaruesa() {
              if (this.checked) {
                $("input.deptouesa").removeAttr("disabled");
              } else {
                $("input.deptouesa").attr("disabled", true);
              }
            }

                 // DIRECCION DE DESARROLLO ACADEMICO
            $(function() {
              habilitardda();
              $("#diracad").click(habilitardda);
            });

            function habilitardda() {
              if (this.checked) {
                $("input.deptoacad").removeAttr("disabled");
              } else {
                $("input.deptoacad").attr("disabled", true);
              }
            }

            // ACTIVAR TODAS LAS DIRECCIONES
            $(function() {
              habilitardirs();
              $("#activadirs").click(habilitardirs);
            });

            function habilitardirs() {
              if (this.checked) {
                $("input.dircseiio").prop("checked",true);
                $("input.deptoplan").removeAttr("disabled");
                $("input.deptoadmin").removeAttr("disabled");
                $("input.deptouesa").removeAttr("disabled");
                $("input.deptoacad").removeAttr("disabled");
              } else {
                $("input.dircseiio").prop("checked",false);
                $("input.deptoplan").attr("disabled", true);
                $("input.deptoadmin").attr("disabled", true);
                $("input.deptouesa").attr("disabled", true);
                $("input.deptoacad").attr("disabled", true);
              }
            }
            // ACTIVAR TODOS LOS PLANTELES
            $(function() {
              habilitaplanteles();
              $("#activaplan").click(habilitaplanteles);
            });

            function habilitaplanteles() {
              if (this.checked) {
                $("input.plantel").prop("checked",true);
              
              } else {
                $("input.plantel").prop("checked",false);
             
              }
            }

           // ACTIVAR TODOS LOS DEPTOS
            $(function() {
              habilitadeptos();
              $("#activadeptos").click(habilitadeptos);
            });

            function habilitadeptos() {
              if (this.checked) {
                $("input.deptoplan").prop("checked",true);
                $("input.deptoadmin").prop("checked",true);
                $("input.deptouesa").prop("checked",true);
                $("input.deptoacad").prop("checked",true);
              } else {
                $("input.deptoplan").prop("checked",false);
                $("input.deptoadmin").prop("checked",false);
                $("input.deptouesa").prop("checked",false);
                $("input.deptoacad").prop("checked",false);
              }
            }
            
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
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesEmitidos"><i class="fa fa-clock-o"></i> Pendientes Emitidos</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/RespuestasEmitidos"><i class="fa fa-check-circle"></i> Contestados Emitidos</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoEmitidos"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo Emitidos</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosEmitidos"><i class="fa fa-times-circle"></i> No Contestados Emitidos</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>Departamentos/Interno/InformativosEmitidos"><i class="fa  fa-info-circle"></i> Informativos Emitidos</a>
                </li>

                <li class="dropdown">
                  <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                  <ul class="dropdown-menu" role="menu">
                   <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>

                   <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                 </ul>
               </li>

               <li>
                 <a href="<?php echo base_url(); ?>Departamentos/Interno/ReportesEmitidos"><i class="fa fa-book"></i> Reportes</a>
               </li>

                <li>
          <a target="_blank" href="http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_departamentos.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
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
              <?php 
              foreach ($infodepto as $row) {
                echo $row->nombre_area;
              }
              ?> <small>Oficios Emitidos</small>
            </h2>
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
                <span class="label label-danger">Oficio No Contestado</span>

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
         <strong>
          <p style="text-align: center;">Tabla de emisión</p>
        </strong>
        <div class="table-responsive">
          <table id="tabla" class="table table-bordered table-hover table-responsive">
            <thead style="background-color:#4d8585; color:#FFFFFF; font-size: smaller; ">
                <tr>
                    <th>Folio</th>
                    <th>Número de Oficio</th>
                    <th>Fecha de Emisión Física</th>
                    <th>Hora de Emisión Física</th>
                    <th>Asunto</th>
                    <th>Tipo de Recepción</th>
                    <th>Tipo de Documento</th>
                    <th>Emisor</th>
                    <th>Dirección de Destino</th>
                    <th>Fecha de Termino</th>
                    <th>Archivo</th> 
                    <th>Fecha de Acuse</th>
                    <th>Hora de Acuse </th>  
                    <th>Código Archivístico</th>
                    <th>Valores primarios</th>
                    <th>Vigencia</th>
                    <th>Tipo de documento archivístico</th>
                    <th>Clasificación</th>                    
                    <th>Observaciones</th>
                    <th>Días Restantes</th>
                    <th>Fecha de Subida del Oficio al Sistema</th>
                    <th>Hora de Subida del Oficio al Sistema</th>
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

                        <?php  if ($row->status == 'Informativo') { ?>

                             <td><?php //echo 'Es informativo' 
                             $is_informativo='si'; 
                             $this -> load -> model('Modelo_direccion');
                             $query = $this->Modelo_direccion->getAllInformativosByNumOficio($row->num_oficio);
                             foreach ($query as $key) {
                               echo $key->nombre_direccion.',';
                             }
                             ?></td>

                             <?php } 
                             else { 
                              $is_informativo='no'; ?>

                                <td>
                                      <?php 
                                      $this -> load -> model('Modelo_direccion');
                                      $query = $this->Modelo_direccion->getAllsByNumOficio($row->num_oficio);
                                      foreach ($query as $key) {
                                       echo $key->nombre_direccion.',';
                                     }
                                     ?>

                                   </td>

                             <?php } ?>
                                <td><?php if($row->status == 'Informativo')
                                  {
                                     printf("Oficio informativo, no requiere respuesta");
                                  }
                                  else
                                  {
                                    echo $row->fecha_termino;
                                  }
                                   ?></td>
                        <td>
                            <a href="<?php echo base_url()?>Direcciones/Interno/RecepcionInterna/Descargar/<?php echo $row->archivo_oficio; ?>">
                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                         </a>
                     </td>
                    <td><?php echo $row->fecha_acuse; ?></td>
                    <td><?php echo $row->hora_acuse; ?></td>
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
                            if ($row->status == 'Informativo') {
                                  printf("Oficio informativo, no requiere respuesta");
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
                                if ($row->status == 'Informativo') {
                                  printf("Oficio informativo, no requiere respuesta");
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

                            ?>        
                          </td>
            <td><?php echo $row->fecha_subida; ?></td>
            <td><?php echo $row->hora_subida; ?></td>
            <td>
              <button type="button" onclick="EditarOficio('<?php echo $row->id_recepcion_int; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_recepcion; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->emisor; ?>','<?php 
                if($row->status == 'Informativo'){
                  $this -> load -> model('Modelo_direccion');
                  $query = $this->Modelo_direccion->getAllInformativosByNumOficio($row->num_oficio);
                  foreach ($query as $key) {
                   echo $arraydir[] =$key->direccion_destino;
                 }
               }else{
                $this -> load -> model('Modelo_direccion');
                $query = $this->Modelo_direccion->getAllsByNumOficio($row->num_oficio);
                foreach ($query as $key) {
                 echo $arraydir[] =$key->direccion_destino;
               }
             }
             ?>','<?php echo $row->fecha_termino; ?>','<?php echo $row->prioridad; ?>','<?php echo $is_informativo; ?>','<?php 

             $this -> load -> model('Modelo_direccion');
             $query = $this->Modelo_direccion->getAllAsignacionesInternas($row->id_recepcion_int);


             ?>','<?php echo $row->num_oficio_id; ?>','<?php echo $row->codigo_archivistico; ?>','<?php echo $row->valor_doc; ?>','<?php echo $row->vigencia_doc; ?>','<?php echo $row->tipo_doc_archivistico; ?>','<?php echo $row->clasificacion_info; ?>','<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
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
  <style>
    #mdialTamanio{
      width: 100% !important;
    }
  </style>


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
  <div class="modal-dialog" id="mdialTamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar Oficio</h4>
    </div>
    <form data-toggle="validator"  enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficioDeptos" action="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/agregarEntrada">
        <div class="col-lg-12">
          <br>


          <!-- Numero de oficio: -->
             <div class="form-group has-feedback">
            <label for="noficio" class="control-label">Número de Oficio</label>
            <div class="input-group">
              <span class="input-group-addon"></span>
              <input name="num_oficio" id="noficio" class="form-control" placeholder="Ej. MEMORANDUM-CSEIIO-DP-0001-2018" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
            <span class="label label-danger">*El formato del número de oficio debe ser el siguiente: MEMORANDUM-CSEIIO-DP-0001-2018.</span>
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
            <label>Tipo de Emisión</label>
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

    <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">


                <div class="form-group has-feedback">
              <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
              <div class="input-group">
                <label class="radio-inline">
                  <input type="radio" onclick="enable();" name="ReqRespuesta" value="1" required>Si
                </label>
                <label class="radio-inline">
                  <input type="radio" onclick="disable();" name="ReqRespuesta" value="0" required>No
                </label>
              </div>
            </div>

          <script>
            function disable() {
              document.getElementById("fecha_termino_div").style.display = "none";
              document.getElementById("tipo_dias_div").style.display = "none";
            //tipo_dias
          }
          function enable() {
            document.getElementById("fecha_termino_div").style.display = "block";
            document.getElementById("tipo_dias_div").style.display = "block";
          }
        </script>

           <div>
              <label for="tieneRespuesta" class="control-label">Direcciones y Departamentos de destino</label>
            <div class="container">

    
              <div class="row">
                <div class="col-md-4">
                 <fieldset>
                  <legend>Dirección General</legend>
                  <input type="checkbox" name="direccion[]" class="dircseiio" id="dirgral" value="1">
                  Dirección General<br>
                </fieldset>
              </div>

              <div class="col-md-4">
                <fieldset>
                  <legend>Unidad de Acervo</legend>
                  <input type="checkbox" name="direccion[]" class="dircseiio" id="acervo" value="6">
                  Unidad de Acervo<br>
                </fieldset>
              </div>
              <div class="col-md-4">
               <fieldset>
                <legend>Unidad Jurídica</legend>
                <input type="checkbox" name="direccion[]" class="dircseiio" id="ujuridica" value="5">
                Unidad Jurídica<br>
              </fieldset>
            </div>
          </div>
          <br>


             <div class="row">

              <div class="col-md-6">
               <fieldset>
                <legend>Dirección de Planeación</legend>
                <input type="checkbox" name="direccion[]" class="dircseiio" id="dirplaneacion" value="4">
                  Dirección de Planeación<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="deptoplan" value="12">
                  Departamento de Control Escolar<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoplan" value="13">
                  Departamento de Tecnología y Comunicación<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoplan" value="14">
                  Departamento de Estadística y Evaluación<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoplan" value="15">
                  Departamento de Infraestructura, Programación y Presupuesto<br></li>
                  </ul>
              </fieldset>
            </div>

            <div class="col-md-6">
              <fieldset>
                <legend>Dirección de Administrativa</legend>
                 <input type="checkbox" name="direccion[]" class="dircseiio" id="diradmin" value="2">
                  Dirección Administrativa<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="deptoadmin" value="8">
                  Departamento de Recursos Humanos<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoadmin" value="9">
                  Departamento de Contabilidad y Presupuesto<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoadmin" value="10">
                  Departamento de Bienes y Servicios Generales y Patrimonio<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoadmin" value="11">
                  Departamento de Recursos Financieros<br></li>
                  </ul>
              </fieldset>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <fieldset>
                <legend>Dirección de Estudios Superiores</legend>
                <input type="checkbox" name="direccion[]" class="dircseiio" id="uesa" value="3">
                  Dirección de Estudios Superiores<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="deptouesa" value="21">
                  Departamento de Publicaciones de Estudios Superiores<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptouesa" value="19">
                  Departamento de Proyectos Especiales UESA<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptouesa" value="20">
                  Departamento Académico de Estudios Superiores<br></li>

                  </ul>
              </fieldset>
            </div>
            <div class="col-md-6">
             <fieldset>
              <legend>Dirección de Desarrollo Académico</legend>
              <input type="checkbox" name="direccion[]" class="dircseiio" id="diracad" data-error="Seleccione al menos una dirección"  value="7">
                  Dirección de Desarrollo Académico<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="22">
                  Departamento de Académias<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="16">
                  Departamento de Vinculación y Servicios Comunitarios<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="17">
                  Departamento de Extensión Educativa<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="32">
                  Departamento de Diseño Curricular<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="18">
                  Departamento de Seguimiento y Evaluación <br></li>
                  <li><input type="checkbox" name="deptos[]"  class="deptoacad" value="7">
                  Sudirección de Programas Educativos <br></li>
                  </ul>
            </fieldset>
          </div>
        </div>

      
      <br>
      <div class="row">
        <div class="col-md-12">
         <fieldset>
          <legend>Planteles</legend>
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="10">
          BIC 01&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="11">
          BIC 02&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="12">
          BIC 03&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="13">
          BIC 04&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="14">
          BIC 05&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="15">
          BIC 06 &nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="16">
          BIC 07&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="17">
          BIC 08&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="18">
          BIC 09 &nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="19">
          BIC 11&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="20">
          BIC 12&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="21">
          BIC 13&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="22">
          BIC 14&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="23">
          BIC 15&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="24">
          BIC 16&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="25">
          BIC 17&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="26">
          BIC 18&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="27">
          BIC 19 &nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="28">
          BIC 20&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="29">
          BIC 21&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="30">
          BIC 22&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="31">
          BIC 23&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="32">
          BIC 24 &nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="33">
          BIC 25&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="34">
          BIC 26&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="35">
          BIC 27&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="36">
          BIC 28&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="37">
          BIC 29&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="38">
          BIC 30&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="39">
          BIC 31&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="40">
          BIC 32&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="41">
          BIC 33&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="42">
          BIC 34&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="43">
          BIC 35&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="44">
          BIC 36&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="45">
          BIC 37&nbsp; 
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="46">
          BIC 38&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="47">
          BIC 39 &nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="48">
          BIC 40&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="49">
          BIC 41&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="50">
          BIC 42&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="51">
          BIC 43&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="52">
          BIC 44&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="53">
          BIC 45&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="54">
          BI 46&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="55">
          BI 47&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="56">
          BI 48&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="57">
          BI 49&nbsp;
          <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="58">
          UESA<br>
           <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="59">
          CECAM<br>
        </fieldset>
      </div>

    </div>
    <br>
    <div class="row">
      <div class="col-md-4">
        <input type="checkbox" name="activadirs"  id="activadirs" >
        Todas las direcciones&nbsp;
      </div> 
      <div class="col-md-4">
        <input type="checkbox" name="activaplan"  id="activaplan" >
        Todos los planteles&nbsp;
      </div>
      <div class="col-md-4">
        <input type="checkbox" name="activadeptos"  id="activadeptos" >
        Todos los departamentos&nbsp;
      </div> 
    </div>

    </div>
    </div>
    <hr>

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


    <div id="tipo_dias_div" style="display: block;" class="form-group">
        <label>Tipo de días para termino</label>
        <select class="form-control" name="tipo_dias">
            <option value="1">Días Hábiles</option>
            <option value="0">Días Naturales</option>
        </select>
    </div>

 <div id="fecha_termino_div" style="display: block;" class="form-group has-feedback">
      <label for="fecha_termino" class="control-label">Fecha de Termino</label>
      <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="date" id="fecha_termino" name="fecha_termino" class="form-control" >
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
  <div class="modal-dialog" id="mdialTamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
      </div>
      <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/ModificarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group">
            <label>Número de Oficio</label>
            <input name="num_oficio_ac" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required disabled>
          </div>
          
           <input type="hidden" name="num_oficio_a" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>


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


          <div class="form-group has-feedback">
              <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
              <div class="input-group">
                <label class="radio-inline">
                  <input type="radio" onclick="enable_a();" name="ReqRespuesta_a" value="1" required>Si
                </label>
                <label class="radio-inline">
                  <input type="radio" onclick="disable_a();" name="ReqRespuesta_a" value="0" required>No
                </label>
              </div>
            </div>

          <script>
            function disable_a() {
              document.getElementById("fecha_termino_div_a").style.display = "none";
              document.getElementById("tipo_dias_div_a").style.display = "none";
            //tipo_dias
          }
          function enable_a() {
            document.getElementById("fecha_termino_div_a").style.display = "block";
            document.getElementById("tipo_dias_div_a").style.display = "block";
          }
        </script>


         <!--  <div class="form-group">
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
          </div> -->

     <div>
              <label for="tieneRespuesta" class="control-label">Direcciones y Departamentos de destino</label>
            <div class="container">

    
              <div class="row">
                <div class="col-md-4">
                 <fieldset>
                  <legend>Dirección General</legend>
                  <input type="checkbox" name="direccion_a[]" class="dircseiio" id="dirgral" value="1">
                  Dirección General<br>
                </fieldset>
              </div>

              <div class="col-md-4">
                <fieldset>
                  <legend>Unidad de Acervo</legend>
                  <input type="checkbox" name="direccion_a[]" class="dircseiio" id="acervo" value="6">
                  Unidad de Acervo<br>
                </fieldset>
              </div>
              <div class="col-md-4">
               <fieldset>
                <legend>Unidad Jurídica</legend>
                <input type="checkbox" name="direccion_a[]" class="dircseiio" id="ujuridica" value="5">
                Unidad Jurídica<br>
              </fieldset>
            </div>
          </div>
          <br>


             <div class="row">

              <div class="col-md-6">
               <fieldset>
                <legend>Dirección de Planeación</legend>
                <input type="checkbox" name="direccion_a[]" class="dircseiio" id="dirplaneacion" value="4">
                  Dirección de Planeación<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="" value="12">
                  Departamento de Control Escolar<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="13">
                  Departamento de Tecnología y Comunicación<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="14">
                  Departamento de Estadística y Evaluación<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="15">
                  Departamento de Infraestructura, Programación y Presupuesto<br></li>
                  </ul>
              </fieldset>
            </div>

            <div class="col-md-6">
              <fieldset>
                <legend>Dirección de Administrativa</legend>
                 <input type="checkbox" name="direccion_a[]" class="dircseiio" id="diradmin" value="2">
                  Dirección Administrativa<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="" value="8">
                  Departamento de Recursos Humanos<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="9">
                  Departamento de Contabilidad y Presupuesto<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="10">
                  Departamento de Bienes y Servicios Generales y Patrimonio<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="11">
                  Departamento de Recursos Financieros<br></li>
                  </ul>
              </fieldset>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <fieldset>
                <legend>Dirección de Estudios Superiores</legend>
                <input type="checkbox" name="direccion_a[]" class="dircseiio" id="uesa" value="3">
                  Dirección de Estudios Superiores<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="" value="21">
                  Departamento de Publicaciones de Estudios Superiores<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="19">
                  Departamento de Proyectos Especiales UESA<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="20">
                  Departamento Académico de Estudios Superiores<br></li>

                  </ul>
              </fieldset>
            </div>
            <div class="col-md-6">
             <fieldset>
              <legend>Dirección de Desarrollo Académico</legend>
              <input type="checkbox" name="direccion_a[]" class="dircseiio" id="diracad" data-error="Seleccione al menos una dirección"  value="7">
                  Dirección de Desarrollo Académico<br>
                  <ul>
                    <li><input type="checkbox" name="deptos[]"  class="" value="22">
                  Departamento de Académias<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="16">
                  Departamento de Vinculación y Servicios Comunitarios<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="17">
                  Departamento de Extensión Educativa<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="32">
                  Departamento de Diseño Curricular<br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="18">
                  Departamento de Seguimiento y Evaluación <br></li>
                  <li><input type="checkbox" name="deptos[]"  class="" value="7">
                  Sudirección de Programas Educativos <br></li>
                  </ul>
            </fieldset>
          </div>
        </div>

      
      <br>
      <div class="row">
        <div class="col-md-12">
         <fieldset>
          <legend>Planteles</legend>
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="10">
          BIC 01&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="11">
          BIC 02&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="12">
          BIC 03&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="13">
          BIC 04&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="14">
          BIC 05&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="15">
          BIC 06 &nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="16">
          BIC 07&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="17">
          BIC 08&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="18">
          BIC 09 &nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="19">
          BIC 11&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="20">
          BIC 12&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="21">
          BIC 13&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="22">
          BIC 14&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="23">
          BIC 15&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="24">
          BIC 16&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="25">
          BIC 17&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="26">
          BIC 18&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="27">
          BIC 19 &nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="28">
          BIC 20&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="29">
          BIC 21&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="30">
          BIC 22&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="31">
          BIC 23&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="32">
          BIC 24 &nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="33">
          BIC 25&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="34">
          BIC 26&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="35">
          BIC 27&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="36">
          BIC 28&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="37">
          BIC 29&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="38">
          BIC 30&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="39">
          BIC 31&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="40">
          BIC 32&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="41">
          BIC 33&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="42">
          BIC 34&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="43">
          BIC 35&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="44">
          BIC 36&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="45">
          BIC 37&nbsp; 
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="46">
          BIC 38&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="47">
          BIC 39 &nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="48">
          BIC 40&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="49">
          BIC 41&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="50">
          BIC 42&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="51">
          BIC 43&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="52">
          BIC 44&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="53">
          BIC 45&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="54">
          BI 46&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="55">
          BI 47&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="56">
          BI 48&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="57">
          BI 49&nbsp;
          <input type="checkbox" name="direccion_a[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="58">
          UESA<br>
           <input type="checkbox" name="direccion[]"  class="plantel" data-error="Seleccione al menos una dirección"  value="59">
          CECAM<br>
        </fieldset>
      </div>

    </div>
    <br>


    </div>
    </div>
    <hr>

     <div id="tipo_dias_div_a" style="display: block;" class="form-group">
      <label>Tipo de días para termino</label>
      <select class="form-control" name="tipo_dias_a">
        <option value="1">Días Hábiles</option>
        <option value="0">Días Naturales</option>
      </select>
    </div>

    <div id="fecha_termino_div_a" style="display: block;" class="form-group has-feedback">
      <label for="fecha_termino" class="control-label">Fecha de Termino</label>
      <div class="input-group">
        <span class="input-group-addon"></span>
        <input type="date" id="fecha_termino_a" name="fecha_termino_a" class="form-control" >
      </div>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors"></div>
    </div>

          <div class="form-group">
           <?php 
           echo "<p><label for='codigo_archivistico_a'>Código Archivístico </label>";
           echo "<select class='form-control' name='codigo_archivistico_a' id='codigo_archivistico_a'>";
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
     echo "<select class='form-control' name='tipo_doc_archivistico_a' id='tipo_doc_archivistico_a'>";
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
              <input type="file" id="archivof" name="archivo" class="form-control">

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
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDir" action="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/TurnarCopiaDir">
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
                   <option value="10">BIC 01</option>
              <option value="11">BIC 02</option>
              <option value="12">BIC 03</option>
              <option value="13">BIC 04</option>
              <option value="14">BIC 05</option>
              <option value="15">BIC 06</option>
              <option value="16">BIC 07</option>
              <option value="17">BIC 08</option>
              <option value="18">BIC 09</option>
              <option value="19">BIC 11</option>
              <option value="20">BIC 12</option>
              <option value="21">BIC 13</option>
              <option value="22">BIC 14</option>
              <option value="23">BIC 15</option>
              <option value="24">BIC 16</option>
              <option value="25">BIC 17</option>
              <option value="26">BIC 18</option>
              <option value="27">BIC 19</option>
              <option value="28">BIC 20</option>
              <option value="29">BIC 21</option>
              <option value="30">BIC 22</option>
              <option value="31">BIC 23</option>
              <option value="32">BIC 24</option>
              <option value="33">BIC 25</option>
              <option value="34">BIC 26</option>
              <option value="35">BIC 27</option>
              <option value="36">BIC 28</option>
              <option value="37">BIC 29</option>
              <option value="38">BIC 30</option>
              <option value="39">BIC 31</option>
              <option value="40">BIC 32</option>
              <option value="41">BIC 33</option>
              <option value="42">BIC 34</option>
              <option value="43">BIC 35</option>
              <option value="44">BIC 36</option>
              <option value="45">BIC 37</option>
              <option value="46">BIC 38</option>
              <option value="47">BIC 39</option>
              <option value="48">BIC 40</option>
              <option value="49">BIC 41</option>
              <option value="50">BIC 42</option>
              <option value="51">BIC 43</option>
              <option value="52">BIC 44</option>
              <option value="53">BIC 45</option>
              <option value="54">BIC 46</option>
              <option value="55">BIC 47</option>
              <option value="56">BIC 48</option>
              <option value="57">BIC 49</option>
               <option value="58">UESA</option>
               <option value="59">CECAM</option>
            </select>
        </div>


        <div class="form-group">
            <label>Observaciones</label>
            <input name="observaciones_a" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia"  required>
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
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/TurnarCopiaDeptos">
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
            <li class="active"><a data-toggle="tab" href="#memos">N° de Memorandúms usados</a></li>
            <li><a data-toggle="tab" href="#oficios">N° de Oficios usados</a></li>
            <li><a data-toggle="tab" href="#circular">N° de Circular usados</a></li>
          </ul>
          
          <div class="tab-content">
            <div id="memos" class="tab-pane fade in active">
             <table id="tabla" class="table table-bordered table-hover table-responsive">
              <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                 
                  <th>Números de Memorandúm</th>
                </tr>
              </thead >
              <tbody style="font-size:smaller; font-weight: bold ;">
                <?php 
                  $i =1;
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

          <div id="oficios" class="tab-pane fade">
            <table id="tabla" class="table table-bordered table-hover table-responsive">
              <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                
                  <th>Números de Oficio</th>
                </tr>
              </thead >
              <tbody style="font-size:smaller; font-weight: bold ;">
                <?php 
                
                foreach ($nums_oficio as $row) { 
                  ?>
                  <tr>
                   
                    <td><?php echo $row->num_oficio; ?></td>
                  </tr>
                <?php 
              } ?>
              </tbody>
            </table>
          </div>

          <div id="circular" class="tab-pane fade">
            <table id="tabla" class="table table-bordered table-hover table-responsive">
              <thead style="background-color:#50C1C1; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                
                  <th>Números de Circular</th>
                </tr>
              </thead >
              <tbody style="font-size:smaller; font-weight: bold ;">
                <?php 
           
                foreach ($nums_circular as $row) { 
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
 
function mostrarModalNumsOficio() {
     $('#modalNumsOficio').modal('show');
 }

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

function EditarOficio(id,num_oficio, asunto, tipo_recepcion,  tipo_documento, emisor, direccion, fecha_termino, prioridad, is_informativo, asignaciones, num_oficio_id, codigo_archivistico, valor_doc, vigencia_doc, tipo_doc_archivistico, clasificacion_info, observaciones)
{


 if (is_informativo == 'no') 
 {
  document.frmEditarOficio.txt_idoficio.value = id;
  document.frmEditarOficio.num_oficio_a.value = num_oficio;
    document.frmEditarOficio.num_oficio_ac.value = num_oficio;
  document.frmEditarOficio.asunto_a.value = asunto;
  document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
  document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
  document.frmEditarOficio.emisor_h.value = emisor;
  //GetAsignacionesDirecciones
  // for (x=0;x<direccion.length;x++){ 
  //   $("input[name^=direccion_a][value='"+direccion[x]+"']").prop("checked",true);
  // }
// var cadena;
// cadena = getCleanedString(num_oficio);
// console.log(cadena);

   var xmlhttpdirs = new XMLHttpRequest();
    var urldirs = "<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/GetAsignacionesDirecciones/"+num_oficio_id+"";
    xmlhttpdirs.onreadystatechange=function() {
     if (xmlhttpdirs.readyState == 4 && xmlhttpdirs.status == 200) {
       var arraydir = JSON.parse(xmlhttpdirs.responseText);
       var i;
       for(i = 0; i < arraydir.length; i++) {
         //console.log(array[i].id_area);
         $("input[name^=direccion_a][value='"+arraydir[i].direccion_destino+"']").prop("checked",true);
       }
       
     }
   }
   xmlhttpdirs.open("GET", urldirs, true);
   xmlhttpdirs.send()

  document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
  document.frmEditarOficio.prioridad_a.value = prioridad;
  //Solicitud ajax
   var xmlhttp = new XMLHttpRequest();
    var url = "<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/GetAsignaciones/"+id+"";
    xmlhttp.onreadystatechange=function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
       var array = JSON.parse(xmlhttp.responseText);
       var i;
       for(i = 0; i < array.length; i++) {
         //console.log(array[i].id_area);
         $("input[name^=deptos][value='"+array[i].id_area+"']").prop("checked",true);
       }
       
     }
   }
   xmlhttp.open("GET", url, true);
   xmlhttp.send()
   document.frmEditarOficio.codigo_archivistico_a.value = codigo_archivistico;
   document.frmEditarOficio.valor_doc_a.value = valor_doc;
   document.frmEditarOficio.vigencia_doc_a.value = vigencia_doc;
   document.frmEditarOficio.tipo_doc_archivistico_a.value = tipo_doc_archivistico;
   document.frmEditarOficio.clasificacion_info_a.value = clasificacion_info;
  document.frmEditarOficio.observaciones_a.value = observaciones;
  $('#modalActualizar').modal('show');
}
else
  if(is_informativo == 'si') {
    document.frmEditarOficio.txt_idoficio.value = id;
    document.frmEditarOficio.num_oficio_a.value = num_oficio;
    document.frmEditarOficio.num_oficio_ac.value = num_oficio;
    document.frmEditarOficio.asunto_a.value = asunto;
    document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
    document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
    document.frmEditarOficio.emisor_h.value = emisor;
     var xmlhttpdirs = new XMLHttpRequest();
    var urldirs = "<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/GetAsignacionesDirecciones/"+num_oficio_id+"";
    xmlhttpdirs.onreadystatechange=function() {
     if (xmlhttpdirs.readyState == 4 && xmlhttpdirs.status == 200) {
       var arraydir = JSON.parse(xmlhttpdirs.responseText);
       var i;
       for(i = 0; i < arraydir.length; i++) {
         //console.log(array[i].id_area);
         $("input[name^=direccion_a][value='"+arraydir[i].direccion_destino+"']").prop("checked",true);
       }
       
     }
   }
   xmlhttpdirs.open("GET", urldirs, true);
   xmlhttpdirs.send()
    document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
    document.frmEditarOficio.prioridad_a.value = prioridad;
    //Solicitud ajax
    var xmlhttp = new XMLHttpRequest();
   var url = "<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/GetAsignaciones/"+id+"";
    xmlhttp.onreadystatechange=function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
       var array = JSON.parse(xmlhttp.responseText);
       var i;
       for(i = 0; i < array.length; i++) {
        // console.log(array[i].id_area);
         $("input[name^=deptos][value='"+array[i].id_area+"']").prop("checked",true);
       }
       
     }
   }

   xmlhttp.open("GET", url, true);
   xmlhttp.send()
   document.frmEditarOficio.codigo_archivistico_a.value = codigo_archivistico;
   document.frmEditarOficio.valor_doc_a.value = valor_doc;
   document.frmEditarOficio.vigencia_doc_a.value = vigencia_doc;
   document.frmEditarOficio.tipo_doc_archivistico_a.value = tipo_doc_archivistico;
   document.frmEditarOficio.clasificacion_info_a.value = clasificacion_info;
    document.frmEditarOficio.observaciones_a.value = observaciones;

    $('#modalActualizar').modal('show');
  }
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


  $(document).ready(function(){
    $("#btnCerrar").click(function(){
        $("#modalActualizar").modal("hide");
    });
    $("#modalActualizar").on('hidden.bs.modal', function () {
           var dirs = document.getElementsByName('direccion_a[]');
           var deptos = document.getElementsByName('deptos[]');
           for (i=0; i<dirs.length; i++){
            if(dirs[i].checked = true){
                dirs[i].checked = false;
            }
        }
         for (i=0; i<deptos.length; i++){
            if(deptos[i].checked = true){
                deptos[i].checked = false;
            }
        }
    });

});

</script>
<script>
    function enviar(){
     document.frmActualizar.submit();
 }
</script>
