<?php
/**
 * Pattern Library Data.
 *
 * By default, the Pattern Library will automatically pull in any file in the
 * template-parts folder and display it. This file allows us to set specific
 * data and manage variants of the component.
 */

namespace Kalutara\Data;

/**
 * Get dummy data.
 *
 * @param  string $file File name to fetch dummy data for.
 * @return array Dummy data to pass to the variants.
 */
function get_dummy_data( $file ) {
	return [
		'foo' => __( 'Foo', 'hm-kalutara' ),
		'bar' => __( 'Bar', 'hm-kalutara' ),
	];
}
