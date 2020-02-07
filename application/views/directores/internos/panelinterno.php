

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
                <li class="active">
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

                  <li class="dropdown">
                      <a href="#" data-toggle="dropdown" data-hover="dropdown" ><i class="fa fa-arrow-down"></i> Recepción de Oficios Internos</a>
                      <ul class="dropdown-menu" role="menu">
                        <li >
                            <a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
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
                            <a href="<?php echo base_url(); ?>Direcciones/Interno/Informativos"><i class="fa  fa-info-circle"></i> Informativos</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>Direcciones/Interno/Asignaciones"><i class="fa fa-hand-o-left"></i> Asignaciones</a>
                        </li>

                        <li><a href="<?php echo base_url(); ?>Direcciones/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a esta Dirección</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown" ><i class="fa fa-arrow-up"></i> Oficios Emitidos</a>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                    </li>
                    
                 <!--    <li>
                        <a href="<?php //echo base_url(); ?>Direcciones/Interno/RespuestasEmitidos"><i class="fa fa-plus"></i> Respuestas a Oficios Emitidos</a>
                    </li> -->

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/PendientesEmitidos"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/RespuestasEmitidos"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/FueraDeTiempoEmitidos"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/NoContestadosEmitidos"><i class="fa fa-times-circle"></i> No Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Direcciones/Interno/InformativosEmitidos"><i class="fa  fa-info-circle"></i> Informativos</a>
                    </li>


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