<?php
/**
 * Theme Functions.
 *
 * @package snapdragon
 */


if ( ! function_exists( 'snapdragon_nav_menu_id' ) ) {
	function snapdragon_nav_menu_id( $id ) {
		$locations = get_nav_menu_locations();
        $menu_id = $locations[$id] ?? '';
        return !empty($menu_id) ? $menu_id : '';
	}
}



if ( ! function_exists( 'snapdragon_child_menu_items' ) ) {
	function snapdragon_child_menu_items(array $menu, $parent_id) {
        $child_menus = [];
        if (!empty($menu) && is_array($menu)) {
            foreach ($menu as $child) {
                if (intval($child->menu_item_parent == $parent_id)) {
                    array_push($child_menus, $child);
                }
            }
        }
        return $child_menus;
    }
}



if ( ! function_exists( 'snapdragon_is_woocommerce_activated' ) ) {
    // Query WooCommerce activation
	function snapdragon_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_id' ) ? true : false;
	}
}



if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Adds backwards compatibility for wp_body_open() introduced with WordPress 5.2
	 *
	 * @since 2.5.4
	 * @see https://developer.wordpress.org/reference/functions/wp_body_open/
	 * @return void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}



if ( ! function_exists( 'snapdragon_reload_page' ) ) {
    function snapdragon_reload_page() {
        print('<script type="text/javascript">window.top.location="'.$_SERVER['REQUEST_URI'].'";</script>');
		exit;
    }
}



if ( ! function_exists( 'snapdragon_get_footer' ) ) {
	function snapdragon_get_footer() {
		/**
         * Here comes the custom code
         */
        
        
        wp_footer();
	}
}



if ( ! function_exists( 'snapdragon_get_sidebar' ) ) {
	function snapdragon_get_sidebar() {
		
	}
}