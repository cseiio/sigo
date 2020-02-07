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
                 <li >
                    <a href="<?php echo base_url(); ?>Admin/PanelAdmin"><i class="fa fa-desktop"></i> Inicio</a>
                </li>
                <li class="active">
                    <a href="<?php echo base_url(); ?>Admin/Empleados/Directores"><i class="fa fa-building"></i> Directores de Área</a>
                </li>
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/JefesDepto"><i class="fa fa-users"></i> Jefes de Departamento</a>
                </li>
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/Planteles"><i class="fa fa-university"></i> Directores de plantel</a>
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
                        Directores de Área <small> Gestión de Empleados</small>
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

            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table id="tabla" class="table table-bordered table-hover table-responsive">
                    <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; ">
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>Dirección</th>
                            <th>Cargo</th>
                            <th>Email</th>
                            <th>Email Personal</th>
                            <td>Editar</td>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($directores as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->clave_area; ?></td>
                                <td><?php echo $row->nombre_empleado; ?></td>
                                <td><?php echo $row->nombre_direccion; ?></td>
                                <td><?php echo $row->descripcion; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->email_personal; ?></td>  
                                 <td>
                                    <button type="button" onclick="EditarDirector('<?php echo $row->clave_area; ?>','<?php echo $row->nombre_empleado; ?>','<?php echo $row->direccion; ?>','<?php echo $row->descripcion; ?>','<?php echo $row->email; ?>','<?php echo addcslashes($row->email_personal,"\\\"\"\n\r"); ?>');" class="form-control btn btn-warning btn-sm">
                                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                   </button>
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
<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Empleado</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarUsuario" action="<?php echo base_url(); ?>Admin/Empleados/Directores/EditarDirectorArea">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="clave_area">

          <div class="form-group has-feedback">
            <label for="nombre_empleado" class="control-label">Nombre de Empleado</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_empleado" id="nombre_empleado" class="form-control" placeholder="Nombre Completo del Funcionario" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


          <div class="form-group">
            <label>Dirección</label>
            <select class="form-control" name="direccion_a">
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="descripcion" class="control-label">Cargo</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="descripcion" id="descripcion" class="form-control" placeholder="Cargo del Funcionario" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>

         <div class="form-group has-feedback">
            <label for="email" class="control-label">Email Institucional</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Correo Institucional" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>

        <div class="form-group has-feedback">
            <label for="email_personal" class="control-label">Email Personal</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email_personal" id="email_personal" class="form-control" placeholder="Correo Personal" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>

        <button name="btn_enviar_a" type="submit" class="btn btn-info">
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


<!-- SECCION DE SCRIPTS JS -->
<script type="text/javascript">
   function EditarDirector(id, nombre, direccion, cargo,email, email_personal)
   {
    document.frmEditarUsuario.clave_area.value = id;
    document.frmEditarUsuario.nombre_empleado.value = nombre;
    document.frmEditarUsuario.direccion_a.value = direccion;
    document.frmEditarUsuario.descripcion.value = cargo;
    document.frmEditarUsuario.email.value = email;
    document.frmEditarUsuario.email_personal.value = email_personal;
    $('#modalActualizar').modal('show');
   }

    function EliminarDirector()
   {
    $('#modalEliminar').modal('show');
   }

</script>