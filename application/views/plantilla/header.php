<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $titulo ?> / Sistema de Gestión de Oficios</title>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <!-- Bootstrap Core CSS 

    "<?php //echo base_url(); ?>/assets/img/fondobibliotecaoficio.png"-->
   <link href="<?php echo base_url(); ?>/assets/css/cseiiostyles.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
 
    <link href="<?php echo base_url(); ?>/assets/css/login.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/push/bin/push.min.js"></script>
    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>/assets/img/apple-touch-icon.png">
    <link rel="icon"  href="<?php echo base_url(); ?>/assets/img/favicon.ico" >


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

       <!--  <script type="text/javascript" src="<?php //echo base_url(); ?>/assets/js/jquery.js"></script> -->

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/datatables/media/css/dataTables.bootstrap.min.css">
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/assets/datatables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/assets/datatables/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>/assets/datatables/media/js/dataTables.bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>/assets/js/validator.min.js"></script>

        <script type="text/javascript" charset="utf-8">

           $(document).ready(function() {
              $("#tabla").DataTable({
                  "order": [[ 0, 'desc' ]],
                  "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
          } );
      </script>

<script src="<?php echo base_url(); ?>/assets/js/bootstrap-hover-dropdown.js"></script>



<script type="text/javascript">
/*funcion ajax que llena el combo dependiendo de la categoria seleccionada*/
$(document).ready(function(){
   $("#direccion").change(function () {
           $("#direccion option:selected").each(function () {
            dir=$('#direccion').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/llenarCombo", { dir: dir}, function(data){
            $("#departamentos_cmb").html(data);
            });            
        });
   })
});
/*fin de la funcion ajax que llena el combo dependiendo de la categoria seleccionada*/
$(document).ready(function(){
   $("#direccion1").change(function () {
           $("#direccion1 option:selected").each(function () {
            dir=$('#direccion1').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/llenarCombo", { dir: dir}, function(data){
            $("#departamentos_cmb1").html(data);
            });            
        });
   })
});


