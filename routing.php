<?php 
	
	if(isset($_GET['opcion'])){
		//PLAN DE CUENTAS
		if ($_GET['opcion']=='listPlanCuentas') {
			require_once('plan_cuentas/list.php');
		}
		if ($_GET['opcion']=='registerPlanCuenta') {
			$codigo=$_GET['codigo'];
			require_once('plan_cuentas/register.php');
		}
		if ($_GET['opcion']=='editPlanCuenta') {
			$codigo=$_GET['codigo'];
			require_once('plan_cuentas/edit.php');
		}
		if ($_GET['opcion']=='deletePlanCuenta') {
			$codigo=$_GET['codigo'];
			require_once('plan_cuentas/saveDelete.php');
		}
		if ($_GET['opcion']=='listConfigCuentas') {
			require_once('configuracion_cuentas/list.php');
		}



		if ($_GET['opcion']=='listCuentasAux') {
			$codigo=$_GET['codigo'];
			require_once('cuentas_auxiliares/list.php');
		}
		if ($_GET['opcion']=='registerCuentaAux') {
			$codigo=$_GET['codigo'];
			require_once('cuentas_auxiliares/register.php');
		}
		if ($_GET['opcion']=='editCuentaAux') {
			$codigo=$_GET['codigo'];
			$codigo_padre=$_GET['codigo_padre'];
			require_once('cuentas_auxiliares/edit.php');
		}
		if ($_GET['opcion']=='deleteCuentaAux') {
			$codigo=$_GET['codigo'];
			$codigo_padre=$_GET['codigo_padre'];
			require_once('cuentas_auxiliares/saveDelete.php');
		}



		//PARTIDAS PRESUPUESTARIAS
		if ($_GET['opcion']=='listPartidasPres') {
			require_once('partidas_presupuestarias/list.php');
		}
		if ($_GET['opcion']=='registerPartidaPres') {
			require_once('partidas_presupuestarias/register.php');
		}
		if ($_GET['opcion']=='editPartidaPres') {
			$codigo=$_GET['codigo'];
			require_once('partidas_presupuestarias/edit.php');
		}
		if ($_GET['opcion']=='deletePartidaPres') {
			$codigo=$_GET['codigo'];
			require_once('partidas_presupuestarias/saveDelete.php');
		}			
		if ($_GET['opcion']=='registerOfCuenta') {
			$codigo=$_GET['codigo'];
			require_once('partidas_presupuestarias/registerOfCuenta.php');
		}	

		//COMPROBANTES
		if ($_GET['opcion']=='listComprobantes') {
			require_once('comprobantes/list.php');
		}
		if ($_GET['opcion']=='registerComprobante') {
			require_once('comprobantes/register.php');
		}

	}else{
		//require("paginaprincipal.php");
	}

 ?>