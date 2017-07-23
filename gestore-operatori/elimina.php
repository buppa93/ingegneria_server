<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MuseoOperatoreDbInterface.php";

    $id_museo = $_GET["id_museo"];
    $id_operatore = $_GET["id_operatore"];

    $mmDbInstance = new MuseoOperatoreDbInterface();
    $mmDbInstance->createConn();
    $res = $mmDbInstance->delete($id_museo, $id_operatore);
    $mmDbInstance->closeConn();

    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoreoperatori');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoreoperatori');
    }

?>