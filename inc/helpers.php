<?php
/**
 * Helper functions
 *
 * @package kalutara
 */

namespace Kalutara\Helpers;

use const Kalutara\Rewrites\QUERY_VAR;

/**
 * Get all files within a supplied directory and subdirectories.
 *
 * @param string $dir The directory to scan.
 * @return array An array of file paths contained within the supplied directory.
 */
function get_files_in_path( $dir ) {
	$result = [];

	foreach ( scandir( $dir ) as $filename ) {
		if ( $filename[0] === '.' ) {
			continue;
		}

		$file_path = $dir . '/' . $filename;
		if ( is_dir( $file_path ) ) {
			foreach ( get_files_in_path( $file_path ) as $child_file_name ) {
				$result[] = $filename . '/' . $child_file_name;
			}
		} else {
			$result[] = $filename;
		}
	}

	return $result;
}

/**
 * Remove the '.php' from a filename string
 *
 * @param string $file      Filename, it can include the folder name.
 * @param string $extension Extension (with the dot) to be replaced.
 * @return string Filename without the extension.
 */
function remove_extension_from_filename( $file, $extension = '.php' ) {
	return str_replace( $extension, '', $file );
}

/**
 * Create a string with the specific folder and filename
 * to apply grid sizes in CSS.
 *
 * For example: atoms-buttons, molecules-form, organisms-card
 *
 * @param string $file filename of the component.
 * @return string CSS valid string.
 */
function get_css_class_name( $file ) {
	$file = remove_extension_from_filename( $file );
	return str_replace( '/', '-', $file );
}

function get_template_dirs() {
	$directories[] = get_template_directory() . '/template-parts';

	if ( is_child_theme() ) {
		$directories[] = get_stylesheet_directory() . '/template-parts';
	}

	return $directories;
}

function get_all_templates() {
	$templates = [];
	$directories = get_template_dirs();

	foreach ( $directories as $directory ) {
		// Convert files in path to template paths.
		$templates = array_merge( $templates, array_map(
			'\Kalutara\Helpers\remove_extension_from_filename',
			get_files_in_path( $directory )
		) );
	}

	$templates = array_unique( $templates );

	return $templates;
}

function generate_backstop_scenarios() {
	$templates = get_all_templates();
	foreach ( $templates as $template ) {
		$file_path = locate_template( 'template-parts/' . $template . '.php' );
		$file_docs = \Kalutara\Parser\get_template_part_header( $file_path );

		$backstop_data[] = [
			'label' => ! empty( $file_docs['summary'] ) ? $file_docs['summary'] : $template,
			'url' => home_url( QUERY_VAR . '/' . $template ),
		];
	}

	echo wp_json_encode( $backstop_data );
}
