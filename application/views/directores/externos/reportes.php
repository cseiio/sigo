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
              <li >
                <a href="<?php echo base_url(); ?>Direcciones/PanelDir"><i class="fa fa-desktop"></i> Inicio</a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/RecepcionDir"><i class="fa fa-plus"></i> Recepción de Oficios</a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/PendientesDir"><i class="fa fa-clock-o"></i> Pendientes</a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/ContestadosDir"><i class="fa fa-check-circle"></i> Contestados</a>
              </li>

              <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/ContestadosFueraTiempoDir"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
              </li>

              <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/NoContestadosDir"><i class="fa  fa-times-circle"></i> No Contestados</a>
              </li>
              <?php 
                        //isDepartamento
              if ($this->session->userdata('isDepartamento') == 34) {
                ?>
                <li style="visibility: hidden;">
                  <a href="<?php echo base_url(); ?>Direcciones/Externos/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
                </li>
              <?php }
              else
              {
               ?>
               <li>
                <a href="<?php echo base_url(); ?>Direcciones/Externos/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
              </li>

            <?php } ?>

            <li  class="dropdown">
              <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
              <ul class="dropdown-menu" role="menu">
               <li><a href="<?php echo base_url(); ?>Direcciones/Externos/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a esta Dirección</a></li>
             </ul>
           </li>

           <li class="active">
            <a href="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir"><i class="fa fa-book"></i> Reportes</a>
          </li>

          <li>
            <a target="_blank" href="http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_direcciones_de_area.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
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
          <li><a data-toggle="tab" href="#menu1">Reportes Generales de la <?php echo $this->session->userdata('nombre_direccion'); ?></a></li>
          <?php  if ($this->session->userdata('isDepartamento') == 34) { ?>
           <li style="visibility: hidden;"><a data-toggle="tab" href="#menu2">Reportes por Departamentos de la <?php echo $this->session->userdata('nombre_direccion'); ?></a></li>
           <?php }
                else
                {

            ?>

            <li><a data-toggle="tab" href="#menu2">Reportes por Departamentos de la <?php echo $this->session->userdata('nombre_direccion'); ?></a></li>
            <?php } ?>
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
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados Fuera del Rango Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes Generales de la <?php echo $this->session->userdata('nombre_direccion'); ?></h3>
                <p>Bienvenido al Panel de Reportes Generales de la <?php echo $this->session->userdata('nombre_direccion'); ?> - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados por la dirección</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteAllPorDirecciones">
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

              <div id="generales2" class="tab-pane fade">
                <h3>Total de Oficios Contestados dentro del Rango de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad exterior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteContestadosPorDirecciones">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados</p>
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
                <h3>Total de Oficios Contestados Fuera del Rango Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera del rango de tiempo en la modalidad exterior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteContestadoFueraDeTiempoDir">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios fuera del rango de tiempo</p>
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
                <h3>Total de Oficios Pendientes dentro del Rango de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios pendientes dentro del rango de tiempo, en la modalidad exterior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reportePendientesDir">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes por responder</p>
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

                      <h3>Total de Oficios No Contestados en el Tiempo de Respuesta</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados en la modalidad exterior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/ReportesDir/reporteNoContestadosDir">
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
            </div>
          </div>


                    <!-- REPORTES POR DIRECCIONES -->

          <div id="menu2" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#incioDir">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir2">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir3">Oficios Contestados Fuera del Rango Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#dir5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
            </ul>

            <div class="tab-content">
              <div id="incioDir" class="tab-pane fade in active">
                <h3>Panel de Reportes por Departamentos</h3>
                <p>Bienvenido al Panel de Reportes por Departamentos - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="dir1" class="tab-pane fade">
                <h3>Total de Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados por los departamentos adscritos a la dirección</h4>

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

              <div id="dir2" class="tab-pane fade">
                <h3>Total de Oficios Contestados dentro del Rango de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad exterior</h4>

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

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados</p>

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
                <h3>Total de Oficios Contestados Fuera del Rango Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera de tiempo, en la modalidad exterior</h4>

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

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados fuera de tiempo</p>

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
                <h3>Total de Oficios Pendientes dentro del Rango de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios pendientes por responder, en la modalidad exterior</h4>

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

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes por responder</p>

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

                <h3>Total de Oficios No Contestados en el Tiempo de Respuesta</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados en la modalidad exterior</h4>

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
            </div>
          </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->