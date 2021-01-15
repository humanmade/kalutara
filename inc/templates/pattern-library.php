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

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>

	<style>
		.kalutara-component {
			border-bottom: 2px solid #333 !important;
			padding: 0 10px 10px !important;
			background: white !important;
		}
		.kalutara-component:last-child {
			border-bottom: none !important;
		}
		.kalutara-component__header {
			background: #EEE !important;
			padding: 5px 10px !important;
			margin: 0 -10px 10px !important;
			overflow: hidden !important;
		}
		.kalutara-component__summary,
		.kalutara-component__template,
		.kalutara-component__documentation,
		.kalutara-component__variant-title {
			margin: 5px 0 !important;
			padding: 0 !important;
			font-size: 14px !important;
			line-height: 1.4 !important;
			font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, monospace !important;
			color: #333 !important;
		}
		.kalutara-component__summary {
			font-weight: bold !important;
		}
		.kalutara-component__template a,
		.kalutara-component__template a:link {
			color: #333 !important;
			text-decoration: underline !important;
			border: none !important;
		}
		.kalutara-component__template a:hover,
		.kalutara-component__template a:focus {
			color: #e06c75 !important;
			text-decoration: underline !important;
			border: none !important;
		}
		.kalutara-component__documentation {
			clear: both !important;
		}
		.kalutara-component__variant-title {
			margin: 15px 0 !important;
		}
		@media screen and ( min-width: 750px ) {
			.kalutara-component__summary {
				float: left !important;
			}
			.kalutara-component__template {
				float: right !important;
			}
		}
	</style>

</head>
<body>

<?php
foreach ( $directories as $directory ) :
	foreach ( Kalutara\Helpers\get_files_in_path( $directory ) as $file ) :

		$file_path = trailingslashit( $directory ) . $file;
		$file_documentation = Kalutara\Parser\get_template_part_header( $file_path );
		?>
		<article
			id="kalutara-<?php echo sanitize_html_class( Kalutara\Helpers\get_css_class_name( $file ) ); ?>"
			class="kalutara-component kalutara-component--<?php echo sanitize_html_class( Kalutara\Helpers\get_css_class_name( $file ) ); ?>"
		>
			<div class="kalutara-component__header">
				<?php
				if ( ! empty( $file_documentation['summary'] ) ) :
					?>
					<h3 class="kalutara-component__summary">
						<?php echo esc_html( $file_documentation['summary'] ); ?>
					</h3>
					<?php
				endif;
				?>

				<p class="kalutara-component__template">
					<a href="#kalutara-<?php echo sanitize_html_class( Kalutara\Helpers\get_css_class_name( $file ) ); ?>">
						Template: <?php echo esc_html( str_replace( '.php', '', $file ) ); ?>
					</a>
				</p>

				<?php
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

			$variations = ! empty( $file_documentation['data'] ) ? $file_documentation['data'] : [ [] ];

			foreach ( $variations as $data ) :
				// If this data variant has a "title" in its meta, output that.
				if ( ! empty( $data['_meta']['title'] ) ) {
					echo '<h4 class="kalutara-component__variant-title">' . esc_html( $data['_meta']['title'] ) . '</h4>';
				}
				?>
				<div class="kalutara-component__preview">
					<?php
					$template = Kalutara\Helpers\remove_extension_from_filename( $file );
					$is_extended_template_part = apply_filters( 'kalutara_use_extended_template_parts', false, $file );

					if ( $is_extended_template_part ) {
						// Handle extended template parts plugin not enabled.
						if ( ! function_exists( 'get_extended_template_part' ) ) {
							wp_die( 'get_extended_template_part plugin not found.' );
						}

						get_extended_template_part( $template, '', $data );
					} else {
						get_template_part( 'template-parts/' . $template, '', $data );
					}
					?>
				</div>
				<?php
			endforeach;
			?>
		</article>
		<?php
	endforeach;
endforeach;

wp_footer();

?>
