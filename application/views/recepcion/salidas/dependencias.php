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
                        <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas"><i class="fa fa-plus"></i> Oficios de Salida</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Pendientes"><i class="fa fa-check-circle"></i> Pendientes</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/ContestadosFueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li >
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/NoContestados"><i class="fa fa-check-circle"></i> No Contestados</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                    </li>

                    <li class="active">
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Dependencias"><i class="fa fa-building"></i> Dependencias</a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/Reportes"><i class="fa fa-book"></i> Reportes</a>
                    </li>

                    <li>
            <a target="_blank" href="http://cseiio.edu.mx/sigo/manuales/manual_de_operacion_sigo_unidad_central.pdf"><i class="fa fa-question-circle"></i> Ayuda</a>
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
                                <?php echo $this->session->userdata('descripcion'); ?>  <small>Dependencias</small>
                            </h2>
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-dashboard"></i> Módulo de administración de dependencias
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
                <div class="alert alert-danger alert-dismissible" onchange="mostrarModal();" style="text-aling:center; color:#FF1E1E"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> <?php echo validation_errors();  ?>
                </div>
                <?php }
                if ($error) { ?>
                <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong><?php echo $error; ?>
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
                    <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
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

                <div align="right" class="row">
                   <div class="col-lg-12">
                     <button type="button" onclick="mostrarModal();"  class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                        <strong>Nueva Dependencia</strong>
                    </button>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table id="tabla" class="table table-bordered table-hover table-responsive">
                    <thead style="background-color:#B2B2B2; color:#FFFFFF; font-size: smaller; ">
                        <tr>
                            <th>Folio de Dependencia</th>
                            <th>Nombre de Dependencia</th>
                            <th>Titular</th>
                            <th>Cargo</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <td>Página Web</td>
                            <td>Editar</td>
                            <td>Eliminar</td>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($dependencias as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->id_dependencia; ?></td>
                                <td><?php echo $row->nombre_dependencia; ?></td>
                                 <td><?php echo $row->titular; ?></td>
                                <td><?php echo $row->cargo; ?></td>
                                <td><?php echo $row->direccion; ?></td>
                                <td><?php echo $row->telefono; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->pagina_web; ?></td>
                                <td>
                                   <button type="button" onclick="EditarDependencia('<?php echo $row->id_dependencia; ?>','<?php echo $row->nombre_dependencia; ?>','<?php echo $row->cargo; ?>','<?php echo $row->direccion; ?>','<?php echo $row->pagina_web; ?>','<?php echo $row->email; ?>','<?php echo $row->titular; ?>','<?php echo addcslashes($row->telefono,"\\\"\"\n\r"); ?>');" class="form-control btn btn-warning btn-sm">
                                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                   </button>
                             </td>
                             <td>
                                <a href="<?php echo base_url()?>RecepcionGral/Salidas/Dependencias/EliminarDependencia/<?php echo $row->id_dependencia; ?>">
                                 <button type="button" onclick="if(confirma() == false) return false" class="form-control btn btn-danger btn-sm">
                                     <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar 
                                 </button>
                             </a>
                         </td>


                     </tr>
                     <?php } ?>
                 </tbody>
             </table>
         </div>

         <!-- /.row -->
     </div>

 </div>

 <!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar una Nueva Dependencia</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroDependencia" action="<?php echo base_url(); ?>RecepcionGral/Salidas/Dependencias/AgregarDependencia">
        <div class="col-lg-12">
          <br>

          <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="nombre_dependencia" class="control-label">Nombre de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_dependencia" id="nombre_dependencia" class="form-control" placeholder="Ej. Secretaría de Asuntos Indígenas" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="nombre_titular" class="control-label">Nombre del Titular de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_titular" id="nombre_titular" class="form-control" placeholder="Ej. Lic. Anel Méndez Barragán" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="cargo_titular" class="control-label">Cargo del Titular</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_titular" id="cargo_titular" class="form-control" placeholder="Ej. Secretária de Asuntos Indígenas" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>


          <div class="form-group has-feedback">
            <label for="direccion_dependencia" class="control-label">Dirección de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="direccion_dependencia" id="direccion_dependencia" class="form-control" placeholder="Ej. Calle Sauces #123, Col. Fresnos, Edificio 2" required > 
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

         <div class="form-group has-feedback">
            <label for="telefono" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ej. 513455">
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="email" class="control-label">Correo de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Ej. coordinador@cseiio.edu.mx">
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="pagina_web" class="control-label">Página Web</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input  name="pagina_web" id="pagina_web" class="form-control" placeholder="Ej. http://www.sedesoh.com.mx" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <button name="btn_enviar" type="submit" class="btn btn-info">
          <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Dependencia
      </button>

  </div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<!-- ACTUALIZAR -->
<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información de la Dependencia</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmModificarDependencia" action="<?php echo base_url(); ?>RecepcionGral/Salidas/Dependencias/ModificarDependencia">
        <div class="col-lg-12">
          <br>

          <!-- Numero de oficio: -->
          <input type="hidden" name="id_dependencia_a">

          <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="nombre_dependencia_a" class="control-label">Nombre de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_dependencia_a" id="nombre_dependencia_a" class="form-control" placeholder="Ej. Secretaría de Asuntos Indígenas" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="nombre_titular_a" class="control-label">Nombre del Titular de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_titular_a" id="nombre_titular_a" class="form-control" placeholder="Ej. Lic. Anel Méndez Barragán" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="cargo_titular_a" class="control-label">Cargo del Titular</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_titular_a" id="cargo_titular_a" class="form-control" placeholder="Ej. Secretária de Asuntos Indígenas" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>


        <div class="form-group has-feedback">
            <label for="direccion_dependencia_a" class="control-label">Dirección de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="direccion_dependencia_a" id="direccion_dependencia_a" class="form-control" placeholder="Ej. Calle Sauces #123, Col. Fresnos, Edificio 2" required >    
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="telefono_a" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="number" name="telefono_a" id="telefono_a" class="form-control" placeholder="Ej. 513455">
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group has-feedback">
            <label for="email_a" class="control-label">Correo de la Dependencia</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email_a" id="email_a" class="form-control" placeholder="Ej. coordinador@cseiio.edu.mx">
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="pagina_web_a" class="control-label">Página Web</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input  name="pagina_web_a" id="pagina_web_a" class="form-control" placeholder="Ej. http://www.sedesoh.com.mx" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div> 
        </div>

        <button name="btn_enviar" type="submit" class="btn btn-info">
            <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Modificar Información
      </button>

  </div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>

<script type="text/javascript">

    function mostrarModal()
    {
        $('#modal').modal('show');
    }

    function EditarDependencia(id_dependencia, nombre_dependencia, cargo, direccion, pagina_web, email, titular, telefono)
    {
        

        document.frmModificarDependencia.id_dependencia_a.value = id_dependencia;
        document.frmModificarDependencia.nombre_dependencia_a.value = nombre_dependencia;
        document.frmModificarDependencia.nombre_titular_a.value = titular;
        document.frmModificarDependencia.cargo_titular_a.value = cargo;
        document.frmModificarDependencia.direccion_dependencia_a.value = direccion;
        document.frmModificarDependencia.telefono_a.value = telefono;
        document.frmModificarDependencia.pagina_web_a.value = pagina_web;
        document.frmModificarDependencia.email_a.value = email;
      
        $('#modalActualizar').modal('show');
    }

    function confirma(){
        if (confirm("¿Realmente desea eliminarlo?")){ 
        }
        else { 
          return false
      }
  }

</script>