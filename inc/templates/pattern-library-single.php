<?php
/**
 * Template to display the pattern library.
 *
 * @package Kalutara
 */


$path = get_query_var( Kalutara\Rewrites\QUERY_VAR );
$file = locate_template( 'template-parts/' . $path . '.php' );

if ( ! $file ) {
	wp_die( 'file not found' );
}

$file_documentation = Kalutara\Parser\get_template_part_header( $file );

?>

<!doctype html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php wp_head(); ?>
	</head>

<body>

<main class="kalutara-frame">
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
				<p><code><?php echo esc_html( $path . '.php' ); ?></code><p>
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
				<?php get_template_part( 'template-parts/' . $path, '', $data ); ?>
			</div>
			<?php
		endforeach;
		?>
	</article>
</main>
	<?php wp_footer(); ?>
</body>
