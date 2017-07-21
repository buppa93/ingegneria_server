<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MultimediaDbInterface.php";

    $id = $_GET["id"];

    $multimediaDbInstance = new MultimediaDbInterface();
    $multimediaDbInstance->createConn();
    $res = $multimediaDbInstance->delete($id);
    $multimediaDbInstance->closeConn();

    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }

?>