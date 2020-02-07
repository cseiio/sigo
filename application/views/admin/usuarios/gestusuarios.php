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
                       Usuarios <small> Gestor de Información de Usuarios</small>
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

                <div align="right" class="row">
                   <div class="col-lg-12">
                     <button type="button" onclick="mostrarModal();"  class="btn btn-success" >
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                        <strong>Nuevo Usuario</strong>
                    </button>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table id="tabla" class="table table-bordered table-hover table-responsive">
                    <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; ">
                        <tr>
                            <th>Clave del Área</th>
                            <th>Password</th>
                            <th>Nivel</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($usuarios as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->clave_area; ?></td>
                                <td><?php echo $row->password; ?></td>
                                <td><?php echo $row->nivel; ?></td>
                                <td>
                                    <button type="button" onclick="EditarUsuario('<?php echo $row->clave_area; ?>','<?php echo $row->password; ?>','<?php echo $row->nivel; ?>');" class="form-control btn btn-warning btn-sm">
                                     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                 </button>
                             </td>
                             <td>
                                <a href="<?php echo base_url()?>Admin/Usuarios/GestUsuarios/bajaUsuarios/<?php echo $row->clave_area; ?>">
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


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar a un Nuevo Usuario</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>Admin/Usuarios/GestUsuarios/agregarUsuarios">
        <div class="col-lg-12">
          <br>

          <!-- Numero de oficio: -->
          <div class="form-group">
           <?php 
           echo "<p><label for='empleado'>Empleados sin ser activados </label>";
           echo "<select class='form-control' name='empleado' id='empleado'>";
           if (count($usuarios_alta)) {
            foreach ($usuarios_alta as $list) {
              echo "<option value='". $list->clave_area. "'>" . "NOMBRE: ".$list->nombre_empleado . " --- USUARIO: " .$list->clave_area."</option>";
          }
      }
      echo "</select><br/>";
      ?>
  </div>

  <div class="form-group">
    <label for="inputPassword" class="control-label">Password</label>
    <div class="form-inline row">
      <div class="form-group col-lg-12">
        <input type="password" data-minlength="6" class="form-control" name="password" id="inputPassword" placeholder="Password" required>
        <div class="help-block">Mínimo 6 caracteres.</div>
      </div>
      <div class="form-group col-lg-12">
        <input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Los passwords no coinciden" placeholder="Confirma tu password" required>
        <div class="help-block with-errors"></div>
      </div>
    </div>
  </div>

    <!-- 1 = Recepcion, 2 =Directores de Area, 3 = Jefe de Depto, 4=Admin, 5= Direccion General, 6= Planteles -->
    <div class="form-group">
        <label>Nivel</label>
        <select class="form-control" id="nivel" name="nivel">
            <option value="1">Unidad Central de Correspondencia</option>
            <option value="2">Director de Área</option>
            <option value="6">Director de Plantel</option>
            <option value="3">Jefe de Departamento</option>
            <option value="4">Administrador</option>
        </select>
    </div>


    <button name="btn_enviar" type="submit" class="btn btn-info">
      <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
  </button>

</div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar la Información del Usuario</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarUsuario" action="<?php echo base_url(); ?>Admin/Usuarios/GestUsuarios/modificarUsuario">
        <div class="col-lg-12">
          <br>

          <input type="hidden" name="clave_area">

          <div class="form-group">
            <label for="inputPassword" class="control-label">Cambio de password</label>
            <div class="form-inline row">
              <div class="form-group col-lg-12">
                <input type="text" data-minlength="6" class="form-control" name="password" id="inputPassword" placeholder="Password" required>
                <div class="help-block">Mínimo 6 caracteres.</div>
            </div>
        </div>
    </div>

    <!-- 1 = Recepcion, 2 =Directores de Area, 3 = Jefe de Depto, 4=Admin, 5= Direccion General, 6= Planteles -->
    <div class="form-group">
        <label>Nivel</label>
        <select class="form-control" id="nivel" name="nivel">
            <option value="1">Unidad Central de Correspondencia</option>
            <option value="2">Director de Área</option>
            <option value="6">Director de Plantel</option>
            <option value="3">Jefe de Departamento</option>
            <option value="4">Administrador</option>
        </select>
    </div>


    <button name="btn_enviar" type="submit" class="btn btn-info">
      <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
  </button>

</div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>



</div>
    <!-- /#wrapper -->
    <script type="text/javascript">

        function mostrarModal()
        {
            $('#modal').modal('show');
        }

        function EditarUsuario(clave_area, password, nivel)
        {

            document.frmEditarUsuario.clave_area.value = clave_area;
            document.frmEditarUsuario.password.value = password;
            document.frmEditarUsuario.nivel.value = nivel;
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