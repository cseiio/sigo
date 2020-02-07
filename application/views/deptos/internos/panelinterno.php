

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
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesInternos"><i class="fa fa-clock-o"></i> Pendientes</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/ContestadosInterno"><i class="fa fa-check-circle"></i> Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoInterno"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosInterno"><i class="fa  fa-times-circle"></i> No Contestados</a>
                        </li>

                        <li>
                          <a href="<?php echo base_url(); ?>Departamentos/Interno/Informativos"><i class="fa  fa-info-circle"></i> Informativos</a>
                      </li>

                      <li class="dropdown">
                        <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                        <ul class="dropdown-menu" role="menu">
                         <li><a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a este Departamento</a></li>
                     </ul>
                 </li>

                 <li>
                     <a href="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt"><i class="fa fa-book"></i> Reportes</a>
                 </li>

                  <li>
          <a target="_blank" href="http://192.168.0.116/sigo/manuales/manual_de_operacion_sigo_departamentos.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
        </li>

             </ul>
         </div>
         <!-- /.navbar-collapse -->
     </div>
 </nav>
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
            <a class="navbar-brand" href="<?php echo base_url(); ?>Departamentos/PanelDeptos">SGOCSEIIO</a>
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
                <li class="active">
                    <a href="<?php echo base_url(); ?>Departamentos/PanelDeptos">Inicio</a>
                  </li>

                  <li class="dropdown">
                      <a href="#" data-toggle="dropdown" data-hover="dropdown" ><i class="fa fa-arrow-down"></i> Recepción de Oficios Internos</a>
                      <ul class="dropdown-menu" role="menu">
                        <li >
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesInternos"><i class="fa fa-clock-o"></i> Pendientes</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/ContestadosInterno"><i class="fa fa-check-circle"></i> Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoInterno"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosInterno"><i class="fa  fa-times-circle"></i> No Contestados</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/Informativos"><i class="fa  fa-info-circle"></i> Informativos</a>
                        </li>


                        <li><a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a esta Dirección</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown" ><i class="fa fa-arrow-up"></i> Oficios Emitidos</a>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesEmitidos"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/RespuestasEmitidos"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoEmitidos"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosEmitidos"><i class="fa fa-times-circle"></i> No Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/InformativosEmitidos"><i class="fa  fa-info-circle"></i> Informativos</a>
                    </li>


                    <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>

                    <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>

                </ul>
            </li>

            <li>
             <a href="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt"><i class="fa fa-book"></i> Reportes Recepcion</a>
         </li>

     </ul>
 </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Encabezado -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $this->session->userdata('nombre_direccion'); ?> <small>Panel Principal de Oficios Internos</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Incio
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            
   
            
            <hr>
        
            

            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->