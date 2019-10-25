<?php

require_once '../layouts/bodylogin.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsGeneral.php';
require_once 'configModule.php';

$dbh = new Conexion();

$codGestion=$_POST["gestion"];
$codUnidad=$_POST["unidad_organizacional"];
$cantidadFilas=$_POST["cantidad_filas"];
$tipoComprobante=$_POST["tipo_comprobante"];
$nroCorrelativo=$_POST["nro_correlativo"];
$glosa=$_POST["glosa"];

session_start();

$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

$fechaHoraActual=date("Y-m-d H:i:s");


$codComprobante=obtenerCodigoComprobante();
$sqlInsert="INSERT INTO comprobantes (codigo, cod_empresa, cod_unidadorganizacional, cod_gestion, cod_moneda, cod_estadocomprobante, cod_tipocomprobante, fecha, numero, glosa, created_at, created_by, modified_at, modified_by) VALUES ('$codComprobante', '1', '$globalUnidad', '$codGestion', '1', '1', '$tipoComprobante', '$fechaHoraActual', '$nroCorrelativo', '$glosa', '$fechaHoraActual', '$globalUser', '$fechaHoraActual', '$globalUser')";
echo $sqlInsert;
$stmtInsert = $dbh->prepare($sqlInsert);
$flagSuccess=$stmtInsert->execute();	


for ($i=1;$i<=$cantidadFilas;$i++){ 	    	
	$cuenta=$_POST["cuenta".$i];

	if($cuenta!=0 || $cuenta!=""){
		$area=$_POST["area".$i];
		$debe=$_POST["debe".$i];
		$haber=$_POST["haber".$i];
		$glosaDetalle=$_POST["glosa_detalle".$i];

		//BORRAMOS LA TABLA
		$sqlDelete="";
		$sqlDelete="DELETE from comprobantes_detalle where cod_comprobante='$codigoComprobante'";
		$stmtDel = $dbh->prepare($sqlDelete);
		$flagSuccess=$stmtDel->execute();

		$sqlDetalle="INSERT INTO comprobantes_detalle (cod_comprobante, cod_cuenta, cod_area, debe, haber, glosa, orden) VALUES ('$codComprobante', '$cuenta', '$area', '$debe', '$haber', '$glosaDetalle', '$i')";
		$stmtDetalle = $dbh->prepare($sqlDetalle);
		$flagSuccessDetalle=$stmtDetalle->execute();	

	}
} 

if($flagSuccess==true){
	showAlertSuccessError(true,$urlList);	
}else{
	showAlertSuccessError(false,$urlList);
}


?>
