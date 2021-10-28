<?php

class conta_individual{
	public $sufijo= ''; 
	public $UNICO_IDENT= ''; 
	public $mes= ''; 
	public $anio= '';
	public $type='anterior';
    
	function cobros(){
		$sufijo=$this->sufijo;
        $UNICO_IDENT=$this->UNICO_IDENT;
        $mes=$this->mes;
        $anio=$this->anio;
		$type=$this->type;
		if($type=='acumulado_anterior'){$type='<';$type2="OR(YEAR(FECHADECOBRO) < '$anio')"; }
		if($type=='acumulado_corriente'){$type='<=';$type2="OR(YEAR(FECHADECOBRO) < '$anio')";}
		if($type=='solo_mes_corriente'){$type='=';$type2='';}
		$sql=mysql_query("SELECT * FROM ".$sufijo."_COBROS WHERE UNICO_IDENT='$UNICO_IDENT'
			AND ((MONTH(FECHADECOBRO) $type '$mes' AND YEAR(FECHADECOBRO) = '$anio') $type2 ) ");
	}
}

class cartera_vencida{
	public $sufijo= ''; 
	public $UNICO_IDENT= ''; 
	public $mes= ''; 
	public $anio= '';
	public $type='anterior';
	
	function cartera_depto(){
		$sufijo=$this->sufijo;$UNICO_IDENT=$this->UNICO_IDENT;$mes=$this->mes;$anio=$this->anio;
		$type=$this->type;if($type=='anterior'){$type='<';}
		if($type=='corriente'){$type='<=';}
			$sql=mysql_query("
			SELECT SUM(MONTO)  AS COBROS,0 as PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_COBROS 
			WHERE ".$sufijo."_COBROS.UNICO_IDENT='$UNICO_IDENT'
			AND ((MONTH(FECHADECOBRO) $type '$mes' AND YEAR(FECHADECOBRO) = '$anio')OR(YEAR(FECHADECOBRO) < '$anio'))
			UNION
			SELECT 0 AS COBROS,SUM(MONTO) AS PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_PAGOS
			WHERE ".$sufijo."_PAGOS.UNICO_IDENT='$UNICO_IDENT'
			AND ((MONTH(FECHADEPAGO) $type '$mes' AND YEAR(FECHADEPAGO) = '$anio')OR(YEAR(FECHADEPAGO) < '$anio'))
			UNION
			SELECT 0 AS COBROS,0 as PAGOS, SUM(MONTO) AS DESCUENTOS FROM ".$sufijo."_DESCUENTOS
			WHERE ".$sufijo."_DESCUENTOS.UNICO_IDENT='$UNICO_IDENT'
			AND ((MONTH(FECHA) $type '$mes' AND YEAR(FECHA) = '$anio')OR(YEAR(FECHA) < '$anio'))
			");
		while($DATOS = mysql_fetch_assoc($sql)){
		$COBROS=bcadd($COBROS,$DATOS['COBROS'],2);
		$PAGOS=bcadd($PAGOS,$DATOS['PAGOS'],2);
		$DESCUENTOS=bcadd($DESCUENTOS,$DATOS['DESCUENTOS'],2);}
		$SALDO1=bcsub($COBROS,$PAGOS,2);
		$TOTAL_CARTERA=bcsub($SALDO1,$DESCUENTOS,2);
		RETURN $TOTAL_CARTERA;
	}

	function cartera_total(){
		$sufijo=$this->sufijo;
		$mes=$this->mes;
		$anio=$this->anio;
		$type=$this->type;
		if($type=='anterior'){$type='<';}
		if($type=='corriente'){$type='<=';}
		
		$sql=mysql_query("SELECT 
				".$sufijo."_COBROS.NUMERODECOBRO AS COBROS1,
				".$sufijo."_COBROS.CUENTADECOBRO AS CUENTA,
				".$sufijo."_COBROS.UNICO_IDENT AS UNICO_IDENT,
				".$sufijo."_COBROS.MONTO AS MONTO_ORIG,
				SUM(".$sufijo."_APLICA.MONTO) AS APLICA
			FROM ".$sufijo."_COBROS 
			LEFT JOIN ".$sufijo."_APLICA
			ON ".$sufijo."_COBROS.NUMERODECOBRO=".$sufijo."_APLICA.COBRO
				AND ((MONTH(".$sufijo."_APLICA.FECHA_PAGO) $type '$mes' AND YEAR(".$sufijo."_APLICA.FECHA_PAGO) = '$anio')
				OR(YEAR(".$sufijo."_APLICA.FECHA_PAGO) < '$anio'))
			WHERE (
					(MONTH(".$sufijo."_COBROS.FECHADECOBRO) $type '$mes' AND YEAR(".$sufijo."_COBROS.FECHADECOBRO) = '$anio')
					OR(YEAR(".$sufijo."_COBROS.FECHADECOBRO) < '$anio')
				)
			GROUP BY COBROS1 
				HAVING APLICA < MONTO_ORIG 
				OR APLICA IS NULL 
			ORDER BY UNICO_IDENT ASC
		");
		while($DATOS = mysql_fetch_assoc($sql)){
			$COBROS=bcadd($COBROS,$DATOS['MONTO_ORIG'],2);
			$PAGOS=bcadd($PAGOS,$DATOS['APLICA'],2);
		}
		$TOTAL_CARTERA=bcsub($COBROS,$PAGOS,2);
		RETURN $TOTAL_CARTERA;
	}
}

class desglose{
	public $sufijo= ''; 
	public $UNICO_IDENT= '';
	public $anio= '';
	public $click_atras='';
	public $click_adelante='';
	public $_Tipo_Usuario="";
	public $_To_Excel="";
	public $_Sesion="";
	public $selectedMes="";
	
	
	function year(){
		$YEAR=date('Y',time());
		return $YEAR;
	}
	function desglose_depto(){
		$sufijo=$this->sufijo;
		$depto=$this->UNICO_IDENT;
		$ANIO=$this->anio;
		$click_atras=$this->click_atras;
		$click_adelante=$this->click_adelante;
		
		if(empty($ANIO)){
			$ANIO=$this->year();
		}
		IF($ANIO < $this->year()){
			$month='12';
            $this->selectedMes='12';
		}
		if(empty($this->selectedMes) and $ANIO == $this->year()){
			$month = date('m',time());
		}else{
			$month = $this->selectedMes;
		}
		
		$ANIO_ANT=$ANIO-1;
		$ANIO_POS=$ANIO+1;
		
		if($this->_Tipo_Usuario == 1){
			$_id_form=uniqid();
			if($this->_To_Excel != 1){
				echo"<form id=\"$_id_form\" method=\"post\" 
				target=\"_blank\" action=\"pantallas/reside/ExcelDesglose.php\">
				<input type=\"hidden\" name=\"sesion\" value=\"" . $this->_Sesion . "\"'>
				<input type=\"hidden\" name=\"ANIO\" value=\"" . $this->anio . "\"'>
				<input type=\"hidden\" name=\"DEPTO\" value=\"" . $this->UNICO_IDENT . "\"'>
				</form>";
			}
		}
		if($this->_To_Excel != 1){
			ECHO " <table class=\"\"><tr class=\"titulo_seccion\">
			<td style=\"color:rgb(255,255,255);width:20%;\" $click_atras > << $ANIO_ANT</td>
			<td >
			DESGLOSE DE COBROS Y PAGOS DE $ANIO ";
			if($this->_Tipo_Usuario == 1){
				echo "<input type=\"button\" value=\"XLS\" onclick=\"document.getElementById('$_id_form').submit();\" />";
			}
			echo"
			</td>
			<td style=\"color:rgb(255,255,255);width:20%;\" $click_adelante >$ANIO_POS >> </td>
			</tr></table>";
		}
		
		$cobros=mysql_query("SELECT SUM(MONTO)FROM ".$sufijo."_COBROS WHERE UNICO_IDENT='$depto' and YEAR(FECHADECOBRO)< '$ANIO' ");
		$cobros=mysql_result($cobros,0,0);
		$pagos=mysql_query("SELECT SUM(MONTO)FROM ".$sufijo."_PAGOS WHERE UNICO_IDENT='$depto' and YEAR(FECHADEPAGO) < '$ANIO' ");
		$pagos=mysql_result($pagos,0,0);
		$descuento=mysql_query("SELECT SUM(MONTO)FROM ".$sufijo."_DESCUENTOS WHERE UNICO_IDENT='$depto' and YEAR(FECHA) < '$ANIO' ");
		$descuento=mysql_result($descuento,0,0);
		$total=bcsub($cobros,$pagos,2);
		$total=bcsub($total,$descuento,2);
		if (empty($total)){$saldoanterior="0.00";}else{$saldoanterior=number_format($total,2);}
		echo "<table class=\"\">";
		echo"<tr class=\"titulo_seccion\" >
		<td>FECHA</td>
		<td>CONCEPTO</td>
		<td>(+)COBROS</td>
		<td>(-)PAGOS</td>
		<td>(-)DESC.</td>
		<td>(=)SALDO</td>
		</tr>";
		echo"<tr class=\"A1\"><td></td><td>SALDO A CIERRE DE $ANIO_ANT</td><td></td><td></td><td></td><td>$saldoanterior</td></tr>";
		$saldos=$total;
		
		$sql=mysql_query("
			SELECT NUMERODECOBRO AS UNICO,FECHADECOBRO AS FECHA,'COBRO' as TIPO ,
				CONCEPTODECOBRO AS CONCEPTO,MONTO AS TOTAL1,null AS TOTAL2,NULL AS TOTAL3 
			FROM ".$sufijo."_COBROS 
				WHERE UNICO_IDENT='$depto'
				AND (YEAR(FECHADECOBRO) = '$ANIO' AND MONTH(FECHADECOBRO) <= '$month')
		UNION
			SELECT NUMERODEPAGO AS UNICO,FECHADEPAGO AS FECHA,'PAGO' as TIPO ,
				CONCAT('PAGO EN ',CUENTA_INGRESO,' ',FORMADEPAGO) AS CONCEPTO,
				null AS TOTAL1,MONTO AS TOTAL2,NULL AS TOTAL3 
			FROM ".$sufijo."_PAGOS 
				WHERE UNICO_IDENT='$depto'
				AND (YEAR(FECHADEPAGO) = '$ANIO' AND MONTH(FECHADEPAGO) <= '$month')
		UNION
			SELECT NUMERO AS UNICO,FECHA AS FECHA,'DESC' as TIPO ,
				CONCAT(FUNDAMENTO,' ',DETALLES) AS CONCEPTO,
				null AS TOTAL1,NULL AS TOTAL2,MONTO AS TOTAL3 
			FROM ".$sufijo."_DESCUENTOS 
				WHERE UNICO_IDENT='$depto'
				AND (YEAR(FECHA) = '$ANIO' AND MONTH(FECHA) <= '$month')
		ORDER BY FECHA ASC
	 ");
		 
		 
		while($dato=mysql_fetch_assoc($sql)){
			$a+=1;
			$CONCEPTO=$dato['CONCEPTO'];
		if($dato['TIPO']=='PAGO'){
			$sqlALFA=mysql_query("SELECT CONCEPTO,MONTO FROM ".$sufijo."_APLICA WHERE UNICO='{$dato['UNICO']}' AND (TIPO='INGRESO' OR TIPO ='INGRESO2') ");
			while($datoALFA=mysql_fetch_assoc($sqlALFA)){
				$CONCEPTO.="<span style=\"font-size:11;\"><BR/> [{$datoALFA['CONCEPTO']} = {$datoALFA['MONTO']}] </span>";
			}
		}
			
			$COB=$dato[TOTAL1];
			$PAG=$dato[TOTAL2];
			$DES=$dato[TOTAL3];
			$saldos=bcadd($saldos,bcsub(bcsub($COB,$PAG,2),$DES,2),2);
			if($a%2){$class="A2";}else{$class="A1";}
			
			echo"<tr class=\"$class\" onmouseover=\"resaltar_over(this);\" onclick=\"resaltar(this);\" >
			<td>".FECHAMEX($dato['FECHA'])."</td>
			<td>{$CONCEPTO}</td>
			<td>".number_format($dato['TOTAL1'],2)."</td>
			<td>".number_format($dato['TOTAL2'],2)."</td>
			<td>".number_format($dato['TOTAL3'],2)."</td>
			<td>".number_format($saldos,2)."</td>
			</tr>";
		
		}
		echo "</table>";
	}	
}
class saldo{
	public $sufijo= ''; 
	public $UNICO_IDENT= ''; 
	public $mes= ''; 
	public $anio= ''; 
	public $type='anterior';
	
function saldo_depto(){
	$sufijo=$this->sufijo;$UNICO_IDENT=$this->UNICO_IDENT;$mes=$this->mes;$anio=$this->anio;
	$type=$this->type;if($type=='anterior'){$type='<';}
	if($type=='corriente'){$type='<=';}
		$sql=mysql_query("
		SELECT SUM(MONTO)  AS COBROS,0 as PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_COBROS 
		WHERE ".$sufijo."_COBROS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHADECOBRO) $type '$mes' AND YEAR(FECHADECOBRO) = '$anio') OR(YEAR(FECHADECOBRO) < '$anio'))
		UNION
		SELECT 0 AS COBROS,SUM(MONTO) AS PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_PAGOS
		WHERE ".$sufijo."_PAGOS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHADEPAGO) $type '$mes' AND YEAR(FECHADEPAGO) = '$anio')OR(YEAR(FECHADEPAGO) < '$anio'))
		UNION
		SELECT 0 AS COBROS,0 as PAGOS, SUM(MONTO) AS DESCUENTOS FROM ".$sufijo."_DESCUENTOS
		WHERE ".$sufijo."_DESCUENTOS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHA) $type '$mes' AND YEAR(FECHA) = '$anio')OR(YEAR(FECHA) < '$anio'))
		");
	while($DATOS = mysql_fetch_assoc($sql)){
	$COBROS=bcadd($COBROS,$DATOS['COBROS'],2);
	$PAGOS=bcadd($PAGOS,$DATOS['PAGOS'],2);
	$DESCUENTOS=bcadd($DESCUENTOS,$DATOS['DESCUENTOS'],2);}
	$SALDO1=bcsub($COBROS,$PAGOS,2);
	$SALDO=bcsub($SALDO1,$DESCUENTOS,2);
	RETURN $SALDO;
}
}

