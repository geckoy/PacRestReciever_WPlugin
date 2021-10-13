<?php 
if ( ! defined( 'WPINC' ) ) die;

if ( ! current_user_can( 'manage_options' ) && !current_user_can('edit_shop_orders') ) {
    return;
}

global $post;
global $wpdb;
$product = wc_get_product($post->ID); 
$sql_account_data = 'SELECT * FROM paa_account_data WHERE product_id = '.$product->id; 
$sql_account_pokemon = 'SELECT * FROM paa_pokemons WHERE product_id = '.$product->id;
$sql_account_unpw = 'SELECT * FROM paa_accounts WHERE product_id = '.$product->id;

// $sql_account_items = 'SELECT * FROM paa_account_items WHERE product_id = '.$product->id;
// $sql_account_candy = 'SELECT * FROM paa_account_candy WHERE product_id = '.$product->id;
// $sql_account_mega_energy = 'SELECT * FROM paa_account_mega_energy WHERE product_id = '.$product->id;
?>
<?php $account_unpw = $wpdb->get_row($sql_account_unpw, OBJECT); ?>
<div id="account_unpw">
    <h1>Account username & password :</h1>
    <div>
        <h4>Username :&nbsp;</h4><input id="un_data" onfocus="copyClipboard(this)" type="password" name="pokemon_account_data[username]" value="<?= encrypter_dcrypter($account_unpw->username, 'd') ?>" readonly>&nbsp;&nbsp;&nbsp; <input type="button" class="button" onclick="display_data(this)" value="display"> <input type="button" class="button" onclick="allow_edits('username', this)" value="edit">
        <input type="hidden" name="pokemon_account_data[original][username]" value="<?= encrypter_dcrypter($account_unpw->username, 'd') ?>">
    </div>
    <div>
        <h4>Password :&nbsp;</h4><input id="pw_data" onfocus="copyClipboard(this)" type="password" name="pokemon_account_data[password]" value="<?= encrypter_dcrypter($account_unpw->password, 'd') ?>" readonly>&nbsp;&nbsp;&nbsp; <input type="button" class="button" onclick="display_data(this)" value="display"> <input type="button" class="button" onclick="allow_edits('password', this)" value="edit">
        <input type="hidden" name="pokemon_account_data[original][password]" value="<?= encrypter_dcrypter($account_unpw->password, 'd') ?>">
    </div>
</div>

