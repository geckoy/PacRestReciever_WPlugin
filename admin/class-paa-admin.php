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
class Paa_Admin {

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

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/paa-admin.css', array(), $this->version, 'all' );

		/** 
		 * Datatable enqueued styles
		 */

		wp_enqueue_style( 'DataTableCSS', plugin_dir_url( __FILE__ ) . 'assets/datatable/datatables.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Paa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Paa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/paa-admin.js', array( 'jquery' ), $this->version, false );

		/** 
		 * DataTable Enqueued scripts
		 */
		wp_enqueue_script( 'DataTableJS', plugin_dir_url( __FILE__ ) . 'assets/datatable/datatables.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * This method is responsible For displaying Adminstration menu and its subheader menus for the plugin.
	 * 
	 * @since    1.0.0
	 */
	public function Paa_options_page() {

		/** 
		 * Paa Header page
		 */  
		add_menu_page(
			'Paa Plugin',
			'Paa Api',
			'manage_options',
			'Paa',
			array($this, 'Display_admin_Page'),
			'dashicons-sort',
			80
		);	

		/**
		 * Paa subHeader page 'edit reciever'
		 */ 
		add_submenu_page(
			'Paa',
			'Edit Reciever',
			'Edit the reciever',
			'manage_options',
			'Paa_reciever_editor',
			array($this, 'Display_reciever_editor')
		);

		/**
		 * Paa subHeader page 'Download accounts'
		 */ 
		add_submenu_page(
			'Paa',
			'Download Accounts',
			'Download Un:Pw in csv',
			'manage_options',
			'Paa_download_accounts',
			array($this, 'Display_download_accounts')
		);

		/**
		 * Paa subHeader page 'Upload Against SOLD list'
		 */ 
		add_submenu_page(
			'Paa',
			'Upload Against Sold list',
			'Upload the CSV ASL',
			'manage_options',
			'Paa_upload_against_sold_list',
			[$this, 'Display_upload_against_sold_list']
		);
	}

	/**
	 * Callback of add_menu_page();
	 */
	public function Display_admin_Page(){
		require_once 'partials/paa-admin-display.php';
	}

	/**
	 * Callback of add_submenu_page() Edit Reciever;
	 */
	public function Display_reciever_editor() {
		require_once 'partials/paa_reciever_editor_display.php';
	}

	/**
	 * Callback of add_submenu_page() Download Accounts;
	 */
	public function Display_download_accounts()
	{
		require_once 'partials/paa_download_accounts_display.php';
	}

	public function Display_upload_against_sold_list()
	{
		require_once 'partials/Paa_upload_against_sold_list.php';
	}

	/**
	 * This method is responsible for controlling the settings for Administration menu and its subheader menus of the plugin.
	 * 
	 * @since    1.0.0 
	 */
	public function Paa_settings_init() {
		////////////////////////////////dont touch
		require_once 'settings/paa_admin_settings.php';
		new Paa_Admin_settings($this->plugin_name, $this->version);
		

		/* Limit Access to some user roles */
		global $pagenow, $typenow;
		
		if( ( $typenow === "shop_order" && $_POST["action"] === "editpost" ) || ( $typenow === "shop_order" && $pagenow === "post-new.php" ) )
		{
			if(! current_user_can("manage_options") )
			{
				echo "<h1>Unauthorized</h1>";
				header("HTTP/1.1 500 unauthorized");
				exit;
			}
		}
	}
	/**
	 * public init wordpress
	 */
	public function Paa_public_init()
	{
		/**
		 * delete accounts
		 */
// 		global $wpdb;
// 		$plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
// 		$logFolder_path = $plugin_dir."/admin/log/";
// 		$file_path["counter"] = $logFolder_path."counter.txt";
// 		$file_path["undesired"] = $logFolder_path."undesired.txt";

// 		$myfile["counter"]["opened"] = fopen($file_path["counter"], "a+");
// 		$myfile["list_undsired"]["opened"] = fopen($file_path["undesired"], "a");
		
		
// 		if( $myfile["counter"]["opened"] !== false )
// 		{
// 			$myfile["counter"]["readed"] = fread($myfile["counter"]["opened"],filesize($file_path["counter"]));
// 			$count = $myfile["counter"]["readed"];
// 			fclose($myfile["counter"]["opened"]);
// 			unset($myfile["counter"]);
// 		}else
// 		{
// 			return;
// 		}
		
// // ##############################
// // 	$myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
// // 	fwrite($myfile["counter"]["opened"], $count + 1);
// // 	fclose($myfile["counter"]["opened"]);
// // 	return;
// // ############################

// 		if($count >= 7490 ) // add one more
// 		{
// 			return;
// 		}
		
// 		$row = $wpdb->get_row("SELECT * FROM paa_accounts WHERE id = {$count}");
		
// 		if($row === NULL){
// 			$myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
// 			fwrite($myfile["counter"]["opened"], $count + 1);
// 			fclose($myfile["counter"]["opened"]);
// 			return;
// 		}else
// 		{
// 			$username = encrypter_dcrypter($row->username,"d");
// 			$password = encrypter_dcrypter($row->password,"d");
// 			$product_id = $row->product_id;
// 			$is_sold = $row->sold;
// 			$pattern = "/Jiahua/i";
// 			if( preg_match($pattern, $username) )
// 			{
				
// 				//echo "delete the account";

// 				$delete_status = $wpdb->delete("paa_accounts",["product_id" =>$product_id]);
// 				if( $delete_status === false ) return;
				
// 				fwrite($myfile["list_undsired"]["opened"], "{$count} / $username, $password, is sold : $is_sold, product_id : $product_id \n");
// 				$product = wc_get_product( $product_id );
// 				$product->delete();
// 				$myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
// 				fwrite($myfile["counter"]["opened"], $count + 1);
// 				fclose($myfile["counter"]["opened"]);
				
// 				return;
// 			}else
// 			{
// 				//echo "don't delete";
				
				
// 				$myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
// 				fwrite($myfile["counter"]["opened"], $count + 1);
// 				fclose($myfile["counter"]["opened"]);
// 				return;
// 			}
// 		}
		
		/**
		 * reprice accounts
		 */

		
		// global $wpdb;
		// $plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
		// $logFolder_path = $plugin_dir."/admin/log/";
		// $file_path["counter"] = $logFolder_path."counter.txt";
		// $file_path["undesired"] = $logFolder_path."undesired.txt";

		// $myfile["counter"]["opened"] = fopen($file_path["counter"], "a+");
		// $myfile["list_undsired"]["opened"] = fopen($file_path["undesired"], "a");
		
		
		// if( $myfile["counter"]["opened"] !== false )
		// {
		// 	$myfile["counter"]["readed"] = fread($myfile["counter"]["opened"],filesize($file_path["counter"]));
		// 	$count = $myfile["counter"]["readed"];
		// 	fclose($myfile["counter"]["opened"]);
		// 	unset($myfile["counter"]);
		// }else
		// {
		// 	return;
		// }
		
		
		// if($count >= 272 ) // add one more
		// {
		// 	return;
		// }
		
		// $product_ids = $wpdb->get_results("SELECT product_id FROM `paa_account_data` WHERE level = 40 AND shinycount = 0 AND product_id IN (SELECT product_id FROM `paa_accounts` WHERE sold = 0) ORDER BY product_id DESC LIMIT 273", OBJECT);
		
		// if($product_ids === NULL ) return;
		// $product_id = $product_ids[$count]->product_id;
		// $product = wc_get_product($product_id);
		
		// $price = "10";
		// $product->set_price($price);
		// $product->set_regular_price($price);
		// $product->save();
		// $wpdb->update( 
		// 	'paa_account_data', 
		// 	array( 
		// 		'price' => stripslashes(10.00),   // float
		// 	), 
		// 	array( 'product_id' => $product_id ), 
		// 	array( 
		// 		'%f',   // price value 'float'
		// 	), 
		// 	array( '%d' ) 
		// );
		
		// $myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
		// fwrite($myfile["counter"]["opened"], $count + 1);
		// fclose($myfile["counter"]["opened"]);
		// return;

		/**
		 * recatigorize accounts
		 */

		
		// global $wpdb;
		// $plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
		// $logFolder_path = $plugin_dir."/admin/log/";
		// $file_path["counter"] = $logFolder_path."counter.txt";
		// $file_path["undesired"] = $logFolder_path."undesired.txt";

		// $myfile["counter"]["opened"] = fopen($file_path["counter"], "a+");
		// $myfile["list_undsired"]["opened"] = fopen($file_path["undesired"], "a");
		
		
		// if( $myfile["counter"]["opened"] !== false )
		// {
		// 	$myfile["counter"]["readed"] = fread($myfile["counter"]["opened"],filesize($file_path["counter"]));
		// 	$count = $myfile["counter"]["readed"];
		// 	fclose($myfile["counter"]["opened"]);
		// 	unset($myfile["counter"]);
		// }else
		// {
		// 	return;
		// }
		
		
		// if($count >= 272 ) // add one more 272
		// {
		// 	return;
		// }
		
		// $product_ids = $wpdb->get_results("SELECT product_id FROM `paa_account_data` WHERE level = 40 AND shinycount = 0 AND price = 10 ORDER BY product_id DESC", OBJECT);
		// $category_vanilla = categories_id("vanilla-accounts");
		
		// if($product_ids === NULL ) return;
		// $product_id = $product_ids[$count]->product_id;
		// $product = wc_get_product($product_id);
		
		
		// $product->set_category_ids([$category_vanilla]);
		// $product->save();
		
		
		// $myfile["counter"]["opened"] = fopen($file_path["counter"], "w");
		// fwrite($myfile["counter"]["opened"], $count + 1);
		// fclose($myfile["counter"]["opened"]);
		// return;
	}

	/**
	 * This method is responsible for displaying custom meta box that display account details in the product edit screen.
	 * 
	 * @since    1.0.0
	 */
	public function admin_product_add_custom_box() {
		$screens = [ 'product', 'shop_order' ];
		$content_callback = [
			"product" 	   => [
				"callback"  => [$this, 'admin_product_custom_box_html'],
				"uniqid"    => "admin_order_URL",
				"box_title" => "Order Details"
			],

			"shop_order"   => [
				"callback"  => [$this, 'admin_order_custom_box_html'],
				"uniqid"    => "admin_order_URL",
				"box_title" => "Order Details"
			],
			
		];
		foreach ( $screens as $screen ) {
			$args = $content_callback[$screen];
			add_meta_box(
				$args["uniqid"], // Unique ID
				$args["box_title"],      // Box title
				$args["callback"],  // Content callback, must be of type callable
				$screen                 // Post type
			);
		}
	}

	/**
	 * Callback for admin_product_add_custom_box();
	 */
	public function admin_product_custom_box_html( $post ) {
		if( !current_user_can('manage_options') && !current_user_can('edit_shop_orders') ) {
			return;
		}
		require_once 'partials/paa_product_details.php';
	}
	
	/**
	 * Callback for admin_product_add_custom_box();
	 */
	public function admin_order_custom_box_html( $post )
	{
		if( !current_user_can('manage_options') && !current_user_can('edit_shop_orders') ) return;
		$order = wc_get_order( $post->ID );
		echo 'ORDER URL : ' . $order->get_checkout_order_received_url();
	}



	public function delete_db_data_after_post_deletion( $postid ) {
		global $wpdb;//product
		$post_type = get_post_type( $postid );
		if( $post_type == "product" ) return;
		$wpdb->delete( 'paa_account_data', array( 'product_id' => $postid ) );
		$wpdb->delete( 'paa_pokemons', array( 'product_id' => $postid ) );
		//$wpdb->delete( 'paa_accounts', array( 'product_id' => $postid ) );
		//$wpdb->delete( 'paa_account_items', array( 'product_id' => $postid ) );
		//$wpdb->delete( 'paa_account_candy', array( 'product_id' => $postid ) );
		//$wpdb->delete( 'paa_account_mega_energy', array( 'product_id' => $postid ) );
		
		
	}

	public function order_status_completed( $post_id ) 
	{
		global $post_type;	
		if($post_type != 'shop_order') return;
		$order = wc_get_order($post_id);
		
		if($items = $order->get_items())
		{
			
			foreach( $items as $item_id => $item )
			{
				
				$product = $item->get_product();
				$product_id = $product->get_id();
				set_product_to_sold_status( $product_id );
				//wp_trash_post( $product_id );
				$product->delete();
			}	
		}	
	}

	public function order_status_denied( $post_id )
	{
		global $post_type;	
		if($post_type != 'shop_order') return;
		$order = wc_get_order($post_id);

		if($items = $order->get_items())
		{
			
			foreach( $items as $item_id => $item )
			{
				$product = $item->get_product();
				$product_id = $product->get_id();
				$product_status = get_post_status($product_id);

				redo_set_product_to_sold_status( $product_id );
				if( $product_status == "trash" )
				{
					wp_untrash_post( $product_id );
				}
			}	
		}	
	}


	/**
	 * Hook update the price of product in the db 
	 */
	public function update_price(){
		if( $_POST["post_type"] == "product" )
		{
			global $wpdb;

			if(array_key_exists("pokemon_account_data",$_POST))
			{
				$original_account_creds = $_POST["pokemon_account_data"]["original"];
				unset($_POST["pokemon_account_data"]["original"]);
				$account_creds = $_POST["pokemon_account_data"]; 
				if($original_account_creds["username"] != $account_creds["username"])
				{
					$wpdb->update( "paa_accounts", ["username" => encrypter_dcrypter(stripslashes($account_creds["username"]))], ["product_id" => $_POST['post_ID']], ["%s"], ["%d"] );
				}

				if($original_account_creds["password"] != $account_creds["password"])
				{
					$wpdb->update( "paa_accounts", ["password" => encrypter_dcrypter(stripslashes($account_creds["password"]))], ["product_id" => $_POST['post_ID']], ["%s"], ["%d"] );
				}
			}
	
			if($_POST['_regular_price']){
				$wpdb->update( 
					'paa_account_data', 
					array( 
						'price' => stripslashes($_POST['_regular_price']),   // float
					), 
					array( 'product_id' => $_POST['post_ID'] ), 
					array( 
						'%f',   // price value 'float'
					), 
					array( '%d' ) 
				);
			}
		}
		
	}	
	
	/**
	 * Middleware
	 */
	public function csv_accounts()
	{	
		global $plugin_dir;
		//http://localhost/ritmojsoslyxz6969/downloads/data.csv
		if ($_SERVER['REQUEST_URI']=='/ritmojsoslyxz6969/downloads/data.csv') 
		{
			if(current_user_can('manage_options'))
			{
				if (confirm_auth_http($_SERVER['PHP_AUTH_USER']) && confirm_auth_http($_SERVER['PHP_AUTH_PW']) ) 
				{
					header('WWW-Authenticate: Basic realm="Access to Heaven"');
					header('HTTP/1.0 401 Unauthorized');
					echo '<h1>Unauthorized</h1>';
					die;
				}else
				{
					$accounts = $this->retrieve_accounts_csv();
					//$url = $plugin_dir.'admin/partials/'.__Accounts_CSV__;	
					//$url = $plugin_dir.'admin/partials/MACOAZDJAZdfajkizndoaznfiakzejdldqzDQZdQKZDaiflzjnfa/account.php';		
					header("HTTP/1.0 200 authorized");
					header("Content-type: text/plain");
					header("Content-Disposition: attachment; filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");

					foreach($accounts as $account)
					{
						echo encrypter_dcrypter($account->username, "d").",".encrypter_dcrypter($account->password,"d")."\r\n";
					}

					exit();
				}
			}else
			{
				die;
			}
		}
	}
	private function retrieve_accounts_csv()
	{
		global $wpdb;

			return $wpdb->get_results( 
				"
					SELECT * 
					FROM paa_accounts WHERE sold=0;
				"
			);
		
	}
	public function send_account_on_payment($order_id)
	{
		if(! validate_num($order_id)) return;

		send_account_to_customer($order_id);
	}
	
}

/*
$file = plugin_dir_path( __FILE__ )."log.txt";	
		$arr = [];
		foreach( $order->get_items() as $item_id => $item )
			{
				$product = $item->get_product();
				$product_id = $product->get_id();
				$arr[] = $product_id;			
			}	
			file_put_contents( $file, $arr );
*/