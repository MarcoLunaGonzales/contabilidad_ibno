<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';
require_once 'functionsGeneral.php';
require_once 'configModule.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$globalNombreGestion=$_SESSION["globalNombreGestion"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalAdmin=$_SESSION["globalAdmin"];

/*$sqlCount="";
$sqlCount="SELECT count(*)as nro_registros FROM actividades_poa where cod_indicador='$codigoIndicador' and cod_area in ($globalArea) and cod_unidadorganizacional in ($globalUnidad) and cod_estado=1";	
$stmtX = $dbh->prepare($sqlCount);
$stmtX->execute();
while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
	$contadorRegistros=$row['nro_registros'];
}*/
$contadorRegistros=0;

$fechaActual=date("Y-m-d");

?>
<script>
	numFilas=<?=$contadorRegistros;?>;
	cantidadItems=<?=$contadorRegistros;?>;
</script>

<div class="content">
	<div class="container-fluid">

		<form id="form1" class="form-horizontal" action="comprobantes/save.php" method="post">

			<input type="hidden" name="cantidad_filas" id="cantidad_filas" value="<?=$contadorRegistros;?>">

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h4 class="card-title">Registrar <?=$moduleNameSingular;?></h4>
					</div>
				</div>
				<div class="card-body ">
					<div class="row">
					
						<div class="col-sm-2">
							<div class="form-group">
						  		<label for="gestion" class="bmd-label-floating">Gestion</label>
					  			<input class="form-control" type="text" name="gestion" value="<?=$globalNombreGestion;?>" id="gestion" readonly="true" />
							</div>
						</div>

						<div class="col-sm-2">
							<div class="form-group">
						  		<label for="unidad_organizacional" class="bmd-label-floating">Unidad</label>
						  		<input class="form-control" type="text" name="unidad_organizacional" value="<?=$globalNombreUnidad;?>" id="unidad_organizacional" readonly="true" />
							</div>
						</div>

						<div class="col-sm-2">
							<div class="form-group">
						  		<label for="fecha" class="bmd-label-floating">Fecha</label>
						  		<input class="form-control" type="date" name="fecha" value="<?=$fechaActual;?>" id="fecha" readonly="true"/>
							</div>
						</div>

						<div class="col-sm-4">
				        	<div class="form-group">
					        <select class="selectpicker form-control" name="tipo_comprobante" id="tipo_comprobante" data-style="<?=$comboColor;?>" onChange="ajaxCorrelativo(this);">
							  	<option disabled selected value="">Tipo de Comprobante</option>
							  	<?php
							  	$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM tipos_comprobante where cod_estadoreferencial=1 order by 1");
								$stmt->execute();
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$codigoX=$row['codigo'];
									$nombreX=$row['nombre'];
									$abrevX=$row['abreviatura'];
								?>
								<option value="<?=$codigoX;?>"><?=$nombreX;?></option>	
								<?php
							  	}
							  	?>
							</select>
							</div>
				      	</div>

						<div class="col-sm-2">
							<div class="form-group">
						  		<label for="nro_correlativo" class="bmd-label-floating">#Correlativo</label>
						  		<div id="divnro_correlativo"><input class="form-control" type="number" name="nro_correlativo" id="nro_correlativo" min="1" required="true" readonly="true" /></div>
							</div>
						</div>
						
					</div>

					<div class="row">
					    <div class="col-sm-12">
						    <div class="form-group">
				          		<label for="glosa" class="bmd-label-floating">Glosa</label>
								<textarea class="form-control" name="glosa" id="glosa" required="true" rows="1" value=""></textarea>
							</div>
						</div>
					</div>

				</div>
			</div>	

			<div class="card">
				<div class="card-header <?=$colorCard;?> card-header-text">
					<div class="card-text">
					  <h6 class="card-title">Detalle</h6>
					</div>
				</div>
				<div class="card-body ">

					<?php
					//$sqlDetalle="";
					//$stmtLista = $dbh->prepare($sqlDetalle);
					//$stmtLista->execute();

					/*$stmtLista->bindColumn('cod_tiposeguimiento', $codTipoSeguimiento);
					$stmtLista->bindColumn('cod_tiporesultado', $codTipoResultado);
					$stmtLista->bindColumn('cod_unidadorganizacional', $codUnidad);
					$stmtLista->bindColumn('cod_area', $codArea);
					$stmtLista->bindColumn('cod_datoclasificador',$codDatoClasificador);
					$stmtLista->bindColumn('clave_indicador',$claveIndicador);
					$stmtLista->bindColumn('observaciones',$observaciones);
					$stmtLista->bindColumn('cod_hito',$codHito);
					*/
					?>
					<fieldset id="fiel" style="width:100%;border:0;">
						<button type="button" name="add" class="btn btn-warning btn-round btn-fab" onClick="addCuentaContable(this)" accesskey="a">
                      		<i class="material-icons">add</i>
		                </button>						
			        	<?php
    	                //$index=1;
                      	//while ($rowLista = $stmtLista->fetch(PDO::FETCH_BOUND)) {
	                    ?>
						<div id="div<?=$index;?>">	
							
							<div class="h-divider">
	        				</div>
		 					
	 					</div>
			            <?php
						//	$index++;
						//}
						?>
		            </fieldset>
							
							<div class="row">
								<div class="col-sm-5">
						      	</div>
								<div class="col-sm-2">
						            <div class="form-group">	
						          		<input class="form-control" type="number" name="totaldeb" id="totaldeb" readonly="true">	
									</div>
						      	</div>
								<div class="col-sm-2">
						            <div class="form-group">
						            	<input class="form-control" type="number" name="totalhab" id="totalhab" readonly="true">	
									</div>
						      	</div>
						      	<div class="col-sm-3">
								</div>
							</div>

				  	<div class="card-footer fixed-bottom">
						<button type="submit" class="<?=$buttonMorado;?>">Guardar</button>
						<a href="<?=$urlList;?>" class="<?=$buttonCancel;?>">Cancelar</a>

				  	</div>

				</div>
			</div>	
		</form>
	</div>
</div>



<!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form name="form1">
	  		<div class="row">
    	      	<div class="form-group col-sm-4">
            		<label for="nro_cuenta" class="bmd-label-floating">Nro. Cuenta:</label>
            		<input type="number" class="form-control" id="nro_cuenta" name="nro_cuenta">
          		</div>
          		<div class="form-group col-sm-6">
            		<label for="cuenta" class="bmd-label-floating">Cuenta:</label>
            		<input type="text" class="form-control" id="cuenta" name="cuenta">
          		</div>
    	      	<div class="form-group col-sm-2">
      		        <button type="button" class="btn btn-just-icon btn-danger btn-link" onclick="buscarCuenta(form1);">
      		        	<i class="material-icons">search</i>
      		        </button>
          		</div>
          	</div>
          	<div class="row" id="divResultadoBusqueda">
    	      	<div class="form-group col-sm-8">
	          		Resultados de la Búsqueda        		
          		</div>
          	</div>
        </form>
      </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button-->
      </div>
    </div>
  </div>
</div>
<!--  End Modal -->