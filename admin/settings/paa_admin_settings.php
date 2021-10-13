<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Paa
 * @subpackage Paa/admin
 * @author     Younes Arab nedjadi <younesheissenmann@gmail.com>
 */
class Paa_Admin_settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
        $this->version = $version;

        // Execute the class 
        $this->run();

    }

////////////////////////////////////////////////////////////////////////////////////
////////////////////// Header page settings ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

    public function Administration_menu_settings() {
            // Register a new setting for "Paa" page.
            register_setting( 'Paa', // A settings group name. Should correspond to an allowed option key name. Default allowed option key names include 'general', 'discussion', 'media', 'reading', 'writing', 'misc', 'options', and 'privacy'.
                            'Paa_options_api_token' // The name of an option to sanitize and save.
            );

            register_setting( 'Paa', // A settings group name. Should correspond to an allowed option key name. Default allowed option key names include 'general', 'discussion', 'media', 'reading', 'writing', 'misc', 'options', and 'privacy'.
            'Paa_options_api_header' // The name of an option to sanitize and save.
            );

		// Register a new section in the "wporg" page.
		add_settings_section(
			'Paa_section_API_tokens',//$id Slug-name to identify the section.
			'Api Token For the PAC', //$title Shown as the heading for the section
			array($this, 'Paa_section_API_tokens_callback'),// Function that echos out any content at the top of the section (between heading and fields).
			'Paa' //The slug-name of the settings page on which to show the section. Built-in pages include 'general', 'reading', 'writing', 'discussion', 'media', etc. Create your own using add_options_page();
		);
	 
		// Register a new field in the "Paa_section_API_tokens" section, inside the "Paa" page.
		add_settings_field( 'Paa_api_token', //$id Slug-name to identify the field. Used in the 'id' attribute of tags.
							'This Token is used as a Username', //Formatted title of the field. Shown as the label for the field during output.
							array($this,'Paa_field_api'), //Function that fills the field with the desired form inputs. The function should echo its output.
							'Paa',//The slug-name of the settings page on which to show the section (general, reading, writing, ...).
							'Paa_section_API_tokens');//The slug-name of the section of the settings page in which to show the box.

		// Register a new field in the "Paa_section_API_tokens" section, inside the "Paa" page.
		add_settings_field( 'Paa_api_token_Header', //$id Slug-name to identify the field. Used in the 'id' attribute of tags.
							'This Token is used as a Password', //Formatted title of the field. Shown as the label for the field during output.
							array($this,'Paa_field_api_header'), //Function that fills the field with the desired form inputs. The function should echo its output.
							'Paa',//The slug-name of the settings page on which to show the section (general, reading, writing, ...).
							'Paa_section_API_tokens');//The slug-name of the section of the settings page in which to show the box.
    }

    public function Paa_field_api($args) {
		// Get the value of the setting we've registered with register_setting()
		$randombyteskey = bin2hex(openssl_random_pseudo_bytes(16));
		$randombytessecrectkey = bin2hex(openssl_random_pseudo_bytes(16));
		$token = hash_hmac ( 'sha256' , $randombyteskey , $randombytessecrectkey );
		$options = get_option( 'Paa_options_api_token' );
		echo '<p>Previous Api Username Token : '.$options.'</p>';
		?>
		<input type="text" name="Paa_options_api_token" value="<?php echo $token; ?>" >
		<?php
	} 

	public function Paa_field_api_header($args) { 
		$randombyteskeyheader = bin2hex(openssl_random_pseudo_bytes(16));
		$randombytessecrectkeyheader = bin2hex(openssl_random_pseudo_bytes(16));
		$tokenheader = hash_hmac ( 'sha256' , $randombyteskeyheader , $randombytessecrectkeyheader );
	
		$optionsheader = get_option( 'Paa_options_api_header' );
		echo '<p>Previous Api Password Token : '.$optionsheader.'</p>';
		?>
		<input type="text" name="Paa_options_api_header" value="<?php echo $tokenheader; ?>" >
		<?php
	}



	public function Paa_section_API_tokens_callback() {
	  echo	'<p>Click on save to save the new api tokens, the previous keys will automatically deleted.</p>';
	  echo "<p>Note : Dont Touch anything if you're not a Developer!</p>";
    }
    

