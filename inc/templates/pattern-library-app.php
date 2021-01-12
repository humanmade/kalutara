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
		<link href="<?php echo esc_url( plugins_url( '/assets/style.css', dirname( __DIR__ ) ) ); ?>" rel="stylesheet" />
	</head>

	<body>

<div class="kalutara">
	<main class="kalutara-viewport">
		<iframe src="<?php echo esc_url( home_url( 'pattern-library/iframe' ) ); ?>"></iframe>
	</main>

	<nav class="kalutara-sidebar">
		<ul>
			<?php foreach ( $files as $file ) : ?>
				<li class="kalutara-sidebar__item">
					<a
						href="#<?php echo esc_attr( Kalutara\Helpers\get_css_class_name( $file ) ); ?>"
						class="kalutara-sidebar__link"
					>
						<?php echo esc_html( $file ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>

</body>
