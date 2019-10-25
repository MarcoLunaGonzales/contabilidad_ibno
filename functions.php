<?php

require_once 'conexion.php';

function nameMes($month){
  setlocale(LC_TIME, 'es_ES');
  $monthNum  = $month;
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  $monthName = strftime('%B', $dateObj->getTimestamp());
  return $monthName;
}

function abrevMes($month){
  if($month==1){    return ("Ene");   }
  if($month==2){    return ("Feb");  }
  if($month==3){    return ("Mar");  }
  if($month==4){    return ("Abr");  }
  if($month==5){    return ("May");  }
  if($month==6){    return ("Jun");  } 
  if($month==7){    return ("Jul");  }
  if($month==8){    return ("Ago");  }
  if($month==9){    return ("Sep");  }
  if($month==10){    return ("Oct");  }         
  if($month==11){    return ("Nov");  }         
  if($month==12){    return ("Dic");  }             
}

function nameGestion($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM gestiones where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameCuenta($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM plan_cuentas where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function obtieneNumeroCuenta($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT numero FROM plan_cuentas where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['numero'];
   }
   return($nombreX);
}


function obtieneNuevaCuenta($codigo){//ESTA FUNCION TRABAJA CON UNA CUENTA FORMATEADA CON PUNTOS
   $dbh = new Conexion();
   $nivelCuenta=buscarNivelCuenta($codigo);
   $cuentaSinFormato=str_replace(".","",$codigo);
   $nivelCuentaBuscado=$nivelCuenta+1;
   
   //echo "nivel cta: ".$nivelCuentaBuscado; 

   list($nivel1, $nivel2, $nivel3, $nivel4, $nivel5) = explode('.', $codigo);
   
   $stmt = $dbh->prepare("SELECT (max(numero))numero FROM plan_cuentas where cod_padre=:codigo");
   $stmt->bindParam(':codigo',$cuentaSinFormato);
   $stmt->execute();
   $cuentaHijoMaxima="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cuentaHijoMaxima=$row['numero'];
   }
   //echo "max:".$cuentaHijoMaxima;
   //ACA SACAMOS EL NUMERO DEL NIVEL MAXIMO
   $numeroIncrementar=0;
   if($nivelCuentaBuscado==2){
      $numeroIncrementar=substr($cuentaHijoMaxima, 1,2);
   }
   if($nivelCuentaBuscado==3){
      $numeroIncrementar=substr($cuentaHijoMaxima, 3,2);
   }
   if($nivelCuentaBuscado==4){
      $numeroIncrementar=substr($cuentaHijoMaxima, 5,2);
   }
   if($nivelCuentaBuscado==5){
      $numeroIncrementar=substr($cuentaHijoMaxima, 7,3);
   }
   $numeroIncrementar=($numeroIncrementar*1)+1;

  $nuevaCuenta="";
  if($nivelCuentaBuscado==3){
    $numeroIncremetarConCeros = str_pad($numeroIncrementar, 2, "0", STR_PAD_LEFT);
    $nuevaCuenta=$nivel1.$nivel2.$numeroIncremetarConCeros."00"."000";
  }
  if($nivelCuentaBuscado==4){
    $numeroIncremetarConCeros = str_pad($numeroIncrementar, 2, "0", STR_PAD_LEFT);
    $nuevaCuenta=$nivel1.$nivel2.$nivel3.$numeroIncremetarConCeros."000";
  }
  if($nivelCuentaBuscado==5){
    $numeroIncremetarConCeros = str_pad($numeroIncrementar, 3, "0", STR_PAD_LEFT);
    $nuevaCuenta=$nivel1.$nivel2.$nivel3.$nivel4.$numeroIncremetarConCeros;
  }
  //echo $nuevaCuenta;
  return($nuevaCuenta);
}

function formateaPlanCuenta($cuenta, $nivel){
  $tabs="";
  for($i=1;$i<=$nivel;$i++){
    $tabs.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  }
  $cuenta=$tabs.$cuenta;
  if($nivel==1){
    $cuenta="<span class='text-left font-weight-bold'>$cuenta</span>";
  }
  if($nivel==5){
    $cuenta="<span class='text-primary small'>$cuenta</span>";
  }
  return($cuenta);
}

function formateaPuntosPlanCuenta($cuenta){
  $nivel1=substr($cuenta, 0, 1);
  $nivel2=substr($cuenta, 1, 2);
  $nivel3=substr($cuenta, 3, 2);
  $nivel4=substr($cuenta, 5, 2);
  $nivel5=substr($cuenta, 7, 3);
  $cuentaNueva=$nivel1.".".$nivel2.".".$nivel3.".".$nivel4.".".$nivel5;
  return($cuentaNueva);
}