class anticipos{
	public $sufijo= ''; 
	public $UNICO_IDENT= ''; 
	public $mes= ''; 
	public $anio= ''; 
	public $type='anterior';

function anticipo_depto_del_mes(){
	$sufijo=$this->sufijo;$UNICO_IDENT=$this->UNICO_IDENT;$mes=$this->mes;$anio=$this->anio;
	$type=$this->type;if($type=='anterior'){$type='<';}
	if($type=='corriente'){$type='<=';}
		$sql=mysql_query("
		SELECT SUM(MONTO)  AS COBROS,0 as PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_COBROS 
		WHERE ".$sufijo."_COBROS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHADECOBRO) $type '$mes' AND YEAR(FECHADECOBRO) = '$anio'))
		UNION
		SELECT 0 AS COBROS,SUM(MONTO) AS PAGOS, 0 as DESCUENTOS FROM ".$sufijo."_PAGOS
		WHERE ".$sufijo."_PAGOS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHADEPAGO) $type '$mes' AND YEAR(FECHADEPAGO) = '$anio'))
		UNION
		SELECT 0 AS COBROS,0 as PAGOS, SUM(MONTO) AS DESCUENTOS FROM ".$sufijo."_DESCUENTOS
		WHERE ".$sufijo."_DESCUENTOS.UNICO_IDENT='$UNICO_IDENT'
		AND ((MONTH(FECHA) $type '$mes' AND YEAR(FECHA) = '$anio'))
		");
	while($DATOS = mysql_fetch_assoc($sql)){
	$COBROS=bcadd($COBROS,$DATOS['COBROS'],2);
	$PAGOS=bcadd($PAGOS,$DATOS['PAGOS'],2);
	$DESCUENTOS=bcadd($DESCUENTOS,$DATOS['DESCUENTOS'],2);}
	$SALDO1=bcsub($COBROS,$PAGOS,2);
	$SALDO=bcsub($SALDO1,$DESCUENTOS,2);
	RETURN $SALDO;
}


}









?>