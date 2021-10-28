<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');

$html = "<div id='IMGCLIENTES'><img id=\"\" src=\"".DOMINIO."IMG/IACCLIENTES.png\" alt=\"IMGCLIENTES\" width=\"100%\" ></div>";
echo xmlShow("ContenedorCentral",$html);
function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}