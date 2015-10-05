<?php
include('../../mods/route.php');
include('../../php/jslib.php');
require("../../php/funciones.php");
include('../../php/app_menu.php');
include('../../php/aside_menu.php');
include('../../php/fincas.php');
include('../../php/html_snippets.php');
//menu aplicacion
$app_menu = new app_menu();
$aside_menu = new aside_menu();
$html_snippet = new html_snippets();
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
    <title>Fincas - STL SAS</title>
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
    <div class="container-fluid">

      <div class="page-header" id="banner">
          <div class="col-sm-12 text-center">
            <p class="lead">Gestión de Fincas.</p>
            <div class="col-sm-12 text-right">
            <div class="col-lg-5"></div>
            <div class="col-lg-5">
              <div id='edt-button' class="btn btn-floating-mini btn-success" title="Modificar Fincas"><i class="md md-edit"></i></div>
              <div id='add-button' class='btn btn-floating-mini btn-danger' title="Nuevo"><i class='md md-add'></i></div>
            </div>
            <div class="col-lg-2">
            </div>
          </div>
          <div class="row">
             <div class="col-sm-2 text-right"></div>
             <div class="col-sm-8 text-right">
                <p><?php echo $fincas->get_fincas(); ?></p>
             </div>
             <div class="col-sm-2 text-right"></div>
          </div>
        </div>
      </div>
      <div id="add-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button id="btn_exit" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></button>
              <h4 class="modal-title">Registrar Finca</h4>
            </div>
            <div class="modal-body">
              <!-- caja para mensajes -->
              <div id="msg_box" style="display:none" class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert"><i class="md md-clear"></i></button>
                <div id="msg_body"></div>
              </div>

              <!-- formulario -->
              <form class="form-horizontal" action="/" method="GET" id="frm_finca">
                <fieldset>
                  <div class="form-group" id="gr_cod_finca">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-10" style="margin-top: 30px" id="combo_fincas_all">
                        <?php echo $fincas->get_options_fincas(); ?>
                      <label for="cod" class="">Seleccione Finca(*)</label>
                    </div>
                    <div class="col-lg-10" style="margin-top: 30px; display:none;" id="combo_fincas_aut">
                        <?php echo $fincas->get_options_fincas_aut("cod_aut"); ?>
                      <label for="cod" class="">Código Finca(*)</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-10" style="margin-top: 30px">
                    </div>
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-10" style="margin-top: 30px">
                      <label for="lote_especie" class="">Autorizar Lotes</label>
                      <div class="checkbox" id="lote_especie">
                        
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
    function borrar_finca(f, obj){
      var c = confirm("Seguro desea borrar esta finca?");
      if(c){
        $.ajax({      
          url: "../../php/ajax_fincas.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "del_finca",
                  finca: f
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
    function save_check(f, obj){
      //alert("accion: "+obj.checked+" id: "+obj.value);
      if(obj.checked){evento = "save"; lote = obj.value;}
        else{evento = "erase"; lote = obj.value;}
      $.ajax({      
          url: "../../php/ajax_fincas.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "change_lote_aut",
                  e: evento,
                  l: lote,
                  f: f
                },
          success: function(data){}
        });
    }
    $(function() {
      $("btn_exit").on("click", function(){$("#lote_especie").html("");}); 
      $("#add-button").click(function(){
        $("#lote_especie").empty();
        $(".modal-title").text("Autorizar Fincas");
        $("#combo_fincas_all").fadeIn();
        $("#btn_save").fadeIn();
        $("#combo_fincas_aut").fadeOut();
        $("#add-modal").modal();
      });
      $("#edt-button").click(function(){
        $("#lote_especie").empty();
        $(".modal-title").text("Modificar Fincas");
        $("#combo_fincas_all").fadeOut();
        $("#btn_save").fadeOut();
        $("#combo_fincas_aut").fadeIn();
        $("#add-modal").modal();
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
      $("#Fincas").parents(1).addClass("active");

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
      //acción al cambiar el select id=cod
      $("#cod").change(function(){
        $.ajax({      
          url: "../../php/ajax_fincas.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "get_lotes",
                  cod: $("#cod").val()
                },
          success: function(data){    
            if(data.res==true){
              $("#lote_especie").fadeIn();
              $("#lote_especie").html(data.mes);
            }
          }
        });
      });
      //acción al cambiar el select id=cod_aut
      $("#cod_aut").change(function(){
        $.ajax({      
          url: "../../php/ajax_fincas.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "get_lotes",
                  cod: $("#cod_aut").val(),
                  aut: true
                },
          success: function(data){    
            if(data.res==true){
              $("#lote_especie").fadeIn();
              $("#lote_especie").html(data.mes);
            }
          }
        });
      });
      //guardar finca
      $('#btn_save').on('click', function() {
        //traemos arreglo de lotes
        var lotes_val = new Array();
        $("input[name='lotes[]']:checked").each(function(){
          lotes_val.push($(this).val());
        });

        //ejecutamos ajax
        $.ajax({      
          url: "../../php/ajax_fincas.php",     
          dataType: "json",     
          type: "POST",     
          data: { 
                  action: "save",
                  cod: $("#cod").val(),
                  nombre: $("#nombre").val(),
                  arr_lotes: lotes_val
                },
          success: function(data){    
            if(data.res==true){
              $("#msg_box").fadeIn();
              $("#msg_box").addClass("alert-success");
              $("#msg_body").text(data.mes);
              $("#frm_finca").trigger("reset");
              setTimeout(function(){location.reload();}, 3000);
            }else if(data.res==false){
              $("#msg_box").fadeIn();
              $("#msg_box").addClass("alert-danger");
              $("#gr_cod_finca").addClass("has-error");
              setTimeout(function(){
                $("#gr_cod_finca").removeClass("has-error");
                $("#msg_box").fadeOut();
              },2000);
              $("#msg_body").text(data.mes);
              setTimeout(function(){location.reload();}, 3000);
            }
          }
        });
      });
  });
  </script>
  </body>
</html>
