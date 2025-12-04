<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');

?>

<article class="page type-page no-result not-found">

    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'snapdragon' ); ?></h1>
    </header>

    <div class="page-content">
        <?php 
            if( is_home() && current_user_can( 'publish_posts' ) ) :
                $kses_publish_post = [
                    'a' => [ 'href' => [] , 'class' => [] , 'aria-label' => [] , 'role' => [] ],
                    'p' => [ 'class' => [] , 'role' => [] ],
                ];

                printf(
                    wp_kses(
                        __( '<p>Ready to publish your first post? <a href="%1$s">Get started here</a></p>', 'snapdragon' ) , $kses_publish_post ) , esc_url( admin_url( 'post-new.php' ) )
                    );

            elseif ( is_search() ) :
                ?>
                    <p class="page-hints">
                        <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' , 'snapdragon' );?>
                    </p>
                <?php

                get_search_form();
                
            else :
                ?>
                    <p class="page-hints">
                        <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' , 'snapdragon' ); ?>
                    </p>
                <?php
                get_search_form();
            endif;
        ?>
    </div>
    
</article>