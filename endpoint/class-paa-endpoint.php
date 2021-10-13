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
class Paa_Endpoint {

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
	 * products categories
	 */
	private $categories;

	/**
	 * Shinies amount
	 */
	private $shinies;
	
	/**
	 *	Options reciever editor 
	 */
	private $option = [];

	/**
	 * Based prices of accounts
	 */
	private $pricing = [
		30    => 2,
		31    => 3,
		32    => 4,
		33    => 5,
		34    => 6,
		35    => 8,
		36    => 10,
		37    => 13,
		38    => 16,
		39    => 20,
		40    => 30
	];

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
	public function define_method_dependencies()
	{
		$this->categories = product_categories();

		$this->option['price'] = get_option("paa_reciever_editing_price");
		$this->option['category'] = get_option("paa_reciever_editing_category");
	}
	
	/**
	 * Callback For 
	 * 		Hooks : 
	 * 						@rest_api_init  "LOCATION : plugin_dir_path( dirname( __FILE__ ) ).'includes/class-paa.php';" 
	 */
	public function Paa_rest_api_endpoint(){
	 
		register_rest_route( 'paa/v1', '/saveanimal', array(
			'methods' => 'POST',
			'callback' => array($this, 'my_endpoint_display')
		  ) );
	}

	private function prepare_tokens($tokens)
	{
		$pass_token = explode(':',$tokens[0]);
		$header_token = explode('Basic ',$pass_token[0])[1];
		return [$header_token,$pass_token[1]];
	}
	
	/**
	 * Callback For Paa_rest_api_endpoint();
	 */
	
