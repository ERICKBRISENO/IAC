<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');

$html = "<div id='IMGIACSOLUCIONES' ><img id=\"\" src=\"".DOMINIO."IMG/IACSOLUCIONES.png\" alt=\"IACSOLUCIONES\" width=\"100%\" ></div>";
echo xmlShow("ContenedorCentral",$html);
function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}