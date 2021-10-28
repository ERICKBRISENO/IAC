<?php
//!BOOM á
set_time_limit(1000);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // La pagina ya expiró
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Fue modificada
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

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
include_once(APP_MODELS_AutoDb . 'A000BITACORA.php');


$HTTPS      = $_SERVER['HTTPS'];
if (empty($HTTPS)) {
    header("Location: https://www.sistemaiac.com");
}

$GeneralesPagina = new GeneralesPagina();

ECHO GenHtml::doDoctype("HTML-5");
$head_MetaTags = $GeneralesPagina->doMetaTags();
$head_CSS = $GeneralesPagina->doCssLinks();
$head_JS = $GeneralesPagina->doJsLinks();

$head = GenHtml::doHead(
    "<!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-M6V7JD4');
            </script>
            <!-- End Google Tag Manager -->"
    ."<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-178048730-1\"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-178048730-1');
        </script>"

    . $head_MetaTags . $head_CSS . $head_JS);
/*
$contenido = $GeneralesPagina->showPaginaTest();
$contenido .= $GeneralesPagina->showIACHome();
$contenido .= $GeneralesPagina->showTopPromocion();
$contenido .= $GeneralesPagina->showPromocionesMiniBaner();
$contenido .= $GeneralesPagina->showPrecios();
$contenido .= $GeneralesPagina->showSoluciones();
$contenido .= $GeneralesPagina->showClientes();
$contenido .= $GeneralesPagina->showFAQS();
$contenido .=  $GeneralesPagina->showContactanos();
$contenido .= $GeneralesPagina->showCreateNewUser();
$contenido .=  $GeneralesPagina->showLOGIN();
*/
//$contenido .=  $GeneralesPagina->showContadorPromocion();
//$contenido = $GeneralesPagina->showIACHome();
$Head = $GeneralesPagina->showHEAD();
$DivCenter=$GeneralesPagina->showPaginaTest();
$foot = $GeneralesPagina->showFOOT();


$contenido=LayOut::doContainer("","","","","","",
        LayOut::doContainer("","","","","","",$Head)
        .LayOut::doContainer("ContenedorCentral","","","","","",$DivCenter)
        .LayOut::doContainer("","","","","","",$foot)
);

//$contenido .= $GeneralesPagina->showBasicViewBoton("0","2600px","50px","180px","18px","FAQS",'IMGFAQS');
//$contenido .= $GeneralesPagina->doEmptyWindow('WINDOW');

$style = Css::position('absolute');
$style .= Css::display('none');
$style .= Css::padding('5px');
$style .= Css::zIndex('10000');
$style .= Css::backColor('rgb(40,40,40)');
$style .= Css::border('1px solid black');

$style = Css::width('1280px');
$style .= Css::margin('0 auto 0 auto');
$contenedor = GenHtml::doDiv("contenedor",$style,"","","",$contenido);

$calendar = GenHtml::doDiv('calendarContent',$style,'corner5','/eve/','/spe/','/content/');
$fixed = $GeneralesPagina->doFixedDivs();
$body = GenHtml::doBody("","",
    '<!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6V7JD4"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->'
    .$contenedor.$calendar.$fixed
    ,"");

ECHO GenHtml::doHtml($head . $body);



function processPetition($PROCESS,$USER,$DATA){
    $myJSON=json_encode($USER);
    $myJSONPost=json_encode($_POST);
    $BITACORAAuto=new BITACORAAuto();
    //$BITACORAAuto->doInsert($PROCESS.$myJSON,$myJSONPost);
    if(file_exists(APP_PROCESS . $PROCESS.'.php')){
        include_once(APP_PROCESS . $PROCESS.'.php');
        return $PROCESS($USER,$DATA);
    }elseif(file_exists(APP_PROCESS_DBUSE . $PROCESS.'.php')){
        include_once(APP_PROCESS_DBUSE . $PROCESS.'.php');
        return $PROCESS($USER,$DATA);
    }else{
        return "ERROR $PROCESS";
    }
}

function xmlShow($ubicacion,$content){
    $html="<RESPUESTASERVER><UBICACION>$ubicacion</UBICACION><CONTENIDO>";
    $html.=$content;
    $html.="</CONTENIDO></RESPUESTASERVER>";
    return $html;
}
function export($var){
    return "<pre>".var_export($var,true)."</pre>";
}

