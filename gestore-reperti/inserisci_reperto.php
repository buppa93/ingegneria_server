<?php
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    require("/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/RepertiDbInterface.php");

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
    echo "<br><br>";
    var_dump($reperto);
    echo "<br><br>";
    $res = $dbInstance->create($reperto);
    if($res)
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    else
    {
        echo $dbInstance->getConn()->error;
        echo "non inserito";
    }
    $dbInstance->closeConn();
?>