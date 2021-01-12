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

$files = [];
foreach ( $directories as $directory ) {
	$files = Kalutara\Helpers\get_files_in_path( $directory );
}

?>

<!doctype html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php wp_head(); ?>

	<style>
		.kalutara-component {
			padding: 0 20px;
			border-bottom: 1px solid black;
		}

		.kalutara-component__header {
			background: #EEE;
			margin-left: -20px;
			margin-right: -20px;
			padding: 20px;
		}

		.kalutara-component__header h3 {
			margin: 0 !important;
		}
	</style>

	</head>

<body>

<main class="kalutara-frame">

	<?php
	foreach ( $files as $file ) :
		$file_path = trailingslashit( $directory ) . $file;
		$file_documentation = Kalutara\Parser\get_template_part_header( $file_path );
		?>
		<article
			id="<?php echo esc_attr( Kalutara\Helpers\get_css_class_name( $file ) ); ?>"
			class="kalutara-component kalutara-component--<?php echo sanitize_html_class( Kalutara\Helpers\get_css_class_name( $file ) ); ?>"
		>
			<div class="kalutara-component__header">
			<?php

			if ( ! empty( $file_documentation['summary'] ) ) :
				?>
					<h3 class="kalutara-component__summary">
						<?php echo esc_html( $file_documentation['summary'] ); ?>
					</h3>
					<p><code><?php echo esc_html( $file ); ?></code><p>
				<?php
			else :
				?>
					<h3 class="kalutara-component__summary">
						<?php echo esc_html( $file ); ?>
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

			</div>

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
					get_template_part(
						'template-parts/' . Kalutara\Helpers\remove_extension_from_filename( $file ),
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
	?>
</main>
	<?php wp_footer(); ?>
</body>
