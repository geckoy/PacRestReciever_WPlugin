<?php 
if ( ! defined( 'WPINC' ) ) die;

///////////////////////////////////////////////////////////////////////
///////////////////////// Global Helpers //////////////////////////////
///////////////////////////////////////////////////////////////////////
   /**
    * check if file works 
    */
    function tester()
    {
      return 'have good day sir!';
    }
   /**
    * Check if argument is number
    */
      function validate_num($value) 
      {
            return is_numeric($value);
      }

   /**
    * Check if argument is not a name
    */
      function validate_name($value)
      {
         return	preg_match('/[^A-Za-z ]/i',$value);
      }

   /**
    * Print_r argument data in more readble way
    */
      function printer($data)
      {
         echo '<pre style="color:black; font-size:30px;">';
         print_r($data);
         echo '<pre>';
      }

   /**
    * Print_r argument data in more header way
    */
   function printer_h($data)
	{
		echo '<h1 style="font-size:200px;">'.$data.'</h1>';
	}

   /**
    * parse input with comma
    */

   
    
/////////////////////////////////////////////////////////////////////////
////////////////////////// Core functions ///////////////////////////////
/////////////////////////////////////////////////////////////////////////

   /**
    * Account username and password Encrypter - Dcrypter 
    *    use in : 
    *             - plugin\enpoint\class-paa-endpoint.php
    *             -   
    */
      function encrypter_dcrypter($stringToHandle = "", $encryptDecrypt = 'e')
      {
         // Set default output value
         // $output = null;
         // Set secret keys
         $secret_key = __SECRET_KEY__; // Change this!
         $secret_iv = __SECRET_IV__; // Change this!
         $key = hash('sha256',$secret_key);
         $iv = substr(hash('sha256',$secret_iv),0,16);
         // Check whether encryption or decryption
         if($encryptDecrypt == 'e'){
            // We are encrypting
            $stringToHandle = base64_encode(openssl_encrypt($stringToHandle,"AES-256-CBC",$key,0,$iv));
         }else if($encryptDecrypt == 'd'){
            // We are decrypting
            $stringToHandle = openssl_decrypt(base64_decode($stringToHandle),"AES-256-CBC",$key,0,$iv);
         }
         // Return the final value
         return $stringToHandle;
      }
   /**
    * Check UN:PW for the download 
    */
      function confirm_auth_http($input)
      {
         if($input === __HTTP_Username__ || $input === __HTTP_Password__ )
         {
            return false;
         }else
         {
            return true;
         }
      }

   /**
    *  Get category based on the slug => id 
    *    use in :
    *       -
    */
      function categories_id(string $cat_slug)
      {
         $product_terms_reverse = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'fields'=>'id=>slug',
         ) );
         
         $product_terms_filter = array();
         foreach($product_terms_reverse as $product_terms_key=>$product_terms_value){
            $product_terms_filter[$product_terms_value] =$product_terms_key;
         }
         return $product_terms_filter[$cat_slug];
      }
      /**
       * retrive all product categories slug=>id 
       */
         function product_categories()
         {
            $product_terms_reverse = get_terms( array(
               'taxonomy' => 'product_cat',
               'hide_empty' => false,
               'fields'=>'id=>slug',
            ) );
            
            $product_terms_filter = array();
            foreach($product_terms_reverse as $product_terms_key=>$product_terms_value){
               $product_terms_filter[$product_terms_value] =$product_terms_key;
            }
      
            return $product_terms_filter;
         }
   /**
    * Send mails with woocommerce template
    *    use in :  
    *          -  plugin\includes\functions.php
    */
      function Mailer($recipient, $subject, $content, $attachment = array())
      {
         /* global $woocommerce; */
         $mail = new WC_Emails();
         $email_heading = get_bloginfo('name');
         ob_start();
         $mail->email_header($email_heading);
         $message = ob_get_clean();
         $message .= $content;
         ob_start();
         $mail->email_footer();
         $message .= ob_get_clean();
         return $mail->send($recipient, $subject, $message, "Content-Type: text/html\r\n", $attachment);
      }
   /**
    * Send Accounts username and password to its owner
    *        use in :
    *                -  theme\template-parts\Customer-send-accounts.php
    */
      function send_account_to_customer(int $order_id, bool $return = false)
      {	
         global $wpdb;
         $order = wc_get_order($order_id);
         if(! $order) return; 
         //$order->get_status();
      
         if( $order->is_paid() )
         {
            $subject = "Pokemon Accounts - ".get_bloginfo('name');
            $Customer =[
               'mail' => $order->get_billing_email(),
               'payment-method' =>$order->get_payment_method()
            ];
            $header_message = "<h1>Accounts Bought, Have fun!:</h1>";
            $body_message = "";
            $body_message = "<p>Dear customer in table below contain your accounts usernames and passwords</p>";
            $body_message .= "<table><tr><th>Username</th><th>Password</th></tr>";
            foreach( $order->get_items() as $item_id => $item )
            {
            //Get the WC_Product object
            $product = $item->get_product();
            $product_id = $product->get_id();

            set_product_to_sold_status($product_id);

            $product_accounts = $wpdb->get_row('SELECT * FROM paa_accounts WHERE product_id ='.$product_id. ';', OBJECT);
            $account_username = encrypter_dcrypter($product_accounts->username,'d');
            $account_password = encrypter_dcrypter($product_accounts->password,'d');
            
            $body_message .=  "<tr><td style='border-right:solid black 1px'> $account_username </td><td> $account_password </td></tr>";
            }
            $body_message .= "</table>";
            $body_message .= "<br />";
            $body_message .= "<p><h1>Congratulations 'Must read this NOTE !!'</h1> This next bit is your responsibility! Change the email && password!!
            CHANGE THE PASSWORD NOW
            Due to some bad apples...the 24/7 on tap email change process had to  be restricted.
            You will have to reach out to chat to facilitate an email change...super easy..
            
            Check Us out 
            <a href='https://www.facebook.com/groups/shinymadness' target='_blank'>ShinyMadness - Facebook</a>
            
            There is a Page  && a  Group Chat as well!!</p>";
            $footer_message = "<p>Thank you for visiting our store ".get_bloginfo('name');
            //$mail_status = wp_mail( $Customer['mail'], 'Accounts', $body_message);
            $mail_status =  Mailer($Customer['mail'], $subject, $body_message);
            if($return)
            {
               if($mail_status) {
                  echo  'sent';
               }else{
                  echo 'not sent';
               }
               die;
            }
         }else{
            header('HTTP/1.1 500 Payment Needed');
            die();
         }
      }


   /**
    * Set Accounts username and password status to sold 
    */
      function set_product_to_sold_status(int $product_id)
      {  
         global $wpdb;
         $wpdb->update( "paa_accounts", ["sold"=>1], ["product_id" => $product_id], ["%d"], ["%d"] );
      }

      function redo_set_product_to_sold_status(int $product_id)
      {
         global $wpdb;
         $wpdb->update( "paa_accounts", ["sold"=>0], ["product_id" => $product_id], ["%d"], ["%d"] );
      }
   /**
    * Retrive Account data
    */
      function account_data_retriever( array $key = [], int $product_id, string $cache_group)
      {
         $cache_id = $cache_group.'_'.$product_id;
            if(! empty($key))
            {                  
               require_once plugin_dir_path( dirname( __FILE__ ) ) .'includes/pokemon-accounts/class-paa-product.php';
               if($cache_group === "no-caching")
               {
                  $account_information = new Paa_Account($key, $product_id, $cache_group);
                  return $account_information;
               }else
               {
                  $cached_account_information = get_transient( $cache_id );
                  if( $cached_account_information === false )
                  {
                     $account_information = new Paa_Account($key, $product_id, $cache_group);
                     set_transient( $cache_id, $account_information, 12 * HOUR_IN_SECONDS );
                     return $account_information;

                  }else
                  {
                     return $cached_account_information;
                  }
               }
            }else
            {
               return 'Internal error';
            }
      }


