<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Material Design Bootstrap theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link href='http://fonts.googleapis.com/css?family=Roboto:500,300,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" type="text/css">


    <link rel="stylesheet" href="materia.css" type="text/css">
      
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.easing.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mtr-ripple.js"></script>
    <script src="js/jquery.mtr-panel.js"></script>
    <script src="js/jquery.mtr-header.js"></script>

    <!--
    <link rel="stylesheet" href="dist/materia.css" type="text/css">
    <script src="dist/materia.js" type="text/javascript"></script>
    -->

    <style>
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
        height: 282px;
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
    <nav class="navbar-panel">
      <div class="header container-fluid mtr-red-500">
        <div class="row">
          <div class="col-xs-12">
            <h2><b>Materia</b></h2>
            <h4>Off canvas panel</h4>
          </div>
        </div>
      </div>

      <div class="content mtr-grey-100">
        <ul class="nav">
          <li><a href="#">Item 1</a></li>
          <li><a href="#">Item 2</a></li>
          <li><a href="#">Item 3</a></li>
          <li><a href="#">Item 4</a></li>
          <li><a href="#">Item 5</a></li>
        </ul>
      </div>
    </nav>

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

    <div class="container-fluid">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-sm-12 text-center">
            <p class="lead">A Bootstrap theme inspired by Google Material Design.</p>
          </div>
        </div>
      </div>






      <div id="source-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></button>
              <h4 class="modal-title">Source Code</h4>
            </div>
            <div class="modal-body">
              <pre></pre>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-flat btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="container-fluid mtr-blue-grey-700">
      <div class="row text-center">
        <div class="col-sm-12">
          <p class="lead">Materia by Johann Troendle.</p>
        </div>
        <div class="col-sm-12">
          <p>Initial Boostrap template from <a href="http://thomaspark.me" rel="nofollow">Thomas Park</a>.
          <p>Code released under the <a href="https://github.com/thomaspark/bootswatch/blob/gh-pages/LICENSE">MIT License</a>.</p>
          <p>Based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>. Icons from <a href="http://zavoloklom.github.io/material-design-iconic-font/" rel="nofollow">Material Design Iconic Font / Sergey Kupletsky</a>. Web fonts from <a href="http://www.google.com/webfonts" rel="nofollow">Google</a>.</p>
        </div>
      </div>
    </footer>

    <script>
      (function(){
        var $button = $("<div id='source-button' class='btn btn-floating-mini btn-primary'><i class='md  md-developer-mode'></i></div>").click(function(){
          // Clean ripple
          $(this).parent().find('.mtr-ripple-wrapper').remove();
          $(this).parent().find('.mtr-btn').removeClass('mtr-btn');
          var html = $(this).parent().html();
          html = cleanSource(html);
          $("#source-modal pre").text(html);
          $("#source-modal").modal();
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

    });
  </script>
  </body>
</html>
