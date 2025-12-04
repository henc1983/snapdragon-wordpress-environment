<?php
/**
 * Template Contents.
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



if ( ! function_exists( 'snapdragon_display_comments' ) ) {
	/**
	 * Snapdragon display comments
	 * @since  1.0
	 */
	function snapdragon_display_comments() {
		if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
			comments_template();
		endif;
	}
}



if ( ! function_exists( 'snapdragon_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 * @since 1.0
	 */
	function snapdragon_post_header() {
		?>
        <header class="entry-header">
            <?php
            /**
             * Functions hooked in to snapdragon_post_header_before action.
             *
             * @hooked snapdragon_post_meta - 10
             */
            do_action( 'snapdragon_post_header_before' );

            if ( is_single() ) {
                the_title( '<h1 class="entry-title">', '</h1>' );
            } else {
                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            }

            do_action( 'snapdragon_post_header_after' );
            
            ?>
        </header>
        <?php
	}
}



if ( ! function_exists( 'snapdragon_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0
	 */
	function snapdragon_post_content() {
		?>
        <div class="entry-content">
            <?php

                /**
                 * Functions hooked in to snapdragon_post_content_before action.
                 *
                 * @hooked snapdragon_post_thumbnail - 10
                 */
                do_action( 'snapdragon_post_content_before' );

                the_content(
                    sprintf(
                        /* translators: %s: post title */
                        __( 'Continue reading %s', 'snapdragon' ),
                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                    )
                );

                do_action( 'snapdragon_post_content_after' );

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'snapdragon' ),
                        'after'  => '</div>',
                    )
                );
            ?>
        </div>
        <?php
	}
}



if ( ! function_exists( 'snapdragon_post_taxonomy' ) ) {
	/**
	 * Display the post taxonomies
	 * @since 1.0
	 */
	function snapdragon_post_taxonomy() {
		/* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', 'snapdragon' ) );

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', __( ', ', 'snapdragon' ) );

        ?>

        <aside class="entry-taxonomy">
            <?php if ( $categories_list ) : ?>

            <div class="cat-links">
                <?php echo esc_html( _n( 'Category:', 'Categories:', count( get_the_category() ), 'snapdragon' ) ); ?> <?php echo wp_kses_post( $categories_list ); ?>
            </div>

            <?php endif; ?>

            <?php if ( $tags_list ) : ?>

            <div class="tags-links">
                <?php echo esc_html( _n( 'Tag:', 'Tags:', count( get_the_tags() ), 'snapdragon' ) ); ?> <?php echo wp_kses_post( $tags_list ); ?>
            </div>

            <?php endif; ?>
        </aside>

        <?php 
	}
}



if ( ! function_exists( 'snapdragon_pagination' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function snapdragon_pagination() {
		global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => _x( 'Next', 'Next post', 'snapdragon' ),
            'prev_text' => _x( 'Previous', 'Previous post', 'snapdragon' ),
        );

        the_posts_pagination( $args );
	}
}



if ( ! function_exists( 'snapdragon_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.0
	 */
	function snapdragon_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $size );
		}
	}
}



if ( ! function_exists( 'snapdragon_post_meta' ) ) {
	/**
	 * Display the post meta
	 * @since 1.0
	 */
	function snapdragon_post_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

		$posted_on = '
			<span class="posted-on">' .
			/* translators: %s: post date */
			sprintf( __( 'Posted on %s', 'snapdragon' ), $output_time_string ) .
			'</span>';

		// Author.
		$author = sprintf(
			'<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
			__( 'by', 'snapdragon' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);

		// Comments.
		$comments = '';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$comments_number = get_comments_number_text( __( 'Leave a comment', 'snapdragon' ), __( '1 Comment', 'snapdragon' ), __( '% Comments', 'snapdragon' ) );

			$comments = sprintf(
				'<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
				esc_url( get_comments_link() ),
				$comments_number
			);
		}

		echo wp_kses(
			sprintf( '%1$s %2$s %3$s', $posted_on, $author, $comments ),
			[
				'span' => [
					'class' => [],
				],
				'a'    => [
					'href'  => [],
					'title' => [],
					'rel'   => [],
				],
				'time' => [
					'datetime' => [],
					'class'    => [],
				],
			]
		);
	}
}



if ( ! function_exists( 'snapdragon_page_header' ) ) {
	/**
	 * Display the page header
	 * @since 1.0
	 */
	function snapdragon_page_header() {
		if ( is_front_page() || is_page_template( 'template-homepage.php' ) ) {
			return;
		}

		?>
		<header class="page-header">
			<?php
				snapdragon_post_thumbnail( 'full' );
				the_title( '<h1 class="page-title">', '</h1>' );
			?>
		</header>

		<?php
	}
}



if ( ! function_exists( 'snapdragon_page_content' ) ) {
	/**
	 * Display the post content
	 * @since 1.0
	 */
	function snapdragon_page_content() {
		?>

		<div class="page-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'snapdragon' ),
						'after'  => '</div>',
					)
				);
			?>
		</div>

		<?php
	}
}