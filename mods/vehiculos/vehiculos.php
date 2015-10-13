<?php
include('../../mods/route.php');
include('../../php/jslib.php');
require("../../php/funciones.php");
include('../../php/app_menu.php');
include('../../php/aside_menu.php');
include('../../php/vehiculos.php');
include('../../php/fincas.php');
include('../../php/html_snippets.php');
//menu aplicacion
$app_menu = new app_menu();
$aside_menu = new aside_menu();
$html_snippet = new html_snippets();
$vehiculos = new vehiculos();
$fincas = new fincas();

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
    <title>Vehiculos - STL SAS</title>
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
          <div class="col-sm-12">STL SAS Logistik</div>
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
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button id="btn_exit" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></button>
              <h4 class="modal-title">Registrar Vehiculo</h4>
            </div>
            <div class="modal-body">
              <!-- caja para mensajes -->
              <div id="msg_box" style="display:none" class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert"><i class="md md-clear"></i></button>
                <div id="msg_body"></div>
              </div>

              <!-- formulario -->
              <form class="form-horizontal" action="/" method="GET" id="frm_users">
                <fieldset>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Información General</h3>
                  </div>
                  <div class="panel-body">
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="tipo">
                        <label for="cod" class="">Tipo</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="marca">
                        <label for="cod" class="">Marca</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="modelo">
                        <label for="cod" class="">Modelo</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="color">
                        <label for="cod" class="">Color</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="linea">
                        <label for="cod" class="">Linea</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="placa">
                        <label for="cod" class="">Placa</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="nro_motor">
                        <label for="cod" class="">Numero Motor</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="nro_chasis">
                        <label for="cod" class="">Numero Chasis</label>
                      </div>
                      <div class="col-lg-4" style="margin-top: 10px">
                        <?php echo $vehiculos->get_options_propietarios(); ?>
                        <label for="cod" class="">Propietario</label>
                      </div>
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">SOAT y Revisión Tecnomecánica</h3>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <label class="col-lg-2 control-label">SOAT</label>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="emp_soat">
                        <label for="cod" class="">Empresa</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="num_soat">
                        <label for="cod" class="">Numero</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="ven_soat">
                        <label for="cod" class="">Vence</label>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-lg-2 control-label">Revisión Tecnomecánica</label>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="emp_rt">
                        <label for="cod" class="">Empresa</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="num_rt">
                        <label for="cod" class="">Numero</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="ven_rt">
                        <label for="cod" class="">Vence</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Información de Remolque</h3>
                  </div>
                  <div class="panel-body">
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="tipo_rem">
                        <label for="cod" class="">Tipo</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="color_rem">
                        <label for="cod" class="">Color</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="marca_rem">
                        <label for="cod" class="">Marca</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="capacidad">
                        <label for="cod" class="">Capacidad (m<sup>3</sup>)</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="tipo_llanta_dir">
                        <label for="cod" class="">Llanta Direccional</label>
                      </div>
                      <div class="col-lg-2" style="margin-top: 10px">
                        <input type="text" class="form-control" id="tipo_llanta_tra">
                        <label for="cod" class="">Llanta Tracción</label>
                      </div>
                  </div>
                </div>
                  <div class="form-group">
                    <div class="col-sm-12 text-right">
                      <a href="#" id="btn_save" class="btn btn-primary">Guardar</a>
                    </div>
                  </div>
                </fieldset>
              </form>
              <!-- -->
            </div>
          </div>
        </div>
      </div>
    <div class="container-fluid">
      <div class="page-header" id="banner">
        <div class="row">
          <label class="col-lg-2 control-label"></label>
          <div class="col-sm-8 text-center">
            <p class="lead">Gestión de Vehiculos.</p>
            <div class="col-lg-12">
            <div class="col-lg-5"></div>
            <div class="col-lg-6  "></div>
            <div class="col-lg-1"><a href="#" id="btn_new" class="btn btn-floating-mini btn-danger" data-ripple-centered="" title="Agregar Usuario"><i class="md md-group-add"></i></a></div>
            </div>
            <p><?php echo $vehiculos->get_vehiculos(); ?></p>
          </div>
          <label class="col-lg-2 control-label"></label>
        </div>
      </div>

      <div id="modalx" style="display:none;">
        <div class="row">
          <label class="col-lg-2 control-label"></label>
          <div class="col-sm-8 text-center">
            <p class="lead" style="margin-top:40px;">Gestión de Vehiculos.<br><br></p>
            <div class="row">
              <input type="hidden" id="cod_finca">
              <div class="col-lg-10" id="inv_box"></div>
              <div class="col-lg-2"><a href="#" id="btn_back" class="btn btn-floating-mini btn-danger" data-ripple-centered=""><i class="md md-close"></i></a></div>
            </div>
            <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Finca</th>
                <th>Fecha Registro</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody id="turnos_box">
            </tbody>
          </table> 
          </div>
          <label class="col-lg-2 control-label"></label>
        </div>
      </div>
    </div>
