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

$idFila=$_GET['idFila'];

?>

<div class="col-md-12">
	<div class="row">

		<div class="col-sm-2">
        	<div class="form-group">
	        <select class="selectpicker form-control form-control-sm" name="unidad<?=$idFila;?>" id="unidad<?=$idFila;?>" data-style="<?=$comboColor;?>" >
			  	<option disabled selected value="">Unidad</option>
			  	<?php
			  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM unidades_organizacionales where cod_estadoreferencial=1 order by 2");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$codigoX=$row['codigo'];
					$nombreX=$row['nombre'];
					$abrevX=$row['abreviatura'];
				?>
				<option value="<?=$codigoX;?>"><?=$abrevX;?></option>	
				<?php
			  	}
			  	?>
			</select>
			</div>
      	</div>

		<div class="col-sm-2">
        	<div class="form-group">
	        <select class="selectpicker form-control form-control-sm" name="area<?=$idFila;?>" id="area<?=$idFila;?>" data-style="<?=$comboColor;?>" >
			  	<option disabled selected value="">Area</option>
			  	<?php
			  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM areas where cod_estadoreferencial=1 and contabilidad=1 order by 2");
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$codigoX=$row['codigo'];
					$nombreX=$row['nombre'];
					$abrevX=$row['abreviatura'];
				?>
				<option value="<?=$codigoX;?>"><?=$abrevX;?></option>	
				<?php
			  	}
			  	?>
			</select>
			</div>
      	</div>

      	<div class="col-sm-3">
        	<div class="form-group" id="divCuentaDetalle<?=$idFila;?>">
        		<input type="hidden" name="cuenta<?=$idFila;?>" id="cuenta<?=$idFila;?>">
        		<input type="hidden" name="cuenta_auxiliar<?=$idFila;?>" id="cuenta_auxiliar<?=$idFila;?>">
			</div><!--i class="material-icons">add</i-->
      	</div>

		<div class="col-sm-2">
            <div class="form-group">
            	<label for="debe<?=$idFila;?>" class="bmd-label-floating">Debe</label>			
          		<input class="form-control" type="number" name="debe<?=$idFila;?>" id="debe<?=$idFila;?>" required="true" onChange="calcularTotalesComprobante();" OnKeyUp="calcularTotalesComprobante();">	
			</div>
      	</div>

		<div class="col-sm-2">
            <div class="form-group">
            	<label for="haber<?=$idFila;?>" class="bmd-label-floating">Haber</label>			
          		<input class="form-control" type="number" name="haber<?=$idFila;?>" id="haber<?=$idFila;?>" required="true" onChange="calcularTotalesComprobante();" OnKeyUp="calcularTotalesComprobante();">	
			</div>
      	</div>

      	<div class="col-sm-2">
		    <div class="form-group">
          		<label for="glosa_detalle<?=$idFila;?>" class="bmd-label-floating">GlosaDetalle</label>
				<textarea class="form-control" name="glosa_detalle<?=$idFila;?>" id="glosa_detalle<?=$idFila;?>" rows="1" value=""></textarea>
			</div>
		</div>

		<div class="col-sm-1">
			<button rel="tooltip" class="btn btn-just-icon btn-danger btn-link" onclick="minusCuentaContable('<?=$idFila;?>');">
            	<i class="material-icons">remove_circle</i>
	        </button>
		</div>

	</div>
</div>

<div class="h-divider">