	public function my_endpoint_display( WP_REST_Request $request )
	{
		

		$request->set_method('POST');
		
			

		$apitokens = $this->prepare_tokens($request->get_headers()['authorization']);
		
		if(!$request->is_json_content_type()){
			return new WP_Error( 'JSON_ERROR', 'The Data that was sent is not a json format, retry.', array( 'status' => 400 ) );
		}else
		{	
			if(!hash_equals(get_option( 'Paa_options_api_token' ), $apitokens[0]) || !hash_equals(get_option( 'Paa_options_api_header' ), $apitokens[1]) ) 
			{	
				return new WP_Error( 'AUTHORIZATION_ERROR', 'Failed to Authenticate.', array( 'status' => 401 ) );
			}else
			{			
////////////////////////////////////// Total number of products //////////////////////////
				// $args = array( 'post_type' => 'product', 'product_cat' => 'lvl40+zero-shiny','post_status' => 'publish', 
				// 'posts_per_page' => -1 );
				// $products = new WP_Query( $args );
								
////////////////////////load method dependecies////////////////////////////////////

	$this->define_method_dependencies();
						
////////////////////////GET RAW JSON////////////////////////////////////
	global $wpdb;
	$jsonpoke = $request->get_params();
	$pokeaccountlevel = $jsonpoke['level'];

////////////////////////Verify Status////////////////////////////////////
	if($this->check_status($jsonpoke['status']))
	{
		return [ 'ACCOUNT_ERROR' => 'Account contain undesired status.'];
	}
/////////////////////////// prepare username password ///////////////////////////////

	$pokeaccountusername = encrypter_dcrypter($jsonpoke['username']);
	$pokeaccountpassword = encrypter_dcrypter($jsonpoke['password']);

/////////////////////////// prepare account name ////////////////////////////////////

	$product_name = $wpdb->get_results( "SELECT max(ID) FROM {$wpdb->prefix}posts", ARRAY_N )[0][0] + 1000;

//////////////////////// Setting up variables //////////////////////////////
	$playerData = $jsonpoke['playerData'];
	$totalItems = $jsonpoke['totalItems'];
	$accountstatus = $jsonpoke['status'];
	$accounttotalpokemons = $jsonpoke['totalPokemon'];
	$items = json_encode($jsonpoke['items']);
	$candy = json_encode($jsonpoke['candyData']);
	$mega_energy = json_encode($jsonpoke['megaEnergyData']);
	$pokemons = $jsonpoke['pokemon'];
	$account_experience = $playerData['experience'];
	$post_status = "publish";
	$account_flagged = ($playerData["team"] != 0);
	$account_not_flagged = ($playerData["team"] == 0);
/////////////////////////// Check duplication //////////////////////////////////////

	$account_duplacation = $wpdb->get_row( "SELECT * FROM paa_accounts WHERE username = '{$pokeaccountusername}'", OBJECT );

	if(! empty($account_duplacation) || ! empty($wpdb->last_error))
	{
		if(! empty($wpdb->last_error)) return new WP_Error( 'ACCOUNT_ERROR', "$wpdb->last_error", array( 'status' => 500 ) );
		
		$wpdb->query(
			$wpdb->prepare(
				"
				INSERT INTO paa_account_duplicates
				( product_id, account )
				VALUES ( %s, %s )
				",
				$account_duplacation->product_id, serialize($jsonpoke)
			)
		);
		return [ 'ACCOUNT_ERROR' => 'Duplicates found.'];
	}

	
/////////////////////////// Check ASL //////PurfTrainer09062////////////////////////////////
	if($account_not_flagged)
	{
		$account_asl = $wpdb->get_row( "SELECT * FROM paa_against_sold_list WHERE username = '{$pokeaccountusername}'", OBJECT );
		if($account_asl || ! empty($wpdb->last_error))
		{
			if(! empty($wpdb->last_error)) return new WP_Error( 'ACCOUNT_ERROR', "$wpdb->last_error", array( 'status' => 500 ) );
			$wpdb->query(
				$wpdb->prepare(
					"
					INSERT INTO paa_against_sold_list_found
					( asl_id, account )
					VALUES ( %s, %s )
					",
					$account_asl->id, serialize($jsonpoke)
				)
			);
			return [ 'ACCOUNT_ERROR' => 'ASL found.'];
		}
	}
/////////////////////////Check If level pricing exist///////////////////////////////
	if(! array_key_exists($pokeaccountlevel,$this->pricing))
	{


		do{
			$status = $wpdb->query(
				$wpdb->prepare(
					"
					INSERT INTO paa_account_duplicates
					( account )
					VALUES ( %s )
					",
					serialize($jsonpoke)
				)
			);
		}while($status === false);
		
		return [ 'ACCOUNT_ERROR' => 'Level is unpricable.'];
	}
////////////////////////Check if is teamed//////////////////////////////////
if($account_flagged)
{
	$post_status = "private";
}
////////////////////////Setting shinies count////////////////////////////////////
	$this->shinies = $this->count_shinies($jsonpoke['pokemon']);
	
/////////////////////Account categoring////////////////////////////////////		
	$product_term = $this->categories['zero-shiny'];
	if($this->shinies > 0)
	{
		$product_term = $this->categories['shiny'];
	}
	$prodcut_cat = [];
	$prodcut_cat[] = $product_term;	
		
	if($this->option['category']['status'] == "activated")
	{
		foreach($this->option['category']['categories'] as $category)
		{
			$prodcut_cat[] = $category;
		}				
	}

			
	if($pokeaccountlevel == 40)
	{
		$prodcut_cat[] = $this->categories['lvl40'];
	}elseif($pokeaccountlevel >= 30 && $pokeaccountlevel < 40)
	{
		$prodcut_cat[] = $this->categories['lvl3ties'];
	}elseif($pokeaccountlevel >= 20 && $pokeaccountlevel < 30)
	{
		$prodcut_cat[] = $this->categories['lvl2ties'];
	}		
	
//////////////////////Account Pricing/////////////////////////////////// 
	if($this->option['price']['status'] == "activated")
	{
		$price = $this->option['price']['price'];
	}else{
			$price =  $this->pricing[$pokeaccountlevel];
			if($this->shinies > 0)
			{
				$shinies_price = $this->shinies*0.5;
				$price += $shinies_price;
			}
	}

	// if($products->found_posts < 1000)
	// {
	// 	if($this->shinies < 1 && $pokeaccountlevel == 40)
	// 	$price = 10;
	// }
	
	if( $pokeaccountlevel == 40 )
	{
		if($account_experience >= 20000000 && $account_experience <= 80000000)
		{
			$XP_difference = $account_experience - 20000000;
			$XP_difference /= 1000000;
			$price += ceil($XP_difference);
		}elseif($account_experience >= 80000000)
		{
			$post_status = "private";
		}
	}
	// printer($post_status);
	// printer($price);
	// return;

////////////////////////CREATE THE PRODUCT///////////////////////////////
	$post_id = $this->create_product( array(
		'type'               => '', // Simple product by default
		'name'               => $product_name,
		'description'        => '',
		'short_description'  => '',
		'category_ids'       => $prodcut_cat,
		'regular_price'      => $price, // product price
		'reviews_allowed'    => true,
		'virtual'		 	 => true,
		'sold_individually'	 => true,
		'status'			 => $post_status,
	));  
	update_post_meta( $post_id, '_manage_stock', 'yes' );
	update_post_meta( $post_id, '_stock', '1' );

///////////////////////INSERT ACCOUNT USERNAME AND PASSWORD//////////////
	do{
		$status = $wpdb->query(
					$wpdb->prepare(
					"
					INSERT INTO paa_accounts
					( product_id,username,password)
					VALUES ( %d, %s, %s)
					",
					$post_id,$pokeaccountusername,$pokeaccountpassword
					)
				);
	}while($status === false);
	
////////////////////INSERT ACCOUNT DATA////////////////////////////////////
	do{
		$status = $wpdb->query(
					$wpdb->prepare(
					"
					INSERT INTO paa_account_data
					( product_id, level, totalPokemon,	shinycount, status, totalItems, price, experience, hasWarning, inGameUsername, kilometersWalked, maxItemStorage, maxPokemonStorage, pokeCoins, pokemonCaught, pokemonEncountered, pokestopsVisited, remainingNameChanges, stardust, startDate, startTimestamp, team, wasSuspended, Items, candy,mega_energy )
					VALUES ( %d,%d,%d,%d,%s,%d,%f, %d,%d,%s,%f,%d,%d,%d,%d,%d,%d,%d,%d,%s,%d,%d,%d,%s,%s,%s)
					",
					$post_id, $pokeaccountlevel, $accounttotalpokemons, $this->shinies, $accountstatus ,$totalItems , $price, $playerData['experience'],$playerData['hasWarning'],$playerData['inGameUsername'],$playerData['kilometersWalked'],$playerData['maxItemStorage'],$playerData['maxPokemonStorage'],$playerData['pokeCoins'],$playerData['pokemonCaught'],$playerData['pokemonEncountered'],$playerData['pokestopsVisited'],$playerData['remainingNameChanges'],$playerData['stardust'],$playerData['startDate'],$playerData['startTimestamp'],$playerData['team'],$playerData['wasSuspended'],$items,$candy,$mega_energy
					)
				);	
	}while($status === false);
///////////////////////INSERT POKEMONS///////////////////////////////////

	if(! empty($pokemons))
	{
		foreach($pokemons as $pokemon) 
		{
			do{
				$status = $wpdb->query(
							$wpdb->prepare(
							"
							INSERT INTO paa_pokemons
							( product_id,id,name,gender,formId,formName,costumeId,isShiny,isLucky,isShadow,isPurified,isBad,isLegendary,isMythical,individualAttack,individualDefense,individualStamina,ivsPercentage,level,cp,stamina,maxStamina,move1Id,move2Id,move3Id,move1Name,move2Name,move3Name,height,weight,creationTimestamp,creationDate )
							VALUES ( %d, %d, %s, %d, %d, %s, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d , %f, %d, %d, %d, %d, %d, %d, %d, %s, %s, %s, %f, %f, %d, %s)
							",
							$post_id,$pokemon['id'],$pokemon['name'],$pokemon['gender'],$pokemon['formId'],$pokemon['formName'],$pokemon['costumeId'],$pokemon['isShiny'],$pokemon['isLucky'],$pokemon['isShadow'],$pokemon['isPurified'],$pokemon['isBad'],$pokemon['isLegendary'],$pokemon['isMythical'],$pokemon['individualAttack'],$pokemon['individualDefense'],$pokemon['individualStamina'],$pokemon['ivsPercentage'],$pokemon['level'],$pokemon['cp'],$pokemon['stamina'],$pokemon['maxStamina'],$pokemon['move1Id'],$pokemon['move2Id'],$pokemon['move3Id'],$pokemon['move1Name'],$pokemon['move2Name'],$pokemon['move3Name'],$pokemon['height'],$pokemon['weight'],$pokemon['creationTimestamp'],$pokemon['creationDate']
							)
						);
			}while($status === false);
		} 
	}

//////////////////////////////End
				return array("ACCOUNT_SUCCESS" => 'product Added.');
			} 
		}
	}

