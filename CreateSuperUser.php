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
$ImputEmpresa = InputText::doBasicCornerText("EMPRESA","","200px",'35px',0,'left');
$ImputNick = InputText::doBasicCornerText("NICKDEEMPRESA","","200px",'35px',0,'left');
$ImputNombre = InputText::doBasicCornerText("NOMBRE","","200px",'35px',0,'left');
$ImputApPat = InputText::doBasicCornerText("APELLIDO_PATERNO","","200px",'35px',0,'left');
$ImputApMat = InputText::doBasicCornerText("APELLIDO_MATERNO","","200px",'35px',0,'left');
$ImputFechaNacimientoDia = InputText::doBasicCornerText("FECHA_NACIMIENTO_DIA","dd","65px",'35px',0,'left');
$ImputFechaNacimientoMes = InputText::doBasicCornerText("FECHA_NACIMIENTO_MES","mm","65px",'35px',0,'left');
$ImputFechaNacimientoAnio = InputText::doBasicCornerText("FECHA_NACIMIENTO_ANIO","aaaa","65px",'35px',0,'left');
$ImputTelefono = InputText::doBasicCornerText("TELEFONO","","200px",'35px',0,'left');
$ImputWhatsApp = InputText::doBasicCornerText("WHATSAPP","","200px",'35px',0,'left');
$ImputMail = InputText::doBasicCornerText("MAIL","","200px",'35px',0,'left');


//Texts::
$Id=uniqid(true);

$ButtonIniciar=Buttons::doButtonSubmit("200px","40px","REGISTRARSE",$Id);


$Cuestionario = GenHtml::doTable("","","","","",
            GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","colspan=\"2\"","*Todos los datos son obligatorios*")
        ).
        GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Empresa")
            . GenHTML::doTd("","","","","",$ImputEmpresa)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Nick Unico Empresa")
            . GenHTML::doTd("","","","","",$ImputNick)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Nombre Completo")
            . GenHTML::doTd("","","","","",$ImputNombre)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Apellido Paterno")
            . GenHTML::doTd("","","","","",$ImputApPat)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Apellido Materno")
            . GenHTML::doTd("","","","","",$ImputApMat)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Fecha de Nacimiento")
            . GenHTML::doTd("","","","","",
                GenHtml::doDiv("","","","","",
                    $ImputFechaNacimientoDia.$ImputFechaNacimientoMes.$ImputFechaNacimientoAnio
                )
            )
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Telefono")
            . GenHTML::doTd("","","","","",$ImputTelefono)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","WhatsApp")
            . GenHTML::doTd("","","","","",$ImputWhatsApp)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","","Mail")
            . GenHTML::doTd("","","","","",$ImputMail)
        )
        .GenHtml::doTr("","","","","",
            GenHTML::doTd("","","","","colspan=\"2\"",$ButtonIniciar)
        )
    );

$FORM=GenHtml::doForm($Id,"","","","CreateSuperUserGuardar.php","_self","post","",$Cuestionario);

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

$BanerAzul = "<div id='' style=\"$Style\"><img id=\"\" src=\"".DOMINIO."IMG/BANERAZUL.png\" alt=\"BANERAZUL\" ></div>";

//$Style = Css::position('relative');
$Style = Css::float('left');
$Style.=Css::display('block');
$Style.=Css::border('none');
//$Style.=Css::top('10PX');
$Style.=Css::left('60px');
$Style.=Css::padding('0');
$Style.=Css::width('');
$Style.=Css::height('');

$IacAqui = "<div id='' style=\"$Style\"><img id=\"\" src=\"".DOMINIO."IMG/IACAQUI.png\" height=\"465px\" alt=\"IACAQUI\" ></div>";


$bgColor= 'hsl(212,43%,93%)';
$border= '1px solid hsl(212,43%,88%)';

$html=
    LayOut::doContainer("","5px",0,"","","",
        LayOut::doCellContainer("","60%","","",
            LayOut::doContainer("","","",$bgColor,"70px","",
                        LayOut::doCellContainer("","100%",$bgColor,$border,$BanerAzul)
                    )
                    .LayOut::doContainer("","","",$bgColor,"370px","",
                        LayOut::doCellContainer("","100%",$bgColor,$border,$Cuestionario)
                    )
            )
            . LayOut::doCellContainer("","40%","","",
                LayOut::doContainer("","0",0,"","","",
                    LayOut::doCellContainer("","100%",$bgColor,$border,$IacAqui)
                )
            )
);

$Window = HtmlWindow::doBasicWindow('','850px','525px',"Registrese y Cree Rapidamente Sus Condominios",$html);
$var1 = $GeneralesPagina->doCssLinks();
$var2 = $GeneralesPagina->doJsLinks();
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