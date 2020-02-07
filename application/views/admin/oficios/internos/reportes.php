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
                    <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/PanelOfInternos"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/PendientesInternos"><i class="fa fa-clock-o"></i> Pendientes</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/ContestadosInterno"><i class="fa fa-check-circle"></i> Contestados</a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/FueraDeTiempoInterno"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/NoContestadosInterno"><i class="fa  fa-times-circle"></i> No Contestados</a>
                </li>
                
                <li class="active">
                   <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt"><i class="fa fa-book"></i> Reportes</a>
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
                          Reportes <small>Sistema de Gestión de Oficios del CSEIIO</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Reportes
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
             
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Inicio</a></li>
          <li><a data-toggle="tab" href="#menu1">Reportes Generales de la en modalidad interna</a></li>
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
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1"> Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios No Contestados en el Tiempo de Respuesta</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales6">Oficios Contestados Fuera del Rango Tiempo</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes Generales en modalidad interna</h3>
                <p>Bienvenido al Panel de Reportes Generales en modalidad interna - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados, provenientes de otras direcciones</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt/reporteAllPorDirecciones">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recepcionados</p>
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
                <h3>Total de Oficios Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt/reporteContestadosDireccionesInt">
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


              <div id="generales4" class="tab-pane fade">
                <h3>Total de Oficios No Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt/reporteNoContestadosDireccionesInt">
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
                <h3>Total de Oficios Pendientes</h3>
                <br>
                <h4>Genera el reporte de los oficios pendientes en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt/reportePendientesDireccionesInt">
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


                <div id="generales6" class="tab-pane fade">
                <h3>Total de Oficios Contestados Fuera de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Admin/Oficios/Internos/ReportesDirInt/reporteContestadoFueraDeTiempoDir">
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