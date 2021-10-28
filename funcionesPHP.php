<?php


function CONECTARSE(){
$direccion = 'localhost:3306';
$usuario = 'saradmon_IAC';
$password = 'SARadmon123';
    $base="saradmon_IAC";
   if (!($link=mysql_connect($direccion,$usuario,$password)))
   {echo "Error conectando a la base de datos.";exit();}
   if (!mysql_select_db($base,$link))
   {echo "Error seleccionando la base de datos.";exit();   }
   return $link;
}

function CONECTARSE_2(){
$direccion = 'localhost:3306';
$usuario = 'saradmon_adminis';
$password = 'SARadmon123';
$base="saradmon_sys2";
   if (!($link=mysql_connect($direccion,$usuario,$password)))
   {echo "Error conectando a la base de datos.";exit();}
   if (!mysql_select_db($base,$link))
   {echo "Error seleccionando la base de datos.";exit();   }
   return $link;
}


function COMPARA_FECHAS($FECHA_BASE,$FECHA_COMPARA){
	$FECHA_BASE=explode("-",$FECHA_BASE);
	$FECHA_COMPARA=explode("-",$FECHA_COMPARA);
	$mes_base=$FECHA_BASE[1];
	$anio_base=$FECHA_BASE[2];
	$mes_compara=$FECHA_COMPARA[1];
	$anio_compara=$FECHA_COMPARA[2];
		if(($mes_compara<=$mes_base and $anio_compara==$anio_base) or $anio_compara<$anio_base){
		return true;
		}else{ return false;}
}

function EXISTE_LA_FECHA_IN_SQLFORMAT($FECHA){
    $timezone = new DateTimeZone('America/Mexico_City');
	$date = DateTime::createFromFormat( '!Y-m-d' , $FECHA);
    $date2 = $date->format("Y-m-d");
    if(!$date){
        return false;
    }else{
        if($date2 != $FECHA){
            return false;
        }
        return true;
    }
}

function IS_FECHA1_MAYOR_FECHA2_IN_SQLFORMAT($FECHA1,$FECHA2){
    $timezone = new DateTimeZone('America/Mexico_City');
    $FECHA1 = DateTime::createFromFormat( "!Y-m-d" , $FECHA1  );
    $FECHA2 = DateTime::createFromFormat( "!Y-m-d" , $FECHA2  );
    if ($FECHA1 > $FECHA2){
        return true;
    }
    return false;
}

function IS_FECHA1_MAYOR_OR_IGUAL_FECHA2_IN_SQLFORMAT($FECHA1,$FECHA2){
    $timezone = new DateTimeZone('America/Mexico_City');
    $FECHA1 = DateTime::createFromFormat( "!Y-m-d" , $FECHA1  );
    $FECHA2 = DateTime::createFromFormat( "!Y-m-d" , $FECHA2  );
    if ($FECHA1 >= $FECHA2){
        return true;
    }
    return false;
}




function FECHAMEX_MENOS60DIAS($FECHA_BASE){
	$FECHA_BASE=explode("-",$FECHA_BASE);
	$dia_base=$FECHA_BASE[0];
	$mes_base=$FECHA_BASE[1];
	$anio_base=$FECHA_BASE[2];
	if($mes_base >= 3){
		$mes_menos=$mes_base-2;
		if(strlen($mes_menos)==1){
			$mes_menos="0".$mes_menos;
		}
		return $dia_base."-".$mes_menos."-".$anio_base;
	}
	if($mes_base < 3){
		$mes_menos=$mes_base+10;
		$anio_menos=$anio_base-1;
		return $dia_base."-".$mes_menos."-".$anio_menos;
	}	
}

