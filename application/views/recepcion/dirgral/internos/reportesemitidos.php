     <?php date_default_timezone_set('America/Mexico_City');  ?>
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
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                </li>

                <li >
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/PendientesEmitidos"><i class="fa fa-clock-o"></i> Oficios Emitidos Pendientes</a>
                </li>

                <li >
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/RespuestasEmitidos"><i class="fa fa-plus"></i> Oficios Emitidos Contestados</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/FueraDeTiempoEmitidos"><i class="fa fa-bell-slash"></i> Oficios Emitidos Contestados Fuera de Tiempo</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/NoContestadosEmitidos"><i class="fa  fa-times-circle"></i>Oficios Emitidos No Contestados</a>
                </li>

                <li>
                  <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/InformativosEmitidos"><i class="fa  fa-info-circle"></i>Oficios Emitidos Informativos</a>
                </li>

                <li class="dropdown">
                  <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                  <ul class="dropdown-menu" role="menu">

                   <li><a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                   <li><a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                 </ul>
               </li>

               <li class="active">
                 <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos"><i class="fa fa-book"></i> Reportes</a>
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
                         <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Reportes</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Módulo de impresión de reportes
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
             
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Inicio</a></li>
          <li><a data-toggle="tab" href="#menu1">Oficios Emitidos: <?php echo $this->session->userdata('nombre_direccion'); ?></a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <h3>Panel de Reportes</h3>
            <p>Bienvenido al Panel de Reportes del Sistema de Oficios del CSEIIO</p>
          </div>
          <!-- REPORTES GENERALES -->
          <div id="menu1" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#inicioGeneral">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1"> Oficios Emitidos</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2"> Oficios Emitidos Pendientes</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Emitidos Contestados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios Emitidos Contestados Fuera de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios Emitidos No Contestados</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes Emitidos: <?php echo $this->session->userdata('nombre_direccion'); ?></h3>
                <p>Bienvenido al Panel de Reportes Emitidos: <?php echo $this->session->userdata('nombre_direccion'); ?> - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Emitidos</h3>
                <br>
                <h4>Genera el total de oficios emitidos por la dirección.</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos/reporteEmitidosDireccionesInt">
                  
                  <div class="form-group">

                    <div class="form-group">
                      <label for="dependencia" class="col-lg-2 control-label">Dependencias: </label>
                      <div class="col-lg-6">
                        <!-- Consulta todas las dependencias -->
                        <?php 
                        echo "<select class='form-control' name='dependencia' id='dependencia'>";
                        echo '<option value="todas">Todas</option>';
                        if (count($dependencias)) {
                          foreach ($dependencias as $list) {
                            echo "<option value='". $list->dependencia. "'>" . $list->dependencia . "</option>";
                          }
                        }
                        echo "</select><br/>";
                        ?>
                      </div>
                    </div>

                    <hr>

                        <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios emitidos</p>

                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>

              </div>

              <div id="generales2" class="tab-pane fade">
                <h3>Total de Oficios Pendientes Emitidos</h3>
                <br>
                <h4>Genera el reporte de los oficios pendientes por responder que han sido emitidos a otras direcciones o departamentos.</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos/reportePendientesDireccionesInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes emitidos</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


              <div id="generales3" class="tab-pane fade">
                <h3>Total de Oficios Contestados Emitidos</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados emitidos</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos/reporteContestadosDireccionesInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados emitidos</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


              <div id="generales4" class="tab-pane fade">
                <h3>Total de Oficios Emitidos Contestados Fuera de Tiempos</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera de tiempo.</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos/reporteContestadoFueraDeTiempoDir">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>

              <div id="generales5" class="tab-pane fade">
                <h3>Total de Oficios No Contestados Emitidos</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesEmitidos/reporteNoContestadosDireccionesInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios no contestados</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


                <div id="generales6" class="tab-pane fade">
                <h3>Total de Oficios Contestados Fuera de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad Interior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/ReportesDirInt/reporteContestadoFueraDeTiempoDir">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios fuera de tiempo</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


            </div>
          </div>


                    <!-- REPORTES POR DIRECCIONES -->

          <div id="menu2" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#incioDir">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir1">Total de Oficios</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir2">Total de Oficios Contestados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir3">Total de Oficios No Contestados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir4">Total de Oficios Pendientes </a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir5">Total de Oficios Fuera de Tiempo</a></li>
            </ul>

            <div class="tab-content">
              <div id="incioDir" class="tab-pane fade in active">
                <h3>Panel de Reportes por Departamentos</h3>
                <p>Bienvenido al Panel de Reportes por Departamentos - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="dir1" class="tab-pane fade">
                <h3>Total de Oficios Recibidos</h3>
                <br>
                <h4>Genera el total de oficios recibidos</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteAllPorDepartamento">

                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el Departamento</p>


                  <div class="form-group">
                     <?php 
                     echo "<p><label for='area_destino' class='col-lg-2 control-label'>Departamentos: </label>";
                     echo "<div class='col-lg-6'>";
                     echo "<select class='form-control' name='area_destino' id='area_destino'>";
                     if (count($deptos)) {
                        foreach ($deptos as $list) {
                          echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
                      }
                  }
                  echo "</select></div><br/>";
                  ?>
              </div> 

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>

                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>

              </div>

              <div id="dir2" class="tab-pane fade">
                <h3>Total de Oficios Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad Interior</h4>

                <br>

                    
                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteContestadosPorDepartamento">

                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el Departamento</p>


                  <div class="form-group">
                     <?php 
                     echo "<p><label for='area_destino' class='col-lg-2 control-label'>Departamentos: </label>";
                     echo "<div class='col-lg-6'>";
                     echo "<select class='form-control' name='area_destino' id='area_destino'>";
                     if (count($deptos)) {
                        foreach ($deptos as $list) {
                          echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
                      }
                  }
                  echo "</select></div><br/>";
                  ?>
              </div> 

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>

                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


              <div id="dir3" class="tab-pane fade">
                <h3>Total de Oficios No Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados en la modalidad Interior</h4>

                <br>

    
                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteNoContestadosDepto">

                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el Departamento</p>


                  <div class="form-group">
                     <?php 
                     echo "<p><label for='area_destino' class='col-lg-2 control-label'>Departamentos: </label>";
                     echo "<div class='col-lg-6'>";
                     echo "<select class='form-control' name='area_destino' id='area_destino'>";
                     if (count($deptos)) {
                        foreach ($deptos as $list) {
                          echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
                      }
                  }
                  echo "</select></div><br/>";
                  ?>
              </div> 

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>

                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


              <div id="dir4" class="tab-pane fade">
                <h3>Total de Oficios Pendientes</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad Interior</h4>

                <br>

    
                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reportePendientesDepto">

                 <p style="color: #EF4444; font-weight: bold;">*Seleccione el Departamento</p>


                  <div class="form-group">
                     <?php 
                     echo "<p><label for='area_destino' class='col-lg-2 control-label'>Departamentos: </label>";
                     echo "<div class='col-lg-6'>";
                     echo "<select class='form-control' name='area_destino' id='area_destino'>";
                     if (count($deptos)) {
                        foreach ($deptos as $list) {
                          echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
                      }
                  }
                  echo "</select></div><br/>";
                  ?>
              </div> 

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>

                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>

              <div id="dir5" class="tab-pane fade">
                <h3>Total de Oficios Contestados Fuera de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad Interior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteContestadosFueraDepartamento">

               <p style="color: #EF4444; font-weight: bold;">*Seleccione el Departamento</p>


                  <div class="form-group">
                     <?php 
                     echo "<p><label for='area_destino' class='col-lg-2 control-label'>Departamentos: </label>";
                     echo "<div class='col-lg-6'>";
                     echo "<select class='form-control' name='area_destino' id='area_destino'>";
                     if (count($deptos)) {
                        foreach ($deptos as $list) {
                          echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
                      }
                  }
                  echo "</select></div><br/>";
                  ?>
              </div> 

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>

                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->