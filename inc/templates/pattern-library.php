<?php
/**
 * Template to display the pattern library.
 *
 * @package Kalutara
 */

namespace Kalutara;

$directories = [];

if ( is_child_theme() ) {
	$directories[] = get_stylesheet_directory() . '/template-parts';
}

$directories[] = get_template_directory() . '/template-parts';

\get_header();

foreach ( $directories as $directory ) :
	foreach ( Helpers\get_files_in_path( $directory ) as $file ) : ?>
		<article class="kalutara-component <?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>">
			<h2><?php echo esc_html( $file ); ?></h2>
			<?php
			get_extended_template_part(
				Helpers\remove_extension_from_filename( $file ),
				'',
				Data\get_dummy_data( $file )
			);
			?>
		</article>
		<?php
	endforeach;
endforeach;

\get_footer();
