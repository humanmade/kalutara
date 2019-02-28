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

$files = [];
foreach ( $directories as $directory ) {
	$files = Helpers\get_files_in_path( $directory );
}

\get_header();

?>
<main class="kalutara-viewport">
	<?php
	foreach ( $files as $file ) :

		$file_path = trailingslashit( $directory ) . $file;
		$file_documentation = Parser\get_template_part_header( $file_path );
		?>
		<article
			class="kalutara-component <?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>"
			id="<?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>"
		>
			<h2><?php echo esc_html( $file ); ?></h2>
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
	<?php endforeach; ?>
</main>

<nav class="kalutara-sidebar">
	<ul>
		<?php foreach ( $files as $file ) : ?>
			<li class="kalutara-sidebar__item">
				<a href="#<?php echo esc_attr( Helpers\get_css_class_name( $file ) ); ?>" class="kalutara-sidebar__link">
					<?php echo esc_html( $file ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<aside class="kalutara-docbox">
	<em>Documentation will live here</em>
</aside>

<?php

\get_footer();
