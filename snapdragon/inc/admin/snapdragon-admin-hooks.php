<?php
/**
 * Snapdragon Admin Template Hooks
 *
 * @since    1.0
 * @package  snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_before' , 10 );
add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_messages' , 20 );
add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_content_before' , 30 );

add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_tabs_navigation' , 40 );
add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_tabs_content' , 50 );

add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_content_after' , 90 );
add_action( 'snapdragon_admin_page' , 'snapdragon_admin_page_after' , 100 );


add_action( 'snapdragon_admin_user_tab_content' , 'snapdragon_admin_user_tab_content_html');
add_action( 'snapdragon_admin_company_tab_content' , 'snapdragon_admin_company_tab_content_html');
add_action( 'snapdragon_admin_accountant_tab_content' , 'snapdragon_admin_accountant_tab_content_html');
add_action( 'snapdragon_admin_bank_tab_content' , 'snapdragon_admin_bank_tab_content_html');
add_action( 'snapdragon_admin_webhost_tab_content' , 'snapdragon_admin_webhost_tab_content_html');
add_action( 'snapdragon_admin_woocommerce_tab_content' , 'snapdragon_admin_woocommerce_tab_content_html');
add_action( 'snapdragon_admin_plugins_tab_content' , 'snapdragon_admin_plugins_tab_content_html');
add_action( 'snapdragon_admin_translates_tab_content' , 'snapdragon_admin_translates_tab_content_html');
add_action( 'snapdragon_admin_settings_tab_content' , 'snapdragon_admin_settings_tab_content_html');