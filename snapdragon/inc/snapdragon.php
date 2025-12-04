<?php
/**
 * Snapdragon Class
 *
 * @since    1.0
 * @package  snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



if ( ! class_exists( 'Snapdragon' ) ) :
    class Snapdragon {
        
        
        
        private static $instance = null;
        public $defaults;
        public $cookies;
        public $updater;
        public $translates;
        public $setup;



		public $name;
		public $version;
		public $author;
		public $theme_uri;



        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}



        public function __construct() {

			/**
			 * Create this object immediately after instantiate engine class
			 * @return $snapdragon
			 */
			$GLOBALS['snapdragon'] = $this;



			// Engine class settings
            $theme 					= wp_get_theme( 'snapdragon' );
            $this->name 			= $theme->get( 'Name' );
            $this->version 			= $theme->get( 'Version' );
            $this->author 			= $theme->get( 'Author' );
            $this->theme_uri		= $theme->get( 'ThemeURI' );



			// Including important files
			$this->including_required_files();
			$this->init_hooks();


			do_action( 'snapdragon_init' );
			// refresh $snapdragon object
			return $this;

        } // *** __construct() *** //



		private function including_required_files() {

			// *** It's important! This file will be first! *** //
			require_once THEME_DIR . '/inc/snapdragon-functions.php';

			

			// If admin page loaded
			if( is_admin() ) {
				require_once  THEME_DIR . '/inc/admin/admin-template-functions.php';
				require_once  THEME_DIR . '/inc/admin/snapdragon-admin-hooks.php';
				require_once  THEME_DIR . '/inc/snapdragon-admin.php';
			}



			// refresh $snapdragon object
			return $this;

		} // *** including_required_files() *** //



		private function init_hooks() {

			add_action( 'snapdragon_init' , fn()=>$this->init_defaults() , 10 );
			add_action( 'snapdragon_init' , fn()=>$this->init_translates() , 20 );
			add_action( 'snapdragon_init' , fn()=>$this->init_cookies() , 30 );
			add_action( 'snapdragon_init' , fn()=>$this->init_updater() , 40 );
			add_action( 'snapdragon_init' , fn()=>$this->init_theme_setup() , 50 );
			add_action( 'snapdragon_init' , fn()=>$this->init_theme_templates() , 60 );

			add_action( 'snapdragon_init_theme_templates_before' , fn()=>$this->including_template_files() , 10 );
			add_action( 'snapdragon_init_cookies_finish' , fn()=>$this->store_important_cookies() , 10 );

			do_action( 'snapdragon_init_theme_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_hooks() *** //



		private function init_defaults() {
			$path = THEME_DIR . '/inc/extras/theme-defaults.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			$this->defaults   = require_once $path;
			
			do_action( 'snapdragon_init_defaults_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_defaults() *** //



		private function init_translates() {
			$path = THEME_DIR . '/inc/extras/theme-translates.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			$this->translates   = require_once $path;
			
			do_action( 'snapdragon_init_translates_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_translates() *** //



		private function init_cookies() {
			$path = THEME_DIR . '/inc/extras/theme-cookies.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			$this->cookies   = require_once $path;
			
			do_action( 'snapdragon_init_cookies_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_cookies() *** //



		private function init_updater() {
			$path = THEME_DIR . '/inc/extras/theme-updater.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			$this->updater   = require_once $path;
			
			do_action( 'snapdragon_init_updater_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_updater() *** //



		private function init_theme_setup() {
			$path = THEME_DIR . '/inc/extras/theme-setup.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			$this->setup   = require_once $path;
			
			do_action( 'snapdragon_init_theme_setup_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_theme_setup() *** //



		private function including_template_files() {
			
			$path = THEME_DIR . '/inc/templates';

			foreach(glob($path . '/*.php') as $file) {
				require_once $file;
			}

		} // *** including_template_files() *** //



		private function init_theme_templates() {

			do_action( 'snapdragon_init_theme_templates_before' );

			$path = THEME_DIR . '/inc/snapdragon-templates.php';
			if( ! file_exists( $path ) ) {
				error_log("Important file missing: $path", 0);
				return;
			}

			require_once $path;
			
			do_action( 'snapdragon_init_theme_templates_finish' );
			// refresh $snapdragon object
			return $this;

		} // *** init_theme_templates() *** //



		private function store_important_cookies() {
			if( ! property_exists( $this , 'defaults' ) ||
				! property_exists( $this , 'cookies' ) || 
				! property_exists( $this , 'translates' ) || 
				! is_a( $this->defaults , 'SnapdragonDefaults' ) ||
				! is_a( $this->translates , 'SnapdragonTranslates' ) ||
				! is_a( $this->cookies , 'SnapdragonCookies' )
			) {
				return;
			}
						
			if( ! headers_sent() ) {

				$count = 0;

				foreach( $this->defaults::IMPORTANT_COOKIE_PAIRS as $name => $value ) {

					/**
					 * get cookie is need to load
					 * 
					 * e.g.: WooCommerce is inactive store cookies will be remove,
					 * or has no enabled language, translate cookie will remove
					 */
					$important = $this->check_cookie_is_important( $name );
				
					/**
					 * if cookie doesn't exist and but it's important, it will set
					 * and counter increase by one
					 */
					if( $this->cookies->get_cookie( $name ) === null && $important ) {
						
						$this->cookies->set_cookie( $name , $value );
						
						$count++;
					}
				}
				


				// If cookie counter bigger than 0 reload the page to use stored cookies
				if( ! ( $count === 0 ) ) {
					snapdragon_reload_page();
				}
			}

		} // *** store_important_cookies() *** //



		private function check_cookie_is_important( $name ) {
			$result = true;

			switch( true ) {
				case in_array( 'product' , array_map( 'strtolower' , explode( '_' , $name ) ) ) :
                    if( ! snapdragon_is_woocommerce_activated() ) {
                        $this->cookies->remove_cookie( $name );

                        $result = false;
                    }
                    break;

				case in_array( 'language' , array_map( 'strtolower' , explode( '_' , $name ) ) ) :
                    
                    $count = count( $this->translates->get_enabled() );

                    if( $count < 1 ) {
						$this->cookies->remove_cookie( $name );
                        $result = false;
                    }
                    break;

				default:
                    $result = true;
			}

			return $result;
		}
    }
endif;