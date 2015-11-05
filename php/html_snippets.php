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
				.stroke {
					text-shadow: -1px -1px 1px #333, 1px -1px 1px #333, -1px 1px 1px #333, 1px 1px 1px #333;
				}
		";
		return $css;
	}

	function app_name($e, $a=""){
		$mod = '<span style="font-size:23px;">'.$a.'</span>';
		$str = [
			"001" => "STL SAS - Logistik".$mod
		];
		/* ====================== */
		return $str[$e];
	}

	function cbx_years($id, $i, $f){
		$html='<select class="form-control valued" id="'.$id.'">';
		for ($j=$i; $j < $f; $j++) { 
			$html.='<option value="'.$j.'">'.$j.'</option>';
		}
		$html.='</select>';
		return $html;
	}
	function cbx_config($id){
		$html='	<select class="form-control valued" id="'.$id.'">
					<option value=""></option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="2S1">2S1</option>
					<option value="2S3">2S3</option>
					<option value="3S1">3S1</option>
					<option value="3S3">3S3</option>
					<option value="R2">R2</option>
					<option value="2R2">2R2</option>
					<option value="2R3">2R3</option>
					<option value="3R2">3R2</option>
					<option value="4R2">4R2</option>
					<option value="4R4">4R4</option>
					<option value="2B1">2B1</option>
					<option value="2B2">2B2</option>
					<option value="2B3">2B3</option>
					<option value="3B1">3B1</option>
					<option value="3B2">3B2</option>
					<option value="3B3">3B3</option>
					<option value="4B1">4B1</option>
					<option value="4B2">4B2</option>
					<option value="4B3">4B3</option>
				</select>';
		return $html;
	}

}
?>