	private function create_product( $args ){

		/* if( ! function_exists('wc_get_product_object_type') && ! function_exists('wc_prepare_product_attributes') )
			return false; */
	
		// Get an empty instance of the product object (defining it's type)
		$product = $this->wc_get_product_object_type( $args['type'] );
		if( ! $product )
			return false;
	
		// Product name (Title) and slug
		$product->set_name( $args['name'] ); // Name (title).
		if( isset( $args['slug'] ) )
			$product->set_name( $args['slug'] );
	
		// Description and short description:
		$product->set_description( $args['description'] );
		$product->set_short_description( $args['short_description'] );
	
		// Status ('publish', 'pending', 'draft' or 'trash')
		$product->set_status( isset($args['status']) ? $args['status'] : 'publish' );
	
		// Visibility ('hidden', 'visible', 'search' or 'catalog')
		$product->set_catalog_visibility( isset($args['visibility']) ? $args['visibility'] : 'visible' );
	
		// Featured (boolean)
		$product->set_featured(  isset($args['featured']) ? $args['featured'] : false );
	
		// Virtual (boolean)
		$product->set_virtual( isset($args['virtual']) ? $args['virtual'] : false );
	
		// Prices
		$product->set_regular_price( $args['regular_price'] );
		$product->set_sale_price( isset( $args['sale_price'] ) ? $args['sale_price'] : '' );
		$product->set_price( isset( $args['sale_price'] ) ? $args['sale_price'] :  $args['regular_price'] );
		if( isset( $args['sale_price'] ) ){
			$product->set_date_on_sale_from( isset( $args['sale_from'] ) ? $args['sale_from'] : '' );
			$product->set_date_on_sale_to( isset( $args['sale_to'] ) ? $args['sale_to'] : '' );
		}
	
		// Downloadable (boolean)
		$product->set_downloadable(  isset($args['downloadable']) ? $args['downloadable'] : false );
		if( isset($args['downloadable']) && $args['downloadable'] ) {
			$product->set_downloads(  isset($args['downloads']) ? $args['downloads'] : array() );
			$product->set_download_limit(  isset($args['download_limit']) ? $args['download_limit'] : '-1' );
			$product->set_download_expiry(  isset($args['download_expiry']) ? $args['download_expiry'] : '-1' );
		}
	
		// Taxes
		if ( get_option( 'woocommerce_calc_taxes' ) === 'yes' ) {
			$product->set_tax_status(  isset($args['tax_status']) ? $args['tax_status'] : 'taxable' );
			$product->set_tax_class(  isset($args['tax_class']) ? $args['tax_class'] : '' );
		}
	
		// SKU and Stock (Not a virtual product)
		if( isset($args['virtual']) && ! $args['virtual'] ) {
			$product->set_sku( isset( $args['sku'] ) ? $args['sku'] : '' );
			$product->set_manage_stock( isset( $args['manage_stock'] ) ? $args['manage_stock'] : false );
			$product->set_stock_status( isset( $args['stock_status'] ) ? $args['stock_status'] : 'instock' );
			if( isset( $args['manage_stock'] ) && $args['manage_stock'] ) {
				$product->set_stock_status( $args['stock_qty'] );
				$product->set_backorders( isset( $args['backorders'] ) ? $args['backorders'] : 'no' ); // 'yes', 'no' or 'notify'
			}
		}
	
		// Sold Individually
		$product->set_sold_individually( isset( $args['sold_individually'] ) ? $args['sold_individually'] : false );
	
		// Weight, dimensions and shipping class
		$product->set_weight( isset( $args['weight'] ) ? $args['weight'] : '' );
		$product->set_length( isset( $args['length'] ) ? $args['length'] : '' );
		$product->set_width( isset(  $args['width'] ) ?  $args['width']  : '' );
		$product->set_height( isset( $args['height'] ) ? $args['height'] : '' );
		if( isset( $args['shipping_class_id'] ) )
			$product->set_shipping_class_id( $args['shipping_class_id'] );
	
		// Upsell and Cross sell (IDs)
		$product->set_upsell_ids( isset( $args['upsells'] ) ? $args['upsells'] : '' );
		$product->set_cross_sell_ids( isset( $args['cross_sells'] ) ? $args['upsells'] : '' );
	
		// Attributes et default attributes
		if( isset( $args['attributes'] ) )
			$product->set_attributes( $this->wc_prepare_product_attributes($args['attributes']) );
		if( isset( $args['default_attributes'] ) )
			$product->set_default_attributes( $args['default_attributes'] ); // Needs a special formatting
	
		// Reviews, purchase note and menu order
		$product->set_reviews_allowed( isset( $args['reviews'] ) ? $args['reviews'] : false );
		$product->set_purchase_note( isset( $args['note'] ) ? $args['note'] : '' );
		if( isset( $args['menu_order'] ) )
			$product->set_menu_order( $args['menu_order'] );
	
		// Product categories and Tags
		if( isset( $args['category_ids'] ) )
			$product->set_category_ids( $args['category_ids'] );
		if( isset( $args['tag_ids'] ) )
			$product->set_tag_ids( $args['tag_ids'] );
	
	
		// Images and Gallery
		$product->set_image_id( isset( $args['image_id'] ) ? $args['image_id'] : "" );
		$product->set_gallery_image_ids( isset( $args['gallery_ids'] ) ? $args['gallery_ids'] : array() );
	
		## --- SAVE PRODUCT --- ##
		$product_id = $product->save();
	
		return $product_id;
	}
	
