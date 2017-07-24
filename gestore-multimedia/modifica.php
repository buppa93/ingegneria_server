<?php
    /**
     * Script che modifica sul database il file multimediale
     * con i parametri speditoìi in GET
     */
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MultimediaDbInterface.php";

    $id = $_POST['idm'];
    $id_tipo = $_POST['id_tipom'];
    $id_reperto = $_POST['id_repertom'];
    $url = $_POST['urlm'];

    $multimedia = new Multimedia($id, $id_tipo, $url, $id_reperto);

    $dbInstance = new MultimediaDbInterface();
    $dbInstance->createConn();
    $res = $dbInstance->update($multimedia);
    $dbInstance->closeConn();
    
    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremultimedia');
    }
?>