<?php
//!BOOM á
set_time_limit(1000);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // La pagina ya expiró
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Fue modificada
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');
//include_once(APP_ROOT . 'ConstantesError.php');
//include_once(APP_ROOT . 'ProcessExisting.php');
include_once(APP_PROCESS . 'ProAutorizacionDeUso.php');
include_once(APP_VIEWS_COMMON . 'GenHtml.php');
include_once(APP_VIEWS_COMMON . 'ScrImg.php');
include_once(APP_VIEWS_COMMON . 'Css.php');
include_once(APP_VIEWS_COMMON . 'GenJs.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Buttons.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputText.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputHidden.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputCheck.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputFile.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Texts.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Forms.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Selects.php');
include_once(APP_VIEWS_BASIC_COMPO . 'HtmlBox.php');
include_once(APP_VIEWS_BASIC_COMPO . 'LayOut.php');
include_once(APP_VIEWS_BASIC_COMPO . 'HtmlWindow.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Tabs.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Tables.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Barras.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Accordion.php');

$style = Css::position('absolute');
$style .= Css::top('0px');
$style .= Css::left('0px');
$img = "<img id=\"\" src=\"".DOMINIO."IMG/IACPRICE.png\" alt=\"IACPRICE\" width=\"100%\" >";
$html = GenHtml::doDiv("",$style,"","","",$img);

$textStyle = Css::position('absolute');
$textStyle .= Css::top('1500px');
$textStyle .= Css::left('300px');
$textStyle .= Css::textSize("50px");
$textStyle .= Css::height('100px');
$textStyle .= Css::width('150px');

$Id=uniqid(true);
$InputText = Forms::doFormContent($Id,GenHtml::doInputText("",$textStyle,"","VIVIENDAS","","",""));

$style = Css::position('absolute');
$style .= Css::top('1500px');
$style .= Css::left('500px');
$style .= Css::height('100px');
$style .= Css::width('100px');
$style .= Css::border('none');

$js=GenJs::doOnClick("guardarAjax('IACPrecioJusto.php', '{$Id}');");
$Button = Buttons::doFullButton("","100px","100px","","80,160,90","110,190,120","","","CALCULAR","","",$js);
$buttonCalcular = GenHtml::doDiv("",$style,"","","",$Button);

$PrecioStyle = Css::position('absolute');
$PrecioStyle .= Css::top('1500px');
$PrecioStyle .= Css::left('885px');
$PrecioStyle .= Css::textSize("50px");
$PrecioStyle .= Css::height('100px');
$PrecioStyle .= Css::width('250px');
$PrecioStyle .= Css::border('none');

$PrecioText = GenHtml::doDiv("PRECIOJUSTO",$PrecioStyle,"","","","");

$BeneficiadosStyle = Css::position('absolute');
$BeneficiadosStyle .= Css::top('1020px');
$BeneficiadosStyle .= Css::left('530px');
$BeneficiadosStyle .= Css::textSize("100px");
$BeneficiadosStyle .= Css::height('100px');
$BeneficiadosStyle .= Css::width('250px');
$BeneficiadosStyle .= Css::border('none');

$BeneficiadosNumero = GenHtml::doDiv("BENEFICIADOS",$BeneficiadosStyle,"","","","10");

$BeneficiadosStyle = Css::position('absolute');
$BeneficiadosStyle .= Css::top('915px');
$BeneficiadosStyle .= Css::left('270px');
$BeneficiadosStyle .= Css::textSize("40px");
$BeneficiadosStyle .= Css::height('50px');
$BeneficiadosStyle .= Css::width('800px');
$BeneficiadosStyle .= Css::border('none');

$BeneficiadosTexto = GenHtml::doDiv("",$BeneficiadosStyle,"","","","CONDOMINIOS BENEFICIADOS!");

$html .= LayOut::doContainer("","0 0 0 0","","","2050px","","");

echo xmlShow("ContenedorCentral",$html.$InputText.$buttonCalcular.$PrecioText.$BeneficiadosNumero.$BeneficiadosTexto);

function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}