<?php echo $html_snippet->load_footer(); ?>

    <script>
      (function(){
        $('.bs-component [data-toggle="popover"]').popover();
        $('.bs-component [data-toggle="tooltip"]').tooltip();

        $(".bs-component").hover(function(){
          $(this).append($button);
          $button.show();
        }, function(){
          $button.hide();
        });

        function cleanSource(html) {
          var lines = html.split(/\n/);

          lines.shift();
          lines.splice(-1, 1);

          var indentSize = lines[0].length - lines[0].trim().length,
              re = new RegExp(" {" + indentSize + "}");

          lines = lines.map(function(line){
            if (line.match(re)) {
              line = line.substring(indentSize);
            }

            return line;
          });

          lines = lines.join("\n");

          return lines;
        }

      })();
    </script>

    <script type="text/javascript">
    function validar_clave(pfx){
      if(pfx==2){pf="ch_";}else{pf="";}
      var pass= $("#"+pf+"pass").val();
      var pass_re= $("#"+pf+"pass_re").val();

      if(pass.length>=6){
        if(pass==pass_re){
          return true;
        }else{
          alert("las claves no coinciden");
          return false;
        }
      }else{
        alert("La clave necesita tener más de 6 caracteres");
        return false;
      }
    }
    function borrar_usuario(u, obj){
      var c = confirm("Seguro desea borrar el registro?");
      if(c){
        $.ajax({      
          url: "../../php/ajax_vehiculos.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "del_user",
                  user: u
                },
          success: function(data){    
            if(data.res==true){       
              alert(data.mes);
              $(obj).closest('tr').fadeOut();
            }
            else{
              alert(data.mes);
            }
          }
        });
      }
    }
    function modalx(x){
      switch(x){
        case 'on': $("#banner").fadeOut();$("#modalx").fadeIn(); break;
        case 'off': $("#banner").fadeIn();$("#modalx").fadeOut(); break;
      }
    }
    $("#btn_back").on("click", function(){$("#progress").fadeIn(); modalx("off"); $("#progress").fadeOut();});
    $("#btn_new").on("click", function(){$("#add_modal").modal()});
    function cambiar_clave(id){
      $("#codi").val(id); 
      $("#change_pass_modal").modal();
    }
    function load_modal(f,l){
      $("#progress").fadeIn();
      $.ajax({      
        url: "../../php/ajax_usuarios.php",     
        dataType: "json",     
        type: "POST",     
        data: { 
                action: "get_rutas",
                cod: f,
                lot: l
              },
        success: function(data){    
          if(data.res==true){       
            $("#cod_finca").val(f);
            $("#inv_box").html(data.mes);
            modalx("on");
            $("#progress").fadeOut();
          }
          else{
            modalx("on");
          }
        }
      });
    }
    $(function() {
      
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
      $("#usuarios").parents(1).addClass("active");

    });
  $(document).ready(function(){
      //==============AJAX===============
      //Guardar usuarios
      $('#btn_save').on('click', function() {

        $.ajax({      
          url: "../../php/ajax_vehiculos.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "save",
                  tipo: $("#tipo").val(),
                  marca: $("#marca").val(),
                  modelo: $("#modelo").val(),
                  color: $("#color").val(),
                  linea: $("#linea").val(),
                  placa: $("#placa").val(),
                  nro_motor: $("#nro_motor").val(),
                  nro_chasis: $("#nro_chasis").val(),
                  cod_prop: $("#cod_prop").val(),
                  emp_soat: $("#emp_soat").val(),
                  num_soat: $("#num_soat").val(),
                  ven_soat: $("#ven_soat").val(),
                  emp_rt: $("#emp_rt").val(),
                  num_rt: $("#num_rt").val(),
                  ven_rt: $("#ven_rt").val(),
                  tipo_rem: $("#tipo_rem").val(),
                  color_rem: $("#color_rem").val(),
                  marca_rem: $("#marca_rem").val(),
                  capacidad: $("#capacidad").val(),
                  tipo_llanta_dir: $("#tipo_llanta_dir").val(),
                  tipo_llanta_tra: $("#tipo_llanta_tra").val()
                },    
          success: function(data){           
           if(data.res==true){
              $("#msg_box").addClass("alert-success");
              $("#msg_body").text(data.mes);
              $("#msg_box").fadeIn();
              $("#frm_finca").trigger("reset");
              setTimeout(function(){location.reload();}, 3000);
            }else if(data.res==false){
              $("#msg_box").addClass("alert-danger");
              $("#msg_body").text(data.mes);
              $("#msg_box").fadeIn();
            }
          }
        });

      });
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
