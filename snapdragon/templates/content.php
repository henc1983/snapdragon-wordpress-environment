<?php
/**
 * The template part for Blog posts
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');

?>

<article id="post-<?php esc_attr_e( get_the_ID() ); ?>" <?php post_class(); ?>>
    <?php
	/**
	 * 
	 * Functions hooked in to snapdragon_loop_post action.
	 *
	 * @hooked snapdragon_post_header          - 10
	 * @hooked snapdragon_post_content         - 30
	 * @hooked snapdragon_post_taxonomy        - 40
	 */
	do_action( 'snapdragon_loop' );
	?>
</article>