function limpiaSQL($array) {
	// Check if the parameter is an array
	if(is_array($array)) {
		foreach($array as $key => $value) {
			if(is_array($array[$key])){
				$array[$key] = limpiaSQL($array[$key]);
			}
            if(is_string($array[$key])){
				$array[$key] = mysql_real_escape_string($array[$key]);
				$DIABLO1=array("\\n","\\");
				$array[$key]=str_ireplace($DIABLO1," ",$array[$key]);
				$DIABLO=array("<",">","%","=","”","“","|","+","from"," insert ","update","delete","drop","`","eval(","encode","decode"," or ","like"," and ","&","'");
				$array[$key]=str_ireplace($DIABLO,"",$array[$key]);
			}
		}
	}
    // Check if the parameter is a string
    if(is_string($array)){
		$array = mysql_real_escape_string($array);
		$DIABLO1=array("\\n","\\");
		$array=str_ireplace($DIABLO1," ",$array);
		$DIABLO=array("<",">","%","=","”","“","|","+","from"," insert ","update","delete","drop","`","eval(","encode","decode"," or ","like"," and ","&","'");
		$array=str_ireplace($DIABLO,"",$array);
	}
	return $array;
}
function SALIR($VALOR){
	echo "<input type=\"hidden\" id=\"alertamalinfo\" value=\"$VALOR\">";
	exit();
}

function FECHAMEX($VALOR){
	$a=explode("-",$VALOR);
	$fecha=$a[2]."-".$a[1]."-".$a[0];
	return $fecha;
}
function FECHASQL($VALOR){
	$a=explode("-",$VALOR);
	$fecha=$a[2]."-".$a[1]."-".$a[0];
	return $fecha;
}

