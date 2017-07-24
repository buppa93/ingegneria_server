<?php
    /**
     * Script che inserisce sul database il reperto
     * avente argomenti uguali a quelli spediti in POST
     */
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/RepertiDbInterface.php";
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/qrGenerator/qrlib.php";

    $id = $_POST['id'];
    $museo = $_POST['museo'];
    $proprietario = $_POST['proprietario'];
    $data_acquisizione = $_POST['data_acquisizione'];
    $dimensioni = $_POST['dimensioni'];
    $valore = $_POST['valore'];
    $titolo = $_POST['titolo'];
    $tipo = $_POST['tipo'];
    $autore = $_POST['autore'];
    $peso = $_POST['peso'];
    $luogo_scoperta = $_POST['luogo_scoperta'];
    $data_scoperta = $_POST['data_scoperta'];
    $bibliografia = $_POST['bibliografia'];
    $descrizione = $_POST['descrizione'];
    $pubblicato = $_POST['pubblicato'];

    $dbInstance = new RepertiDbInterface();
    $dbInstance->createConn();
    $reperto = new Reperto($id, $museo, $proprietario, $data_acquisizione, 
                        $dimensioni, $valore, $titolo, $tipo, $autore, $peso, $luogo_scoperta,
                        $data_scoperta, $bibliografia, $descrizione, $pubblicato);

    $res = $dbInstance->create($reperto);
    if($res)
    {
        $qrFileName = $reperto->getId().'.png';
        $path = '/storage/ssd4/018/2182018/public_html/wp-content/uploads/qrcodes/';
        QRcode::png($reperto->getId(), $path.$qrFileName); 
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    }
    $dbInstance->closeConn();
?>