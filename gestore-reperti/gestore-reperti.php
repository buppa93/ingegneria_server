<?php
    /*
    Plugin Name: Gestore Reperti
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce i reperti.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */
    $path = ABSPATH . 'wp-content/plugins/extensionModel/';
    include_once $path."dbInterfaces/RepertiDbInterface.php";
    include_once $path."dbInterfaces/PersonaDbInterface.php";
    include_once $path."dbInterfaces/MuseoDbInterface.php";
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
           wp_enqueue_script('jquery');
       }

       //$musei = array();
       //$direttori = array();

       //Aggiunge al menu
       function gestore_reperti_add_page()
       {
           add_menu_page('Gestore Reperti', 'Gestore Reperti', 'manage_options', 'gestorereperti', 'gestorereperti_do_page', 'dashicons-art');
       }

       function gestorereperti_do_page()
       {
           $current_user = new CmUser(wp_get_current_user());
           $current_user->setUserCookie();
           add_thickbox();
           ?>
           <input type="hidden" name="userrole" id="userrole" value="<?php echo $_SESSION["UserRole"]; ?>" />
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
                <script type="text/javascript">
                    function getQrCode(id)
                    {
                        location.href='https://smartmuseum.000webhostapp.com/wp-content/uploads/qrcodes/'
                                        +id+'.png';
                    }
                </script>
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
                        $usrId = $current_user->getUser()->ID;
                        $str = "";
                        $dbInstance->closeConn();
                        if(!$current_user->isProprietario())
                        {
                            for($i=0; $i<count($reperti); $i++)
                            {
                                $str = "<tr>".
                                        '<td id="id'.$reperti[$i]->getId().'">'.$reperti[$i]->getId()."</td>".
                                        '<td id="museo'.$reperti[$i]->getId().'">'.$reperti[$i]->getIdMuseo()."</td>".
                                        '<td id="proprietario'.$reperti[$i]->getId().'">'.$reperti[$i]->getIdProprietario()."</td>".
                                        '<td id="dataAcquisizione'.$reperti[$i]->getId().'">'.$reperti[$i]->getDataAcquisizione()."</td>".
                                        '<td id="dimensioni'.$reperti[$i]->getId().'">'.$reperti[$i]->getDimensioni()."</td>".
                                        '<td id="valore'.$reperti[$i]->getId().'">'.$reperti[$i]->getValore()."</td>".
                                        '<td id="titolo'.$reperti[$i]->getId().'">'.$reperti[$i]->getTitolo()."</td>".
                                        '<td id="tipo'.$reperti[$i]->getId().'">'.$reperti[$i]->getTipo()."</td>".
                                        '<td id="autore'.$reperti[$i]->getId().'">'.$reperti[$i]->getNomeAutore()."</td>".
                                        '<td id="peso'.$reperti[$i]->getId().'">'.$reperti[$i]->getPeso()."</td>".
                                        '<td id="lScoperta'.$reperti[$i]->getId().'">'.$reperti[$i]->getLuogoScoperta()."</td>".
                                        '<td id="dScoperta'.$reperti[$i]->getId().'">'.$reperti[$i]->getDataScoperta()."</td>".
                                        '<td id="bibliografia'.$reperti[$i]->getId().'">'.$reperti[$i]->getBibliografia()."</td>".
                                        '<td id="descrizione'.$reperti[$i]->getId().'">'.$reperti[$i]->getDescrizione()."</td>".
                                        '<td id="pubblicato'.$reperti[$i]->getId().'">'.$reperti[$i]->getPubblicato()."</td>".
                                        '<td><button type="button" onclick="getQrCode('.$reperti[$i]->getId().')">Qr Code</button></td>'.
                                        '<td><a href="#TB_inline?width=600&height=550&inlineId=edit-reperto" class="thickbox" id="'.
                                        $reperti[$i]->getId().'" onClick="setEditPage('.$reperti[$i]->getId().')">'.
                                        '<span class="dashicons dashicons-edit edit-rep"></span></a></td>'.
                                        '<td><a href="https://smartmuseum.000webhostapp.com/wp-content/plugins/gestore-reperti/elimina.php?id='.
                                        $reperti[$i]->getId().'" '.
                                        'id="'.$reperti[$i]->getId().'"><span class="dashicons dashicons-trash trash-rep"></span></a></td>'.
                                    "</tr>";
                                echo $str;
                            }
                        }
                        else
                        {
                            $dbInstance = new RepertiDbInterface();
                            $dbInstance->createConn();
                            $reperti = $dbInstance->read();
                            $usrId = $current_user->getUser()->ID;
                            $str = "";
                            $dbInstance->closeConn();
                            foreach($reperti as $reperto)
                            {
                                if($reperto->getIdProprietario() == $usrId)
                                {
                                    $str = "<tr>".
                                        '<td id="id'.$reperto->getId().'">'.$reperto->getId()."</td>".
                                        '<td id="museo'.$reperto->getId().'">'.$reperto->getIdMuseo()."</td>".
                                        '<td id="proprietario'.$reperto->getId().'">'.$reperto->getIdProprietario()."</td>".
                                        '<td id="dataAcquisizione'.$reperto->getId().'">'.$reperto->getDataAcquisizione()."</td>".
                                        '<td id="dimensioni'.$reperto->getId().'">'.$reperto->getDimensioni()."</td>".
                                        '<td id="valore'.$reperto->getId().'">'.$reperto->getValore()."</td>".
                                        '<td id="titolo'.$reperto->getId().'">'.$reperto->getTitolo()."</td>".
                                        '<td id="tipo'.$reperto->getId().'">'.$reperto->getTipo()."</td>".
                                        '<td id="autore'.$reperto->getId().'">'.$reperto->getNomeAutore()."</td>".
                                        '<td id="peso'.$reperto->getId().'">'.$reperto->getPeso()."</td>".
                                        '<td id="lScoperta'.$reperto->getId().'">'.$reperto->getLuogoScoperta()."</td>".
                                        '<td id="dScoperta'.$reperto->getId().'">'.$reperto->getDataScoperta()."</td>".
                                        '<td id="bibliografia'.$reperto->getId().'">'.$reperto->getBibliografia()."</td>".
                                        '<td id="descrizione'.$reperto->getId().'">'.$reperto->getDescrizione()."</td>".
                                        '<td id="pubblicato'.$reperto->getId().'">'.$reperto->getPubblicato()."</td>".
                                        '<td><button type="button" onclick="getQrCode('.$reperto->getId().')">Qr Code</button></td>'.
                                        '<td><a href="#TB_inline?width=600&height=550&inlineId=edit-reperto" class="thickbox" id="'.
                                        $reperto->getId().'" onClick="setEditPage('.$reperto->getId().')">'.
                                        '<span class="dashicons dashicons-edit edit-rep"></span></a></td>'.
                                        '</tr>';
                                    echo $str;
                                }
                            }
                        }
                    ?>
                </table>
            </div>
            <div id="Aggiungi" class="tabcontent aggiungirep">
                <h3>Aggiungi</h3>
                <p>Questa pagina aggiunge un reperto.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-reperti/inserisci_reperto.php'?>">
                    <?php settings_fields("gestore_reperti_options"); ?>

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
                                            $str = "";
                                            for($i=0; $i<count($musei); $i++)
                                            {
                                                $str = '<option value="'.$musei[$i]->getId().
                                                     '">'.$musei[$i]->getNome().
                                                     '</option>';
                                                echo $str;
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
                                            $proprietari = get_users(array(
                                                                            'role'   => 'contributor',
                                                                            'fields' => 'all'
                                                                        ));
                                            $str = "";
                                            foreach($proprietari as $proprietario)
                                            {
                                                $str = '<option value="'.$proprietario->ID.
                                                     '">'.$proprietario->first_name.' '.$proprietario->last_name.
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
                                        <input type="submit" id="submitrep" class="button-primary" value="Inserisci" />
                                    </p>
                                </td>
                            </th>
                        </tr>
                    </table>
                </form>
                <?php makeRepertiModal(); ?>
            </div>
           </div>
            <script type="text/javascript">
                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
            <script type="text/javascript">
                function setEditPage(id)
                {
                    museo = document.getElementById("museo"+id).innerHTML;
                    proprietario = document.getElementById("proprietario"+id).innerHTML;
                    dAcquisizione = document.getElementById("dataAcquisizione"+id).innerHTML;
                    dimensioni = document.getElementById("dimensioni"+id).innerHTML;
                    valore = document.getElementById("valore"+id).innerHTML;
                    titolo = document.getElementById("titolo"+id).innerHTML;
                    tipo = document.getElementById("tipo"+id).innerHTML;
                    autore = document.getElementById("autore"+id).innerHTML;
                    peso = document.getElementById("peso"+id).innerHTML;
                    lScoperta = document.getElementById("lScoperta"+id).innerHTML;
                    dScoperta = document.getElementById("dScoperta"+id).innerHTML;
                    bibliografia = document.getElementById("bibliografia"+id).innerHTML;
                    descrizione = document.getElementById("descrizione"+id).innerHTML;
                    pubblicato = document.getElementById("pubblicato"+id).innerHTML;
                    document.getElementById("editid").value=id;
                    document.getElementById("editmuseo").value=museo;
                    document.getElementById("editproprietario").value=proprietario;
                    document.getElementById("editacquisizione").value=dAcquisizione;
                    document.getElementById("editdimensioni").value=dimensioni;
                    document.getElementById("editvalore").value=valore;
                    document.getElementById("edittitolo").value=titolo;
                    document.getElementById("edittipo").value=tipo;
                    document.getElementById("editautore").value=autore;
                    document.getElementById("editpeso").value=peso;
                    document.getElementById("editlscoperta").value=lScoperta;
                    document.getElementById("editdscoperta").value=dScoperta;
                    document.getElementById("editbibliografia").value=bibliografia;
                    document.getElementById("editdescrizione").value=descrizione;
                    document.getElementById("editpubblicato").value=pubblicato;
                }
            </script>
           <?php
       }

       function makeRepertiModal()
       {
            
               
            ?>

            <div id="edit-reperto" style="display:none;">
                <h2>Modifica Reperto</h2>
                <form method="post" action="<?php echo plugins_url() . '/gestore-reperti/modifica.php'?>">

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                ID
                                <td>
                                    <input type="number" id="editid" name="idm" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                ID MUSEO
                                <td>
                                    <select name="museom" id="editmuseo">
                                        <?php
                                            $museoDbInstance = new MuseoDbInterface();
                                            $museoDbInstance->createConn();
                                            $musei = $museoDbInstance->read();
                                            $str = "";
                                            for($i=0; $i<count($musei); $i++)
                                            {
                                                $str = '<option value="'.$musei[$i]->getId().
                                                     '">'.$musei[$i]->getNome().
                                                     '</option>';
                                                echo $str;
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
                                    <select name="proprietariom" id="editproprietario">
                                        <?php
                                            $proprietari = get_users(array(
                                                                            'role'   => 'contributor',
                                                                            'fields' => 'all'
                                                                        ));
                                            $str = "";
                                            foreach($proprietari as $proprietario)
                                            {
                                                $str = '<option value="'.$proprietario->ID.
                                                     '">'.$proprietario->first_name.' '.$proprietario->last_name.
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
                                DATA ACQUISIZIONE
                                <td>
                                    <input type="date" id="editacquisizione" name="data_acquisizionem" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DIMENSIONI
                                <td>
                                    <input type="text" id="editdimensioni" name="dimensionim" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                VALORE
                                <td>
                                    <input type="number" id="editvalore" name="valorem" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                TITOLO
                                <td>
                                    <input type="text" id="edittitolo" name="titolom" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                TIPO
                                <td>
                                    <input type="text" id="edittipo" name="tipom" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                NOME AUTORE
                                <td>
                                    <input type="text" id="editautore" name="autorem" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                PESO
                                <td>
                                    <input type="number" id="editpeso" name="pesom" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                LUOGO SCOPERTA
                                <td>
                                    <input type="text" id="editlscoperta" name="luogo_scopertam" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DATA SCOPERTA
                                <td>
                                    <input type="date" id="editdscoperta" name="data_scopertam" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                BIBLIOGRAFIA
                                <td>
                                    <textarea name="bibliografiam" id="editbibliografia" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                DESCRIZIONE
                                <td>
                                    <textarea name="descrizionem" id="editdescrizione" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                PUBBLICATO
                                <td>
                                    <select name="pubblicatom" id="editpubblicato">
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
                                        <input type="submit" id="editrep" class="button-primary" value="Modifica" />
                                    </p>
                                </td>
                            </th>
                        </tr>
                    </table>
                </form>
                <script type="text/javascript" src="../wp-content/plugins/extensionModel/securityCheck.js" />
            </div>
            <?php
       }
?>
