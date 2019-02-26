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
	foreach ( Helpers\get_files_in_path( $directory ) as $file ) :

		if ( 'post-card.php' !== $file ) continue;

		$file_path = trailingslashit( $directory ) . $file;
		$file_documentation = Parser\get_template_part_header( $file_path );
		?>
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
endforeach;

\get_footer();
