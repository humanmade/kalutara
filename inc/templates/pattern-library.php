<?php
/**
 * Template to display the pattern library.
 *
 * @package Kalutara
 */

$directories = [];

if ( is_child_theme() ) {
	$directories[] = get_stylesheet_directory() . '/template-parts';
}

$directories[] = get_template_directory() . '/template-parts';

\get_header();

foreach ( $directories as $directory ) :
	foreach ( Kalutara\Helpers\get_files_in_path( $directory ) as $file ) :

		$file_path = trailingslashit( $directory ) . $file;
		$file_documentation = Kalutara\Parser\get_template_part_header( $file_path );
		?>
		<article class="kalutara-component kalutara-component--<?php echo sanitize_html_class( Kalutara\Helpers\get_css_class_name( $file ) ); ?>">
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
			// Use file doc data for variations, otherwise use a single empty variation.
			$variations = ! empty( $file_documentation['data'] ) ? $file_documentation['data'] : [ [] ];

			foreach ( $variations as $data ) :

				// If this data variant has a "title" in its meta, output that.
				if ( ! empty( $data['_meta']['title'] ) ) {
					echo '<h4 class="kalutara-component__variant-title">' . esc_html( $data['_meta']['title'] ) . '</h4>';

				}
				?>
				<div class="kalutara-component__preview">
					<?php
					get_extended_template_part(
						Kalutara\Helpers\remove_extension_from_filename( $file ),
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
