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
		'name'           => $parsed->getSummary(),
		'documentation'  => $parsed->getDescription(),
		'template_vars'  => $parsed->getTagsByName( 'var', null, true ),
		'globals'        => $parsed->getTagsByName( 'global', null, true ),
		'data'           => $parsed->getTagsByName( 'data', null, true ),
		'data_providers' => $parsed->getTagsByName( 'dataProviders', null, true ),
	];
}

