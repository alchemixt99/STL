<?php
class html_snippets{
	function load_footer (){
		$html = '
		<footer class="container-fluid mtr-blue-grey-700">
	      <div class="row text-center">
	        <div class="col-sm-12">
	          <p>
	          	<a href="https://co.linkedin.com/in/javilaortiz" rel="nofollow">Jhon Avila</a> 
	          	- 
	          	<a href="https://twitter.com/javilaortiz">@javilaortiz</a> 
	          	/ 
	          	Diseño por: <a href="http://thomaspark.me" rel="nofollow">Thomas Park</a</p>
	          <p>2015</p>
	        </div>
	      </div>
	    </footer>';
	    return $html;
	}

	function load_header_css(){
		$dir = '../../img/';
		$files  = scandir($dir);
		//print_r($files);
		$pos=rand(2, count($files)-1);
		$css = "
				#topbar.toolbar-expanded{background-image: url('../../img/".$files[$pos]."');}
		";
		return $css;
	}
}
?>