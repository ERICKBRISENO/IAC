<?php
//!BOOM á
set_time_limit(1000);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // La pagina ya expiró
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Fue modificada
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');
include_once(APP_PROCESS . 'ProAutorizacionDeUso.php');

include_once(APP_VIEWS_COMMON . 'GenHtml.php');
include_once(APP_VIEWS_COMMON . 'ScrImg.php');
include_once(APP_VIEWS_COMMON . 'Css.php');
include_once(APP_VIEWS_COMMON . 'GenJs.php');

include_once(APP_VIEWS_BASIC_COMPO . 'Accordion.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Barras.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Buttons.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Forms.php');
include_once(APP_VIEWS_BASIC_COMPO . 'HtmlBox.php');
include_once(APP_VIEWS_BASIC_COMPO . 'HtmlWindow.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputCheck.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputFile.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputHidden.php');
include_once(APP_VIEWS_BASIC_COMPO . 'InputText.php');
include_once(APP_VIEWS_BASIC_COMPO . 'LayOut.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Selects.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Tables.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Tabs.php');
include_once(APP_VIEWS_BASIC_COMPO . 'Texts.php');

include_once(APP_VIEWS . 'GeneralesPagina.php');

$GeneralesPagina = new GeneralesPagina();

ECHO GenHtml::doDoctype("HTML-5");
$head_MetaTags = $GeneralesPagina->doMetaTags();
$head_CSS = $GeneralesPagina->doCssLinks();
$head_JS = $GeneralesPagina->doJsLinks();
ECHO GenHtml::doHead($head_MetaTags . $head_CSS . $head_JS);
/*****DECLARACION DE PAGINA Y VARIABLES DE CABECERA*******/

///$style =Css::
//$style =Css::
$css = Css::textSize("25px");
$css .= Css::float("left");
$css .= Css::textAlign("center");

$text1 = Texts::doBasicText("Condominios",$css);
$text2 = Texts::doBasicText("Usuarios",$css);
$text3 = Texts::doBasicText("Rol de Usuario",$css);
$text4 = Texts::doBasicText("Asignacion de Usuarios",$css);
$text5 = Texts::doBasicText("Mi configuracion",$css);

/*
doFullButton($float,$width,$height,
    $margin,$upColor,$downColor,
    $borderColor,$class,$text,
    $textSize,$textColor,$event,$id='/id/'
*/

$html = Buttons::doFullButton("right","200px","60px","0 auto 0 auto","","rgb(0,0,0)","","corner10","Mi Configuracion","25px","black","","");
//$html = Buttons::doSimpleButton("right","200px","50px",$text1,"");
$html .= Buttons::doSimpleButton("right","200px","60px",$text4,"");
$html .= Buttons::doSimpleButton("right","200px","60px",$text3,"");
$html .= Buttons::doSimpleButton("right","200px","60px",$text2,"");
$html .= Buttons::doSimpleButton("right","200px","60px",$text1,"");

$css2 = Css::textSize("15px");
$css2 .= Css::float("center");
$css2 .= Css::textAlign("center");

$css3 = Css::textSize("15px");
$css3 .= Css::float("left");
$css3 .= Css::textAlign("center");

$text6 = Texts::doBasicText("Usuario",$css2);
$text7 = Texts::doBasicText("Condominio",$css2);
$text8 = Texts::doBasicText("Rol",$css2);
$text9 = Texts::doBasicText("Selecciona usuario",$css3);
$text10 = Texts::doBasicText("Selecciona Condominio",$css3);
$text11 = Texts::doBasicText("Selecciona Rol",$css3);

$Usuario = Selects::doBasicCornerSelect("Usuario",array('1','2'),"300px");
$Condominio = Selects::doBasicCornerSelect("Condominio",array('1','2'),"300px");
$Rol = Selects::doBasicCornerSelect("Rol",array('1','2'),"300px");

