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
                <a class="navbar-brand" href="<?php echo base_url(); ?>Admin/PanelAdmin">SGOCSEIIO</a>
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
                        <a href="<?php echo base_url(); ?>Admin/PanelAdmin"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>Admin/Empleados/PanelEmpleados"><i class="fa fa-users"></i> Gestión de Empleados</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Usuarios/PanelUsuarios"><i class="fa fa-user"></i> Gestión Usuarios de Sistema</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Accesos/PanelAccesos"><i class="fa fa-unlock-alt"></i> Control de Accesos</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/PanelOfExternos"><i class="fa fa-chevron-up"></i> Monitor de Oficios Externos</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/PanelOfInternos"><i class="fa fa-chevron-down"></i> Monitor de Oficios Internos</a>
                    </li>
                </ul>
            </div>
            <!-- /.n /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Panel Administrativo <small>Sistema de Gestión de Oficios del CSEIIO</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Incio
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
             
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $empleados_registrados; ?></div>
                                        <div>Total de Empleados Registrados</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Admin/Empleados/PanelEmpleados">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver mas Información</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $usuarios_registrados; ?></div>
                                        <div>Total de Usuarios con Acceso al Sistema</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Admin/Usuarios/GestUsuarios">
                                <div class="panel-footer">
                                    <span class="pull-left">Más Información</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shield fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $accesos; ?></div>
                                        <div>Total de accesos registrados al sistema</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Admin/Accesos/Monitor">
                                <div class="panel-footer">
                                    <span class="pull-left">Más Información</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $externos; ?></div>
                                        <div>Total de oficios registrados en el proceso Externo</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/PanelOfExternos">
                                <div class="panel-footer">
                                    <span class="pull-left">Más Información</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


                  <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $internos; ?></div>
                                        <div>Total de oficios registrados en el proceso Interno</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Admin/Oficios/Internos/PanelOfInternos">
                                <div class="panel-footer">
                                    <span class="pull-left">Más Información</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
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