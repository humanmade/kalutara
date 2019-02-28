<?php
/**
 * PHPDoc parser functionality.
 *
 * Functions used to parse a docblock inside a template part and
 * return the data inside it.
 */

namespace Kalutara\Parser;

use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock;

/**
 * Parse a file header and return the parsed docblock.
 *
 * @param string $file_path Path of file to parse
 * @return [] Parsed DocBlock object if valid
 */
function get_template_part_header( $file ) {
	$template_part = file_get_contents( $file );

	$has_header = preg_match( '#/\*\*(.|[\n\r])*?\*/#m', $template_part, $matches );

	if ( ! $has_header ) {
		return;
	}

	$reflector_factory = DocBlockFactory::createInstance();
	$parsed = $reflector_factory->create( $matches[0] );

	return [
		'summary'        => $parsed->getSummary(),
		'documentation'  => $parsed->getDescription()->render(),
		'template_vars'  => $parsed->getTagsByName( 'var', null, true ),
		'globals'        => $parsed->getTagsByName( 'global', null, true ),
		'data'           => parse_data(
			$parsed->getTagsByName( 'data', null, true )
		),
		'data_providers' => parse_data_providers(
			$parsed->getTagsByName( 'dataProviders', null, true )
		),
	];
}

/**
 * Parse the json data from a @data attribute.
 *
 * @param DocBlock\Tag[] $data Any 'data' entries in the docblock.
 * @return [] Array of decoded data values.
 */
function parse_data( $data ) {
	return array_map(
		function ( $data_entry ) {
			$data_value = $data_entry->getDescription()->render();
			return json_decode( $data_value );
		},
		$data
	);
}

/**
 * Parse the json data providers from a @data attribute.
 *
 * If any data providers are found on the attribute, calls those functions and
 * returns the result.
 *
 * @param DocBlock\Tag[] $data_providers Any 'data_provider' entries in the docblock.
 * @return [] Array of decoded data values.
 */
function parse_data_providers( $data_providers ) {
	$data_provider_values = array_map(
		function ( $data_provider_entry ) {
			$data_provider_func = $data_provider_entry->getDescription()->render();

			return is_callable( $data_provider_func ) ?
				call_user_func( $data_provider_func ) :
				[];
		},
		$data_provider
	);

	return array_filter( $data_providers );
}
