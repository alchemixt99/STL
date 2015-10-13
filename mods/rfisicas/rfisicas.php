<?php
include('../../mods/route.php');
include('../../php/jslib.php');
require("../../php/funciones.php");
include('../../php/app_menu.php');
include('../../php/aside_menu.php');
include('../../php/rfisicas.php');
include('../../php/html_snippets.php');
//menu aplicacion
$app_menu = new app_menu();
$aside_menu = new aside_menu();
$html_snippet = new html_snippets();
$rf = new rfisicas();

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
    <title>Remisiones Fisicas - STL SAS</title>
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
          <div class="col-sm-12">STL SAS Logistic APP</div>
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
        <div class="row">
          <div class="col-sm-12 text-right">
            <div id='add-button' class='btn btn-floating-mini btn-danger' title="Nuevo"><i class='md  md-add'></i></div>
          </div>
          <div class="col-sm-12 text-center">
            <p class="lead">Gestión de Remisiones Físicas.<br><br></p>
            <p><?php echo $rf->get_rfisicas(); ?></p>
          </div>
        </div>
      </div>
      <div id="add-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></button>
              <h4 class="modal-title">Registrar Finca</h4>
            </div>
            <div class="modal-body">
              <!-- caja para mensajes -->
              <div class="alert alert-dismissible alert-info" style="display:none" id="caja_mensaje">
                <button type="button" class="close" data-dismiss="alert"><i class="md md-clear"></i></button>
                <div id="texto-mensaje"></div>
              </div>
              <!-- formulario -->
              <form class="form-horizontal" action="/" method="GET">
                <fieldset>
                  <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-4" style="margin-top: 30px">
                      <input type="text" class="form-control " id="ini">
                      <label for="ini" class="">Inicia</label>
                    </div>
                    <div class="col-lg-4" style="margin-top: 30px">
                      <input type="text" class="form-control " id="fin">
                      <label for="fin" class="">Termina</label>
                    </div>
                    <label class="col-lg-2 control-label"></label>
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
    function change(a, id){
      $.ajax({      
        url: "../../php/ajax_rfisicas.php",     
        dataType: "json",     
        type: "POST",     
        data: { 
                action: "change",
                a: a,
                id: id
              },
        success: function(data){    
          if(data.res==true){
            alert(data.mes);
          }else if(data.res==false){
            alert(data.mes);
          }
          location.reload();
        }
      });
    }
    
      (function(){
        $("#add-button").click(function(){
          // Clean ripple
          /*$(this).parent().find('.mtr-ripple-wrapper').remove();
          $(this).parent().find('.mtr-btn').removeClass('mtr-btn');
          var html = $(this).parent().html();
          html = cleanSource(html);
          $("#source-modal pre").text(html);*/
          $("#add-modal").modal();
        });

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
      $("#Remisiones Fisicas").parents(1).addClass("active");

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
      //guardar finca
      $('#btn_save').on('click', function() {
        var ini = $("#ini").val();
        var fin = $("#fin").val();

        if(ini<fin){
          $.ajax({      
            url: "../../php/ajax_rfisicas.php",     
            dataType: "json",     
            type: "POST",     
            data: { 
                    action: "save",
                    ini: ini,
                    fin: fin
                  },
            success: function(data){    
              if(data.res==true){
                $("#caja_mensaje").removeClass("alert-info");
                $("#caja_mensaje").addClass("alert-success");
                $("#texto-mensaje").text(data.mes);
                $("#caja_mensaje").fadeIn();
                setTimeout(function(){location.reload();}, 3000);
              }else if(data.res==false){
                $("#caja_mensaje").removeClass("alert-info");
                $("#caja_mensaje").addClass("alert-danger");
                $("#texto-mensaje").text(data.mes);
                $("#caja_mensaje").fadeIn();
              }
            }
          });
        }else{
          $("#caja_mensaje").removeClass("alert-info");
          $("#caja_mensaje").addClass("alert-danger");
          $("#texto-mensaje").text("verifique los valores e intentelo de nuevo");
          $("#caja_mensaje").fadeIn();
        }
      });
  });
  </script>
  </body>
</html>
