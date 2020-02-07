  
<?php
foreach ($contestadosDatos as $row) {
   
    $mensajes = '<script  type="text/javascript" charset="utf-8" async defer>
    Push.create("Notificación", {
     body: "'.$row->emisor." ha respondido el oficio: ".$row->num_oficio.'",
     icon: "'.base_url()."/assets/img/apple-touch-icon-60x60.png".'"
 });
 </script>';

 echo $mensajes;
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
                 <li class="active">
                    <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion"><i class="fa fa-arrow-down"></i> Oficios de Entrada</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas"><i class="fa fa-arrow-up"></i> Oficios de Salida</a>
                </li>
                    <li class="dropdown">
                      <a href="#" data-toggle="dropdown" data-hover="dropdown" ><i class="fa fa-tag"></i> Correspondencia Interna de Dirección General</a>
                      <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/BuzonInterno"><i class="fa fa-arrow-down"></i> Buzón de oficios internos</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/DirGral/Interno/RecepcionInterna"><i class="fa fa-arrow-up"></i> Oficios Emitidos</a>
                        </li>

                    </ul>
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

    <div class="container-fluid">
        <br><br><br><br>
        <!-- Page Heading -->
        <div  class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    <?php echo $this->session->userdata('descripcion'); ?>  <small>Paneles Estadísticos</small>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Inicio
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <h3 style="text-align: center;">Oficios de Entrada</h3>
            <br>

              <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-envelope fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $pendientes+$nocontestados; ?></div>
                                <div>Pendientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Pendientes">
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
                                <i class="fa fa-times-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $nocontestados; ?></div>
                                <div>No Contestados</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/NoContestados">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
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
                                <i class="fa fa-check-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $contestados; ?></div>
                                <div>Contestados en Tiempo y Forma</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Contestados">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
          

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-orange">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-clock-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $fueratiempo; ?></div>
                                <div>Contestados Fuera de Tiempo</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/ContestadosFueraTiempo">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
                 <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-plus-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $conteoTotal; ?></div>
                                <div>Total de Oficios Recibidos</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-info-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totalinformativos; ?></div>
                                <div>Total de Oficios Informativos</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/OficiosInformativos">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <hr>


        <div class="row">
            <h3 style="text-align: center;">Oficios de Salida</h3>
            <br>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-level-up fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totalsalientes; ?></div>
                                <div>Total de Oficios Salientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
    
        </div>
        
        <hr>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->