	// Utility public function that returns the correct product object instance
	private function wc_get_product_object_type( $type ) {
		// Get an instance of the WC_Product object (depending on his type)
		if( isset($args['type']) && $args['type'] === 'variable' ){
			$product = new WC_Product_Variable();
		} elseif( isset($args['type']) && $args['type'] === 'grouped' ){
			$product = new WC_Product_Grouped();
		} elseif( isset($args['type']) && $args['type'] === 'external' ){
			$product = new WC_Product_External();
		} else {
			$product = new WC_Product_Simple(); // "simple" By default
		} 
		
		if( ! is_a( $product, 'WC_Product' ) )
			return false;
		else
			return $product;
	}
	
	// Utility public function that prepare product attributes before saving
	private function wc_prepare_product_attributes( $attributes ){
		global $woocommerce;
	
		$data = array();
		$position = 0;
	
		foreach( $attributes as $taxonomy => $values ){
			if( ! taxonomy_exists( $taxonomy ) )
				continue;
	
			// Get an instance of the WC_Product_Attribute Object
			$attribute = new WC_Product_Attribute();
	
			$term_ids = array();
	
			// Loop through the term names
			foreach( $values['term_names'] as $term_name ){
				if( term_exists( $term_name, $taxonomy ) )
					// Get and set the term ID in the array from the term name
					$term_ids[] = get_term_by( 'name', $term_name, $taxonomy )->term_id;
				else
					continue;
			}
	
			$taxonomy_id = wc_attribute_taxonomy_id_by_name( $taxonomy ); // Get taxonomy ID
	
			$attribute->set_id( $taxonomy_id );
			$attribute->set_name( $taxonomy );
			$attribute->set_options( $term_ids );
			$attribute->set_position( $position );
			$attribute->set_visible( $values['is_visible'] );
			$attribute->set_variation( $values['for_variation'] );
	
			$data[$taxonomy] = $attribute; // Set in an array
	
			$position++; // Increase position
		}
		return $data;
	}
	
