<?php
    /*
    Plugin Name: Gestore Multimedia
    Plugin URI: http://smartmuseum.000webhostapp.com
    Description: Gestisce i file multimediali.
    Version: 0.0.1
    Author: Giuseppe Antonio Sansone
    */
    
    $path = ABSPATH . 'wp-content/plugins/extensionModel/dbInterfaces/';
    include $path."MultimediaDbInterface.php";
    include $path."TipoMultimediaDbInterface.php";

    /* PAGINA DELLE IMPOSTAZIONI
       Crea la pagina delle impostazioni del plugin */

       //Inizializza gestore_musei_init() nell'interfaccia di amministrazione
       add_action('admin_init', 'gestore_multimedia_init');

       //Aggiunge la funzione della pagina di impostazioni al menu
       add_action('admin_menu', 'gestore_multimedia_add_page');

       //Esegue il whitelisting delle impostazioni
       function gestore_multimedia_init()
       {
           register_setting('gestore_multimedia_options', 'gestore_multimedia_option', 'gestore_multimedia_validate');
       }

       //$musei = array();
       //$direttori = array();

       //Aggiunge al menu
       function gestore_multimedia_add_page()
       {
           add_options_page('Gestore Multimedia', 'Gestore Multimedia', 'manage_options', 'gestoremultimedia', 'gestoremultimedia_do_page');
       }

       function gestoremultimedia_do_page()
       {
           ?>
           <link rel="stylesheet" type="text/css" href="<?php echo plugins_url().'/gestore-multimedia/tabstyle.css'?>">
           <script type="text/javascript" src="<?php echo plugins_url().'/gestore-multimedia/tabaction.js'?>"></script>
           <div class="wrap">
            <h2>Gestore Multimedia</h2>
            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openPage(event, 'Visualizza')">Visualizza Multimedia</button>
                <button class="tablinks" onclick="openPage(event, 'Aggiungi')">Aggiungi multimedia</button>
            </div>
            <div id="Visualizza" class="tabcontent">
                <h3>Visualizza</h3>
                <p>Questa pagina visualizza i file multimediali.</p>
                
                <table class="form-table">
                    <tr valign="top">
                        <th>ID</th>
                        <th>ID TIPO</th>
                        <th>ID REPERTO</th>
                        <th>URL</th>
                    </tr>
                    <?php
                        $multimediaDbInstance = new MultimediaDbInterface();
                        $multimediaDbInstance->createConn();
                        $multimedias = $multimediaDbInstance->read();
                        $str = "";
                        for($i=0; $i<count($multimedias); $i++)
                        {
                            $str= "<tr>".
                                    "<td>".$multimedias[$i]->getId()."</td>".
                                    "<td>".$multimedias[$i]->getIdTipo()."</td>".
                                    "<td>".$multimedias[$i]->getIdReperto()."</td>".
                                    '<td><img id="img-prev" src="'.$multimedias[$i]->getUrl().'" width="100" height="100" style="max-height: 100px; width: 100px;"></td>'.
                                 "</tr>";
                            echo $str;
                        }
                        $multimediaDbInstance->closeConn();
                    ?>
                </table>
                
            </div>
            <div id="Aggiungi" class="tabcontent">
                <h3>Aggiungi</h3>
                <p>Questa pagina aggiunge un file multimediale.</p> 
                <form method="post" action="<?php echo plugins_url() . '/gestore-multimedia/inserisci_multimedia.php'?>">
                    <?php settings_fields("gestore_multimedia_options"); ?>

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
                                TIPO
                                <td>
                                    <select name="id_tipo">
                                        <?php
                                            $tipiMultimediaInstance = new TipoMultimediaDbInterface();
                                            $tipiMultimediaInstance->createConn();
                                            $tipi = $tipiMultimediaInstance->read();
                                            $str = "";
                                            for($i=0; $i<count($tipi); $i++)
                                            {
                                                $str = '<option value="'.
                                                            $tipi[$i]->getId().'">'.$tipi[$i]->getNome().
                                                       '</option>';
                                                echo $str;
                                            }
                                            $tipiMultimediaInstance->closeConn();
                                        ?>
                                    </select>
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                REPERTO (ID)
                                <td>
                                    <input type="number" name="id_reperto" class="regular-text code" />
                                </td>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                FILE MULTIMEDIALE
                                <td>
                                    <?php
                                        media_selector_settings_page_callback();
                                    ?>
                                    <!-- <input type="text" name="url" class="regular-text code" /> -->
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

       function media_selector_settings_page_callback()
       {
           wp_enqueue_media();
           ?>
           <div class='image-preview-wrapper'>
            <img id='image-preview' src='' width='100' height='100' style='max-height: 100px; width: 100px;'> 
           </div>
           <input id='upload_image_button' type='button' class='button' value="<?php _e('Upload image'); ?>" />
           <input type='hidden' name='url' id='url' value=''>
           <?php
       }
       
       add_action( 'admin_footer', 'media_selector_print_scripts' );
       
       function media_selector_print_scripts() 
       {
           $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
           ?>
            <script type='text/javascript'>
		        jQuery( document ).ready( function( $ ) 
                {
			        // Uploading files
			        var file_frame;
			        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			        var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			        jQuery('#upload_image_button').on('click', function( event )
                    {
				        event.preventDefault();
				        // If the media frame already exists, reopen it.
				        if ( file_frame ) 
                        {
					        // Set the post ID to what we want
					        file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					        // Open frame
					        file_frame.open();
					        return;
				        } 
                        else 
                        {
					        // Set the wp.media post id so the uploader grabs the ID we want when initialised
					        wp.media.model.settings.post.id = set_to_post_id;
				        }
				        // Create the media frame.
				        file_frame = wp.media.frames.file_frame = wp.media(
                            {
					            title: 'Scegli un file media oppurecaricane uno',
					            button: 
                                {
						            text: 'Usa',
					            },
					            multiple: false	// Set to true to allow multiple files to be selected
				            });
				        // When an image is selected, run a callback.
				        file_frame.on( 'select', function() 
                        {
					        // We set multiple to false so only get one image from the uploader
					        attachment = file_frame.state().get('selection').first().toJSON();
					        // Do something with attachment.id and/or attachment.url here
					        $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					        $( '#url' ).val( attachment.url );
					        // Restore the main post ID
					        wp.media.model.settings.post.id = wp_media_post_id;
				        });
					    // Finally, open the modal
					    file_frame.open();
			        });
			        // Restore the main ID when the add media button is pressed
			        jQuery( 'a.add_media' ).on( 'click', function()
                    {
				        wp.media.model.settings.post.id = wp_media_post_id;
			        });
		        });
	        </script>
        <?php
    }
?>
