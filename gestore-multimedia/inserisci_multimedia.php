<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MultimediaDbInterface.php";

    setcookie("insert", "");
    $id = $_POST['id'];
    $id_tipo = $_POST['id_tipo'];
    $id_reperto = $_POST['id_reperto'];
    $url = $_POST['url'];

    $multimedia = new Multimedia($id, $id_tipo, $url, $id_reperto);

    $dbInstance = new MultimediaDbInterface();
    $dbInstance->createConn();
    $res = $dbInstance->create($multimedia);
    if($res)
    {
        setcookie("insert", "true");
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }
    else
    {
        setcookie("insert", "false");
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }
    $dbInstance->closeConn();

?>