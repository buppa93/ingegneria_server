<?php
    /*
    Plugin Name: Gestore Musei
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce le strutture museali.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */
    $path = ABSPATH . 'wp-content/plugins/extensionModel/';

    include_once $path."dbInterfaces/MuseoDbInterface.php";
    include_once $path."dbInterfaces/PersonaDbInterface.php";
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
           wp_enqueue_script('jquery');
       }

       //Aggiunge al menu
       function gestore_musei_add_page()
       {
           add_menu_page('Gestore Musei', 'Gestore Musei', 'manage_options', 'gestoremusei', 'gestoremusei_do_page', 'dashicons-building');
       }

       function gestoremusei_do_page()
       {
           $current_user = new CmUser(wp_get_current_user());
           $current_user->setUserCookie();
           add_thickbox();
           ?>
           <input type="hidden" name="userrole" id="userrole" value="<?php echo $_SESSION["UserRole"]; ?>" />
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
                        $usrId = $current_user->getUser()->ID;
                        for($i=0; $i<count($musei); $i++)
                        {
                            $str = "<tr>".
                                     "<td>".$musei[$i]->getId()."</td>".
                                     "<td>".$musei[$i]->getIdDirettore()."</td>".
                                     "<td>".$musei[$i]->getNome()."</td>".
                                     "<td>".$musei[$i]->getCitta()."</td>".
                                     "<td>".$musei[$i]->getIndirizzo()."</td>".
                                     "<td>".$musei[$i]->getTelefono()."</td>".
                                     "<td>".$musei[$i]->getOrari()."</td>";
                                     if((($current_user->isDirettore()) && ($usrId == $musei[$i]->getIdDirettore()))
                                            || $current_user->isAmministratore())
                                     {
                                        $str .= '<td><a href="#TB_inline?width=600&height=550&inlineId=edit-museo" class="thickbox" id="'.
                                                $musei[$i]->getId().'" onClick="setEditPage('.$musei[$i]->getId().', '.$musei[$i]->getIdDirettore().
                                                ', \''.$musei[$i]->getNome().'\', \''.$musei[$i]->getCitta().'\', \''.$musei[$i]->getIndirizzo()
                                                .'\', \''.$musei[$i]->getTelefono().'\', \''.$musei[$i]->getOrari().'\' )">'.
                                                '<span class="dashicons dashicons-edit edit-mus"></span></a></td>'.
                                                '<td><a href="https://smartmuseum.000webhostapp.com/wp-content/plugins/gestore-musei/elimina.php?id='.
                                                $musei[$i]->getId().'" '.
                                                'id="'.$musei[$i]->getId().'"><span class="dashicons dashicons-trash trash-mus"></span></a></td>';
                                     }
                                 $str .= "</tr>";
                            echo $str;
                        }
                        $dbInstance->closeConn();
                    ?>
                </table>
                
            </div>
            <div id="Aggiungi" class="tabcontent aggiungimus">
                <h3>Aggiungi</h3>
                <p>Questa pagina aggiunge un museo.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-musei/inserisci_museo.php' ?>">
                    <?php settings_fields("gestore_musei_options"); ?>

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
                                            $direttori = get_users(array(
                                                                            'role'   => 'editor',
                                                                            'fields' => 'all'
                                                                        ));
                                            $str = "";
                                            foreach($direttori as $direttore)
                                            {
                                                $str = '<option value="'.$direttore->ID.
                                                     '">'.$direttore->first_name.' '.$direttore->last_name.
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
                                        <input type="submit" id="submitmus" class="button-primary" value="Inserisci" />
                                    </p>
                                </td>
                            </th>
                        </tr>
                    </table>
                </form>
                <?php makeMuseiModal(); ?>
            </div>
           </div>
            <script>
                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
            <script type="text/javascript">
                function setEditPage(id, idDirettore, nome, citta, indirizzo, telefono, orari)
                {
                    document.getElementById("editid").value=id;
                    document.getElementById("editdirettore").value=idDirettore;
                    document.getElementById("editnome").value=nome;
                    document.getElementById("editcitta").value=citta;
                    document.getElementById("editindirizzo").value=indirizzo;
                    document.getElementById("edittelefono").value=telefono;
                    document.getElementById("editorari").value=orari;
                }
            </script>
           <?php
       }

       function makeMuseiModal()
       { 
            ?> 
            <div id="edit-museo" style="display:none;">
                <h2>Modifica Museo</h2>
                <form method="post" action="<?php echo plugins_url() . '/gestore-musei/modifica.php' ?>">
                    <?php settings_fields("gestore_musei_options"); ?>

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
                                DIRETTORE
                                <td>
                                    <select name="direttorem" id="editdirettore">
                                        <?php
                                            $direttori = get_users(array(
                                                                            'role'   => 'editor',
                                                                            'fields' => 'all'
                                                                        ));
                                            $str = "";
                                            foreach($direttori as $direttore)
                                            {
                                                $str = '<option value="'.$direttore->ID.
                                                     '">'.$direttore->first_name.' '.$direttore->last_name.
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
                                    <input type="tel" id="edittelefono" name="telefonom" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                NOME
                                <td>
                                    <input type="text" id="editnome" name="nomem" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                CITTA'
                                <td>
                                    <input type="text" id="editcitta" name="cittam" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                INDIRIZZO
                                <td>
                                    <input type="text" id="editindirizzo" name="indirizzom" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                ORARI
                                <td>
                                    <textarea id="editorari" name="orarim" rows="15" cols="50"></textarea>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <td>
                                    <p class="submit">
                                        <input type="submit" id="editmus" class="button-primary" value="Modifica" />
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
