

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

                <li class="dropdown active">
                  <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                  <ul class="dropdown-menu" role="menu">

                   <li><a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                   <li><a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                 </ul>
               </li>

               <li>
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
                            <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Copias emitidas a Direcciones</small>
                        </h2>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Módulo de copias emitidas a direcciones
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                                <!-- /.row -->
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
                            <th>Folio</th>
                            <th>Número de oficio</th>
                            <th>Asunto</th>
                            <th>Emisor de la copia</th>
                            <th>Receptor de la copia</th>
                            <th>Oficio</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead >
                        <tbody style="font-size:smaller; font-weight: bold ;">
                                <?php foreach ($copias_dir as $row) { 
                                    ?>
                               <tr>
                                <td><?php echo $row->id_recepcion_int; ?></td>
                                <td><?php echo $row->num_oficio; ?></td>
                                <td><?php echo $row->asunto; ?></td>
                                <td><?php echo $row->emisor; ?></td>  
                                <td><?php echo $row->nombre_direccion; ?></td> 
                                <td>
                                    <a href="<?php echo base_url()?>Direcciones/Interno/BuzonInterno/Descargar/<?php echo $row->archivo_oficio; ?>">
                                       <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                                   </a>
                               </td>
                               <td><?php echo $row->observacion; ?></td>                         
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