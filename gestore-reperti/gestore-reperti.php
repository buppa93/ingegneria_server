<?php
    /*
    Plugin Name: Gestore Reperti
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce i reperti.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */

    error_reporting(E_ALL);
    $path = ABSPATH . 'wp-content/plugins/extensionModel/';
    require_once($path."dbInterfaces/RepertiDbInterface.php");
    require_once($path."dbInterfaces/PersonaDbInterface.php");
    require_once($path."dbInterfaces/MuseoDbInterface.php");
    /* PAGINA DELLE IMPOSTAZIONI
       Crea la pagina delle impostazioni del plugin */

       //Inizializza gestore_musei_init() nell'interfaccia di amministrazione
       add_action('admin_init', 'gestore_reperti_init');

       //Aggiunge la funzione della pagina di impostazioni al menu
       add_action('admin_menu', 'gestore_reperti_add_page');

       //Esegue il whitelisting delle impostazioni
       function gestore_reperti_init()
       {
           register_setting('gestore_reperti_options', 'gestore_reperti_option', 'gestore_reperti_validate');
       }

       //$musei = array();
       //$direttori = array();

       //Aggiunge al menu
       function gestore_reperti_add_page()
       {
           add_options_page('Gestore Reperti', 'Gestore Reperti', 'manage_options', 'gestorereperti', 'gestorereperti_do_page');
       }

       function gestorereperti_do_page()
       {
           ?>
           <link rel="stylesheet" type="text/css" href="<?php echo plugins_url() . '/gestore-reperti/tabstyle.css'?>">
           <script type="text/javascript" src="<?php echo plugins_url() . '/gestore-reperti/tabaction.js'?>"></script>
           <div class="wrap">
            <h2>Gestore Reperti</h2>
            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openPage(event, 'Visualizza')">Visualizza Reperti</button>
                <button class="tablinks" onclick="openPage(event, 'Aggiungi')">Aggiungi Reperto</button>
            </div>
            <div id="Visualizza" class="tabcontent">
                <h3>Visualizza</h3>
                <p>Questa pagina visualizza i reperti.</p>
                
                <table class="form-table">
                    <tr valign="top">
                        <th>ID</th>
                        <th>ID MUSEO</th>
                        <th>ID PROPRIETARIO</th>
                        <th>DATA ACQUISIZIONE</th>
                        <th>DIMENSIONI</th>
                        <th>VALORE</th>
                        <th>TITOLO</th>
                        <th>TIPO</th>
                        <th>NOME AUTORE</th>
                        <th>PESO</th>
                        <th>LUOGO SCOPERTA</th>
                        <th>DATA SCOPERTA</th>
                        <th>BIBLIOGRAFIA</th>
                        <th>DESCRIZIONE</th>
                        <th>PUBBLICATO</th>
                    </tr>
                    <?php
                        $dbInstance = new RepertiDbInterface();
                        $dbInstance->createConn();
                        $reperti = $dbInstance->read();
                        for($i=0; $i<count($reperti); $i++)
                        {
                            echo "<tr>";
                                echo "<td>".$reperti[$i]->getId()."</td>";
                                echo "<td>".$reperti[$i]->getIdMuseo()."</td>";
                                echo "<td>".$reperti[$i]->getIdProprietario()."</td>";
                                echo "<td>".$reperti[$i]->getDataAcquisizione()."</td>";
                                echo "<td>".$reperti[$i]->getDimensioni()."</td>";
                                echo "<td>".$reperti[$i]->getValore()."</td>";
                                echo "<td>".$reperti[$i]->getTitolo()."</td>";
                                echo "<td>".$reperti[$i]->getTipo()."</td>";
                                echo "<td>".$reperti[$i]->getNomeAutore()."</td>";
                                echo "<td>".$reperti[$i]->getPeso()."</td>";
                                echo "<td>".$reperti[$i]->getLuogoScoperta()."</td>";
                                echo "<td>".$reperti[$i]->getDataScoperta()."</td>";
                                echo "<td>".$reperti[$i]->getBibliografia()."</td>";
                                echo "<td>".$reperti[$i]->getDescrizione()."</td>";
                                echo "<td>".$reperti[$i]->getPubblicato()."</td>";
                            echo "</tr>";
                        }
                        $dbInstance->closeConn();
                    ?>
                </table>
                
            </div>
            <div id="Aggiungi" class="tabcontent">
                <h3>Aggiungi</h3>
                <p>Questa pagina aggiunge un reperto.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-reperti/inserisci_reperto.php'?>">
                    <?php settings_fields("gestore_reperti_options"); ?>
                    <?php $options = get_option("gestore_reperti_option"); ?>

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
                                ID MUSEO
                                <td>
                                    <select name="museo">
                                        <?php
                                            $museoDbInstance = new MuseoDbInterface();
                                            $museoDbInstance->createConn();
                                            $musei = $museoDbInstance->read();
                                            for($i=0; $i<count($musei); $i++)
                                            {
                                                echo '<option value="'.$musei[$i]->getId().
                                                     '">'.$musei[$i]->getNome().
                                                     '</option>';
                                            }
                                            $museoDbInstance->closeConn();
                                        ?>
                                    </select>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                PROPRIETARIO
                                <td>
                                    <select name="proprietario">
                                        <?php
                                            $personaDbInstance = new PersonaDbInterface();
                                            $personaDbInstance->createConn();
                                            $direttori = $personaDbInstance->read();
                                            for($i=0; $i<count($direttori); $i++)
                                            {
                                                echo '<option value="'.$direttori[$i]->getNumeroDocumento().
                                                     '">'.$direttori[$i]->getNome().' '.$direttori[$i]->getCognome().
                                                     '</option>';
                                            }
                                            $personaDbInstance->closeConn();
                                        ?>
                                    </select>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DATA ACQUISIZIONE
                                <td>
                                    <input type="date" name="data_acquisizione" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DIMENSIONI
                                <td>
                                    <input type="text" name="dimensioni" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                VALORE
                                <td>
                                    <input type="number" name="valore" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                TITOLO
                                <td>
                                    <input type="text" name="titolo" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                TIPO
                                <td>
                                    <input type="text" name="tipo" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                NOME AUTORE
                                <td>
                                    <input type="text" name="autore" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                PESO
                                <td>
                                    <input type="number" name="peso" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                LUOGO SCOPERTA
                                <td>
                                    <input type="text" name="luogo_scoperta" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DATA SCOPERTA
                                <td>
                                    <input type="date" name="data_scoperta" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                BIBLIOGRAFIA
                                <td>
                                    <textarea name="bibliografia" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DESCRIZIONE
                                <td>
                                    <textarea name="descrizione" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                PUBBLICATO
                                <td>
                                    <select name="pubblicato">
                                        <option value="n">No</option>
                                        <option value="s">Si</option>
                                    </select>
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
