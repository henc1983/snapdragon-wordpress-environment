<?php
/**
 * Template hooks.
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');


/**
 * Posts
 * 
 * @see snapdragon_post_header()
 * @see snapdragon_post_content()
 * @see snapdragon_post_taxonomy()
 * @see snapdragon_pagination()
 */
add_action( 'snapdragon_loop' , 'snapdragon_post_header' , 10 );
add_action( 'snapdragon_loop' , 'snapdragon_post_content' , 30 );
add_action( 'snapdragon_loop' , 'snapdragon_post_taxonomy' , 40 );
add_action( 'snapdragon_loop_after' , 'snapdragon_pagination' , 10 );

add_action( 'snapdragon_post_header_before' , 'snapdragon_post_meta' , 10 );
add_action( 'snapdragon_post_content_before' , 'snapdragon_post_thumbnail' , 10 );
