<?php
    /*
    Plugin Name: Gestore Operatori
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce gli operatori.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */
    
    $path = ABSPATH . 'wp-content/plugins/extensionModel/dbInterfaces/';
    include_once $path."MuseoOperatoreDbInterface.php";
    include_once $path."MuseoDbInterface.php";
    include_once '/storage/ssd4/018/2182018/public_html/wp-content/plugins/extensionModel/model/cm_user.php';

    /* PAGINA DELLE IMPOSTAZIONI
       Crea la pagina delle impostazioni del plugin */

       //Inizializza gestore_musei_init() nell'interfaccia di amministrazione
       add_action('admin_init', 'gestore_operatori_init');

       //Aggiunge la funzione della pagina di impostazioni al menu
       add_action('admin_menu', 'gestore_operatori_add_page');

       //Esegue il whitelisting delle impostazioni
       function gestore_operatori_init()
       {
           register_setting('gestore_operatori_options', 'gestore_operatori_option', 'gestore_operatori_validate');
           wp_enqueue_script('jquery');
       }

       //$musei = array();
       //$direttori = array();

       //Aggiunge al menu
       function gestore_operatori_add_page()
       {
           add_menu_page('Gestore Operatori', 'Gestore Operatori', 'manage_options', 'gestoreoperatori', 'gestoreoperatori_do_page', 'dashicons-id');
       }

       function gestoreoperatori_do_page()
       {
           $current_user = new CmUser(wp_get_current_user());
           $current_user->setUserCookie();
           add_thickbox();
           ?>
           <input type="hidden" name="userrole" id="userrole" value="<?php echo $_SESSION["UserRole"]; ?>" />
           <link rel="stylesheet" type="text/css" href="<?php echo plugins_url().'/gestore-operatori/tabstyle.css'?>">
           <script type="text/javascript" src="<?php echo plugins_url().'/gestore-operatori/tabaction.js'?>"></script>
           <div class="wrap">
            <h2>Gestore Operatori</h2>
            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openPage(event, 'Visualizza')">Visualizza Operatori</button>
                <button class="tablinks" onclick="openPage(event, 'Aggiungi')">Associa Operatore</button>
            </div>
            <div id="Visualizza" class="tabcontent">
                <h3>Visualizza</h3>
                <p>Questa pagina visualizza i gli operatori associati ai musei.</p>
                
                <table class="form-table">
                    <tr valign="top">
                        <th>MUSEO</th>
                        <th>ID MUSEO</th>
                        <th>OPERATORE</th>
                        <th>ID OPERATORE</th>
                    </tr>
                    <?php
                        $mmDbInterface = new MuseoOperatoreDbInterface();
                        $mmDbInterface->createConn();
                        $rows = $mmDbInterface->read();
                        $mmDbInterface->closeConn();
                        $museiDbInterface = new MuseoDbInterface();
                        $museiDbInterface->createConn();
                        $str = "";
                        foreach($rows as $row)
                        {
                            $museo = $museiDbInterface->readById($row->getIdMuseo()); 
                            $c_user = get_userdata($row->getIdOperatore());
                            $str = "<tr>".
                                        "<td>".$museo->getNome()."</td>".
                                        "<td>".$museo->getId()."</td>".
                                        "<td>".$c_user->first_name." ".$c_user->last_name."</td>".
                                        "<td>".$c_user->ID."</td>";
                                        if($current_user->isAmministratore() || $current_user->isDirettore())
                                        {
                                            $str .= '<td><a href="https://smartmuseum.000webhostapp.com/wp-content/plugins/gestore-operatori/elimina.php?id_museo='.
                                                    $museo->getId().'&id_operatore='.$c_user->ID.
                                                    '" '.'id="'.$museo->getId().'"><span class="dashicons dashicons-trash trash-op"></span></a></td>';
                                        }
                            echo $str;
                        }
                        $museiDbInterface->closeConn();
                    ?>
                </table>
                
            </div>
            <div id="Aggiungi" class="tabcontent aggiungiop">
                <h3>Aggiungi</h3>
                <p>Questa pagina associa un operatore ad un museo.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-operatori/inserisci_operatore.php'?>">
                    <?php settings_fields("gestore_operatori_options"); ?>

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                MUSEO
                                <td>
                                    <select name="id_museo">
                                        <?php
                                            $dbInstance = new MuseoDbInterface();
                                            $dbInstance->createConn();
                                            $musei = $dbInstance->read();
                                            $str = "";
                                            foreach($musei as $museo)
                                            {
                                                $str = '<option value="'.$museo->getId().
                                                     '">'.$museo->getNome().'</option>';
                                                echo $str;
                                            }
                                        ?>
                                    </select>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                OPERATORE
                                <td>
                                    <select name="id_operatore">
                                        <?php
                                            $operatori = get_users(array(
                                                                            'role'   => 'author',
                                                                            'fields' => 'all'
                                                                        ));
                                            $str = "";
                                            foreach($operatori as $operatore)
                                            {
                                                $str = '<option value="'.$operatore->ID.
                                                     '">'.$operatore->first_name.' '.$operatore->last_name.
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
                                <td>
                                    <p class="submit">
                                        <input type="submit" id="submitop" class="button-primary" value="Inserisci" />
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
