<?php
    /**
     * Script che elimina dal database il reperto
     * avente id uguale all'argomento id spedito in GET
     */
    include_once "/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/dbInterfaces/RepertiDbInterface.php";

    $id = $_GET["id"];

    $repertoDbInstance = new RepertiDbInterface();
    $repertoDbInstance->createConn();
    $res = $repertoDbInstance->delete($id);
    $repertoDbInstance->closeConn();

    if($res)
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    }
    else
    {
        header('Location: https://smartmuseum.000webhostapp.com/wp-admin/options-general.php?page=gestorereperti');
    }

?>