<div id="account-details-wrapper">
    <h1 id="Account-Details-header">Account Details :</h1>
    <input type="text" id="player_data_search" placeholder="search for keyword...">
    <?php
    if($account_data = $wpdb->get_row($sql_account_data, ARRAY_A)) {
    ?>
        <table id="player_data_table" style="text-align: left;">
                <tr>
                        <th>id</th> <td><?php echo $account_data['id'];?></td>
                </tr>
                <tr>
                        <th>product_id</th> <td><?php echo $account_data['product_id'];?></td>
                </tr>
                <tr>
                        <th>level</th> <td><?php echo $account_data['level'];?></td>
                </tr>
                <tr>
                        <th>total Pokemon</th> <td><?php echo $account_data['totalPokemon'];?></td>
                </tr>
                <tr>
                        <th>status</th> <td><?php echo $account_data['status'];?></td>
                </tr>
                <tr>
                        <th>total Items</th> <td><?php echo $account_data['totalItems'];?></td>
                </tr>
                <tr>
                        <th>price</th> <td><?php echo $account_data['price'];?></td>
                </tr>
                <tr>
                        <th>experience</th> <td><?php echo $account_data['experience'];?></td>
                </tr>
                <tr>
                        <th>has Warning</th> <td><?php echo $account_data['hasWarning'];?></td>
                </tr>
                <tr>
                        <th>inGame Username</th> <td><?php echo $account_data['inGameUsername'];?></td>
                </tr>
                <tr>
                        <th>kilometers Walked</th> <td><?php echo $account_data['kilometersWalked'];?></td>
                </tr>
                <tr>
                        <th>max Item Storage</th> <td><?php echo $account_data['maxItemStorage'];?></td>
                </tr>
                <tr>
                        <th>max Pokemon Storage</th> <td><?php echo $account_data['maxPokemonStorage'];?></td>
                </tr>
                <tr>
                        <th>poke Coins</th> <td><?php echo $account_data['pokeCoins'];?></td>
                </tr>
                <tr>
                        <th>pokemon Caught</th> <td><?php echo $account_data['pokemonCaught'];?></td>
                </tr>
                <tr>
                        <th>pokemon Encountered</th> <td><?php echo $account_data['pokemonEncountered'];?></td>
                </tr>
                <tr>
                        <th>pokestops Visited</th> <td><?php echo $account_data['pokestopsVisited'];?></td>
                </tr>
                <tr>
                        <th>remaining Name Changes</th> <td><?php echo $account_data['remainingNameChanges'];?></td>
                </tr>
                <tr>
                        <th>stardust</th> <td><?php echo $account_data['stardust'];?></td>
                </tr>
                <tr>
                        <th>start Date</th> <td><?php echo $account_data['startDate'];?></td>
                </tr>
                <tr>
                        <th>start Timestamp</th> <td><?php echo $account_data['startTimestamp'];?></td>
                </tr>
                <tr>
                        <th>team</th> <td><?php echo $account_data['team'];?></td>
                </tr>
                <tr>
                        <th>was Suspended</th> <td><?php echo $account_data['wasSuspended'];?></td>
                </tr>
        </table>

    <?php } else {
        echo '<p style="clear: both;font-size:19px;">No data Found</p>';
        } ?>
