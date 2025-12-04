<?php
/**
 * Main Page template
 * @package snapdragon
 */

get_header();

    while ( have_posts() ) :

        the_post();        
        get_template_part( 'templates/content', 'page' );

    endwhile;

get_footer();