	private function check_status($status)
	{
		if($status == "error" || $status == "wrongCredentials" || $status == "notActivated" || $status == "locked" || $status == "disabled" || $status == "tempBanned" || $status == "banned") 
		{
			return true;
		}
	}
	
	private function count_shinies($pokemons)
	{
		$count = 0;
		foreach($pokemons as $pokemon) { 
			if($pokemon['isShiny'] === true) {
				$count += 1; 
			}
		}
		return $count;
	}

}



// $myfile = fopen(__log_file__, "r") or die("Unable to open file!");
						
						
// 						$txt = json_encode((array)$request);
// 						fwrite($myfile, $txt);
// 						fclose($myfile);
// 						$readed = fread($myfile,filesize(__log_file__));
// 						printer(json_decode($readed));



	/* 
						global $wpdb;
						$currenttimestamp = date("Y.m.d h:i:sa");
						$pokemonJson = json_encode($jsonpoke['pokemon']);
						$wpdb->query(
						$wpdb->prepare(
						"
						INSERT INTO pokemon_accounts
						( username, password, status,totalPokemon,pokemon, registertime )
						VALUES ( %s, %s, %s, %d, %s, %s )
						",
						$jsonpoke['username'],
						$jsonpoke['password'],
						$jsonpoke['status'],
						$jsonpoke['totalPokemon'],
						$pokemonJson,
						$currenttimestamp,
						)
						);
						return $pokemonJson; */



						/* $metakey   = 'Funny Phrases';
						$metavalue = "WordPress' database interface is like Sunday Morning: Easy.";
		
						$wpdb->query(
						$wpdb->prepare(
						"
						INSERT INTO $wpdb->postmeta
						( post_id, meta_key, meta_value )
						VALUES ( %d, %s, %s )
						",
						10,
						$metakey,
						$metavalue
						)
						); */

							// update_post_meta( $post_id, '_stardust',  $playerData['stardust']);
	// update_post_meta( $post_id, '_level',  $pokeaccountlevel);
	// update_post_meta( $post_id, '_startdate',  strtotime($playerData['startDate']));


