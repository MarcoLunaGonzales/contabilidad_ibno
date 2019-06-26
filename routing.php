<?php 
	
	if(isset($_GET['opcion'])){
		//PERSPECTIVAS
		if ($_GET['opcion']=='listPerspectivas') {
			require_once('perspectivas/list.php');
		}
		if ($_GET['opcion']=='registerPerspectiva') {
			require_once('perspectivas/register.php');
		}
		if ($_GET['opcion']=='editPerspectiva') {
			$codigo=$_GET['codigo'];
			require_once('perspectivas/edit.php');
		}
		if ($_GET['opcion']=='deletePerspectiva') {
			$codigo=$_GET['codigo'];
			require_once('perspectivas/saveDelete.php');
		}			
	}else{
		//require("paginaprincipal.php");
	}

 ?>