function LOGO(){
echo "		<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"450px\" height=\"50px\" id=\"logosar\" align=\"middle\">
		<param name=\"allowScriptAccess\" value=\"sameDomain\" />
		<param name=\"movie\" value=\"../logosar.swf\" /><param name=\"loop\" value=\"false\" />
		<param name=\"menu\" value=\"false\" /><param name=\"quality\" value=\"high\" />
		<param name=\"wmode\" value=\"transparent\" /><embed src=\"/imagenes/logosar.swf\"
		loop=\"false\" menu=\"false\" quality=\"high\" wmode=\"transparent\" width=\"400px\" height=\"50px\" name=\"logosar\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
		</object>
";}


function HEAD(){

    echo "<!DOCTYPE shtml PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    //echo '<!DOCTYPE html>';
	echo"<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"es\" lang=\"es\">
    <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <meta name=\"Language\" content=\"Spanish\"/>
    <meta http-equiv=\"Expires\" content=\"Fri, 20 Feb 2000 10:51:12 GMT\"/>
    <meta http-equiv=\"Last-Modified\" content=\"0\"/>
    <meta http-equiv=\"Cache-Control\" content=\"no-cache, mustrevalidate\"/>
    <meta http-equiv=\"Pragma\" content=\"no-cache\"/>
    <meta http-equiv=\"Expires\" content=\"-1\">
    <meta http-equiv=\"cache-control\" content=\"no-store\">
    <meta name=\"author\" content=\"SAR ADMON\" />
    <link href=\"favicon.ico\" type=\"image/x-icon\" rel=\"shortcut icon\">
    ";
}

function ACCESONEGADO($bool){
echo"
<link rel=\"stylesheet\" type=\"text/css\" href=\"https://www.systemsar.net/estilosCSS/css_admin_layout.css?".time()."\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"https://www.systemsar.net/estilosCSS/css_admin_theme_base.css?".time()."\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"https://www.systemsar.net/jscript/JQUERY_UI_DARKNESS/css/ui-darkness/jquery-ui-1.8.18.custom.css\">
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscript/JQUERY_UI_DARKNESS/js/jquery-1.7.1.min.js\"></script>
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscript/JQUERY_UI_DARKNESS/js/jquery-ui-1.8.18.custom.min.js\"></script>
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscript/jquery/jquery-ui-i18n.js\"></script>
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscript/jquery/colResizable-1.3.min.js\"></script>
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscript/JQUERY_UPLOAD/jquery.MultiFile.pack.js\"></script>
<script type=\"text/javascript\" src=\"https://www.systemsar.net/jscodigoscript.js?".time()."\"></script>";
echo'<script type="text/javascript" src="/jscript/tinymce/tinymce.min.js"></script>';
echo"</head><body>";

$IP=limpiaSQL($_SERVER["REMOTE_ADDR"]);
$PORT=limpiaSQL($_SERVER["REMOTE_PORT"]);

echo "<div id=\"ACCESO\" class=\"corner20\" >
<form action=\"index.php\" method=\"post\" autocomplete=\"off\">";
$alias=substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678901234567890123456789',15)),0,20);
mysql_query("INSERT into A010RESUBMIT (CLAVE,IP,PORT) values('$alias','$IP','$PORT')");
echo"<input type=\"hidden\" name=\"VALOR\" value=\"".$alias."\">
<table id=\"tableacceso\">";
if($bool==1){echo "<tr><td class=\"acceserror\" colspan=\"2\">¡¡¡ DATOS ERRONEOS !!!</td><td></td></tr>";}
echo "<tr><td class=\"accestitulo corner20\" colspan=\"2\">SERVICIOS DE ADMINISTRACION RESIDENCIAL</td><td></td></tr>
<tr><td class=\"accestd1 corner10\">IDENTIFICADOR</td><td class=\"accestd2 corner10\"><input class=\"text_1\" maxlength=\"20\" type=\"TEXT\" name=\"IDENTIFY390\"></td></tr>
<tr><td class=\"accestd1 corner10\">USUARIO</td>      <td class=\"accestd2 corner10\"><input class=\"text_1\" maxlength=\"20\" type=\"TEXT\" name=\"USUALOGIN110\"></td></tr>
<tr><td class=\"accestd1 corner10\">CONTRASEÑA</td>   <td class=\"accestd2 corner10\"><input class=\"text_1\" maxlength=\"20\" type=\"password\" name=\"CONTRA520\"></td></tr>
<tr><td class=\"accestitulo corner20\" colspan=\"2\"><input class=\"boton_1\" type=\"submit\" value=\"ACEPTAR\"></td><td></td></tr>
</table>
</form>
</div>
</body>
</html>
";
}
function ACCESONEGADO2(){
exit("<script>window.location = \"https://www.systemsar.net\"</script>");
}




/***********************************IMPORTANTE***************FUNCION PARA CONVERTIR DE NUMEROS A LETRAS***********/
function PESOS($numero){
	$numero=number_format($numero, 2,".","");
	list($entero,$decimal)=explode(".",$numero);
	$LETRAS="-- ".convertir($entero)." PESOS ".$decimal."/100 MN"." --";
	return $LETRAS;}
function num2letras($num, $fem = false, $dec = false) {
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");
   $matuni[2]  = "dos";   $matuni[3]  = "tres";   $matuni[4]  = "cuatro";   $matuni[5]  = "cinco";   $matuni[6]  = "seis";   $matuni[7]  = "siete";
   $matuni[8]  = "ocho";   $matuni[9]  = "nueve";   $matuni[10] = "diez";   $matuni[11] = "once";   $matuni[12] = "doce";   $matuni[13] = "trece";
   $matuni[14] = "catorce";   $matuni[15] = "quince";   $matuni[16] = "dieciseis";   $matuni[17] = "diecisiete";   $matuni[18] = "dieciocho";
   $matuni[19] = "diecinueve";   $matuni[20] = "veinte";   $matunisub[2] = "dos";   $matunisub[3] = "tres";   $matunisub[4] = "cuatro";   $matunisub[5] = "quin";
   $matunisub[6] = "seis";   $matunisub[7] = "sete";   $matunisub[8] = "ocho";   $matunisub[9] = "nove";
   
   $matdec[2] = "veint";   $matdec[3] = "treinta";   $matdec[4] = "cuarenta";   $matdec[5] = "cincuenta";   $matdec[6] = "sesenta";   $matdec[7] = "setenta";
   $matdec[8] = "ochenta";   $matdec[9] = "noventa";   $matsub[3]  = 'mill';   $matsub[5]  = 'bill';   $matsub[7]  = 'mill';   $matsub[9]  = 'trill';
   $matsub[11] = 'mill';   $matsub[13] = 'bill';   $matsub[15] = 'mill';   $matmil[4]  = 'millones';   $matmil[6]  = 'billones';   $matmil[7]  = 'de billones';
   $matmil[8]  = 'millones de billones';   $matmil[10] = 'trillones';   $matmil[11] = 'de trillones';   $matmil[12] = 'millones de trillones';   $matmil[13] = 'de trillones';
   $matmil[14] = 'billones de trillones';   $matmil[15] = 'de billones de trillones';   $matmil[16] = 'millones de billones de trillones';

   $num = trim((string)@$num);
   if ($num[0] == '-') {$neg = 'menos ';$num = substr($num, 1);}else     $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;   $zeros = true;   $punt = false;   $ent = '';   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {$n = $num[$c];     
   if (! (strpos(".,'''", $n) === false)) {if ($punt) break;else{$punt = true;continue;}}
   elseif (! (strpos('0123456789', $n) === false)) {if ($punt) {if ($n != '0') $zeros = false;$fra .= $n;}else $ent .= $n;}
   else  break;}
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {$fin = ' con';
      for ($n = 0; $n < strlen($fra); $n++) {if (($s = $fra[$n]) == '0') $fin .= ' cero';elseif ($s == '1') $fin .= $fem ? ' una' : ' un'; else $fin .= ' ' . $matuni[$s];}}
   else $fin = ''; if ((int)$ent === 0) return 'Cero ' . $fin; $tex = ''; $sub = 0; $mils = 0; $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') { $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {$matuni[1] = 'una';$subcent = 'as';}else{$matuni[1] = $neutro ? 'un' : 'uno';$subcent = 'os';}
      $t = ''; $n2 = substr($num, 1);
      if ($n2 == '00') {}
      elseif ($n2 < 21) $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {$n3 = $num[2];if ($n3 != 0) $t = 'i' . $matuni[$n3];$n2 = $num[1];$t = ' ' . $matdec[$n2] . $t;}
      else{$n3 = $num[2];if ($n3 != 0) $t = ' y ' . $matuni[$n3];$n2 = $num[1];$t = ' ' . $matdec[$n2] . $t;}
      $n = $num[0];
      if ($n == 1)    {$t = ' ciento' . $t;}
      elseif ($n == 5){$t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;}
      elseif ($n != 0){$t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;}
      if ($sub == 1) {}elseif (! isset($matsub[$sub])) {if ($num == 1) {$t = ' mil';}elseif ($num > 1){$t .= ' mil';}}
      elseif ($num == 1){$t .= ' ' . $matsub[$sub] . '&oacute;n';}
      elseif ($num > 1) {$t .= ' ' . $matsub[$sub] . 'ones';}   
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];$mils = 0;}
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   return ucfirst($tex);}
function unidad($numuero){
	switch ($numuero){
		case 9:{$numu = "NUEVE";break;}
		case 8:{$numu = "OCHO";break;}
		case 7:{$numu = "SIETE";break;}		
		case 6:{$numu = "SEIS";break;}		
		case 5:{$numu = "CINCO";break;}		
		case 4:{$numu = "CUATRO";break;}		
		case 3:{$numu = "TRES";break;}
		case 2:{$numu = "DOS";break;}		
		case 1:{$numu = "UN";break;}		
		case 0:{$numu = "";break;}		
	}return $numu;}
