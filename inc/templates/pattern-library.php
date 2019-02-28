<?php
/**
 * Template to display the pattern library.
 *
 * @package Kalutara
 */

namespace Kalutara;

// Instruct robots not to index this page or expose referer information:
add_action( 'wp_head', 'wp_sensitive_page_meta' );

// Instruct clients not to cache this page:
\nocache_headers();

\get_header();

$query = new \WP_Query( [
	'posts_per_page' => 1,
] );

while ( $query->have_posts() ) :
	$query->the_post();

	foreach ( Helpers\get_files_in_path( 'template-parts' ) as $file ) : ?>
		<article class="kalutara-component <?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>">
			<strong><?php echo esc_html( $file ); ?></strong>
			<?php

			if ( ! empty( $file_documentation['summary'] ) ) :
				?>
				<h3 class="kalutara-component__summary">
					<?php echo esc_html( $file_documentation['summary'] ); ?>
				</h3>
				<?php
			endif;

			if ( ! empty( $file_documentation['documentation'] ) ) :
				?>
				<p class="kalutara-component__documentation">
					<?php echo esc_html( $file_documentation['documentation'] ); ?>
				</p>
				<?php
			endif;
			?>

			<div class="kalutara-component__preview">
				<?php
				get_extended_template_part(
					Helpers\remove_extension_from_filename( $file ),
					'',
					Data\get_data( $file_path )
				);
				?>
			</div>
		</article>
		<?php
	endforeach;

endwhile;

wp_reset_postdata();

\get_footer();
