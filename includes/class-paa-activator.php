<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Paa
 * @subpackage Paa/includes
 * @author     Younes Arab nedjadi <younesheissenmann@gmail.com>
 */
class Paa_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	 global $wpdb;
	 // CREATE TABLES 
	 $wpdb->query("CREATE TABLE `paa_accounts` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL UNIQUE, `username` VARCHAR(255) NOT NULL UNIQUE, `password` VARCHAR(255) NOT NULL, `sold` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	
	 $wpdb->query("CREATE TABLE `paa_pokemons` ( `IDT` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `id` INT NOT NULL , `name` TEXT NOT NULL , `gender` INT NOT NULL , `formId` INT NOT NULL , `formName` TEXT NOT NULL , `costumeId` INT NOT NULL , `isShiny` BOOLEAN NOT NULL , `isLucky` BOOLEAN NOT NULL , `isShadow` BOOLEAN NOT NULL , `isPurified` BOOLEAN NOT NULL , `isBad` BOOLEAN NOT NULL , `isLegendary` BOOLEAN NOT NULL , `isMythical` BOOLEAN NOT NULL , `individualAttack` INT NOT NULL , `individualDefense` INT NOT NULL , `individualStamina` INT NOT NULL , `ivsPercentage` FLOAT NOT NULL , `level` INT NOT NULL , `cp` INT NOT NULL , `stamina` INT NOT NULL , `maxStamina` INT NOT NULL , `move1Id` INT NOT NULL , `move2Id` INT NOT NULL , `move3Id` INT NOT NULL , `move1Name` TEXT NOT NULL , `move2Name` TEXT NOT NULL , `move3Name` TEXT NOT NULL , `height` FLOAT NOT NULL , `weight` FLOAT NOT NULL , `creationTimestamp` BIGINT(30) NOT NULL , `creationDate` TEXT NOT NULL , PRIMARY KEY (`IDT`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_pokemons_solded` ( `IDT` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `id` INT NOT NULL , `name` TEXT NOT NULL , `gender` INT NOT NULL , `formId` INT NOT NULL , `formName` TEXT NOT NULL , `costumeId` INT NOT NULL , `isShiny` BOOLEAN NOT NULL , `isLucky` BOOLEAN NOT NULL , `isShadow` BOOLEAN NOT NULL , `isPurified` BOOLEAN NOT NULL , `isBad` BOOLEAN NOT NULL , `isLegendary` BOOLEAN NOT NULL , `isMythical` BOOLEAN NOT NULL , `individualAttack` INT NOT NULL , `individualDefense` INT NOT NULL , `individualStamina` INT NOT NULL , `ivsPercentage` FLOAT NOT NULL , `level` INT NOT NULL , `cp` INT NOT NULL , `stamina` INT NOT NULL , `maxStamina` INT NOT NULL , `move1Id` INT NOT NULL , `move2Id` INT NOT NULL , `move3Id` INT NOT NULL , `move1Name` TEXT NOT NULL , `move2Name` TEXT NOT NULL , `move3Name` TEXT NOT NULL , `height` FLOAT NOT NULL , `weight` FLOAT NOT NULL , `creationTimestamp` BIGINT(30) NOT NULL , `creationDate` TEXT NOT NULL , PRIMARY KEY (`IDT`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_pokemons_filtered` ( `IDT` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `id` INT NOT NULL , `name` TEXT NOT NULL , `gender` INT NOT NULL , `formId` INT NOT NULL , `formName` TEXT NOT NULL , `costumeId` INT NOT NULL , `isShiny` BOOLEAN NOT NULL , `isLucky` BOOLEAN NOT NULL , `isShadow` BOOLEAN NOT NULL , `isPurified` BOOLEAN NOT NULL , `isBad` BOOLEAN NOT NULL , `isLegendary` BOOLEAN NOT NULL , `isMythical` BOOLEAN NOT NULL , `individualAttack` INT NOT NULL , `individualDefense` INT NOT NULL , `individualStamina` INT NOT NULL , `ivsPercentage` FLOAT NOT NULL , `level` INT NOT NULL , `cp` INT NOT NULL , `stamina` INT NOT NULL , `maxStamina` INT NOT NULL , `move1Id` INT NOT NULL , `move2Id` INT NOT NULL , `move3Id` INT NOT NULL , `move1Name` TEXT NOT NULL , `move2Name` TEXT NOT NULL , `move3Name` TEXT NOT NULL , `height` FLOAT NOT NULL , `weight` FLOAT NOT NULL , `creationTimestamp` BIGINT(30) NOT NULL , `creationDate` TEXT NOT NULL , PRIMARY KEY (`IDT`)) ENGINE = InnoDB;");

	 $wpdb->query("CREATE TABLE `paa_account_data` ( `id` BIGINT NOT NULL AUTO_INCREMENT, `product_id` BIGINT NOT NULL , `level` INT NOT NULL , `totalPokemon` INT NOT NULL , `shinycount` INT NOT NULL, `status` TEXT NOT NULL , `totalItems` INT NOT NULL , `price` DECIMAL(19,4) NOT NULL, `experience` INT NOT NULL , `hasWarning` BOOLEAN NOT NULL , `inGameUsername` TEXT NOT NULL , `kilometersWalked` FLOAT NOT NULL , `maxItemStorage` INT NOT NULL , `maxPokemonStorage` INT NOT NULL , `pokeCoins` INT NOT NULL , `pokemonCaught` INT NOT NULL , `pokemonEncountered` INT NOT NULL , `pokestopsVisited` INT NOT NULL , `remainingNameChanges` INT NOT NULL , `stardust` INT NOT NULL , `startDate` TEXT NOT NULL , `startTimestamp` BIGINT NOT NULL , `team` INT NOT NULL , `wasSuspended` BOOLEAN NOT NULL, `Items` TEXT NOT NULL, `candy` TEXT NOT NULL, `mega_energy` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_account_data_solded` ( `id` BIGINT NOT NULL AUTO_INCREMENT, `product_id` BIGINT NOT NULL , `level` INT NOT NULL , `totalPokemon` INT NOT NULL , `shinycount` INT NOT NULL, `status` TEXT NOT NULL , `totalItems` INT NOT NULL , `price` DECIMAL(19,4) NOT NULL, `experience` INT NOT NULL , `hasWarning` BOOLEAN NOT NULL , `inGameUsername` TEXT NOT NULL , `kilometersWalked` FLOAT NOT NULL , `maxItemStorage` INT NOT NULL , `maxPokemonStorage` INT NOT NULL , `pokeCoins` INT NOT NULL , `pokemonCaught` INT NOT NULL , `pokemonEncountered` INT NOT NULL , `pokestopsVisited` INT NOT NULL , `remainingNameChanges` INT NOT NULL , `stardust` INT NOT NULL , `startDate` TEXT NOT NULL , `startTimestamp` BIGINT NOT NULL , `team` INT NOT NULL , `wasSuspended` BOOLEAN NOT NULL, `Items` TEXT NOT NULL, `candy` TEXT NOT NULL, `mega_energy` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 
	 $wpdb->query("CREATE TABLE `paa_account_duplicates` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `account` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_account_unpriceable` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `account` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_against_sold_list` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL UNIQUE, `password` VARCHAR(255) NOT NULL, `buyer` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 $wpdb->query("CREATE TABLE `paa_against_sold_list_found` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `asl_id` BIGINT NOT NULL UNIQUE, `account` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	
	
	
	//  $wpdb->query("CREATE TABLE `paa_account_items` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `Items` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	//  $wpdb->query("CREATE TABLE `paa_account_candy` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `candy` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	//  $wpdb->query("CREATE TABLE `paa_account_mega_energy` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `product_id` BIGINT NOT NULL , `mega_energy` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
	 
	 /* if(!get_option()) {
		} */
	 // Clear the permalinks	
	 flush_rewrite_rules();
	}
	 
	
}