function decena($numdero){
		if ($numdero >= 90 && $numdero <= 99)	{$numd = "NOVENTA ";if ($numdero > 90)$numd = $numd."Y ".(unidad($numdero - 90));}
		else if ($numdero >= 80 && $numdero <= 89){$numd = "OCHENTA ";if ($numdero > 80)$numd = $numd."Y ".(unidad($numdero - 80));}
		else if ($numdero >= 70 && $numdero <= 79){$numd = "SETENTA ";if ($numdero > 70)$numd = $numd."Y ".(unidad($numdero - 70));}
		else if ($numdero >= 60 && $numdero <= 69){$numd = "SESENTA ";if ($numdero > 60)$numd = $numd."Y ".(unidad($numdero - 60));}
		else if ($numdero >= 50 && $numdero <= 59){$numd = "CINCUENTA ";if ($numdero > 50)$numd = $numd."Y ".(unidad($numdero - 50));}
		else if ($numdero >= 40 && $numdero <= 49){$numd = "CUARENTA ";if ($numdero > 40)$numd = $numd."Y ".(unidad($numdero - 40));}
		else if ($numdero >= 30 && $numdero <= 39){$numd = "TREINTA ";if ($numdero > 30)$numd = $numd."Y ".(unidad($numdero - 30));}
		else if ($numdero >= 20 && $numdero <= 29){if ($numdero == 20)$numd = "VEINTE ";else $numd = "VEINTI".(unidad($numdero - 20));}
		else if ($numdero >= 10 && $numdero <= 19){
		switch ($numdero){
			case 10:{$numd = "DIEZ ";break;}
			case 11:{$numd = "ONCE ";break;}
			case 12:{$numd = "DOCE ";break;}
			case 13:{$numd = "TRECE ";break;}
			case 14:{$numd = "CATORCE ";break;}
			case 15:{$numd = "QUINCE ";break;}
			case 16:{$numd = "DIECISEIS ";break;}
			case 17:{$numd = "DIECISIETE ";break;}
			case 18:{$numd = "DIECIOCHO ";break;}
			case 19:{$numd = "DIECINUEVE ";break;}
			}}
		else $numd = unidad($numdero);return $numd;}
