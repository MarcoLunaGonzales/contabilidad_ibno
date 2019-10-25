function nuevoAjax()
{ var xmlhttp=false;
  try {
      xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
  } catch (e) {
  try {
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  } catch (E) {
    xmlhttp = false;
  }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function ajaxObtienePadre(cuenta){
  var contenedor;
  var cuentaContable=cuenta.value;
  console.log(cuentaContable);
  //contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'plan_cuentas/ajaxObtienePadre.php?cuenta='+cuentaContable,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      document.getElementById('padre').value = ajax.responseText
    }
  }
  ajax.send(null)
}

var numFilas=0;
var cantidadItems=0;
var filaActiva=0;

function addCuentaContable(obj) {
  numFilas++;
  cantidadItems++;
  filaActiva=numFilas;
  document.getElementById("cantidad_filas").value=numFilas;
  console.log("num: "+numFilas+" cantidadItems: "+cantidadItems);
  fi = document.getElementById('fiel');
  contenedor = document.createElement('div');
  contenedor.id = 'div'+numFilas;  
  fi.type="style";
  fi.appendChild(contenedor);
  var divDetalle;
  divDetalle=document.getElementById("div"+numFilas);
  ajax=nuevoAjax();
  ajax.open("GET","comprobantes/ajaxCuentaContable.php?idFila="+numFilas,true);
  ajax.onreadystatechange=function(){
    if (ajax.readyState==4) {
      divDetalle.innerHTML=ajax.responseText;
      $('.selectpicker').selectpicker(["refresh"]);
      $('#myModal').modal('show');
   }
  }   
  ajax.send(null);
}


function calcularTotalesComprobante(){
  var sumadebe=0;
  var sumahaber=0;

  var formulariop = document.getElementById("form1");
  for (var i=0;i<formulariop.elements.length;i++){
    if (formulariop.elements[i].id.indexOf("debe") !== -1 ){    
      console.log("debe "+formulariop.elements[i].value);    
      sumadebe += (formulariop.elements[i].value) * 1;
    }
    if (formulariop.elements[i].id.indexOf("haber") !== -1 ){        
      console.log("haber "+formulariop.elements[i].value);    
      sumahaber += (formulariop.elements[i].value) * 1;
    }
  }  
  document.getElementById("totaldeb").value=sumadebe;  
  document.getElementById("totalhab").value=sumahaber;  
}

function ajaxCorrelativo(combo){
  var contenedor = document.getElementById('divnro_correlativo');
  var tipoComprobante=combo.value;
  console.log(tipoComprobante);
  ajax=nuevoAjax();
  ajax.open('GET', 'comprobantes/ajaxCorrelativo.php?tipo_comprobante='+tipoComprobante,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText;
    }
  }
  ajax.send(null)
}

function buscarCuenta(combo){
  var contenedor = document.getElementById('divResultadoBusqueda');
  var nroCuenta=document.getElementById('nro_cuenta').value;
  var nombreCuenta=document.getElementById('cuenta').value;
  ajax=nuevoAjax();
  ajax.open('GET', 'comprobantes/ajaxBusquedaCuenta.php?nro_cuenta='+nroCuenta+'&cuenta='+nombreCuenta,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText;
    }
  }
  ajax.send(null)
}

function setBusquedaCuenta(codigoCuenta, numeroCuenta, nombreCuenta, codigoCuentaAux, nombreCuentaAux){
  var fila=filaActiva;
  console.log(fila);
  document.getElementById('divCuentaDetalle'+fila).innerHTML=numeroCuenta+' '+nombreCuenta;
  $('#myModal').modal('hide');
}