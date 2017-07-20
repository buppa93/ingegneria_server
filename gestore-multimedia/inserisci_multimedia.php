<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    require("/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MultimediaDbInterface.php");

    $id = $_POST['id'];
    $id_tipo = $_POST['id_tipo'];
    $id_reperto = $_POST['id_reperto'];
    $url = $_POST['url'];

    $multimedia = new Multimedia($id, $id_tipo, $url, $id_reperto);

    $dbInstance = new MultimediaDbInterface();
    $dbInstance->createConn();
    $res = $dbInstance->create($multimedia);
    if($res)
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    else
        echo "non inserito<br>";
    $dbInstance->closeConn();

?>