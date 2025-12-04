<?php
/**
 * Snapdragon Theme Setup Class
 *
 * @since    1.0
 * @package  snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



if ( ! class_exists( 'SnapdragonSetup' ) ) :
    class SnapdragonSetup {
        
        
        
        private static $instance = null;
        
        

        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}



        public function __construct() {
            add_action( 'init' ,   				fn()=>$this->admin_bar() );
            add_action( 'after_setup_theme' ,   fn()=>$this->load_theme_textdomains() );
            add_action( 'after_setup_theme' ,   fn()=>$this->enable_theme_supports() );
            add_action( 'after_setup_theme' ,   fn()=>$this->custom_logo() );
            add_action( 'after_setup_theme' ,   fn()=>$this->register_nav_menus() );
            add_action( 'wp_enqueue_scripts' ,  fn()=>$this->enqueue_styles() );
            add_action( 'wp_enqueue_scripts' ,  fn()=>$this->enqueue_scripts() );
        }



        private function admin_bar() {
			if( is_user_logged_in() && current_user_can( 'manage_options' ) ){
				add_filter( 'show_admin_bar', '__return_true' , 999 );
			}
            else {
                add_filter( 'show_admin_bar', '__return_false' , 999 );
            }				
		}
    


        private function load_theme_textdomains() {
			// Loads wp-content/languages/themes/storefront-it_IT.mo.
			load_theme_textdomain( 'snapdragon', trailingslashit( WP_LANG_DIR ) . 'themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'snapdragon', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/storefront/languages/it_IT.mo.
			load_theme_textdomain( 'snapdragon', get_template_directory() . '/languages' );

		}



        private function enable_theme_supports() {
			
			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			// Declare support for title theme feature.
			add_theme_support( 'title-tag' );

			// Declare support for selective refreshing of widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			// Add support for Block Styles.
			add_theme_support( 'wp-block-styles' );

			// Add support for full and wide align images.
			add_theme_support( 'align-wide' );

			// Add support for editor styles.
			add_theme_support( 'editor-styles' );

			// Add support for responsive embedded content.
			add_theme_support( 'responsive-embeds' );

			/**
			 * Add support for appearance tools.
			 *
			 * @link https://wordpress.org/documentation/wordpress-version/version-6-5/#add-appearance-tools-to-classic-themes
			 */
			add_theme_support( 'appearance-tools' );

			// Add support for theme.json
			// add_theme_support( 'block-template-parts' );
			// add_theme_support( 'block-template' );

			add_theme_support( 'disable-custom-gradients' );
			add_theme_support( 'disable-custom-colors' );
        }



        private function custom_logo() {    
            $default_logo = [
				'height'               => 100,
				'width'                => 400,
				'flex-height'          => true,
				'flex-width'           => true,
				'header-text'          => array( 'site-title', 'site-description' )
			];
			add_theme_support( 'custom-logo' , $default_logo );
        }



        private function register_nav_menus() {
			register_nav_menus(
				[
					'main-menu' => esc_html__('Main Menu' , 'snapdragon'),
					'profile' => esc_html__('Profile' , 'snapdragon'),
					'social-media' => esc_html__('Social Media' , 'snapdragon'),
					'general-informations' => esc_html__('General Informations' , 'snapdragon')
				]
			);
				
		}



        private function enqueue_styles() { 
			global $snapdragon;

			if( ! is_object($snapdragon ) 
				|| ! property_exists( $snapdragon , 'defaults' )
				|| ! property_exists( $snapdragon , 'cookies' )
				|| ! is_a( $snapdragon->defaults , 'SnapdragonDefaults' )
				|| ! is_a( $snapdragon->cookies , 'SnapdragonCookies' )
			 ) {
				return;
			}
			
			$style_dir = untrailingslashit( THEME_DIR . '/assets/styles' );
			$style_uri = untrailingslashit( THEME_URI . '/assets/styles' );

			$media_query = $snapdragon->cookies->get_cookie($snapdragon->defaults::MEDIAQUERY_COOKIE_NAME);
			
			
			wp_dequeue_style( 'global-styles' ); 
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wc-block-style' );

			if ( snapdragon_is_woocommerce_activated() ) {
				wp_dequeue_style('wc-block-vendors-style');
				wp_dequeue_style('wc-block-style');
				wp_dequeue_style('woocommerce-general');
				wp_dequeue_style('woocommerce-layout');
				wp_dequeue_style('woocommerce-smallscreen');
			}
			
			
			wp_enqueue_style("snapdragon-style-$media_query", esc_url("$style_uri/style-$media_query.css"), [], filemtime("$style_dir/style-$media_query.css"));

        }



        private function enqueue_scripts() {    
            global $snapdragon;

			if( ! is_object($snapdragon ) 
				|| ! property_exists( $snapdragon , 'defaults' )
				|| ! property_exists( $snapdragon , 'cookies' )
				|| ! is_a( $snapdragon->defaults , 'SnapdragonDefaults' )
				|| ! is_a( $snapdragon->cookies , 'SnapdragonCookies' )
			 ) {
				return;
			}

            $script_dir = untrailingslashit( THEME_DIR . '/assets/scripts' );
            $script_uri = untrailingslashit( THEME_URI . '/assets/scripts' );
			
			$media_query = $snapdragon->cookies->get_cookie($snapdragon->defaults::MEDIAQUERY_COOKIE_NAME);
			
			wp_enqueue_script( "snapdragon-script-$media_query" , "$script_uri/main-$media_query.js" , [] , filemtime( "$script_dir/main-$media_query.js" ) , true);

        }
    }
endif;



return SnapdragonSetup::instance();