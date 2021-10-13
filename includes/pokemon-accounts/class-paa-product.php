<?php 
/**
 * The file that defines the product data Class
 *
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/includes/pokemon-accounts
 */


class Paa_Account 
{
    private $account_id;
    public  $account_data;
    public  $account_pokemons;
    public  $account_items;
    public  $account_candies;
    private  $cache_group;
    private $wpdb;
    public function __construct( array $key = [], int $product_id, string $cache_group = 'default')
    {  
        // Set up the database connection
            global $wpdb;
            $this->wpdb= $wpdb;

        // Assign the account id 
            $this->account_id = $product_id;
            
        // Set up cache group
            $this->cache_group = $cache_group;

        // load database queries 
            $this->loader($key);
    }

    private function loader(array $key)
    {
        if(! empty($key))
        {
            //$pokemons $account_data $items $candies
            $data = [];
            if($key['account_data']['status'] === true  )
            {
                $this->get_account_data($key['account_data']);
            }

            if($key['pokemons']['status'] === true )
            {
                $this->get_account_pokemons($key['pokemons']);
            }

            // if($key['items']['status'] === true )
            // {
            //     $this->get_account_items($key['items']);
            // }
            // if($key['candies']['status'] === true )
            // {
            //     $this->get_account_candies($key['candies']);
            // }           
        }
    }

    private function get_account_data(array $key) 
    {
        $this->account_data = $this->wpdb->get_row('SELECT * FROM paa_account_data WHERE product_id ='.$this->account_id. ';', OBJECT);
        $this->account_items = json_decode( $this->account_data->Items, true );
        $this->account_candies = json_decode( $this->account_data->candy, true );
    }
   
    private function get_account_pokemons(array $key)
    {   
        $limit= (!empty($key["limit"]))    ? ' LIMIT '.$key["limit"] : '';
        $order = (!empty($key["orderby"]))  ? ' ORDER BY '.$key["orderby"] :'';
        $custom_name = (!empty($key["custom_name"])) ? $key["custom_name"] : "%%";
        $custom_cp = (!empty($key["custom_cp"])) ? $key["custom_cp"] : "%%";
        $custom_attack_one = (!empty($key["custom_attack_one"])) ? $key["custom_attack_one"] : "%%";
        $custom_attack_two = (!empty($key["custom_attack_two"])) ? $key["custom_attack_two"] : "%%";

        $this->account_pokemons = $this->wpdb->get_results($this->wpdb->prepare('SELECT id, name, ivsPercentage, cp, move1Name, move2Name, creationTimestamp, isShiny FROM paa_pokemons WHERE product_id ='.$this->account_id.' AND name LIKE %s AND cp LIKE %s AND move1Name LIKE %s AND move2Name LIKE %s'.$order.$limit.';', $custom_name,$custom_cp,$custom_attack_one,$custom_attack_two), OBJECT);
    }

   
}



// private function get_account_items(array $key)
// {
//     $this->account_items = $this->wpdb->get_row('SELECT Items FROM paa_account_items WHERE product_id ='.$this->account_id. ';', OBJECT);
// }

// private function get_account_candies(array $key)
// {
//     $this->account_candies = $this->wpdb->get_row('SELECT candy FROM paa_account_candy WHERE product_id ='.$this->account_id. ';', OBJECT);
// }