<?php
/**
 * Pattern Library Data.
 *
 * By default, the Pattern Library will automatically pull in any file in the
 * template-parts folder and display it. This file allows us to set specific
 * data and manage variants of the component.
 */

namespace Kalutara\Data;

use Kalutara\Parser;

/**
 * Get data.
 *
 * @param  string $file File name to fetch dummy data for.
 * @return array Dummy data to pass to the variants.
 */
function get_data( $file ) {
	$file_documentation = Parser\get_template_part_header( $file );

	return array_merge(
		$file_documentation['data'],
		$file_documentation['data_providers']
	);
}

/**
 * Get a value from the _meta array in a template data object.
 *
 * @param string $value Key of a meta key to retrieve.
 * @return mixed Value of the meta key specified.
 */
function get_meta_value( $file, $value ) {
	$data = get_data( $file );

	return $data['_meta'][ $value ] ?? null;
}
