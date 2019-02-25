<?php
/**
 * Template to display the pattern library.
 *
 * @package Kalutara
 */

namespace Kalutara;


\get_header();

$query = new \WP_Query( [
	'posts_per_page' => 1,
] );

while ( $query->have_posts() ) :
	$query->the_post();

	foreach ( Helpers\get_files_in_path( 'template-parts' ) as $file ) : ?>
		<article class="kalutara-component <?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>">
			<h2><?php echo esc_html( $file ); ?></h2>
			<?php
			get_extended_template_part(
				Helpers\remove_extension_from_filename( $file ),
				'',
				Data\get_dummy_data( $file ),
				[
					'dir' => '/',
				]
			);
			?>
		</article>
		<?php
	endforeach;

endwhile;

wp_reset_postdata();

\get_footer();
