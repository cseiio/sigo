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
                <li>
                    <a href="<?php echo base_url(); ?>Admin/Usuarios/GestUsuarios"><i class="fa fa-user"></i> Gestión de Usuarios</a>
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
                            Inicio <small> Gestión de Usuarios</small>
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
                    <h4 style="text-align: center;">Bienvenid@ al Panel Administrativo de Gestión de Usuarios, donde se ortorga acceso al Sistema de Gestión de Oficios del CSEIIO, para poder dar de alta un usuario, es necesario que se encuentre registrado en el Panel de Empleados, si no visualizas al empleado, puedes darlo de alta, dando clic <a href="<?php echo base_url(); ?>Admin/Empleados/PanelEmpleados">aquí</a>.</h4>    
                </div>
                <hr>
                 <div class="row">
                    <h4 style="text-align: center;">De igual manera, si ya esta registrado el Usuario, se pueden realizar tareas de mantenimiento como edición y eliminación de usuarios. </h4>    
                </div>
             
                </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->