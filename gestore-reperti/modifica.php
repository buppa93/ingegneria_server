<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/RepertiDbInterface.php";
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/qrGenerator/qrlib.php";

    $id = $_POST['idm'];
    $museo = $_POST['museom'];
    $proprietario = $_POST['proprietariom'];
    $data_acquisizione = $_POST['data_acquisizionem'];
    $dimensioni = $_POST['dimensionim'];
    $valore = $_POST['valorem'];
    $titolo = $_POST['titolom'];
    $tipo = $_POST['tipom'];
    $autore = $_POST['autorem'];
    $peso = $_POST['pesom'];
    $luogo_scoperta = $_POST['luogo_scopertam'];
    $data_scoperta = $_POST['data_scopertam'];
    $bibliografia = $_POST['bibliografiam'];
    $descrizione = $_POST['descrizionem'];
    $pubblicato = $_POST['pubblicatom'];

    $dbInstance = new RepertiDbInterface();
    $dbInstance->createConn();
    $reperto = new Reperto($id, $museo, $proprietario, $data_acquisizione, 
                        $dimensioni, $valore, $titolo, $tipo, $autore, $peso, $luogo_scoperta,
                        $data_scoperta, $bibliografia, $descrizione, $pubblicato);

    $res = $dbInstance->update($reperto);
    if($res)
    {
        $qrFileName = $reperto->getId().'.png';
        $path = '/storage/ssd4/018/2182018/public_html/wp-content/uploads/qrcodes/';
        QRcode::png($reperto->getId(), $path.$qrFileName); 
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorerepert');
    }
    $dbInstance->closeConn();
?>