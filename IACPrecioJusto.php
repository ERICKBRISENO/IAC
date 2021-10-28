<?php

$viviendas = $_POST['VIVIENDAS'];
if($viviendas < 31){
    $costo=330;
}else{
    $costo=$viviendas*15;
}

$html="<span style='font-size:50px'>\$ ".number_format($costo,2)." MXN</span>";
echo xmlShow("PRECIOJUSTO",$html);

function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}