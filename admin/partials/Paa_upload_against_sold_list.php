<?php
    if ( ! defined( 'WPINC' ) ) die;

/**
 * Paa_upload_against_sold_list.php
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php if ( ! current_user_can( 'manage_options' ) ) return;
 
   
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <p>Once you submit the file it will be registered in the table list and when the API recieve an account from PAC it will check for it if exists in table && reject it if match found, NOTE!! the list can't be deleted in any form only from the phpmyadmin.
        Format of the csv should be : "username, password, buyer" IF buyer is unknown you should write that because pushing it empty will eject it.</p>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ASL_x_csrf" value="<?= wp_create_nonce("ASL_x_csrf") ?>">
            <input type="file" name="ASL_file">
            <input type="submit" name="submit" value="submit">
        </form>
        <?php

            // settings_fields( 'UASL' );
            
            // do_settings_sections( 'Paa_upload_against_sold_list' );

            // submit_button( 'Save Settings' );

            if(isset($_POST['submit']) )
            {
                $file = ($_FILES["ASL_file"]['size'] !== 0 ) ? $_FILES["ASL_file"] : '';

                if( ! empty($file) && $file["type"] == "application/vnd.ms-excel" && wp_verify_nonce($_POST['ASL_x_csrf'], "ASL_x_csrf"))
                {
                    echo "<h1>recieved</h1>";
                    
                    if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
                        global $wpdb;
                        $number = 1;
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
                        {
                            $account_username = encrypter_dcrypter($data[0]);
                            $account_password = encrypter_dcrypter($data[1]);
                            $buyer = $data[2];
                            $wpdb->query(
                                $wpdb->prepare(
                                    "
                                    INSERT INTO paa_against_sold_list
                                    ( username, password, buyer )
                                    VALUES ( %s, %s, %s )
                                    ",
                                    $account_username, $account_password, $buyer
                                )
                            );
                        }
                        
                    }else
                    { ?>
                        <h1>Internal Error occured Contact a Developer</h1>
                     <?php
                    }
                }else 
                { ?>
                    <h4>Error occured - check maybe wrong file type or empty file</h4>
                    
                <?php
                }
                
            }?>
            <p>Accepted file type application/vnd.ms-excel "CSV"</p>
    </div>