////////////////////////////////////////////////////////////////////////////////////
////////////////////// SubHeader Reciever editor /////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////
	
	public function paa_reciever_settings()
	{
		// Register a new setting for "Paa_reciever_editor" page.
		register_setting( 'Paa_reciever_editor', 'paa_reciever_editing_category' );
		register_setting( 'Paa_reciever_editor', 'paa_reciever_editing_price' );
		// Register a new section in the "Paa_reciever_editor" page.
		add_settings_section(
			'paa_reciever_editing_section',
			'Edit the api reciever of Products', [$this, 'paa_description_reciever_editing_category_section'],
			'Paa_reciever_editor'
		);

		// Register a new field in the "paa_reciever_editing_section" section, inside the "Paa_reciever_editor" page.
		add_settings_field(
			'paa_reciever_editing_category_field', 
			'Enter the desired category SLUG!!',
			[$this, 'paa_form_reciever_editing_category_field'],
			'Paa_reciever_editor',
			'paa_reciever_editing_section'
		);

		add_settings_field(
			'paa_reciever_editing_price_field', 
			'Enter the desired price "format 1.00"',
			[$this, 'paa_form_reciever_editing_price_field'],
			'Paa_reciever_editor',
			'paa_reciever_editing_section'
		);

	}
	public function paa_description_reciever_editing_category_section()
	{?>
		<p>Editing one of these options, will affect all upcoming registration of products by the api.</p>
		<p>the default setting will be disabled once you activate a function</p>
	<?php }

	public function paa_form_reciever_editing_category_field()
	{ 
		$categories = product_categories();
		$option = get_option("paa_reciever_editing_category");		
		// printer($option);
		// return;
		
		foreach($categories as $category_slug => $id)
			{ 
				if($category_slug == 'zero-shiny' || $category_slug == 'shiny' || $category_slug == 'lvl2ties' || $category_slug == 'lvl40' || $category_slug == 'lvl3ties') continue;
				?>
				<div style="display:block;">
					<label for="paa_reciever_editing_category_checkbox_<?= $category_slug ?>"><?= $category_slug ?> : </label>
					<input type="checkbox" id="paa_reciever_editing_category_checkbox_<?= $category_slug ?>" name="paa_reciever_editing_category[categories][]" value="<?= $id ?>" <?php if(isset($option['categories'])){ if(in_array($id,$option['categories'])){ echo 'checked'; }} ?>>
				</div>
			<?php } ?>
		



		<label style="font-weight:bold;" for="paa_reciever_editing_category_checkbox">Activate this function : </label>
		<input type="checkbox" id="paa_reciever_editing_category_checkbox" value="activated" name="paa_reciever_editing_category[status]" <?php if(isset($option['status'])) { if($option['status'] == 'activated') { echo 'checked'; } }?>>
	<?php }

	public function paa_form_reciever_editing_price_field()
	{
		$option = get_option("paa_reciever_editing_price");
	?>
		<input type="number" min="0" step=".01" name="paa_reciever_editing_price[price]" value="<?php if(isset($option['price'])) { echo $option['price']; } ?>" />
		<label style="font-weight:bold;" for="paa_reciever_editing_price_checkbox">Activate this function : </label>
		<input type="checkbox" id="paa_reciever_editing_price_checkbox" value="activated" name="paa_reciever_editing_price[status]" <?php if(isset($option['status'])) { if($option['status'] == 'activated') { echo 'checked'; }} ?>>
	<?php }

////////////////////////////////////////////////////////////////////////////////////
////////////////////// SubHeader upload against sold list ////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////
	public function Paa_upload_against_sold_list_init() 
	{
		// Register a new setting for "wporg" page.
		//register_setting( 'UASL', 'UASL_options' );

		// Register a new section in the "wporg" page.
		add_settings_section(
			'Paa_upload_against_sold_list_section',
			"Upload the CSV file for the ASL",
			[$this, 'Paa_upload_against_sold_list_section_callback'],
			'Paa_upload_against_sold_list'
		);

		// Register a new field in the "Paa_upload_against_sold_list_section" section, inside the "wporg" page.
		add_settings_field(
			'Paa_upload_against_sold_list_field', // As of WP 4.6 this value is used only internally.
									// Use $args' label_for to populate the id inside the callback.
			"Click on the upload button",
			[$this, 'Paa_upload_against_sold_list_field_cb'],
			'Paa_upload_against_sold_list',
			'Paa_upload_against_sold_list_section'
		);
	}



	public function Paa_upload_against_sold_list_section_callback( $args ) {
		?>
		<p>Once you submit the file it will be registered in the table list and when the API recieve an account from PAC it will check for it if exists in table it'll reject it, NOTE!! the list can't be deleted in any form only from the phpmyadmin.</p>
		<?php
	}


	public function Paa_upload_against_sold_list_field_cb( $args ) {
		// Get the value of the setting we've registered with register_setting()
		//$options = get_option( 'UASL_options' );
		?>
		<input type="file" name="ASL" id="">
		<?php
	}









/////////////////////// register the settings ////////////////////////////////
    public function run() {
        $this->Administration_menu_settings();
		$this->paa_reciever_settings();
		//$this->Paa_upload_against_sold_list_init();
    }
}