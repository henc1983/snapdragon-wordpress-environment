<?php
/**
 * Snapdragon Admin Class
 *
 * @since    1.0
 * @package  snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



if ( ! class_exists( 'SnapdragonAdminClass' ) ) :
    class SnapdragonAdminClass {
        
        
        
        private static $instance = null;
        
        

        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}



        public function __construct() {
            add_action( 'admin_init' , fn()=>$this->handle_post_requests() );
            add_action( 'admin_menu' , fn()=>$this->add_admin_menu() );
            add_action( 'admin_enqueue_scripts' , fn()=>$this->admin_enqueue_scripts() );
        }



        private function handle_post_requests() {
            
            $array_keys = array_keys( $_POST );
            $search = 'snapdragon';

            $matching_keys = array_values(
                array_filter( $array_keys , function( $key ) use ( $search ) {
                    return stripos( $key , $search ) !== false;
                })
            );

            if( isset( $_POST['snapdragon-language-options'] ) ) {
                global $snapdragon;
                $languages = [ 'hu_HU' ];
                
                foreach( array_keys($_POST) as $language ) {
                    
                    if( ! ($language === 'snapdragon-language-options') ) {

                        array_push( $languages , $language );

                    }
                }
                

                if( count($languages) < 1 ) {
                    $languages = [ 'hu_HU' ];
                }

                if( is_object($snapdragon) && property_exists( $snapdragon , 'translates' ) && is_a( $snapdragon->translates , 'SnapdragonTranslates') ) {
                    set_theme_mod( $snapdragon->translates::TRANSLATE_OPTION_NAME , $languages );
                }
                else {
                    set_theme_mod( 'snapdragon_enabled_languages' , $languages );
                }

                snapdragon_reload_page();
            }

            if ( ! empty( $matching_keys ) ) {

                foreach( $matching_keys as $key ) {
                    if( !empty( $_POST[ $key ] ) ) {
                        set_theme_mod( $key , $_POST[$key] );
                    }
                    else {
                        remove_theme_mod( $key );
                    }
    
                    unset( $_POST[ $key ] );
                }

                snapdragon_reload_page();
            }


        }



        private function add_admin_menu() {
            add_submenu_page( 'themes.php' , esc_html__('Snapdragon theme' , 'snapdragon' ) , esc_html__('Snapdragon theme' , 'snapdragon' ) , 'manage_options' , 'snapdragon_admin_page' , fn()=>$this->admin_page_html_callback() , 110 );
        }



        private function admin_enqueue_scripts() {
            if ( ! str_contains($_SERVER['REQUEST_URI'] , "/wp-admin/themes.php?page=snapdragon_admin_page" ) ) {
                return;
            } 
            

            wp_enqueue_style( 'snapdragon-admin', THEME_URI . '/assets/styles/admin.css' , [] , filemtime(THEME_DIR . '/assets/styles/admin.css' ) , 'all' );
        }



        private function admin_page_html_callback() {
            do_action( 'snapdragon_admin_page' );
        }
    }
endif;



return SnapdragonAdminClass::instance();