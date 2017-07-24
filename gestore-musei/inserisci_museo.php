<?php
    /**
     * Script che inserisce nel database il museo
     * avente i parametri spediti in POST
     */
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/MuseoDbInterface.php";

    $id = $_POST['id'];
    $direttore = $_POST['direttore'];
    $telefono = $_POST['telefono'];
    $nome = $_POST['nome'];
    $citta = $_POST['citta'];
    $indirizzo = $_POST['indirizzo'];
    $orari = $_POST['orari'];

    $dbInstance = new MuseoDbInterface();
    $dbInstance->createConn();
    $museo = new Museo($id, $direttore, $telefono, $nome, $citta, $indirizzo, $orari);
    $res = $dbInstance->create($museo);
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