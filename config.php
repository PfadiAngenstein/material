<?php
    // CREDENTIALS
    $cMdUser				= "timo.held@bluewin.ch"; //User needs to be "Adressverwalter"
	$cMdPass				= "Apfelmostt813";

    //MiDataCred
    $urlMiData = "https://db.scout.ch";
    $groups2get = "1"; //Groupids



    //MiData Config
    $arrLabels = array("Spezialfunktion", "Fonction spÃ©ciale", "funzione speciale"); //Display labels instead role_type for these roles
    $labels = implode(",", $arrLabels);
    $labels = utf8_encode($labels);
    $arrLabels = explode(",", $labels);




    

?>