<?php
/**
 * Theme Default Values Class.
 *
 * @package snapdragon
 */



if ( ! class_exists( 'SnapdragonDefaults' ) ) {
    class SnapdragonDefaults {



        private static $instance = null;



		public const COOKIE_EXCLUSION_SELECTION_VALUES = ['language', 'product'];
        public const COOKIE_ACCEPTED_NAME = 'snapdragon_cookies_accepted';
        public const COOKIE_ACCEPTED = 0;
        public const COOKIE_MESSAGE_OPTION_NAME = 'snapdragon_cookie_message';

        public const ADV_COOKIE_SEASONAL_MODAL_NAME = 'snapdragon_seasonal_adverts_showed';
        public const ADV_COOKIE_SEASONAL_MODAL_SHOWED = 0;
        
        public const ADV_COOKIE_MODAL_NAME = 'snapdragon_adverts_showed';
        public const ADV_COOKIE_MODAL_SHOWED = 0;

        public const TRANSLATE_COOKIE_NAME = 'snapdragon_language_selected';

        public const PRODUCT_WISHLIST_COOKIE_NAME = 'snapdragon_product_whislist';
        public const PRODUCT_LAST_VIEWED_COOKIE_NAME = 'snapdragon_product_last_viewed';
                
        public const PRODUCT_ORDERBY_COOKIE_NAME = 'snapdragon_product_orderby';
        public const PRODUCT_ORDERBY_VALUES = ['post_date-DESC', 'post_date-ASC', 'meta_value_num-DESC', 'meta_value_num-ASC', 'title-DESC', 'title-ASC'];
        public const PRODUCT_ORDERBY_COOKIE = 'post_date-DESC';

        public const PRODUCT_NUMBER_COOKIE_NAME = 'snapdragon_product_number';
        public const PRODUCT_NUMBER_VALUES = [12, 24, 48, -1];
        public const PRODUCT_NUMBER = 12;

        public const PRODUCT_ONLY_SALES_COOKIE_NAME = 'snapdragon_product_only_sales';
        public const PRODUCT_ONLY_SALES = 0;
        
        public const PRODUCT_PRICE_COOKIE_NAME = 'snapdragon_product_price';
        public const PRODUCT_PRICE = -1;
        
        public const PRODUCT_GRID_COOKIE_NAME = 'snapdragon_product_grid';
        public const PRODUCT_GRID = 'grid';
        public const PRODUCT_GRID_VALUES = ['grid', 'lines'];


        public const MEDIAQUERY_POST_NAME = 'snapdragon-device-screen';
        public const MEDIAQUERY_COOKIE_NAME = 'snapdragon_device_screen';
        public const MEDIAQUERY_DEFAULT = 'desktop';
        public const MEDIAQUERY_DEVICES = ['mobile','tablet','laptop','desktop'];
        
        
        public const IMPORTANT_COOKIE_PAIRS = [
            self::TRANSLATE_COOKIE_NAME                     => 'hu_HU',
            self::COOKIE_ACCEPTED_NAME                      => self::COOKIE_ACCEPTED,
            self::ADV_COOKIE_SEASONAL_MODAL_NAME            => self::ADV_COOKIE_SEASONAL_MODAL_SHOWED,
            self::ADV_COOKIE_MODAL_NAME                     => self::ADV_COOKIE_MODAL_SHOWED,
            self::PRODUCT_WISHLIST_COOKIE_NAME              => [],
            self::PRODUCT_LAST_VIEWED_COOKIE_NAME           => [],
            self::PRODUCT_ORDERBY_COOKIE_NAME               => self::PRODUCT_ORDERBY_COOKIE,
            self::PRODUCT_NUMBER_COOKIE_NAME                => self::PRODUCT_NUMBER,
            self::PRODUCT_ONLY_SALES_COOKIE_NAME            => self::PRODUCT_ONLY_SALES,
            self::PRODUCT_PRICE_COOKIE_NAME                 => self::PRODUCT_PRICE,
            self::PRODUCT_GRID_COOKIE_NAME                  => self::PRODUCT_GRID,
            self::MEDIAQUERY_COOKIE_NAME                    => self::MEDIAQUERY_DEFAULT,
        ];



        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
    }
}



return SnapdragonDefaults::instance();