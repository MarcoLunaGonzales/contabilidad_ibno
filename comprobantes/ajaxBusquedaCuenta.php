<?php

require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();
$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];

//$idFila=$_GET['idFila'];

$nroCuentaBusqueda=$_GET["nro_cuenta"];
$nombreCuentaBusqueda=$_GET["cuenta"];

$sqlBusqueda="SELECT p.codigo, p.numero, p.nombre from plan_cuentas p where p.nivel=5 ";
if($nroCuentaBusqueda!=""){
	$sqlBusqueda.=" and p.numero like '%".$nroCuentaBusqueda."%'";
}
if($nombreCuentaBusqueda!=""){
	$sqlBusqueda.=" and p.nombre like '%".$nombreCuentaBusqueda."%'";
}
$sqlBusqueda.=" order by p.numero";

//echo $sqlBusqueda;

$stmt = $dbh->prepare($sqlBusqueda);
$stmt->execute();
$stmt->bindColumn('codigo', $codigoCuenta);
$stmt->bindColumn('numero', $numeroCuenta);
$stmt->bindColumn('nombre', $nombreCuenta);

?>

<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Nro. Cuenta</th>
	      			<th>Nombre</th>
	      			<th>Auxiliar</th>
	  			</tr>
			</thead>
		<?php
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
			$numeroCuenta=trim($numeroCuenta);
			$nombreCuenta=trim($nombreCuenta);

			$sqlCuentasAux="SELECT codigo, nombre FROM cuentas_auxiliares where cod_cuenta='$codigoCuenta' order by 2";
			$stmtAux = $dbh->prepare($sqlCuentasAux);
			$stmtAux->execute();
			$stmtAux->bindColumn('codigo', $codigoCuentaAux);
			$stmtAux->bindColumn('nombre', $nombreCuentaAux);
			$txtAuxiliarCuentas="<table class='table table-condensed'>";
			while ($rowAux = $stmtAux->fetch(PDO::FETCH_BOUND)) {
				$txtAuxiliarCuentas.="<tr>
				<td class='text-left small'>$codigoCuentaAux</td>
				<td class='text-left small'><a href='javascript:setBusquedaCuenta('$codigoCuenta','$numeroCuenta','$nombreCuenta','$codigoCuentaAux','$nombreCuentaAux');'>$nombreCuentaAux</a></td>
				</tr>";
			}  	
			$txtAuxiliarCuentas.="</table>";
		?>
		<tr>
			<td class="text-left"><?=$numeroCuenta;?></td>
	      	<td class="text-left"><a href="javascript:setBusquedaCuenta('<?=$codigoCuenta;?>','<?=$numeroCuenta;?>','<?=$nombreCuenta;?>','0','');"><?=$nombreCuenta;?></a></td>
	      	<td class="text-left"><?=$txtAuxiliarCuentas;?></td>
		</tr>
		<?php
		}
		?>
		</table>
	</div>
</div>

