function startTime(){
today=new Date();
h=today.getHours();
m=today.getMinutes();
s=today.getSeconds();
m=checkTime(m);
s=checkTime(s);
document.getElementById('reloj').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);}
function checkTime(i)
{if (i<10) {i="0" + i;}return i;}
window.onload=function(){startTime();}

//lanzar cronjob_rutas
function go_cj_r(){
	window.open('../../php/cronjob_rutas.php');
}
//lanzar cronjob_ica
function go_cj_i(){
	window.open('../../php/cronjob_ica.php');
}

function reporte(a){
	window.open('../../php/reportes.php?i='+a);
}

//sombra al texto
$(document).ready(function(){
	$(".header-title").addClass("stroke");
});

