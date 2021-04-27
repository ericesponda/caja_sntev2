<?php
    $server=1;
    $_SESSION['pagina']=30;

    if(isset($_SESSION['administrador']) and $_SESSION['administrador']==1){
        $_SESSION['des']=0;   ///////////////cambiar esta para acceder a modo desarrollador
    }
    else{
        $_SESSION['des']=0;   ///////////////cambiar esta para acceder a modo desarrollador
    }

    $_SESSION['des']=1;

    if($_SESSION['des']==1){
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        date_default_timezone_set("America/Mexico_City");
    }

    if($server==0){
        define("MYSQLUSER", "saludpublica");
        define("MYSQLPASS", "saludp123$");
        define("SERVIDOR", "localhost");
        define("BDD", "salud");
        define("PORT", "3306");
    }
    if($server==1){
        /////////remoto
        define("MYSQLUSER", "sagyce18_sagyc");
        define("MYSQLPASS", "sagyc123$");
        define("SERVIDOR", "sagyc2.com.mx");
        define("BDD", "sagyce18_caja");
        define("PORT", "3306");
    }

?>