/////////////////////////INSERT ACCOUNT Mega energy///////////////////////						
						
// $mega_energy = json_encode($jsonpoke['megaEnergyData']);
				
// $wpdb->query(
// 		$wpdb->prepare(
// 		"
// 		INSERT INTO paa_account_mega_energy
// 		( product_id , mega_energy)
// 		VALUES ( %d, %s)
// 		",
// 		$post_id,
// 		$mega_energy
// 		)
// 		);	

	/////////////////////////INSERT ACCOUNT CANDY///////////////////////						
						
// $candy = json_encode($jsonpoke['candyData']);
				
// $wpdb->query(
// 		$wpdb->prepare(
// 		"
// 		INSERT INTO paa_account_candy
// 		( product_id , candy)
// 		VALUES ( %d, %s)
// 		",
// 		$post_id,
// 		$candy
// 		)
// 		);	


/////////////////////INSERT ACCOUNT ITEMS/////////////////////////////////

						

						
// $items = json_encode($jsonpoke['items']);				
						
// $wpdb->query(
// 	$wpdb->prepare(
// 	"
// 	INSERT INTO paa_account_items
// 	( product_id , Items)
// 	VALUES ( %d, %s)
// 	",
// 	$post_id,
// 	$items
// 	)
// 	);

// $product_1 = array( 
	// 'post_title' => $product_name,
	// 'post_status' => 'publish',
	// 'post_type' => "product"
	// );
	// $post_id = wp_insert_post( $product_1 );
	// wp_set_object_terms( $post_id, 'simple', 'product_type' );
	// //wp_set_post_terms( $post_id, $prodcut_cat, 'product_cat', true );
	// wp_set_object_terms( $post_id,  $prodcut_cat, 'product_cat' );

	// update_post_meta( $post_id, '_visibility', 'visible' );
	// update_post_meta( $post_id, '_stock_status', 'instock');
	// update_post_meta( $post_id, '_downloadable', 'no' );
	// update_post_meta( $post_id, '_download_limit', '-1' );
	// update_post_meta( $post_id, '_download_expiry', '-1' );
	// update_post_meta( $post_id, '_virtual', 'yes' );
	// update_post_meta( $post_id, '_purchase_note', 'Thanks For Visiting our website your product Information will be sent soon!' );
	// update_post_meta( $post_id, '_sku', '' );
	// update_post_meta( $post_id, '_sold_individually', 'yes' );
	// update_post_meta( $post_id, '_manage_stock', 'yes' );
	// update_post_meta( $post_id, '_backorders', 'no' );
	// update_post_meta( $post_id, '_stock', '1' );
	// update_post_meta( $post_id, '_wc_average_rating', '0' );
	// update_post_meta( $post_id, '_wc_review_count', '0' );
	// update_post_meta( $post_id, 'total_sales', '0' );
	// update_post_meta( $post_id, '_regular_price', $price );
	// update_post_meta( $post_id, '_price', $price );

	// define('__log_file__',plugin_dir_path( __FILE__ )."log.txt");
		// $store = false;
		// if($store)
		// {
		// 	file_put_contents(__log_file__,serialize((array)$request));
		// }
		// else
		// {
		// 	$arr = file_get_contents(__log_file__);
		// 	printer((object)unserialize($arr));
		// 	$arr = file_get_contents(__log_file__);
		// 	printer(json_decode($arr, true));
		// }
		// // $dir = scandir(plugin_dir_path( __FILE__ ).'raw/');
		// // printer($dir);
		// die();
		
		//$apiheadertoken = $request->get_header(get_option( 'Paa_options_api_header' ));
		//$status = (empty($apiheadertoken)) ? "false" : stripslashes(htmlspecialchars($apiheadertoken));