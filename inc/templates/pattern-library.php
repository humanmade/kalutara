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

			<?php
				$data_objects = Data\get_data( $file_path );

				foreach ( $data_objects as $data ) :

					// If this data variant has a "title" in its meta, output that.
					if ( ! empty( $data['_meta']['title'] ) ) {
						echo '<h6 class="kalutara-component__variant-title">' . esc_html( $data['_meta']['title'] ) . '</h6>';

					}
					?>
					<div class="kalutara-component__preview">
						<?php
						get_extended_template_part(
							Helpers\remove_extension_from_filename( $file ),
							'',
							$data
						);
						?>
					</div>
					<?php
				endforeach;
			?>
		</article>
		<?php
	endforeach;
endforeach;

\get_footer();