function centena($numc){if ($numc >= 100){
			if ($numc >= 900 && $numc <= 999){$numce = "NOVECIENTOS ";if ($numc > 900)$numce = $numce.(decena($numc - 900));}
			else if ($numc >= 800 && $numc <= 899){$numce = "OCHOCIENTOS ";if ($numc > 800)$numce = $numce.(decena($numc - 800));}
			else if ($numc >= 700 && $numc <= 799){$numce = "SETECIENTOS ";if ($numc > 700)$numce = $numce.(decena($numc - 700));}
			else if ($numc >= 600 && $numc <= 699){$numce = "SEISCIENTOS ";if ($numc > 600)$numce = $numce.(decena($numc - 600));}
			else if ($numc >= 500 && $numc <= 599){$numce = "QUINIENTOS ";if ($numc > 500)$numce = $numce.(decena($numc - 500));}
			else if ($numc >= 400 && $numc <= 499){$numce = "CUATROCIENTOS ";if ($numc > 400)$numce = $numce.(decena($numc - 400));}
			else if ($numc >= 300 && $numc <= 399){$numce = "TRESCIENTOS ";if ($numc > 300)$numce = $numce.(decena($numc - 300));}
			else if ($numc >= 200 && $numc <= 299){$numce = "DOSCIENTOS ";if ($numc > 200)$numce = $numce.(decena($numc - 200));}
			else if ($numc >= 100 && $numc <= 199){if ($numc == 100)$numce = "CIEN ";
			else $numce = "CIENTO ".(decena($numc - 100));}
		}else $numce = decena($numc);return $numce;}
function miles($nummero){if ($nummero >= 1000 && $nummero < 2000){$numm = "UN MIL ".(centena($nummero%1000));}
		if ($nummero >= 2000 && $nummero <10000){$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));}
		if ($nummero < 1000)$numm = centena($nummero);return $numm;}
function decmiles($numdmero){if ($numdmero == 10000)$numde = "DIEZ MIL";
		if ($numdmero > 10000 && $numdmero <20000){$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));}
		if ($numdmero >= 20000 && $numdmero <100000){$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));}		
		if ($numdmero < 10000)$numde = miles($numdmero);return $numde;}		
function cienmiles($numcmero){if ($numcmero == 100000)$num_letracm = "CIEN MIL";
		if ($numcmero >= 100000 && $numcmero <1000000){$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));}
		if ($numcmero < 100000)$num_letracm = decmiles($numcmero);return $num_letracm;}	
