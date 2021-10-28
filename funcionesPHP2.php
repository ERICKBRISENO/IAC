<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/DirConfig.php');
include_once(APP_MODELS_UseDb . 'A0_CONDOMINIOS.php');

function AVISO_PRE_GENERAL($sufijo,$FECHA1,$FECHA2,$NOMBRE,$PLANTILLA,$MES,$ANO,$AVISO_PRE,$excel = false){

	$numerodecobros = count($PLANTILLA);
	$partes=$numerodecobros+7;
	$a=(100-$partes)/$partes;

	if( ! $excel ) { echo "<div id=\"botonedocuenta\">"; }
	ECHO"<table class=\"tabla1_titulo\" ><tr>";
	echo "<td style=\"width:$a%;\">DIRECCION</td>";
	echo "<td style=\"width:$a%;\">SALDO ANT.</td>";
	
	foreach($PLANTILLA as $dato){
		echo "<td style=\"width:$a%;\" name=\"muestra_tablas\" >$dato</td>";
	}
	
	echo"<td style=\"width:$a%;\">TOTAL</td>";
	echo"<td style=\"width:$a%;\">PAGOS</td>";
	echo"<td style=\"width:$a%;\">DESC</td>";
	echo"<td style=\"width:$a%;\">ADEUDO</td>";
	if( ! $excel ) { echo"<td style=\"width:$a%;\">AVISO</td>"; }
	echo"</tr>";

	$sql=mysql_query("SELECT * FROM ".$sufijo."_IDENTIFICADOR ORDER BY UNICO");
	
	while($direc=mysql_fetch_assoc($sql)){
		$dir = "";
		$UNICO_IDENT[$direc['UNICO']] = $direc['UNICO'];
		
		$_arr_dir[0]=$direc['CONDOMINIO'];
		$_arr_dir[1]=$direc['SUBCONDOMINIO'];
		$_arr_dir[2]=$direc['DIRECCION'];
		
		$dir=implode(" ",$_arr_dir);
		
		$direccion[$direc['UNICO']] = $dir;
		$unico_alias_dir[$direc['UNICO']] = $direc['ALIAS'];
	}

	///////////////INICIO CARTERA VENCIDA DEL DEPARTAMENTO
	foreach ($UNICO_IDENT as $val){
		$cartera=new cartera_vencida();
		$cartera->sufijo=$sufijo;
		$cartera->UNICO_IDENT=$val;
		$cartera->mes=$MES;
		$cartera->anio=$ANO;
		$cartera->type='anterior';
		$saldo[$val]=$cartera->cartera_depto();
	}
	////////////////////INICIO CARTERA VENCIDA DEL DEPARTAMENTO

	//cobros del mes en forma de platillas*/
	foreach($PLANTILLA as $dato){
			$A+=1;
			
			$sql = mysql_query("SELECT 
			".$sufijo."_IDENTIFICADOR.UNICO AS UNICO,
			SUM(".$sufijo."_COBROS.MONTO) AS MONTO 
			FROM ".$sufijo."_IDENTIFICADOR
			LEFT JOIN ".$sufijo."_COBROS ON 
			".$sufijo."_IDENTIFICADOR.UNICO = ".$sufijo."_COBROS.UNICO_IDENT 
			AND (MONTH(".$sufijo."_COBROS.FECHADECOBRO) = '$MES' AND YEAR(".$sufijo."_COBROS.FECHADECOBRO) = '$ANO')
			AND ".$sufijo."_COBROS.CUENTADECOBRO='$dato'
			GROUP BY UNICO 
			ORDER BY UNICO");
			
			while($dato=mysql_fetch_assoc($sql)){
				$TOTAL[$A][$dato['UNICO']]=$dato['MONTO'];
			}
	}

	//pagos del mes
	$sql = mysql_query("SELECT 
		".$sufijo."_IDENTIFICADOR.UNICO AS UNICO,
		SUM(".$sufijo."_PAGOS.MONTO) AS PAGOA
		FROM ".$sufijo."_IDENTIFICADOR
		LEFT JOIN ".$sufijo."_PAGOS
		ON ".$sufijo."_IDENTIFICADOR.UNICO = ".$sufijo."_PAGOS.UNICO_IDENT 
		and (MONTH(".$sufijo."_PAGOS.FECHADEPAGO) = '$MES' AND YEAR(".$sufijo."_PAGOS.FECHADEPAGO) = '$ANO')
		group by unico 
		HAVING 
			PAGOA >= 0 OR 
			PAGOA IS NULL
	");

	while( $sal = mysql_fetch_assoc($sql) ) {
		$sal_Pagos_act[$sal['UNICO']] = ( empty($sal['PAGOA']) ) ? '0.00' : $sal['PAGOA'];
	}

	//DESCUENTOS del mes
	$sql = mysql_query("SELECT 
		".$sufijo."_IDENTIFICADOR.UNICO AS UNICO,
		SUM(".$sufijo."_DESCUENTOS.MONTO) AS DESCUENTOS
		FROM ".$sufijo."_IDENTIFICADOR
		LEFT JOIN ".$sufijo."_DESCUENTOS
		ON ".$sufijo."_IDENTIFICADOR.UNICO = ".$sufijo."_DESCUENTOS.UNICO_IDENT and 
			(MONTH(".$sufijo."_DESCUENTOS.FECHA) = '$MES' AND YEAR(".$sufijo."_DESCUENTOS.FECHA) = '$ANO')
		group by unico 
		HAVING 
			DESCUENTOS>=0 OR 
			DESCUENTOS IS NULL
		");

	while($sal=mysql_fetch_assoc($sql)){
		$sal_Desc_act[$sal['UNICO']] = ( empty($sal['DESCUENTOS']) ) ? '0.00' : $sal['DESCUENTOS'];
	}




	$A=0;

	foreach ($UNICO_IDENT as $val => $VALOR){
		$TOTAL1=0;
		$asd+=1;
		if($asd % 2==0){
			$color="background-color:rgb(200,200,200);";
		}else{
			$color="background-color:rgb(255,255,255);";
		}
		echo "<tr>
		<td style=\"width:$a%; $color \">". $direccion[$val] ."</td>
		<td style=\"width:$a%; $color \">\$ ".number_format($saldo[$val],2,'.',',')."</td>";$TOTAL1+=$saldo[$val];
			for($A=1;$A<=count($PLANTILLA);$A++){
				ECHO"
				<td style=\"width:$a%; $color \">\$ ".number_format($TOTAL[$A][$val],2,'.',',')."</td>";
				$TOTAL1 += $TOTAL[$A][$val];
			}
		echo"<td style=\"width:$a%; $color \">\$ ". number_format($TOTAL1,2,'.',',') ."</td>";
		echo"<td style=\"width:$a%; $color \">\$ ". number_format($sal_Pagos_act[$val],2,'.',',') ."</td>";
		echo"<td style=\"width:$a%; $color \">\$ ". number_format($sal_Desc_act[$val],2,'.',',') ."</td>";
		echo"<td style=\"width:$a%; $color \">\$ ". number_format($TOTAL1-$sal_Pagos_act[$val]-$sal_Desc_act[$val],2,'.',',')."</td>";
		for($cc=0;$cc<=count($AVISO_PRE);$cc++){
			if( $AVISO_PRE[$cc] == $unico_alias_dir[$val] ) {
				$existe=1;
				break;
				break;
			}else{
				$existe=0;
			}
		}
		if( ! $excel ) {
			if ($existe == 1) {
				echo"<td style=\"width:$a%; $color \">
						<input type=\"checkbox\" 
							name=\"AVISO_PRE[]\" 
							checked=\"checked\" 
							value=\"".$unico_alias_dir[$val]."\" 
						/>";
				echo"OK</td>";
			} else {
				echo"<td style=\"width:$a%; $color \">";
					echo"<input type=\"checkbox\" 
							name=\"AVISO_PRE[]\" 
							value=\"".$unico_alias_dir[$val]."\" 
						/>";
				echo"OK</td>";
			}
		}
	}
	echo "</table>";
	if( ! $excel ) {echo"</div>";}
}
function diaSemana($ano,$mes,$dia){
			// 0->domingo     | 6->sabado
			$dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));
			switch($dia){
				case '0' : $dia_mex = 'DOMINGO'; break;
				case '1' : $dia_mex = 'LUNES'; break;
				case '2' : $dia_mex = 'MARTES'; break;
				case '3' : $dia_mex = 'MIERCOLES'; break;
				case '4' : $dia_mex = 'JUEVES'; break;
				case '5' : $dia_mex = 'VIERNES'; break;
				case '6' : $dia_mex = 'SABADO'; break;
			}
			return $dia_mex;
}
		
function AVISOS_INDIVIDUALES($ident,$sufijo,$sql5,$FECHA_EMISION,$FECHA2,$FECHA_DOCUMENTO,$NOMBRE){

		
		/*$consulta = mysql_query("SELECT * FROM A0_BASES123 WHERE BASEDATA852='$sufijo'");
		while ($dato = mysql_fetch_assoc($consulta)) {
			$condo=$dato[NOMBRECONDO];
			$logo=$dato[DIR_LOGO];
		}
        */
        $BASES123=new BASES123();
        $BASES123->doSelectByBaseData852($sufijo);
        $condo=$BASES123->getNombrecondo();
        $logo=$BASES123->getDirLogo();
    
		$fecha_doc=date("d-m-Y");
		//$fecha_doc='27-10-2015';
		$fecha_explode=explode("-",$fecha_doc);
		$MES=$fecha_explode[1];
		$con=mysql_query("SELECT MES FROM A1_MESES WHERE VALOR='$MES'");
		$MES_LETRA=mysql_result($con,0,0);
		$ANIO=$fecha_explode[2];
		$fecha_letra=$fecha_explode[0]." DE ".$MES_LETRA." DE ".$ANIO;
		
		/*$sql=mysql_query("SELECT CUENTADECOBRO FROM ".$sufijo."_COBROS WHERE 
		(MONTH(FECHADECOBRO) = '$MES' AND YEAR(FECHADECOBRO) = '$ANO') GROUP BY CUENTADECOBRO");
		while($dato = mysql_fetch_assoc($sql)){
			$PLANTILLA[]=$dato[CUENTADECOBRO];
		}
		if(empty($PLANTILLA)){echo"NO HAY CARGOS REGISTRADOS EN ESE PERIODO!!!";exit();}
		
		$numerodecobros = count($PLANTILLA);
		$partes=$numerodecobros+6;
		$a=(100-$partes)/$partes;
		*/
		while($DATA=mysql_fetch_assoc($sql5)){
			$RELLENO[]=$DATA[TEXTO];
		}
		$TITULO=$RELLENO[0];
		$SALUDO=$RELLENO[1];
		$P1=$RELLENO[2];
		$P2=$RELLENO[3];
		$P3=$RELLENO[4];
		$DESPEDIDA=$RELLENO[5];
		$ACLARACION=$RELLENO[6];
		$FIRMA=$RELLENO[7];
		$CONTACTO=$RELLENO[8];


		$TEXT_DEPTO="";
		$TIPO_PREDIO='DEPARTAMENTO';
		$sql=mysql_query("SELECT * FROM ".$sufijo."_IDENTIFICADOR WHERE ALIAS='$ident' limit 1");
		$result=mysql_fetch_assoc($sql);
			$UNICO_IDENT=$result[UNICO];
			if(!empty($result[CONDOMINIO])){$TEXT_DEPTO=$result[CONDOMINIO]." ";}
			if(!empty($result[SUBCONDOMINIO])){$TEXT_DEPTO.=$result[SUBCONDOMINIO]." ";}
			if(!empty($result[DIRECCION])){$TEXT_DEPTO.=$result[DIRECCION];}
			if(!empty($result[TIPOPREDIO])){$TIPO_PREDIO=$result[TIPOPREDIO];}
		
		ECHO"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><title>RECORDATORIO GENERAL</title>
		<style type=\"text/css\"><!--
		body{margin: 0;padding: 0;text-align:left;}
		div{margin: 0;padding: 0;border: 0em;overflow:hidding;}
		table{width:800px;border-collapse:collapse;margin:5px 0 0 0;}
		table.titulo td {border-style:none;}
		.tabla1_titulo{background-color:rgb(100,190,255);}
		td.condominio{font-size:25px;text-align:center;border-style:none;}
		td.titulo1{font-size:20px;text-align:center;border-style:none;}
		td{text-align:center;border:1px solid rgb(60,60,60);}
		.limite_pago{width:800px;background-color:rgb(100,190,255);text-align:center;}
		.texto0{font-size:15px;width:100%;text-align:right;}
		.texto1{font-size:15px;width:100%;text-align:justify;}
		.texto2{font-size:15px;width:100%;text-align:center;}
		.texto4{font:bold 15px;width:100%;text-align:center;padding:0 10% 0 10%;}
		--></style></head><body>";
		
		echo "<div style=\"width:80%;margin:10% 10% 0 10%;\"><br/>";
		ECHO"<table class=\"titulo\" ><tr><td rowspan=\"2\"><img border=\"0\" src=\"../../imagenes/LOGO SAR.jpg\" alt=\"LOGO\" width=\"100\" height=\"70\" /></td><td class=\"condominio\">\"$condo\"</td><td rowspan=\"2\"><img border=\"0\" src=\"../archivos/archivos/".$sufijo."/".$logo."\" alt=\"LOGO\" width=\"100\" height=\"70\" /></td></tr><tr>
		<td class=\"titulo1\">$TITULO</td>
		</tr>
		</table>";
		
		
		$sql2=mysql_query("SELECT NOMBRE FROM ".$sufijo."_IDENT_USUARIOS WHERE UNICO_IDENT='{$UNICO_IDENT}' LIMIT 1");
		$nombre_condomino=mysql_result($sql2,0,0);
		IF(EMPTY($nombre_condomino)){$nombre_condomino="SIN NOMBRE EN BASE DE DATOS";}
	
		
		echo "<br/>
		<p class=\"texto0\" >{$fecha_letra}</p>
		<table class=\"titulo\">";
		echo "<tr><td style=\"text-align:left\" >ESTIMADO CONDOMINO</td><td>{$nombre_condomino}</td></tr>";
		echo "<tr><td style=\"text-align:left\" >{$TIPO_PREDIO}</td><td>{$TEXT_DEPTO}</td></tr>";
		echo "</table>";
		
		
		echo"<p class=\"texto1\" style=\"text-indent:50px;\">$SALUDO</p>";

		
		
		ECHO"<table class=\"titulo\">";
		echo "<tr>
			<td style=\" text-align:left;font:bold 14px arial;\">CONCEPTO</td>
			<td style=\" width:15px;text-align:left;font:bold 14px arial;\" ></td>
			<td style=\" width:100px;text-align:left;font:bold 14px arial;\" >ADEUDO</td>
			</tr>";
			
		$FECHA_SQL=FECHASQL($FECHA_EMISION);
		$seleccion2=mysql_query("SELECT
        ".$sufijo."_COBROS.NUMERODECOBRO AS COBROUNICO,
        ".$sufijo."_COBROS.FECHADECOBRO AS COBROFECH,
        ".$sufijo."_COBROS.CONCEPTODECOBRO AS COBROCONCEPTO,
        ".$sufijo."_COBROS.MONTO AS COBROMONTO,
        SUM(".$sufijo."_APLICA.MONTO) AS PAGOAPLICADO
        FROM ".$sufijo."_COBROS
        LEFT JOIN ".$sufijo."_APLICA
        ON
            ".$sufijo."_COBROS.NUMERODECOBRO = ".$sufijo."_APLICA.COBRO
        WHERE 
			".$sufijo."_COBROS.UNICO_IDENT='$UNICO_IDENT' 
			 AND ".$sufijo."_COBROS.FECHADECOBRO < '{$FECHA_SQL}'
        GROUP BY COBROUNICO
		HAVING (COBROMONTO > PAGOAPLICADO OR PAGOAPLICADO IS NULL)
        ORDER BY ".$sufijo."_COBROS.FECHADECOBRO
        ");
		$num_adeudos=mysql_num_rows($seleccion2);
		if($num_adeudos>10){
			$font_size="font-size:9px;";
		}
		if($num_adeudos>15){
			$font_size="font-size:7px;";
		}
		while ($line2 = mysql_fetch_assoc($seleccion2)) {
		$totalcobro=$line2[COBROMONTO];
		$pagado=$line2[PAGOAPLICADO];
		$pendiente=bcsub($totalcobro,$pagado,2);
		
		$date1=FECHAMEX($line2[FECHADECOBRO]);
		echo "<tr>";
			echo"<td style=\"text-align:left;{$font_size}\">{$line2[COBROCONCEPTO]}</td>
			<td style=\"text-align:right;{$font_size}\" >\$ </td>
			<td style=\"text-align:right;{$font_size}\" >".number_format($pendiente,2,'.',',')."</td>";
		ECHO"</tr>";
		$total_general+=$pendiente;
		}
		echo "<tr>
			<td style=\"text-align:left;font:bold 14px arial;\">ADEUDO TOTAL</td>
			<td style=\"text-align:left;font:bold 14px arial;\" >\$ </td>
			<td style=\"text-align:right;font:bold 14px arial;\" >".number_format($total_general,2,'.',',')."</td>
		</tr>";
		echo "</table>";
		//style=\"text-indent:50px;\"
		echo"<p class=\"texto1\" >$P1</p>";
		echo"<p class=\"texto1\" >$P2</p>";


		
		$fecha_explode=explode("-",$FECHA2);
		$DIA=$fecha_explode[0];
		$MES=$fecha_explode[1];
		$con=mysql_query("SELECT MES FROM A1_MESES WHERE VALOR='$MES'");
		$MES_LETRA=mysql_result($con,0,0);
		$ANIO=$fecha_explode[2];
		$DIA_SEMANA=diaSemana($ANIO,$MES,$DIA);
		
		$fecha_letra=$DIA_SEMANA." ".$fecha_explode[0]." DE ".$MES_LETRA." DE ".$ANIO;
		
		echo "<p class=\"texto4\">$fecha_letra</p>";
		
		
		echo"<p class=\"texto1\" >$P3</p>";
		echo"<p class=\"texto2 \">{$ACLARACION}</p>";
		echo"<p class=\"texto2\">{$DESPEDIDA}</p>";
		echo"<p class=\"texto2\">ATENTAMENTE</p>";
		echo"<br/><p class=\"texto2\" style=\"line-height:110%;\">{$FIRMA}<br>ADMINISTRACION<br>{$CONTACTO}</p>";


}

FUNCTION FIN(){ECHO"</div></body></html>";}










?>