$(document).ready(function(){
   $("#direccion2").change(function () {
           $("#direccion2 option:selected").each(function () {
            dir=$('#direccion2').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/llenarCombo", { dir: dir}, function(data){
            $("#departamentos_cmb2").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#direccion3").change(function () {
           $("#direccion3 option:selected").each(function () {
            dir=$('#direccion3').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/llenarCombo", { dir: dir}, function(data){
            $("#departamentos_cmb3").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#direccion4").change(function () {
           $("#direccion4 option:selected").each(function () {
            dir=$('#direccion4').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/llenarCombo", { dir: dir}, function(data){
            $("#departamentos_cmb4").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#direccion5").change(function () {
           $("#direccion5 option:selected").each(function () {
            dir=$('#direccion5').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/llenarComboEmial", { dir: dir}, function(data){
            $("#email").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#area_destino").change(function () {
           $("#area_destino option:selected").each(function () {
            dir=$('#area_destino').val();
            $.post("<?php echo base_url(); ?>Direcciones/Externos/RecepcionDir/llenarCombo", { dir: dir}, function(data){
            $("#email").html(data);

            });            
        });
   })
});


$(document).ready(function(){
   $("#direccion5").change(function () {
           $("#direccion5 option:selected").each(function () {
            dir2=$('#direccion5').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/llenarComboPersonal", { dir2: dir2}, function(data){
            $("#email_personal").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#area_destino").change(function () {
           $("#area_destino option:selected").each(function () {
            d=$('#area_destino').val();
            $.post("<?php echo base_url(); ?>Direcciones/Externos/RecepcionDir/llenarComboPersonal", { d: d}, function(data){
            $("#email_personal").html(data);

            });            
        });
   })
});


//PROCESO INTERNO DIRECIONES - LLENADO DE CORREOS

$(document).ready(function(){
   $("#dirinternos").change(function () {
           $("#dirinternos option:selected").each(function () {
            dirinterno=$('#dirinternos').val();
            $.post("<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/llenarComboEmailInterno", { dirinterno: dirinterno}, function(data){
            $("#correo").html(data);

            });            
        });
   })
});


$(document).ready(function(){
   $("#dirinternos").change(function () {
           $("#dirinternos option:selected").each(function () {
            dirinterno2=$('#dirinternos').val();
            $.post("<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/llenarComboPersonalInterno", { dirinterno2: dirinterno2}, function(data){
            $("#correo_personal").html(data);
            });            
        });
   })
});

//PROCESO INTERNO DEPARTAMENTOS - LLENADO DE CORREOS

$(document).ready(function(){
   $("#deptointerno").change(function () {
           $("#deptointerno option:selected").each(function () {
            deptoemail=$('#deptointerno').val();
            $.post("<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/llenarComboEmailInterno", { deptoemail: deptoemail}, function(data){
            $("#email").html(data);

            });            
        });
   })
});


$(document).ready(function(){
   $("#deptointerno").change(function () {
           $("#deptointerno option:selected").each(function () {
            deptopersonal=$('#deptointerno').val();
            $.post("<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna/llenarComboPersonalInterno", { deptopersonal: deptopersonal}, function(data){
            $("#email_personal").html(data);
            });            
        });
   })
});

// PANEL ADMINISTRATIVO.- LLENADO DE COMBO  - INSERT

$(document).ready(function(){
   $("#direccion_adsc").change(function () {
           $("#direccion_adsc option:selected").each(function () {
            direccion_adsc=$('#direccion_adsc').val();
            $.post("<?php echo base_url(); ?>Admin/Empleados/JefesDepto/llenarComboDeptos", { direccion_adsc: direccion_adsc}, function(data){
            $("#departamento_adsc").html(data);
            });            
        });
   })
});

// RELLENAR EL CARGO DE LOS FUNCIONARIOS DEL CSEIIO QUE VAN A REDACTAR EL OFICIO
// 
$(document).ready(function(){
   $("#fun_emisor").change(function () {
           $("#fun_emisor option:selected").each(function () {
            fun_emisor=$('#fun_emisor').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas/llenarInputFuncionarios", { fun_emisor: fun_emisor}, function(data){
            $("#funcionario").html(data);
            });            
        });
   })
});

// DEPENDENCIAS PANEL DE SALIDAS

$(document).ready(function(){
   $("#dependencia_remitente").change(function () {
           $("#dependencia_remitente option:selected").each(function () {
            dependencia_remitente=$('#dependencia_remitente').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas/llenarInputRemitente", { dependencia_remitente: dependencia_remitente}, function(data){
            $("#remit").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#dependencia_remitente").change(function () {
           $("#dependencia_remitente option:selected").each(function () {
            dependencia_remitente=$('#dependencia_remitente').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas/llenarInputCargo", { dependencia_remitente: dependencia_remitente}, function(data){
            $("#carg").html(data);
            });            
        });
   })
});

// DEPENDENCIAS PANEL ENTRADAS

$(document).ready(function(){
   $("#dependencia").change(function () {
           $("#dependencia option:selected").each(function () {
            dependencia=$('#dependencia').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/llenarInputEmisor", { dependencia: dependencia}, function(data){
            $("#emis").html(data);
            });            
        });
   })
});

$(document).ready(function(){
   $("#dependencia").change(function () {
           $("#dependencia option:selected").each(function () {
            dependencia=$('#dependencia').val();
            $.post("<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/llenarInputCargo", { dependencia: dependencia}, function(data){
            $("#cargemi").html(data);
            });            
        });
   })
});


$(document).ready(function(){
   $("#dirinternos_single").change(function () {
           $("#dirinternos_single option:selected").each(function () {
            direccion=$('#dirinternos_single').val();
            $.post("<?php echo base_url(); ?>Direcciones/Interno/RecepcionInterna/llenarComboDependencias", { direccion: direccion}, function(data){
            $("#deptos_combo").html(data);

            });            
        });
   })
});

</script>
<script type="text/javascript">



function mostrarReferencia(){
//Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada
if (document.frmRegistroOficioDeptos.turnadoDirecto[0].checked == true) {
//muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'
document.getElementById('selecciones_multiples').style.display='none';
document.getElementById('selecciones_individuales').style.display='block';
//por el contrario, si no esta seleccionada
} else 
  if(document.frmRegistroOficioDeptos.turnadoDirecto[1].checked == true) {
//oculta el div con id 'desdeotro'
document.getElementById('selecciones_individuales').style.display='none';
document.getElementById('selecciones_multiples').style.display='block';
}
}



function mostrarReferenciaDir(){
//Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada
if (document.frmRegistroOficioDir.turnadoDirecto[0].checked == true) {
//muestra (cambiando la propiedad display del estilo) el div con id 'desdeotro'
document.getElementById('selecciones_multiplesdir').style.display='none';
document.getElementById('selecciones_individualesdir').style.display='block';
//por el contrario, si no esta seleccionada
} else 
  if(document.frmRegistroOficioDir.turnadoDirecto[1].checked == true) {
//oculta el div con id 'desdeotro'
document.getElementById('selecciones_individualesdir').style.display='none';
document.getElementById('selecciones_multiplesdir').style.display='block';
}
}

</script>



<style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
</style>    

</head>

<body >

