<?php
/**
 * Helper functions
 *
 * @package kalutara
 */

namespace Kalutara\Helpers;

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
 * @param $file      string Filename, it can include the folder name.
 * @param $extension string Extension (with the dot) to be replaced.
 * @return string Filename without the extension.
 */
function remove_extension_from_filename( $file, $extension = '.php' ) {
	return str_replace( $extension, '', $file );
}

/**
 * Create a string with the specific folder and filename
 * to apply grid sizes in CSS.
 *
 * eg: atoms-buttons, molecules-form, organisms-card
 *
 * @param $file string filename of the component.
 * @return string CSS valid string.
 */
function get_css_class_name( $file ) {
	$file = remove_extension_from_filename( $file );
	return str_replace( '/', '-', $file );
}
