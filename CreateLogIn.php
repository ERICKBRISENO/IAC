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

include_once(APP_VIEWS . 'GeneralesPagina.php');

$GeneralesPagina = new GeneralesPagina();
//DOMINIO. "/IMG/CreaCondo.png"
$ImputNick = InputText::doBasicCornerText("NICKDEEMPRESA","","200px",'35px',0,'left');
$ImputUsuario = InputText::doBasicCornerText("USUARIO","","200px",'35px',0,'left');
$ImputContrasena = InputText::doBasicCornerText("CONTRASENA","","200px",'35px',0,'left');

//Texts::
$Id=uniqid(true);

$ButtonIniciar=Buttons::doButtonSubmit("100px","40px","ENTRAR",$Id);


$Cuestionario = GenHtml::doTable("","","","","",
        GenHtml::doTr("","","","","",
        GenHTML::doTd("","","","","","NickEmpresa")
        . GenHTML::doTd("","","","","",$ImputNick)
    )
    .GenHtml::doTr("","","","","",
        GenHTML::doTd("","","","","","Usuario")
        . GenHTML::doTd("","","","","",$ImputUsuario)
    )
    .GenHtml::doTr("","","","","",
        GenHTML::doTd("","","","","","contraseña")
        . GenHTML::doTd("","","","","",$ImputContrasena)
    )
    .GenHtml::doTr("","","","","",
        GenHTML::doTd("","padding:5px 0 0 0;","","","colspan=\"2\"",$ButtonIniciar)
    )
);

$proces = InputHidden::doProcessHidden("ProLogIn");
//$proces .= InputHidden::doProcessHidden("ProBasicView");

$FORM=GenHtml::doForm($Id,"","","",DOMINIO . "/IAC/index.php","_self","post","",$Cuestionario . $proces);

//$Style = Css::position('relative');
$Style = Css::float('left');
$Style.=Css::display('block');
$Style.=Css::border('none');
//$Style.=Css::top('70px');
//$Style.=Css::left('100px');
$Style.=Css::width('100%');
$Style.=Css::height('');

$Cuestionario = "<div id=\"\" style=\"{$Style}\" \" >$FORM</div>";

//$Style = Css::position('relative');
$Style = Css::float('left');
$Style.=Css::display('block');
$Style.=Css::border('none');
//$Style.=Css::top('0px');
//$Style.=Css::left('0px');
$Style.=Css::width('100%');
$Style.=Css::height('46px');

$BanerAzul = "<div id='' style=\"$Style\"><img id=\"\" width=\"250px\" src=\"https://www.sistemaiac.com/IMG/BANERAZUL.png\" alt=\"BANERAZUL\" ></div>";


$bgColor= 'hsl(212,43%,93%)';
$border= '1px solid hsl(212,43%,88%)';

$html=LayOut::doContainer("","5px",0,"","","",
        LayOut::doCellContainer("","100%",$bgColor,$border,
            LayOut::doContainer("","","",$bgColor,$border,"",$BanerAzul)
            . LayOut::doRowSeparator('20px')
            . LayOut::doContainer("","0 0 0 ","",$bgColor,"","",$Cuestionario)
            . LayOut::doRowSeparator('15px')
        )
    );

$Window = HtmlWindow::doBasicWindow('','350px','295px',"Ingrese sus Datos de Acceso",$html);
//$var1 = $GeneralesPagina->doCssLinks();
//$var2 = $GeneralesPagina->doJsLinks();
//echo GenHtml::doDoctype('HTML-5');
//echo GenHtml::doHead($var1.$var2);
//echo GenHtml::doBody("","",$Window,"" );
function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}

echo xmlShow('VIEW_FIXED_DATA',$Window);
//"style=\"background-image:url(http://iac-softwareparacondominios.com/IMG/IACPRICE.png)\""