function millon($nummiero){if ($nummiero >= 1000000 && $nummiero <2000000){$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));}
		if ($nummiero >= 2000000 && $nummiero <10000000){$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));}
		if ($nummiero < 1000000)$num_letramm = cienmiles($nummiero);return $num_letramm;}	
function decmillon($numerodm){if ($numerodm == 10000000)$num_letradmm = "DIEZ MILLONES";
		if ($numerodm > 10000000 && $numerodm <20000000){$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));}
		if ($numerodm >= 20000000 && $numerodm <100000000){$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));}
		if ($numerodm < 10000000)$num_letradmm = millon($numerodm);return $num_letradmm;}
function cienmillon($numcmeros){if ($numcmeros == 100000000)$num_letracms = "CIEN MILLONES";
		if ($numcmeros >= 100000000 && $numcmeros <1000000000){$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));}
		if ($numcmeros < 100000000)$num_letracms = decmillon($numcmeros);return $num_letracms;}	
function milmillon($nummierod){if ($nummierod >= 1000000000 && $nummierod <2000000000){$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));}
		if ($nummierod >= 2000000000 && $nummierod <10000000000){$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));}
		if ($nummierod < 1000000000)$num_letrammd = cienmillon($nummierod);return $num_letrammd;}	
function convertir($numero){$numf = milmillon($numero);return $numf;}
/***********************************IMPORTANTE***************FUNCION PARA CONVERTIR DE NUMEROS A LETRAS***********/


function APLICA_ANTICIPOS($sufijo){
	//APLICACION DE ANTICIPOS
	$sql=mysql_query("SELECT * FROM ".$sufijo."_ANTICIPOS WHERE MONTO>0 ");
	while ($dato = mysql_fetch_assoc($sql)) {
	$NUM_PAGO=$dato[NUMERODEPAGO];
	$NUM_COBRO=$dato[NUMERODECOBRO];
	if($dato[TIPO]=='INGRESO'){$TIPO='INGRESO';}
	if($dato[TIPO]=='DESCUENTO'){$TIPO='DESCUENTO';}
	$anticipo=$dato[MONTO];
		$sql2=mysql_query("SELECT * FROM ".$sufijo."_COBROS WHERE UNICO_IDENT='$dato[UNICO_IDENT]' and PORCUBRIR>0 ORDER BY FECHADECOBRO ASC");
		while ($dato2 = mysql_fetch_assoc($sql2)) {
		$porcubrir=$dato2[PORCUBRIR];
		$concepto_anti=$dato2[CONCEPTODECOBRO];
		$cubrir=0;
		if ($anticipo >= $porcubrir){$cubrir=$porcubrir;}else{$cubrir=$anticipo;}
		if($cubrir>0){
		mysql_query("UPDATE ".$sufijo."_ANTICIPOS SET MONTO=MONTO - '$cubrir' WHERE NUMERODEPAGO='$NUM_PAGO' AND TIPO='$TIPO' ");
		mysql_query("UPDATE ".$sufijo."_COBROS SET PORCUBRIR=PORCUBRIR - '$cubrir' WHERE NUMERODECOBRO ='$dato2[NUMERODECOBRO]' ");
		mysql_query("INSERT into ".$sufijo."_APLICA (UNICO,UNICO_IDENT,FECHA_PAGO,TIPO,COBRO,FECHA_COBRO,MONTO,CUENTA,CONCEPTO) VALUES ('$dato[NUMERODEPAGO]','$dato[UNICO_IDENT]','$dato[FECHADEPAGO]','$TIPO','$dato2[NUMERODECOBRO]','$dato2[FECHADECOBRO]','$cubrir','$dato2[CUENTADECOBRO]','$concepto_anti') ");
				$anticipo=$anticipo-$cubrir;}
		}
	}
}


function arrayDiff($A, $B) {
    $intersect = array_intersect($A, $B);
    return array_merge(array_diff($A, $intersect), array_diff($B, $intersect));
}











?>