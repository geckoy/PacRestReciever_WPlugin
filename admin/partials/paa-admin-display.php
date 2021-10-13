<?php
  if ( ! defined( 'WPINC' ) ) die;

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'Paa_messages', 'Paa_message', __( 'Settings Saved', 'Paa' ), 'updated' );
    }
 
    // show error/update messages
    settings_errors( 'Paa_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "Paa"
            settings_fields( 'Paa' );
            // output setting sections and their fields
            // (sections are registered for "Paa", each field is registered to a specific section)
            do_settings_sections( 'Paa' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>