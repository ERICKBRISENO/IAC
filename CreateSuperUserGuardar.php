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

include_once(APP_PROCESS . 'ProCondominioCrear.php');

include_once(APP_MODELS_UseDb . 'A0_CLIENTES.php');
include_once(APP_MODELS_UseDb . 'A0_CONDOMINIOS.php');
include_once(APP_MODELS_UseDb . 'A0_ADMINISTRADORES.php');
include_once(APP_MODELS_UseDb . 'A0_ROLES.php');
include_once(APP_MODELS_UseDb . 'A0_ASIGNACIONADMON.php');
include_once(APP_MODELS_COMMON . 'StrAleatorio.php');
include_once(APP_MAILER . 'PHPMailerAutoload.php');

$Empresa=$_POST['EMPRESA'];
$NickEmpresa=$_POST['NICKDEEMPRESA'];
$Nombre=$_POST['NOMBRE'];
$ApPaterno =$_POST['APELLIDO_PATERNO'];
$ApMaterno=$_POST['APELLIDO_MATERNO'];
$FechaNacimientoDia=$_POST['FECHA_NACIMIENTO_DIA'];
$FechaNacimientoMes=$_POST['FECHA_NACIMIENTO_MES'];
$FechaNacimientoAnio=$_POST['FECHA_NACIMIENTO_ANIO'];
$FechaNacimientoMysql = "{$FechaNacimientoAnio}-{$FechaNacimientoMes}-{$FechaNacimientoDia}";
$Telefono=$_POST['TELEFONO'];
$WhatsApp=$_POST['WHATSAPP'];
$Mail=$_POST['MAIL'];

//INSERT CLIENTE
$CLIENTES = New A0_CLIENTES();
$CLIENTES->doInsert($Empresa,$NickEmpresa,$Nombre,$ApPaterno,
    $ApMaterno,$FechaNacimientoMysql,$Telefono,$WhatsApp,$Mail);
$UNICO_CLIENTES = $CLIENTES->getLastId();

//INSERT ADMINISTRADOR
$contrasena=StrAleatorio::getInstance()->doOne(6);
$alias=StrAleatorio::getInstance()->doOne(50);
$ADMINISTRADORES = new A0_ADMINISTRADORESAuto();
$ADMINISTRADORES->doInsertAll($UNICO_CLIENTES, $alias, $Nombre, $ApPaterno, $ApMaterno, $Mail, $Telefono,$Mail,$contrasena, "2");
$UNICO_ADMINISTRADORES = $ADMINISTRADORES->getLastId();

//INSERT CONDOMINIO
$NOMBRECONDO = "MI PRIMER CONDOMINIO";
$A0_CONDOMINIOS = NEW A0_CONDOMINIOS;

do {
    $alias = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 10)), 0, 100);//CARACTERES ALEATORIOS
    $A0_CONDOMINIOS->doSelectAliasByAlias($alias);
    $sql2 = $A0_CONDOMINIOS->getNumMatchs();
} while ($sql2 > 0);
do {
    $sufijo = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 5)), 0, 8);//CARACTERES ALEATORIOS
    $A0_CONDOMINIOS->doSelectByBaseData($sufijo);
    $sql2 = $A0_CONDOMINIOS->getNumMatchs();
} while ($sql2 > 0);

$A0_CONDOMINIOS->doInsertCondominioSimple($UNICO_CLIENTES,$alias,"MIPRIMERCONDOMINIO",$sufijo,$NOMBRECONDO);
$UNICO_CONDOMINIOS = $A0_CONDOMINIOS->getLastId();
//INSERT CONDOMINIO

//INSERT ROLES INICIALES
$A0_ROLES= new A0_ROLES();
$A0_ROLES->doInsertAll($UNICO_CLIENTES,"MAESTRO",1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,11,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
$UNICO_ROLES = $A0_ROLES->getLastId();

//INSERT ASIGNACION INICIAL
$A0_ASIGNACIONADMON = NEW A0_ASIGNACIONADMON;
$A0_ASIGNACIONADMON->doInsertAll($UNICO_CLIENTES,$UNICO_ADMINISTRADORES,$UNICO_CONDOMINIOS,$UNICO_ROLES);

//CREAR CONDOMINIO
$USER['BASE']=$sufijo;
$DATA=ARRAY('UNICO_CLIENTES'=>$UNICO_CLIENTES);

ProCondominioCrear($USER,$DATA);

$mail = new PHPMailer();
//$mail->SMTPDebug = true;
$mail->FromName = "iac.direccion@hotmail.com";
$mail->Username = "iac.direccion@hotmail.com";
$mail->Password = "direccion123";
$mail->Host = "smtp.office365.com";
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPOptions = array('ssl' =>
    array('verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true));
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->AddAddress("iac_direccion@hotmail.com");
$mail->AddAddress($Mail);
$mail->Subject = "IAC USUARIO Y CONTRASEÑA {$NickEmpresa}";
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Body = "LE ENVIAMOS SU NickEmpresa={$NickEmpresa} USUARIO={$Mail} Y CONTRASEÑA={$contrasena}";
$mail->From = "iac.direccion@hotmail.com";


if (!$mail->send()) {
    echo "Mail Error: " . $mail->ErrorInfo;
} else {

}


ECHO GenHtml::doDoctype("HTML-5");
$head_MetaTags = $GeneralesPagina->doMetaTags();
$head_CSS = $GeneralesPagina->doCssLinks();
$head_JS = $GeneralesPagina->doJsLinks();
$head = GenHtml::doHead($head_MetaTags . $head_CSS . $head_JS);

$user_mail = $GeneralesPagina->showBasicViewBoton("0","2560px","50px","180px","18px","showPRIVACIDAD","IMGAVISOPRIVACIDAD");
$contenido="<div id='IMGIACHOME'><img id=\"\" src=\"".DOMINIO."IMG/IACREGISTROEXITOSO.png\" alt=\"IAREGISTROEXISTOSO\" width=\"100%\" ></div>";

$Style = Css::position('fixed');
$Style = Css::float('left');
$Style.=Css::display('block');
$Style.=Css::border('none');
$Style.=Css::top('-330px');
$Style.=Css::left('0px');
$Style.=Css::width('100%');
$Style.=Css::height('46px');

$StyleText=Css::textSize("35px");

$Mail= Texts::doBasicText($Mail,$StyleText);
$html = GenHtml::doDiv("",$Style,"","","",$Mail);

$Style = Css::position('absolute');
$Style.=Css::display('block');
$Style.=Css::border('none');
$Style.=Css::top('661px');
$Style.=Css::left('536px');
$Style.=Css::width('210px');
$Style.=Css::height('50px');
$Style.=Css::zIndex('100');
//$Style.=Css::backColor('rgb(255,255,255)');

$htmlR = "<div id=\"showFAQS\" style=\"{$Style}\" onclick=\"goToPaginaPrincipal();\" ></div>";

$style = Css::width('1280px');
$style .= Css::margin('0 auto 0 auto');
$contenedor = GenHtml::doDiv("contenedor",$style,"","","",$contenido.$html.$htmlR);

$body = GenHtml::doBody("","",$contenedor,"");
ECHO GenHtml::doHtml($head . $body);