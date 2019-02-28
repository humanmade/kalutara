<?php

namespace Kalutara\Rewrites;

const SLUG      = 'pattern-library';
const QUERY_VAR = 'kalutara';

/**
 * Setup the rewrites.
 *
 * @return void
 */
function setup()  {
	add_action( 'init', __NAMESPACE__ . '\\setup_rewrite_rules' );
	add_filter( 'query_vars', __NAMESPACE__ . '\\setup_query_vars' );
	add_action( 'template_redirect', __NAMESPACE__ . '\\template_redirect' );
}

/**
 * Set up rewrite rules for the pattern library pages.
 *
 * @return void
 */
function setup_rewrite_rules()  {
	add_rewrite_rule( '^' . SLUG . '\/?$', 'index.php?' . QUERY_VAR . '=all', 'top' );
	add_rewrite_rule( '^' . SLUG . '\/(.+)?$', 'index.php?' . QUERY_VAR . '=$matches[1]', 'top' );
}

/**
 * Setup Query Vars.
 *
 * @return void
 */
function setup_query_vars( array $query_vars ) : array {
	$query_vars[] = QUERY_VAR;
	return $query_vars;
}

/**
 * Render the Pattern Library
 */
function template_redirect()  {
	global $wp_query;

	if ( empty( $wp_query->get( QUERY_VAR ) ) ) {
		return;
	}

	require_once __DIR__ . '/templates/pattern-library.php';
	exit;
}
