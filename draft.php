<?php 
if ( ! defined( 'WPINC' ) ) die;
// Pokemon items
$PokeBall = 0;
				$GreatBall = 0;
				$UltraBall = 0;
				$MasterBall = 0;
				$PremierBall = 0;
				$Stardust = 0;
				$MegaEnergy = 0;
				$Potion = 0;
				$SuperPotion = 0;
				$HyperPotion = 0;
				$MaxPotion = 0;
				$Revive = 0;
				$MaxRevive = 0;
				$LuckyEgg = 0;
				$Incense = 0;
				$IncenseSpicy = 0;
				$IncenseCool = 0;
				$IncenseFloral = 0;
				$MysteryBox = 0;
				$LureModule = 0;
				$GlacialLureModule = 0;
				$MossyLureModule = 0;
				$MagneticLureModule = 0;
				$XAttack = 0;
				$XDefense = 0;
				$XMiracle = 0;
				$RazzBerry = 0;
				$BlukBerry = 0;
				$NanabBerry = 0;
				$WeparBerry = 0;
				$PinapBerry = 0;
				$GoldenRazzBerry = 0;
				$GoldenPinapBerry = 0;
				$SilverPinapBerry = 0;
				$Poffin = 0;
				$Camera = 0;
				$Sticker = 0;
				$UnlimitedIncubator = 0;
				$EggIncubator = 0;
				$SuperIncubator = 0;
				$PokémonStorageUpgrade = 0;
				$ItemStorageUpgrade = 0;
				$SunStone = 0;
				$MetalCoat = 0;
				$DragonScale = 0;
				$UpGrade = 0;
				$SinnohStone = 0;
				$UnovaStone = 0;
				$FastTM = 0;
				$ChargedTM = 0;
				$EliteFastTM = 0;
				$EliteChargedTM = 0;
				$RareCandy = 0;
				$XLRareCandy = 0;
				$FreeRaidPass = 0;
				$PremiumRaidPass = 0;
				$EXRaidPass = 0;
				$StarPiece = 0;
				$Gift = 0;
				$TeamMedallion = 0;
				$RemoteRaidPass = 0;
				$MysteriousComponent = 0;
				$LeaderMap = 0;
				$GiovanniMap = 0;
				$GlobalEventTicket = 0;
				$PinkEventTicket = 0;
				$GrayEventTicket = 0;
				// //////////////////////////////////////////////////////
				  foreach ($items as $item) {
					switch ($item['name']) {
						case 'Poké Ball':
						$PokeBall = $item['count'];
						break;

						case 'Great Ball':
						$GreatBall = $item['count'];
						break;

						case 'Ultra Ball':
						$UltraBall = $item['count'];
						break;
						
						case 'Master Ball':
						$MasterBall = $item['count'];
						break;

						case 'Premier Ball':
						$PremierBall = $item['count'];
						break;

						case 'Stardust':
						  $Stardust = $item['count'];
						break;

						case 'Mega Energy':
						$MegaEnergy = $item['count'];
						break;

						case 'Potion':
						$Potion = $item['count'];
						break;
						
						case 'Super Potion':
						$SuperPotion = $item['count'];
						break;

						case 'Hyper Potion':
						$HyperPotion = $item['count'];
						break;

						case 'Max Potion':
						$MaxPotion = $item['count'];
						break;

						case 'Revive':
						$Revive = $item['count'];
						break;

						case 'Max Revive':
						$MaxRevive = $item['count'];
						break;
						
						case 'Lucky Egg':
						$LuckyEgg = $item['count'];
						break;

						case 'Incense':
						$Incense = $item['count'];
						break;

						case 'Incense Spicy':
						$IncenseSpicy = $item['count'];
						break;

						case 'Incense Cool':
						$IncenseCool = $item['count'];
						break;

						case 'Incense Floral':
						$IncenseFloral = $item['count'];
						break;
						
						case 'Mystery Box':
						$MysteryBox = $item['count'];
						break;

						case 'Lure Module':
						$LureModule = $item['count'];
						break;

						case 'Glacial Lure Module':
						$GlacialLureModule = $item['count'];
						break;

						case 'Mossy Lure Module':
						$MossyLureModule = $item['count'];
						break;

						case 'Magnetic Lure Module':
						$MagneticLureModule = $item['count'];
						break;
						
						case 'X Attack':
						$XAttack = $item['count'];
						break;

						case 'X Defense':
						$XDefense = $item['count'];
						break;

						case 'X Miracle':
						$XMiracle = $item['count'];
						break;

						case 'Razz Berry':
						$RazzBerry = $item['count'];
						break;

						case 'Bluk Berry':
						$BlukBerry = $item['count'];
						break;
						
						case 'Nanab Berry':
						$NanabBerry = $item['count'];
						break;

						case 'Wepar Berry':
						$WeparBerry = $item['count'];
						break;

						case 'Pinap Berry':
						$PinapBerry = $item['count'];
						break;

						case 'Golden Razz Berry':
						$GoldenRazzBerry = $item['count'];
						break;

						case 'Golden Pinap Berry':
						$GoldenPinapBerry = $item['count'];
						break;
						
						case 'Silver Pinap Berry':
						$SilverPinapBerry = $item['count'];
						break;

						case 'Poffin':
						$Poffin = $item['count'];
						break;

						case 'Camera':
						$Camera = $item['count'];
						break;

						case 'Sticker':
						$Sticker = $item['count'];
						break;

						case 'Unlimited Incubator':
						$UnlimitedIncubator = $item['count'];
						break;
						
						case 'Egg Incubator':
						$EggIncubator = $item['count'];
						break;

						case 'Super Incubator':
						$SuperIncubator = $item['count'];
						break;

						case 'Pokémon Storage Upgrade':
						$PokémonStorageUpgrade = $item['count'];
						break;

						case 'Item Storage Upgrade':
						$ItemStorageUpgrade = $item['count'];
						break;

						case 'Sun Stone':
						$SunStone = $item['count'];
						break;
						
						case 'Metal Coat':
						$MetalCoat = $item['count'];
						break;

						case 'Dragon Scale':
						$DragonScale = $item['count'];
						break;

						case 'Up-Grade':
						$UpGrade = $item['count'];
						break;

						case 'Sinnoh Stone':
						$SinnohStone = $item['count'];
						break;
						
						case 'Unova Stone':
						$UnovaStone = $item['count'];
						break;

						case 'Fast TM':
						$FastTM = $item['count'];
						break;

						case 'Charged TM':
						$ChargedTM = $item['count'];
						break;

						case 'Elite Fast TM':
						$EliteFastTM = $item['count'];
						break;

						case 'Elite Charged TM':
						$EliteChargedTM = $item['count'];
						break;
						
						case 'Rare Candy':
						$RareCandy = $item['count'];
						break;

						case 'XL Rare Candy':
						$XLRareCandy = $item['count'];
						break;

						case 'Free Raid Pass':
						$FreeRaidPass = $item['count'];
						break;

						case 'Premium Raid Pass':
						$PremiumRaidPass = $item['count'];
						break;

						case 'EX Raid Pass':
						$EXRaidPass = $item['count'];
						break;
						
						case 'Star Piece':
						$StarPiece = $item['count'];
						break;

						case 'Gift':
						$Gift = $item['count'];
						break;

						case 'Team Medallion':
						$TeamMedallion = $item['count'];
						break;

						case 'Remote Raid Pass':
						$RemoteRaidPass = $item['count'];
						break;

						case 'Mysterious Component':
						$MysteriousComponent = $item['count'];
						break;
						
						case 'Leader Map':
						$LeaderMap = $item['count'];
						break;

						case 'Giovanni Map':
						$GiovanniMap = $item['count'];
						break;

						case 'Global Event Ticket':
						$GlobalEventTicket = $item['count'];
						break;

						case 'Pink Event Ticket':
						$PinkEventTicket = $item['count'];
						break;

						case 'Gray Event Ticket':
						$GrayEventTicket = $item['count'];
						break;
	  
					  }

                }
                $wpdb->query(
					$wpdb->prepare(
					"
					INSERT INTO account_items
					( product_id , PokeBall, GreatBall, UltraBall, MasterBall, PremierBall, Stardust, MegaEnergy, Potion, SuperPotion, HyperPotion, MaxPotion, Revive, MaxRevive, LuckyEgg, Incense, IncenseSpicy, IncenseCool, IncenseFloral, MysteryBox, LureModule, GlacialLureModule, MossyLureModule, MagneticLureModule, XAttack, XDefense, XMiracle, RazzBerry, BlukBerry, NanabBerry, WeparBerry, PinapBerry, GoldenRazzBerry, GoldenPinapBerry, SilverPinapBerry, Poffin, Camera, Sticker, UnlimitedIncubator, EggIncubator, SuperIncubator, PokémonStorageUpgrade, ItemStorageUpgrade, SunStone, MetalCoat, DragonScale, UpGrade, SinnohStone, UnovaStone, FastTM, ChargedTM, EliteFastTM, EliteChargedTM, RareCandy, XLRareCandy, FreeRaidPass, PremiumRaidPass, EXRaidPass, StarPiece, Gift, TeamMedallion, RemoteRaidPass, MysteriousComponent, LeaderMap, GiovanniMap, GlobalEventTicket, PinkEventTicket, GrayEventTicket )
					VALUES ( %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d )
					",
					$post_id,
					$PokeBall,
					$GreatBall,
					$UltraBall,
					$MasterBall,
					$PremierBall,
					$Stardust,
					$MegaEnergy,
					$Potion,
					$SuperPotion,
					$HyperPotion,
					$MaxPotion,
					$Revive,
					$MaxRevive,
					$LuckyEgg,
					$Incense,
					$IncenseSpicy,
					$IncenseCool,
					$IncenseFloral,
					$MysteryBox,
					$LureModule,
					$GlacialLureModule,
					$MossyLureModule,
					$MagneticLureModule,
					$XAttack,
					$XDefense,
					$XMiracle,
					$RazzBerry,
					$BlukBerry,
					$NanabBerry,
					$WeparBerry,
					$PinapBerry,
					$GoldenRazzBerry,
					$GoldenPinapBerry,
					$SilverPinapBerry,
					$Poffin,
					$Camera,
					$Sticker,
					$UnlimitedIncubator,
					$EggIncubator,
					$SuperIncubator,
					$PokémonStorageUpgrade,
					$ItemStorageUpgrade,
					$SunStone,
					$MetalCoat,
					$DragonScale,
					$UpGrade,
					$SinnohStone,
					$UnovaStone,
					$FastTM,
					$ChargedTM,
					$EliteFastTM,
					$EliteChargedTM,
					$RareCandy,
					$XLRareCandy,
					$FreeRaidPass,
					$PremiumRaidPass,
					$EXRaidPass,
					$StarPiece,
					$Gift,
					$TeamMedallion,
					$RemoteRaidPass,
					$MysteriousComponent,
					$LeaderMap,
					$GiovanniMap,
					$GlobalEventTicket,
					$PinkEventTicket,
					$GrayEventTicket
					)
					);

	/* private final int id;
    private final int gender;
    private final int formId;
    private final int costumeId;
    private final boolean isShiny;
    private final boolean isLucky;
    private final boolean isPurified;
    private final boolean isShadow;
    private final boolean isBad;
    private final int individualAttack;
    private final int individualDefense;
    private final int individualStamina;
    private final float ivsPercentage;
    private final int level;
    private final int cp;
    private final int stamina;
    private final int maxStamina;
    private final int move1Id;
    private final int move2Id;
    private final int move3Id;
    private final float height;
    private final float weight;
    private final long creationTimestamp;
	private final String creationDate; */
	
		/* %d, $post_id,
		%d, $pokemon['id'],
		%s, $pokemon['name'],
		%d, $pokemon['gender'],
		%d, $pokemon['formId'],
		%s, $pokemon['formName'],
		%d, $pokemon['costumeId'],
		%d, $pokemon['isShiny'],
		%d, $pokemon['isLucky'],
		%d, $pokemon['isShadow'],
		%d, $pokemon['isPurified'],
		%d, $pokemon['isBad'],
		%d, $pokemon['isLegendary'],
		%d, $pokemon['isMythical'],
		%d, $pokemon['individualAttack'],
		%d, $pokemon['individualDefense'],
		%d, $pokemon['individualStamina'],
		%f, $pokemon['ivsPercentage'],
		%d, $pokemon['level'],
		%d, $pokemon['cp'],
		%d, $pokemon['stamina'],
		%d, $pokemon['maxStamina'],
		%d, $pokemon['move1Id'],
		%d, $pokemon['move2Id'],
		%d, $pokemon['move3Id'],
		%s, $pokemon['move1Name'],
		%s, $pokemon['move2Name'],
		%s, $pokemon['move3Name'],
		%f, $pokemon['height'],
		%f, $pokemon['weight'],
		%d, $pokemon['totalCandy'],
		%d, $pokemon['creationTimestamp'],
		%s $pokemon['creationDate'] */
	



		/*
				    // //////////////////////////////////////////////////////
				update_post_meta( $post_id,'_pokemon_account_status',$jsonpoke['status']);
				
					// //////////////////////////////////////////////////////
				update_post_meta( $post_id,'_total_pokemon',$jsonpoke['totalPokemon']);
					// //////////////////////////////////////////////////////
				update_post_meta( $post_id,'_totalItems',$totalItems);
					// //////////////////////////////////////////////////////
				update_post_meta( $post_id,'_inGameUsername',$playerData['inGameUsername']);
				update_post_meta( $post_id,'_remainingNameChanges',$playerData['remainingNameChanges']);
				
				$accountteam = $playerData['team'];
				switch($accountteam){
					case 0:
					$accountteam = 'no team';
					break;
					case 1:
					$accountteam = 'mystic';	
					break;
					case 2:
					$accountteam = 'valor';
					break;
					case 3:
					$accountteam = 'instinct';
					break;
				}
			
				update_post_meta( $post_id,'_team',$accountteam);
				update_post_meta( $post_id,'_experience',$playerData['experience']);
				update_post_meta( $post_id,'_distanceWalked',$playerData['distanceWalked']);
				update_post_meta( $post_id,'_pokeCoins',$playerData['pokeCoins']);
				update_post_meta( $post_id,'_stardust',$playerData['stardust']);
				update_post_meta( $post_id,'_maxPokemonStorage',$playerData['maxPokemonStorage']);
				update_post_meta( $post_id,'_maxItemStorage',$playerData['maxItemStorage']);
				update_post_meta( $post_id,'_pokemonSeen',$playerData['pokemonSeen']);
				update_post_meta( $post_id,'_pokemonCaught',$playerData['pokemonCaught']);
				update_post_meta( $post_id,'_pokestopsVisited',$playerData['pokestopsVisited']);
				update_post_meta( $post_id,'_wasSuspended',$playerData['wasSuspended']);
				update_post_meta( $post_id,'_hasWarning',$playerData['hasWarning']);
				update_post_meta( $post_id,'_startTimestamp',$playerData['startTimestamp']);
				update_post_meta( $post_id,'_startDate',$playerData['startDate']);
					 // //////////////////////////////////////////////////////
				update_post_meta( $post_id, '_product_attributes', array(array(
				'name' => 'stardust', // set attribute name
				'value' => $playerData['stardust'], // set attribute value
				'position' => 1,
				'is_visible' => 1,
				'is_variation' => 0,
				'is_taxonomy' => 0 ),
				array(
					'name' => 'level', // set attribute name
					'value' => $pokeaccountlevel, // set attribute value
					'position' => 1,
					'is_visible' => 1,
					'is_variation' => 0,
					'is_taxonomy' => 0 ))); */

					$plaintext = "message to be encrypted";
					$cipher = "aes-128-gcm";
					if (in_array($cipher, openssl_get_cipher_methods()))
					{
						$ivlen = openssl_cipher_iv_length($cipher);
						$iv = openssl_random_pseudo_bytes($ivlen);
						$randombyteskeyssl = bin2hex(random_bytes(32));
						$randombytessecrectkeyssl = bin2hex(random_bytes(32));
						$key = hash_hmac ( 'sha256' , $randombyteskeyssl , $randombytessecrectkeyssl );
						
						
						
						$ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
						//store $cipher, $iv, and $tag for decryption later
						
						$original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
						echo $original_plaintext."\n";
					}



 /* %d,%d,%d,%s,%d, %d,%d,%s,%d,%d,%d,%d,%d,%d,%d,%d,%d,%s,%d,%d,%d

 product_id, level, totalPokemon, status, totalItems, experience, hasWarning, inGameUsername, kilometersWalked, maxItemStorage, maxPokemonStorage, pokeCoins, pokemonCaught, pokemonEncountered, pokestopsVisited, remainingNameChanges, stardust, startDate, startTimestamp, team, wasSuspended */
 /* Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'oWWUy2Uc]s({lXJ8+oty;E]lh9~0]N[!U5-OI-9qj:_cflmug{quCa%N:VCX3a%5');
define('SECURE_AUTH_KEY',  'W@$99_H*gfr(]ZIZ9ITRQg.k.Pp5]#!V2)m4@[lY@Cc78rfTW.~02=#oV=:#TNSW');
define('LOGGED_IN_KEY',    'mp6d!Yg6Kon-5l;iVWSjE:vH**y#*]+foBA?k[Lg{zri3i8ert{ES>8?u@~f<30i');
define('NONCE_KEY',        'AYwZB(SiEjJOW)$B+UcjS57_<=||B-gLVrwGco#X!yZr=|D$Dg~mc5iJ?f[3OnN,');
define('AUTH_SALT',        'V2%MiwE4NUKz2YxEW!BMrz|tj~G0#L[QRms98<}$f^)~*E^h@tGdn@9VT#WTDyGf');
define('SECURE_AUTH_SALT', 'tzq3;Dfgd_URbO9G*sn,tBrKEgwBR#0(.aD(QLkvXmhwcGm).pq*UM4+dYLM|vcg');
define('LOGGED_IN_SALT',   'PO5(%EI5lpYA0-yTJ5I3L4g[]dhRFr)Nx:*-F^bYGE3$yo9>I+(H,?ZLZ7;{JR7(');
define('NONCE_SALT',       'Uoo(3wm+:xy[A^wX7Pm>LooQTb|qtI$XAQ}x>28_Bvx<HbtbWqP.PlU!_j*ofdES');




function woocommerce_content() { 
 
  
 
        if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?> 
 
            <h1 class="page-title"><?php woocommerce_page_title(); ?></h1> 
 
        <?php endif; ?> 
 
        <?php do_action( 'woocommerce_archive_description' ); ?> 
 
        <?php if ( have_posts() ) : ?> 
 
            <?php do_action( 'woocommerce_before_shop_loop' ); ?> 
 
            <?php woocommerce_product_loop_start(); ?> 
 
                <?php woocommerce_product_subcategories(); ?> 
 
                <?php while ( have_posts() ) : the_post(); ?> 
 
                    <?php wc_get_template_part( 'content', 'product' ); ?> 
 
                <?php endwhile; // end of the loop. ?> 
 
            <?php woocommerce_product_loop_end(); ?> 
 
            <?php do_action( 'woocommerce_after_shop_loop' ); ?> 
 
        <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?> 
 
            <?php do_action( 'woocommerce_no_products_found' ); ?> 
 
        <?php endif; 
 
   
} 



function woocommerce_product_subcategories( $args = array() ) { 
    
} 