$Selecciona1 = Selects::doBasicCornerSelect("les",array('1','2'),"300px");
$Selecciona2 = Selects::doBasicCornerSelect("les",array('1','2'),"300px");
$Selecciona3 = Selects::doBasicCornerSelect("les",array('1','2'),"300px");

$html2 = Buttons::doFullButton("left","150px","50px","0 auto 0 auto","","rgb(0,0,0)","","corner10","Guardar","18px","black","","");
$html3 = Buttons::doFullButton("left","150px","50px","0 auto 0 auto","","rgb(0,0,0)","","corner10","Editar","18px","black","","");
$html4 = Buttons::doFullButton("left","150px","50px","0 auto 0 auto","","rgb(0,0,0)","","corner10","Eliminar","18px","black","","");

$Cuestionario = GenHtml::doTable("","","","","",
    GenHtml::doTr("","","","","",
        GenHTML::doTd("","","","","",$text6)
        . GenHTML::doTd("","","","","",$Usuario)
        . GenHTML::doTd("","","","","",$text7)
        . GenHTML::doTd("","","","","",$Condominio)
        .GenHTML::doTd("","","","","",$text8)
        . GenHTML::doTd("","","","","",$Rol)
        . GenHTML::doTd("","","","","",$html2)
    )
);
$FORM=GenHtml::doForm("","","","","","_self","post","",$Cuestionario);

$Cuestionario2 = GenHtml::doTable("","","","","",
    GenHtml::doTr("","","","","",
        GenHTML::doTd("","","","","",$text9)
        . GenHTML::doTd("","","","","",$Selecciona1)
        . GenHTML::doTd("","","","","",$text10)
        . GenHTML::doTd("","","","","",$Selecciona2)
        . GenHTML::doTd("","","","","",$text11)
        . GenHTML::doTd("","","","","",$Selecciona3)
    )
);


//Tabla
$row_head=array($text6,$text7,$text8);
$rows_body=array(array('1','2','3'),array('1','2','3'),array('1','2','3'));
$row_foot=array('','','');
$table_width=isset($style['t_width'])?$style['t_width']:"100%";
$style_table="
        border-top:3px solid rgb(0,120,175);
        border-bottom:3px solid rgb(0,120,175);
        width:90%;
        ";
$tabla=Tables::doBasicTable($row_head,"",$rows_body,$row_foot,"");
$style_div="float:left;width:$table_width;margin:0;";

//$id,$padding,$marginTop,$bgColor,$height,$content
$html=LayOut::doContainer("","","","","","",
    LayOut::doContainer("","","","","","",
        LayOut::doCellCorner("desplegados1","100%","","rgb(160,160,160)","1px solid black",$html)
    )
    .LayOut::doContainer("","","","","","",
        LayOut::doCellCorner("","95%","500px","rgb(160,160,160)","1px solid black",
            LayOut::doContainer("","","","","","",
                LayOut::doCellCorner("","55%","400px","rgb(160,160,160)","1px solid black",
                    LayOut::doContainer("","","","","","",$FORM)
                    . LayOut::doContainer("","20px 0 0 0 ","50px","","","",$Cuestionario2.$html3.$html4)
                )
            )
            . LayOut::doContainer("","","400px","rgb(160,160,160)","1px solid black","",$tabla)

        )
    )
);
/*
 *
 * LayOut::doRow("","","","rgb(160,160,160)","80px",
                        LayOut::doCellCorner("","100%","rgb(255,255,255)","",$html)
                    )
            );

 *  "<div style='height: 80px;'>$html</div>"
 *
 *             . LayOut::doCellContainer("desplegados","","","",
                        LayOut::doCellCorner("","100%","rgb(60,60,60)","","<p>bien</p>")
            )
 */
/*****DECLARACION DE SALIDA DE CONTENIDO A PANTALLA A TRAVEZ DE $html*******/
$style = Css::width('1280px');
$style .= Css::margin('0 auto 0 auto');
$html = GenHtml::doDiv("contenedor",$style,"","","",$html);
echo GenHtml::doBody("","",$html,"" );
