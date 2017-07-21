<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MuseoDbInterface.php";

    $id = $_GET["id"];

    $museoDbInstance = new MuseoDbInterface();
    $museoDbInstance->createConn();
    $res = $museoDbInstance->delete($id);
    $museoDbInstance->closeConn();

    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremusei');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremusei');
    }

?>