</div>
<div id="Account-Pokemons-wrapper">
    <h1>Account Pokemons:</h1>

        <table id="Account-Pokemons-table" class="display">
            <thead>
                <tr>
                    <th>IDT</th>
                    <th>product_id</th>
                    <th>id</th>
                    <th>name</th>
                    <th>gender</th>
                    <th>formId</th>
                    <th>formName</th>
                    <th>costumeId</th>
                    <th>isShiny</th>
                    <th>isLucky</th>
                    <th>isShadow</th>
                    <th>isPurified</th>
                    <th>isBad</th>
                    <th>isLegendary</th>
                    <th>isMythical</th>
                    <th>individualAttack</th>
                    <th>individualDefense</th>
                    <th>individualStamina</th>
                    <th>ivsPercentage</th>
                    <th>level</th>
                    <th>cp</th>
                    <th>stamina</th>
                    <th>maxStamina</th>
                    <th>move1Id</th>
                    <th>move2Id</th>
                    <th>move3Id</th>
                    <th>move1Name</th>
                    <th>move2Name</th>
                    <th>move3Name</th>
                    <th>height</th>
                    <th>weight</th>
                    <th>creationTimestamp</th>
                    <th>creationDate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($account_pokemon = $wpdb->get_results($sql_account_pokemon, ARRAY_A)) {
                    foreach($account_pokemon as $pokemon){
                    ?> 
                    <tr>
                    <?php 
                     echo   '<td>'.$pokemon["IDT"].'</td><td>'.$pokemon["product_id"].'</td><td>'.$pokemon["id"].'</td><td>'.$pokemon["name"].'</td><td>'.$pokemon["gender"].'</td><td>'.$pokemon["formId"].'</td><td>'.$pokemon["formName"].'</td><td>'.$pokemon["costumeId"].'</td><td>'.$pokemon["isShiny"].'</td><td>'.$pokemon["isLucky"].'</td><td>'.$pokemon["isShadow"].'</td><td>'.$pokemon["isPurified"].'</td><td>'.$pokemon["isBad"].'</td><td>'.$pokemon["isLegendary"].'</td><td>'.$pokemon["isMythical"].'</td><td>'.$pokemon["individualAttack"].'</td><td>'.$pokemon["individualDefense"].'</td><td>'.$pokemon["individualStamina"].'</td><td>'.$pokemon["ivsPercentage"].'</td><td>'.$pokemon["level"].'</td><td>'.$pokemon["cp"].'</td><td>'.$pokemon["stamina"].'</td><td>'.$pokemon["maxStamina"].'</td><td>'.$pokemon["move1Id"].'</td><td>'.$pokemon["move2Id"].'</td><td>'.$pokemon["move3Id"].'</td><td>'.$pokemon["move1Name"].'</td><td>'.$pokemon["move2Name"].'</td><td>'.$pokemon["move3Name"].'</td><td>'.$pokemon["height"].'</td><td>'.$pokemon["weight"].'</td><td>'.$pokemon["creationTimestamp"].'</td><td>'.$pokemon["creationDate"].'</td>';
                    ?>
                    </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
        </table>
</div>

<div id="Account-Items-wrapper">
    <h1 id="account-items-header">Account Items</h1> 
    <input type="text" id="account_items_search" placeholder="search for keyword...">
        <?php if($account_items_json = $account_data['Items']) { 
            $account_items = json_decode($account_items_json, true);
            ?> 
            <table id="account_items_table" style="text-align: left;">
            <?php
            foreach($account_items as $items_key => $item){?>
                <tr>
                <?php 
                    echo '<th>'.$items_key.'- poke item name :'.$item['name'].'</th><td>'.$item['count'].'</td>';
                    ?>
                </tr>
            
            <?php
            }
            ?>
            </table>
            <?php 
            
        }else {
            echo '<p style="clear: both;font-size:19px;">No data Found</p>';
            } ?>

</div>


<div id="Account-candy-wrapper">
    <h1 id="account-candy-header">Account candies</h1> 
    <input type="text" id="account_candy_search" placeholder="search for keyword...">
        <?php if($account_candy_json = $account_data['candy']) { 
            $account_candy = json_decode($account_candy_json, true);
            ?> 
            <table id="account_candy_table" style="text-align: left;">
            <?php
            foreach($account_candy as $candy_key => $candy){?>
                <tr>
                <?php 
                    echo '<th>'.$candy_key.'- poke candy Count :'.$candy['candyCount'].'</th><td>'.$candy['xlCandyCount'].'</td>';
                    ?>
                </tr>
            
            <?php
            }
            ?>
            </table>
            <?php 
            
        }else {
            echo '<p style="clear: both;font-size:19px;">No data Found</p>';
            } ?>

</div>

<div id="Account-mega_energy-wrapper">
    <h1 id="account-mega_energy-header">Account mega energy</h1> 
    <input type="text" id="account_mega_energy_search" placeholder="search for keyword...">
        <?php if($account_mega_energy_json = $account_data['mega_energy']) { 
            $account_mega_energy = json_decode($account_mega_energy_json, true);
            ?> 
            <table id="account_mega_energy_table" style="text-align: left;">
            <?php
            foreach($account_mega_energy as $mega_energy_key => $mega_energy){?>
                <tr>
                <?php 
                    echo '<th>'.$mega_energy_key.'</th><td>'.$mega_energy.'</td>';
                    ?>
                </tr>
            
            <?php
            }
            ?>
            </table>
            <?php 
            
        }else {
            echo '<p style="clear: both;font-size:19px;">No data Found</p>';
            } ?>

</div>










<!-- <table id="table_id" class="display">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
            <td>Row 1 Data 3</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
            <td>Row 2 Data 3</td>
        </tr>
        <tr>
            <td>Firstname</td>
            <td>Lastname</td>
            <td>23</td>
        </tr>
        <tr>
            <td>Jill</td>
            <td>Smith</td>
            <td>40</td>
        </tr>
        <tr>
            <td>Eve</td>
            <td>Jackson</td>
            <td>15</td>
        </tr>
    </tbody>
</table>