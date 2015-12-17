<?php
include('../../mods/route.php');
include('../../php/jslib.php');
require("../../php/funciones.php");
include('../../php/app_menu.php');
include('../../php/aside_menu.php');
include('../../php/rutas.php');
include('../../php/html_snippets.php');
include('../../php/fincas.php');
include('../../php/vehiculos.php');
//menu aplicacion
$app_menu = new app_menu();
$aside_menu = new aside_menu();
$html_snippet = new html_snippets();
$rutas = new rutas();
$fincas = new fincas();
$vh = new vehiculos();

$rt = new route();
$rt->check_session();
$libs = new jslib();
$css = $libs->get_css();
$js = $libs->get_js();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rutas - STL SAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.easing.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mtr-ripple.js"></script>
    <script src="js/jquery.mtr-panel.js"></script>
    <script src="js/jquery.mtr-header.js"></script>
    <?php 
      echo $js;
      echo $css;
    ?>

    <!--
    <link rel="stylesheet" href="dist/materia.css" type="text/css">
    <script src="dist/materia.js" type="text/javascript"></script>
    -->

    <style>
    <?php echo $html_snippet->load_header_css(); ?>
    .material-icons {
      font-family: 'Material Icons';
      font-weight: normal;
      font-style: normal;
      font-size: 24px;  /* Preferred icon size */
      display: inline-block;
      width: 1em;
      height: 1em;
      line-height: 1;
      text-transform: none;
      letter-spacing: normal;
      word-wrap: normal;

      /* Support for all WebKit browsers. */
      -webkit-font-smoothing: antialiased;
      /* Support for Safari and Chrome. */
      text-rendering: optimizeLegibility;

      /* Support for Firefox. */
      -moz-osx-font-smoothing: grayscale;

      /* Support for IE. */
      font-feature-settings: 'liga';
    }
      html, body {
        height: 100%;
        width: 100%;
      }

      body > .container-fluid { overflow-x: hidden; }
      #source-button {
        position: absolute;
        top: -25px;
        right: -15px;
        z-index: 5;
        font-weight: 700;
      }

      .bs-component { position: relative; }
      .bs-component .modal {
        position: relative;
        top: auto;
        right: auto;
        left: auto;
        bottom: auto;
        z-index: 1;
        display: block;
        overflow: visible;
      }
      .bs-component .modal-dialog { width: 80%; }

      footer { 
        margin-top: 30px;
        padding: 20px 0;
      }

      #topbar.toolbar-expanded {
        height: 400px;
        position: relative;
      }

      #topbar.fixed {
        position: fixed;
        top: -335px;
        width: 100%;
        z-index: 10;

        transform: translate3d(0,0,0);
        box-shadow: 0 1.5px 4px rgba(0, 0, 0, 0.24), 0 1.5px 6px rgba(0, 0, 0, 0.12);
      }

      .nav-placeholder { height: 400px; display: none;}
      .nav-placeholder.show { display: block;}

      .toolbar-fixed { 
        position: fixed;
        width: 100%;
        height: 55px;
        top: 0;
        z-index: 11;
      }

      .toolbar .header-title {
        height: auto;
        position: absolute;
        bottom: 0;
        font-size: 62px;
        margin-left: 55px;
        margin-bottom: 0;
        overflow: hidden;
      }
      .toolbar .header-title.small {
        font-size: 25px;
        margin-bottom: 15px;
      }
      .navbar{margin-bottom: 0px;}

      #headerToggle { color: rgba(255,255,255,.9);}
    </style>
  </head>
  <body class="mtr-grey-50">
    <!-- Off canvas menu for mobile -->
    <?php echo $aside_menu->build_menu_aside(); ?>
    
    <!-- top navbar -->
    <nav id="topbar" class="toolbar toolbar-expanded mtr-light-blue-800">
      <div class="container-fluid header-title">
        <div class="row">
          <div class="col-sm-12"><?php echo $html_snippet->app_name("001", " / Programacion de Rutas"); ?></div>
        </div>
      </div>
    </nav>

    <nav class="toolbar toolbar-fixed">
      <div class="container-fluid">
        
        <div class="toolbar-header">
          <a  id="headerToggle" href="#" class="menu-toggle" data-ripple-centered="true" data-ripple-color="#fff">
            <i class="md md-menu"></i>
          </a>
          
        </div>
      </div>
    </nav>
    <div class="nav-placeholder"></div>
        <?php echo $app_menu->build_menu(); ?>
    <div id="progress" class="progress progress-striped active" style="margin-bottom: 20px; display:none;">
      <div class="progress-bar" style="width: 100%"></div>
    </div>
    <div class="container-fluid" style="margin-top:20px;">
    <div class="col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Consultar Conductor</h3>

        </div>
        <div class="panel-body">
          <!-- formulario -->
              <form class="form-horizontal" action="/" method="GET" id="frm_general">
                <fieldset>
                  <div class="form-group">
                    <label class="col-lg-1 control-label"></label>
                    <div class="col-lg-5" style="margin-top: 30px">
                      <input type="text" class="form-control" id="fecha">
                      <label for="fecha" class="">Fecha (aaaa-mm-dd)</label>
                    </div>
                    <div class="col-lg-4" style="margin-top: 30px">
                      <input type="text" class="form-control" id="cedula" title="Enter para Consultar">
                      <label for="cedula" class="">Identificación</label>
                    </div>
                    <label class="col-lg-2 control-label">
                    </label>
                  </div>
                </fieldset>
              </form>
              <!-- -->
        </div>
      </div> 
      <!-- Consulta programa por finca -->
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Programación por Finca</h3>

        </div>
        <div class="panel-body">
          <!-- formulario -->
              <form class="form-horizontal" action="/" method="GET" id="frm_general">
                <fieldset>
                  <div class="form-group">
                    <label class="col-lg-1 control-label"></label>
                    <div class="col-lg-9" style="margin-top: 30px">
                      <?php echo $fincas->get_options_fincas_aut("cod_finca") ?>
                    </div>
                    <label class="col-lg-2 control-label">
                    </label>
                  </div>
                </fieldset>
              </form>
              <!-- -->
              <div id="resultados_sch"></div>  
        </div>
      </div>   
    </div>
    <div class="col-lg-8" id="resultados">
      
    </div>
  </div>


  <div class="modal fade" id="md-change-car">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="md md-clear"></i></button>
          <h4 class="modal-title">Cambiar Vehiculo</h4>
        </div>
        <div class="modal-body">
       <!-- formulario -->
          <form class="form-horizontal" action="/" method="GET" id="frm_general">
            <fieldset>
              <div class="form-group">
                <label class="col-lg-1 control-label"></label>
                <div class="col-lg-9" style="margin-top: 30px">
                  <input type="hidden" class="form-control" id="key">
                  <?php echo $vh->get_options_vehiculos('cmd_vehiculo'); ?>
                  <label for="fecha" class="">Nuevo Vehiculo</label>
                </div>
                <label class="col-lg-2 control-label">
                </label>
              </div>
            </fieldset>
          </form>
       <!-- -->
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<?php echo $html_snippet->load_footer(); ?>
    <script type="text/javascript">
    function edt_tr(id){
      $("#key").val(id);
      $("#md-change-car").modal();
    }

    $("#cmd_vehiculo").change(function(){
      var c = confirm("¿Está seguro que desea reemplazar este vehiculo?");
      if(c){
        $.ajax({      
          url: "../../php/ajax_rutas.php",     
          dataType: "json",     
            type: "POST",     
            data: { 
                    action: "update_vh",
                    id: $("#key").val(),
                    vh: $("#cmd_vehiculo").val()
                  },
          success: function(data){    
            if(data.res==true){ 
                alert(data.mes);
                location.reload();
              }
            else{
                alert(data.mes);
            }
          }
        });
      }else{
        alert('false');
      }
    });

    function change(o,id){
      var c = confirm("¿Confirma que desea ejecutar la siguiente operación?");
      if (c) {
        $("#progress").fadeIn();
        if(o==2){
          var razon = prompt('Razón de la cancelación');
        }else {razon = "";}
        $.ajax({      
          url: "../../php/ajax_rutas.php",     
          dataType: "json",     
            type: "POST",     
            data: { 
                    action: "update_delivery",
                    id: id,
                    r: razon,
                    op: o
                  },
          success: function(data){    
            if(data.res==true){ 
                //alert(data.mes);
                $("#progress").fadeOut();
                get_info_cond($("#fecha").val(),$("#cedula").val());
              }
            else{
              alert(data.mes);
            }
          }
        });
      };
    }

    /* Información de conductores */
    function get_info_cond(f,c){
      $("#progress").fadeIn();  
      $.ajax({      
        url: "../../php/ajax_rutas.php",     
        dataType: "json",     
          type: "POST",     
          data: { 
                  action: "get_info_cond",
                  f: f,
                  c: c
                },
        success: function(data){    
          if(data.res==true){ 
            $("#resultados").empty();
            $("#resultados").html(data.mes);
            $(".panel-success").fadeIn("slow");
            $("#progress").fadeOut();
          }
          else{
            $("#resultados").empty();
            $("#resultados").html(data.mes);
          }
        }
      });
    }
    /* programación por finca */
    function get_info_schedule(f,c){
      $("#progress").fadeIn();
      $.ajax({      
        url: "../../php/ajax_rutas.php",     
        dataType: "json",     
          type: "POST",     
          data: { 
                  action: "get_info_schedule",
                  f: $("#cod_finca").val()
                },
        success: function(data){    
          if(data.res==true){ 
            $("#resultados_sch").empty();
            $("#resultados_sch").html(data.mes);
            $(".panel-success").fadeIn("slow");
            $("#progress").fadeOut();
          }
          else{
            $("#resultados_sch").empty();
            $("#resultados_sch").html(data.mes);
          }
        }
      });
    }

    $(function() {
      $("#cod_finca").change(function(){
        var fecha = $("#fecha").val();
        var cod_f = $("#cod_finca").val();
        get_info_schedule(fecha, cod_f);
      });
      var f = new Date();
      var dt = f.getFullYear()+ "-" + (f.getMonth() +1) + "-"+ f.getDate();
      $("#fecha").val(dt);

      $("#cedula").keypress(function(e) {
          if(e.which == 13) {
             get_info_cond($("#fecha").val(),$("#cedula").val());
          }
      });

      
      $('.btn, .dropdown-menu a, .navbar a, .navbar-panel a, .toolbar a, .nav-pills a, .nav-tabs a, .pager a, .pagination a, .list-group a').mtrRipple({live: true}).on('click', function(e) {
        e.preventDefault();
      });

      // Special case for checkbox / radio (no prevented event)
      $('input[type=radio], input[type=checkbox]').mtrRipple({live: true});

      // code snippet to add the valued class for input (for label positioning)
      $('.form-control').on('blur input', function() {
        var $this = $(this);
        var v = $(this).val();
        if (v && v != '') $this.addClass('valued');
        else $this.removeClass('valued');
      }).trigger('blur');

      // Navbar panel
      $('.navbar-panel').mtrPanel({toggle: '.toolbar .menu-toggle'});
      
      $('#topbar').mtrHeader();

      var $body = $('body');
      var $headerTitle = $('.header-title');
      $(window).on('scroll', function(e) {
        var top = $body.scrollTop();
        if (top > 275)
          $headerTitle.addClass('small')
        else
          $headerTitle.removeClass('small');
      });

      //==============Activar menuitem====================  
      $("#Rutas").parents(1).addClass("active");
      $("#cedula").focus();

    });
  $(document).ready(function(){

      //==============AJAX===============
      //logout
      $('#btn_logout').on('click', function() {
        $.ajax({      
          url: "../../php/logout.php",     
          dataType: "json",     
          type: "POST",     
          success: function(data){    
          if(data.res==true){         
            $(location).attr('href',data.mes); 
          }
          else{
            alert(data.mes);
          }
        }});
      });
      

  });
  </script>
  </body>
</html>
