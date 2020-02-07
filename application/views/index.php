<!--   <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <img src="<?php //echo base_url(); ?>/assets/img/apple-touch-icon-60x60.png"> 
      </div>
      <a style="color:#ffffff;" class="navbar-brand" href="#">Sistema de Gestión de Oficios del CSEIIO (SIGO) / Acceso</a>
    </div>
  </nav> -->

  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container-fluid">


      <div class="col-lg-12" style="background-image: url('<?php echo base_url(); ?>/assets/img/banner.png'); background-color: #F9F9F9; text-align: center;">
        <div style="float: left;"> 
          <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/appletouch-sigo-blue.png">
        </div>
        <div style="display: inline-block;"> 
          <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/appletouch280xauto.png">
        </div>
        <div style="float: right;">                   
          <img class="imagenheader" src="<?php echo base_url(); ?>/assets/img/apple-touch-icon-76x76.png">                
        </div>
      </div>
      <!-- Top Menu Items -->
      <div class="col-lg-12" style="background-color: #F9F9F9; text-align: center; ">
          <strong><h4 style="font-weight: bold;">Sistema de Gestión de Oficios (SIGO)</h4></strong>
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

      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>

<br><br><br><br>
<div class="container">
  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
      <h1 class="text-center login-title">Inicia Sesión</h1>
     
     <div class="account-wall">
        <img class="profile-img" src="<?php echo base_url(); ?>/assets/img/user.png" alt="">

        <form data-toggle="validator" class="form-signin"  method="POST" action="">
          
          <div class="form-group">
            <input type="text" name="user" class="form-control" placeholder="Ingresa tu usuario" required autofocus>
          </div>

          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Ingresa tu password" required>
          </div>

          
         <br>
          <button class="btn btn-success btn-block" type="submit"> Ingresar</button>
          <br>
          <div>

            <?php
            $invalido = $this->session->flashdata('invalido');

            if($invalido) { ?>
              <strong>
                 <div class="alert alert-danger" style="text-aling:center; color:#4A4949"  role="alert"><?php echo $invalido ?></div>
              </strong>
            
            <?php } 
             if (validation_errors()) { ?>
               <strong>
                 <div class="alert alert-warning" style="text-aling:center; color:#4A4949"  role="alert"><?php echo validation_errors(); ?></div>
               </strong>
             <?php }  ?>   
            
            </div>
          </form>
        </div>
     </div>
    </div>
  </div>