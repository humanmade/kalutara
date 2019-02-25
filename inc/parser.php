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

	if ( ! $template_part ) {
		return;
	}

	$reflector_factory = DocBlockFactory::createInstance();
	$parsed = $reflector_factory->create( $template_part );

	return [
		'name'           => $parsed->getSummary(),
		'documentation'  => $parsed->getDescription(),
		'template_vars'  => $parsed->getTags( 'var', null, true ),
		'globals'        => $parsed->getTags( 'global', null, true ),
		'data'           => $parsed->getTags( 'data', null, true ),
		'data_providers' => $parsed->getTags( 'dataProviders', null, true ),
	];
}

