<?php
    /**
     * Script che modifica sul database il museo
     * avente i parametri spediti in GET
     */
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MuseoDbInterface.php";

    $id = $_POST['idm'];
    $direttore = $_POST['direttorem'];
    $telefono = $_POST['telefonom'];
    $nome = $_POST['nomem'];
    $citta = $_POST['cittam'];
    $indirizzo = $_POST['indirizzom'];
    $orari = $_POST['orarim'];

    $dbInstance = new MuseoDbInterface();
    $dbInstance->createConn();
    $museo = new Museo($id, $direttore, $telefono, $nome, $citta, $indirizzo, $orari);
    $res = $dbInstance->update($museo);
    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremusei');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestoremusei');
    }
    $dbInstance->closeConn();
?>