function buscarCuentaPadre($cuenta){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM plan_cuentas where numero='$cuenta'");
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function buscarNivelCuenta($cuenta){
  list($nivel1, $nivel2, $nivel3, $nivel4, $nivel5) = explode('.', $cuenta);
  $nivelCuenta=0;
  if($nivel5!="000"){
    $cuentaPadre=$nivel1.$nivel2.$nivel3.$nivel4."000";
    $cuentaBuscar=buscarCuentaPadre($cuentaPadre);
    if($cuentaBuscar!=""){
      $nivelCuenta=5;
    }
  }
  if($nivel5=="000" && $nivel4!="00"){
    $cuentaPadre=$nivel1.$nivel2.$nivel3."00"."000";
    $cuentaBuscar=buscarCuentaPadre($cuentaPadre);
    if($cuentaBuscar!=""){
      $nivelCuenta=4;
    } 
  }
  if($nivel5=="000" && $nivel4=="00" && $nivel3!="00"){
    $cuentaPadre=$nivel1.$nivel2."00"."00"."000";
    $cuentaBuscar=buscarCuentaPadre($cuentaPadre);
    if($cuentaBuscar!=""){
      $nivelCuenta=3;
    } 
  }
  if($nivel5=="000" && $nivel4=="00" && $nivel3=="00" && $nivel2!="00"){
    $cuentaPadre=$nivel1."00"."00"."00"."000";
    $cuentaBuscar=buscarCuentaPadre($cuentaPadre);
    if($cuentaBuscar!=""){
      $nivelCuenta=2;
    } 
  }
  return $nivelCuenta;
}

function obtenerCodigoComprobante(){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT IFNULL(max(c.codigo)+1,1)as codigo from comprobantes c");
   $stmt->execute();
   $codigoComprobante=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigoComprobante=$row['codigo'];
   }
   return($codigoComprobante);
}


function nameCargo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM cargos where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function namePartidaPres($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM partidas_presupuestarias where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameArea($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM areas where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function abrevArea($codigo){
   $dbh = new Conexion();
   $sql="SELECT abreviatura FROM areas where codigo in ($codigo)";
   $stmt = $dbh->prepare($sql);
   //echo $sql;
   $stmt->execute();
   $cadenaAreas="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cadenaAreas=$cadenaAreas."-".$row['abreviatura'];
   }
   return($cadenaAreas);
}

function nameUnidad($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM unidades_organizacionales where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function namePersonal($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM personal2 where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function abrevUnidad($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT abreviatura FROM unidades_organizacionales where codigo in ($codigo)");
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['abreviatura']." - ";
   }
   return($nombreX);
}



function buscarAreasAdicionales($cod_personal,$tipo){//1 codigos , 2 nombres
  $dbh = new Conexion();
  $sql="SELECT pa.cod_area, (select a.abreviatura from areas a where a.codigo=pa.cod_area)as nombre from personal_areas pa where pa.cod_personal='$cod_personal'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="0";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codAreaAdi=$row['cod_area'];
      $nombreAreaAdi=$row['nombre'];
      if($tipo==1){
        $cadena.=",".$codAreaAdi;
      }
      if($tipo==2){
        $cadena.=",".$nombreAreaAdi;
      }
  }
  return($cadena);  
}

function buscarUnidadesAdicionales($cod_personal,$tipo){//1 codigos , 2 nombres
  $dbh = new Conexion();
  $sql="SELECT pa.cod_unidad, (select a.abreviatura from unidades_organizacionales a where a.codigo=pa.cod_unidad)as nombre from personal_unidadesorganizacionales pa where pa.cod_personal='$cod_personal'";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="0";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codAreaAdi=$row['cod_unidad'];
      $codUnidadHijos=buscarHijosUO($codAreaAdi);
      $nombreAreaAdi=$row['nombre'];
      if($tipo==1){
        $cadena.=",".$codUnidadHijos;
      }
      if($tipo==2){
        $cadena.=",".$nombreAreaAdi;
      }
  }
  return($cadena);  
}

function obtenerUnidadesReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT u.codigo from unidades_organizacionales u";
  }else{
    $sql="SELECT u.codigo from unidades_organizacionales u where u.codigo in ($codigo)";
  }
  //echo "codigo.".$codigo." ".$sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

function obtenerAreasReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT a.codigo from areas a";
  }else{
    $sql="SELECT a.codigo from areas a where a.codigo in ($codigo)";
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

function obtenerUFV($date){
  $dbh = new Conexion();
  $sql="";
  $sql="SELECT u.valor from ufvs u where u.fecha='$date'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $valor="0";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valor=$row['valor'];
  }
  return($valor);  
}

?>

