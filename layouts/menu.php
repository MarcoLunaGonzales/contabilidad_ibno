<?php

$globalUserX=$_SESSION['globalUser'];
//echo $globalUserX;
$globalPerfilX=$_SESSION['globalPerfil'];
$globalNameUserX=$_SESSION['globalNameUser'];
$globalNombreUnidadX=$_SESSION['globalNombreUnidad'];
$globalNombreAreaX=$_SESSION['globalNombreArea'];

if($globalPerfilX==1){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>

        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">fullscreen</i>
              <p> Tablas
                <b class="caret"></b>
              </p>
            </a>

            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Transacciones
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> T1</span>
                    <span class="sidebar-normal"> Transacciones 1 </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportes">
              <i class="material-icons">assessment</i>
              <p> Reportes
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportes">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> R1 </span>
                    <span class="sidebar-normal"> Reporte 1</span>
                  </a>
                </li>                             

              </ul>
            </div>
          </li>

        </ul>
      </div>
    </div>
<?php
}
?>

