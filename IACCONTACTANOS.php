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

$NOMBRE=Texts::doStrongText("NOMBRE","14px","rgb(0 0 0 )");
$ImputNOMBRE=InputText::doBasicCornerText("NOMBRE","","400px","30px","","right");

$TELEFONO=Texts::doStrongText("TELEFONO","14px","rgb(0 0 0 )");
$ImputTELEFONO=InputText::doBasicCornerText("TELEFONO","","400px","30px","","right");

$MAIL=Texts::doStrongText("MAIL","14px","rgb(0 0 0 )");
$ImputMAIL=InputText::doBasicCornerText("MAIL","","400px","30px","","right");

$MENSAJE=Texts::doStrongText("MENSAJE","14px","rgb(0 0 0 )");
$InputMENSAJE="<textarea name='MENSAJE' style='float:right' cols='48' rows='15'></textarea>";
$Id=uniqid(true);
$jS=GenJs::doOnClick("guardarAjax('IACCONTACTANOSMail.php', '{$Id}');");
$BotonEnviar = Buttons::doSimpleButton("right","400px","40px","ENVIAR",$jS);

$html1=LayOut::doContainer("","100px 0 0 0","","","600px","",
            LayOut::doCellCorner("","","","","",
                LayOut::doContainer("","0 20px 0 0","","","","",
                        LayOut::doCellCorner("","","","","",$NOMBRE.$ImputNOMBRE)
                )
                .LayOut::doContainer("","0 20px 0 0","","","","",
                    LayOut::doCellCorner("","","","","",$TELEFONO.$ImputTELEFONO)
                )
                .LayOut::doContainer("","0 20px 0 0","","","","",
                    LayOut::doCellCorner("","","","","",$MAIL.$ImputMAIL)
                )
                .LayOut::doContainer("","0 20px 0 0","","","","",
                    LayOut::doCellCorner("","","","","",$MENSAJE.$InputMENSAJE)
                )
                .LayOut::doContainer("","0 20px 0 0","","","","",
                    LayOut::doCellCorner("","","","","",$BotonEnviar)
                )
    )
    .LayOut::doCellCorner("","","","","","")
);

$html1= Forms::doFormContent($Id,$html1);

$html = "<div id='' style='position:absolute;top:0px;left:0px;' >
<img id=\"\" src=\"".DOMINIO."IMG/IACCONTACTANOS.png\" alt=\"IMGTERMINOS\" width=\"100%\" >
</div>";
echo xmlShow("ContenedorCentral",$html.$html1);

function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}