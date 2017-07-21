<?php
    include_once 'httpRequest.php';

    /**
     * Script che permette la ricezione dell'id del reperto
     * (ottenuto tramite scansione del QrCode) da parte del
     * client, e che ne invia le informazioni ottenute tramite
     * interrogazioni sulle informazioni presenti sul database
     * relative all'id del reperto
     */
    
    $id = $_GET['id'];

    $request = new HttpRequest($id);
    $request->receiver();
    $request->sender();

?>