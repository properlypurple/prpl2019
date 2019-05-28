<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Prpl2019theme
 */

if ( ! function_exists( 'prpl2019theme_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function prpl2019theme_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'prpl2019theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'prpl2019theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'prpl2019theme_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function prpl2019theme_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'prpl2019theme' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'prpl2019theme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'prpl2019theme' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'prpl2019theme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'prpl2019theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'prpl2019theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'prpl_post_thumbnail' ) ) :
	/**
	 * Displays an post thumbnail (if one is set), otherwise displays a blank red square.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div element when on single views.
	 */
	function prpl_post_thumbnail() {
		$post_id = get_the_id();
		$image = '';
		if ( prpl_has_post_thumbnail( $post_id ) || is_single() ) {
			// thumbnail default is 640x640
			$image = get_the_post_thumbnail( $post_id, 'prpl-grid-thumb' );
		}
		$class = ( empty( $image ) ) ? "post-no-thumbnail" : "post-thumbnail";
		$icon = '';
		if ( is_singular() ) :
			$image = get_the_post_thumbnail( $post_id, 'prpl-featured' );
			if ( ! empty( $image ) ) : ?>

			<div class="<?php esc_html_e( $class ); ?>">
				<?php echo $image; // WPCS: XSS OK. ?>
			</div><!-- .post-thumbnail -->

			<?php endif;
		elseif ( post_password_required() || is_attachment() ) :  ?>

			<a class="<?php esc_html_e( $class ); ?>" href="<?php the_permalink(); ?>">
				<?php echo $icon . $image; // WPCS: XSS OK. ?>
				<span class="screen-reader-text"><?php the_title(); ?></span>
			</a>

		<?php
		else : ?>
			<a class="<?php esc_html_e( $class ); ?>" href="<?php the_permalink(); ?>">
				<?php echo $icon . $image; // WPCS: XSS OK. ?>
				<span class="screen-reader-text"><?php the_title(); ?></span>
			</a>

		<?php
		endif;
	}
endif;
