<?php
    /*
    Plugin Name: Gestore Musei
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce le strutture museali.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */
    $path = ABSPATH . 'wp-content/plugins/extensionModel/';

    require($path."dbInterfaces/MuseoDbInterface.php");
    require($path."dbInterfaces/PersonaDbInterface.php");
    /* PAGINA DELLE IMPOSTAZIONI
       Crea la pagina delle impostazioni del plugin */

       //Inizializza gestore_musei_init() nell'interfaccia di amministrazione
       add_action('admin_init', 'gestore_musei_init');

       //Aggiunge la funzione della pagina di impostazioni al menu
       add_action('admin_menu', 'gestore_musei_add_page');

       //Esegue il whitelisting delle impostazioni
       function gestore_musei_init()
       {
           register_setting('gestore_musei_options', 'gestore_musei_option', 'gestore_musei_validate');
       }

       //$musei = array();
       //$direttori = array();

       //Aggiunge al menu
       function gestore_musei_add_page()
       {
           add_options_page('Gestore Musei', 'Gestore Musei', 'manage_options', 'gestoremusei', 'gestoremusei_do_page');
       }

       function gestoremusei_do_page()
       {
           ?>
           <link rel="stylesheet" type="text/css" href="<?php echo plugins_url() . '/gestore-musei/tabstyle.css'?>">
           <script type="text/javascript" src="<?php echo plugins_url() . '/gestore-musei/tabaction.js'?>"></script>
           <div class="wrap">
            <h2>Gestore Musei</h2>
            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openPage(event, 'Visualizza')">Visualizza Musei</button>
                <button class="tablinks" onclick="openPage(event, 'Aggiungi')">Aggiungi Museo</button>
            </div>
            <div id="Visualizza" class="tabcontent">
                <h3>Visualizza</h3>
                <p>Questa pagina visualizza i musei.</p>
                
                <table class="form-table">
                    <tr valign="top">
                        <th>ID</th>
                        <th>ID DIRETTORE</th>
                        <th>NOME</th>
                        <th>CITTA'</th>
                        <th>INDIRIZZO</th>
                        <th>TELEFONO</th>
                        <th>ORARI</th>
                    </tr>
                    <?php
                        $dbInstance = new MuseoDbInterface();
                        $dbInstance->createConn();
                        $musei = $dbInstance->read();
                        $str = "";
                        for($i=0; $i<count($musei); $i++)
                        {
                            $str = "<tr>".
                                     "<td>".$musei[$i]->getId()."</td>".
                                     "<td>".$musei[$i]->getIdDirettore()."</td>".
                                     "<td>".$musei[$i]->getNome()."</td>".
                                     "<td>".$musei[$i]->getCitta()."</td>".
                                     "<td>".$musei[$i]->getIndirizzo()."</td>".
                                     "<td>".$musei[$i]->getTelefono()."</td>".
                                     "<td>".$musei[$i]->getOrari()."</td>".
                                 "</tr>";
                            echo $str;
                        }
                        $dbInstance->closeConn();
                    ?>
                </table>
                
            </div>
            <div id="Aggiungi" class="tabcontent">
                <h3>Aggiungi</h3>
                <p>Questa pagina aggiunge un museo.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-musei/inserisci_museo.php' ?>">
                    <?php settings_fields("gestore_musei_options"); ?>
                    <?php $options = get_option("gestore_musei_option"); ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                ID
                                <td>
                                    <input type="number" name="id" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DIRETTORE
                                <td>
                                    <select name="direttore">
                                        <?php
                                            $personaDbInstance = new PersonaDbInterface();
                                            $personaDbInstance->createConn();
                                            $direttori = $personaDbInstance->readOnlyDirettori();
                                            $str = "";
                                            for($i=0; $i<count($direttori); $i++)
                                            {
                                                $str = '<option value="'.$direttori[$i]->getNumeroDocumento().
                                                     '">'.$direttori[$i]->getNome().' '.$direttori[$i]->getCognome().
                                                     '</option>';
                                                echo $str;
                                            }
                                        ?>
                                    </select>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                TELEFONO
                                <td>
                                    <input type="tel" name="telefono" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                NOME
                                <td>
                                    <input type="text" name="nome" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                CITTA'
                                <td>
                                    <input type="text" name="citta" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                INDIRIZZO
                                <td>
                                    <input type="text" name="indirizzo" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                ORARI
                                <td>
                                    <textarea name="orari" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <td>
                                    <p class="submit">
                                        <input type="submit" class="button-primary" value="Inserisci" />
                                    </p>
                                </td>
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
           </div>
            <script>
                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
           <?php
       }
?>
