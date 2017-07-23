<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MuseoOperatoreDbInterface.php";

    setcookie("insert", "");
    $id_museo = $_POST['id_museo'];
    $id_operatore = $_POST['id_operatore'];

    $museoOp = new MuseoOperatore($id_museo, $id_operatore);

    $mmdbInstance = new MuseoOperatoreDbInterface();
    $mmdbInstance->createConn();
    $res = $mmdbInstance->create($museoOp);
    if($res)
    {
        setcookie("insert", "true");
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoreoperatori');
    }
    else
    {
        setcookie("insert", "false");
        //header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoreoperatori');
        echo $mmdbInstance->getConn()->error;
    }
    $mmdbInstance->closeConn();

?>