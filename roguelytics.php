<?php
   /*
   Plugin Name: Roguelytics
   Plugin URI: http://roguelytics.com
   Description: The Only TRUE On-Page Analytics Platform - The plugin lives in settings.
   Version: 1.0
   Author: Rogue Studios
   Author URI: http://roguestudios.io
   */
?>
<?php
   if(! defined('ABSPATH')) exit;

   function roguelytics_plugin_menu() {
      add_options_page( 'Roguelytics', 'Roguelytics', 'administrator', 'roguelytics', 'roguelytics_plugin_options' );
   }

   function roguelytics_plugin_options() {
      global $wpdb;
      if(!current_user_can('administrator')){
         wp_die( __( 'You do not have sufficient permissions to access this page.' ));
      }else{
         global $roguelytics_site;
         $roguelytics_site = "https://www.roguelytics.com";
         global $wpdb;
         if(isset($_POST['rogueltyics_signup'])){
            $retrieved_nonce = $_REQUEST['roguelytics_create_accnt'];
            if(!wp_verify_nonce($retrieved_nonce, 'roguelytics_create_accnt')) die('Failed security check');
            $response = wp_remote_post($roguelytics_site . "/api/v1/login/signup.json", array(
               'timeout'               => 45,
               'body'                  => array(
                  'firstname'             => sanitize_text_field($_POST['firstname']),
                  'lastname'              => sanitize_text_field($_POST['lastname']),
                  'email'                 => sanitize_email($_POST['email']),
                  'password'              => sanitize_text_field($_POST['password']),
                  'password_confirmation' => sanitize_text_field($_POST['password_confirmation']),
                  'site_name'             => sanitize_text_field($_POST['site_name']),
               )
            ));

            $response_code = wp_remote_retrieve_response_code($response);
            $api_response =  json_decode(wp_remote_retrieve_body($response));
            if($response_code == 200 && $body->status == $status){
               $table_name = 'roguelytics';
               roguelytics_create_new_user();
               foreach($api_response->site_keys as $key => $value){
                  $wpdb->insert(
                     $table_name,
                     array(
                        'environment_inject_code' => $value->inject_code,
                        'environment_key' => sanitize_title($value->key),
                        'environment' => sanitize_title($value->environment),
                        'environment_code' => $value->code,
                        'environment_active' => "0",
                     ) 
                  );
               }       
            }else{
               foreach ($api_response->error_messages as $key => $error_type){
                  foreach ($error_type as $key2 => $value2) {
                    if(!$value2 == null){
                     $sign_up_message .= $key . ": " . $value2 . "<br/>";
                    }
                  }
               }
            }
         }

         if($wpdb->get_var("SHOW TABLES LIKE 'roguelytics'")){
            include_once("roguelytics_enviroment_options.php");
         }else{
            include_once("signup.php");
         }
      }   
   }
   
   add_action('init', 'roguelytics_activate_environment');

   function roguelytics_activate_environment(){
      if(isset($_POST['activation_btn'])){
         if(current_user_can('administrator')){
            $retrieved_nonce = $_REQUEST['roguelytics_envrnmt'];
            if(!wp_verify_nonce($retrieved_nonce, 'roguelytics_choose_envnmt')) die('Failed security check');
            global $wpdb;
            $active_id = $_POST['activation_btn'];
            for($i=0; $i < 6; $i++){
               if($i == $active_id){
                  $wpdb->update('roguelytics', array('environment_active' => 1), array('id' => $i));
               }else{
                  $wpdb->update('roguelytics', array('environment_active' => 0), array('id' => $i));
               }
            }
         }
      }
   }

   add_action('wp_login', 'roguelytics_signin');


   function add_roguelytics_code(){
      global $wpdb;
      $roguelytics_code = $wpdb->get_row("SELECT environment_inject_code FROM roguelytics WHERE environment_active = 1");
      echo $roguelytics_code->environment_inject_code;
   }

   add_action('get_footer', 'add_roguelytics_code');

   wp_enqueue_style( 'style', plugins_url("roguelytics_styles.css", __FILE__ ));
   wp_enqueue_script( 'roguelytics_script', plugins_url('roguelytics_js.js', __FILE__), array('jquery'));

   add_action( 'admin_menu', 'roguelytics_plugin_menu' );



   function roguelytics_create_new_user(){
      global $roguelytics_db_version;
      $roguelytics_db_version = '1.0';

      global $wpdb;
      global $roguelytics_db_version;

      $table_name = 'roguelytics';

      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        environment varchar(55) DEFAULT '' NOT NULL,
        environment_code text NOT NULL,
        environment_inject_code text NOT NULL,
        environment_key varchar(55) DEFAULT '' NOT NULL,
        environment_active boolean NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta($sql);
   }
?>