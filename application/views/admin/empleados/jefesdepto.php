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
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/Directores"><i class="fa fa-building"></i> Directores de Área</a>
                </li>
                <li class="active">
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
                        Jefes de Departamento <small> Gestión de Empleados</small>
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
                    <strong>Nuevo Jefe de Departamento</strong>
                </button>
            </div>
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
                            <th>Departamento</th>
                            <th>Cargo</th>
                            <th>Email</th>
                            <th>Email Personal</th>
                            <td>Editar</td>
                            <td>Eliminar</td>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($jefes as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->clave_area; ?></td>
                                <td><?php echo $row->nombre_empleado; ?></td>
                                <td><?php echo $row->nombre_direccion; ?></td>
                                <td><?php echo $row->nombre_area; ?></td>
                                <td><?php echo $row->descripcion; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->email_personal; ?></td>
                                <td>
                                    <button type="button" onclick="EditarJefe('<?php echo $row->clave_area; ?>','<?php echo $row->nombre_empleado; ?>','<?php echo $row->direccion; ?>','<?php echo $row->departamento; ?>','<?php echo $row->descripcion; ?>','<?php echo $row->email; ?>','<?php echo addcslashes($row->email_personal,"\\\"\"\n\r"); ?>');" class="form-control btn btn-warning btn-sm">
                                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                   </button>
                               </td>
                               <td>
                                <a href="<?php echo base_url()?>Admin/Empleados/JefesDepto/eliminarJefeDepto/<?php echo $row->clave_area; ?>">
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
        <h4 align="center" class="modal-title">Registrar a un Nuevo Empleado</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>Admin/Empleados/JefesDepto/agregarJefeDepto">
        <div class="col-lg-12">
          <br>
        
        <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="clave_area" class="control-label">Usuario</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="clave_area" id="clave_area" class="form-control" placeholder="Ej. admin_requsiciones" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>

       <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="nombre_completo" class="control-label">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_completo" id="nombre_completo" class="form-control" placeholder="Ej. LIC. ANEL RAMOS BARRAGÁN" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group">
            <label>Dirección  de Adscripción</label>
            <select class="form-control" id="direccion_adsc" name="direccion">
                <option value="">- Seleccione una Dirección -</option>
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>


         <div class="form-group">
            <label>Departamento de Adscripción</label>
            <select class="form-control" id="departamento_adsc" name="departamento_adsc">
                
            </select>
        </div>


        <div class="form-group has-feedback">
            <label for="cargo_empleado" class="control-label">Cargo</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_empleado" id="cargo_empleado" class="form-control" placeholder="Ej. JEF@ DEL DEPARTAMENTO DE CONTROL ESCOLAR"  required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>


        <div class="form-group has-feedback">
            <label for="email" class="control-label">Correo Institucional</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Ej. coordinador@cseiio.edu.mx"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
        </div>


          <div class="form-group has-feedback">
            <label for="email_personal" class="control-label">Correo Personal</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email_personal" id="email_personal" class="form-control" placeholder="Ej. usuario@gmail.com"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
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


<!-- ACTUALIZAR -->
<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar información del Empleado</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmModificarEmpleado" action="<?php echo base_url(); ?>Admin/Empleados/JefesDepto/modificarJefeDepto">
        <div class="col-lg-12">
          <br>
        
        <!-- Numero de oficio: -->
         <input type="hidden" name="clave_area_a">
       <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="nombre_completo_a" class="control-label">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="nombre_completo_a" id="nombre_completo_a" class="form-control" placeholder="Ej. LIC. ANEL RAMOS BARRAGÁN" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group">
            <label>Dirección  de Adscripción</label>
            <select class="form-control" id="direccion_adsc_a" name="direccion_a">
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>


            <div class="form-group">
             <?php 
             echo "<p><label for='departamento_adsc_a'>Departamento de Adscripción </label>";
             echo "<select class='form-control' name='departamento_adsc_a' id='departamento_adsc_a'>";
             if (count($deptos)) {
                foreach ($deptos as $list) {
                  echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
              }
          }
          echo "</select><br/>";
          ?>
      </div>


        <div class="form-group has-feedback">
            <label for="cargo_empleado_a" class="control-label">Cargo</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo_empleado_a" id="cargo_empleado_a" class="form-control" placeholder="Ej. JEF@ DEL DEPARTAMENTO DE CONTROL ESCOLAR"  required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>


        <div class="form-group has-feedback">
            <label for="email_a" class="control-label">Correo Institucional</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email_a" id="email_a" class="form-control" placeholder="Ej. coordinador@cseiio.edu.mx"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
        </div>


          <div class="form-group has-feedback">
            <label for="email_personal_a" class="control-label">Correo Personal</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input type="email" name="email_personal_a" id="email_personal_a" class="form-control" placeholder="Ej. usuario@gmail.com"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
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

<script type="text/javascript">

function mostrarModal()
  {
    $('#modal').modal('show');
}

function EditarJefe(clave_area, nombre_empleado, direccion, departamento, descripcion, email, email_personal)
{

    document.frmModificarEmpleado.clave_area_a.value = clave_area;
    document.frmModificarEmpleado.nombre_completo_a.value = nombre_empleado;
    document.frmModificarEmpleado.direccion_a.value = direccion;
    document.frmModificarEmpleado.departamento_adsc_a.value = departamento;
    document.frmModificarEmpleado.cargo_empleado_a.value = descripcion;
    document.frmModificarEmpleado.email_a.value = email;
    document.frmModificarEmpleado.email_personal_a.value = email_personal;
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