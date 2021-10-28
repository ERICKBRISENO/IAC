<?php

$html = "<div id='IMGIACHOME'><img id=\"\" src=\"".DOMINIO."IMG/IACHOME.png\" alt=\"IACHOME\" width=\"100%\" ></div>";
echo xmlShow("ContenedorCentral",$html);
function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}