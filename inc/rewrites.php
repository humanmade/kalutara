<?php

namespace Kalutara\Rewrites;

const SLUG      = 'pattern-library';
const QUERY_VAR = 'kalutara';

/**
 * Setup the rewrites.
 *
 * @return void
 */
function setup() {
	add_action( 'init', __NAMESPACE__ . '\\setup_rewrite_rules' );
	add_filter( 'query_vars', __NAMESPACE__ . '\\setup_query_vars' );
	add_action( 'template_redirect', __NAMESPACE__ . '\\template_redirect' );
}

/**
 * Set up rewrite rules for the pattern library pages.
 *
 * @return void
 */
function setup_rewrite_rules() {
	add_rewrite_rule( '^' . SLUG . '\/?$', 'index.php?' . QUERY_VAR . '=kalutara-all', 'top' );
	add_rewrite_rule( '^' . SLUG . '\/iframe\/?$', 'index.php?' . QUERY_VAR . '=kalutara-iframe', 'top' );
	add_rewrite_rule( '^' . SLUG . '\/(.+)?$', 'index.php?' . QUERY_VAR . '=$matches[1]', 'top' );
}

/**
 * Setup Query Vars.
 *
 * @return array
 */
function setup_query_vars( array $query_vars ) : array {
	$query_vars[] = QUERY_VAR;
	return $query_vars;
}

/**
 * Render the Pattern Library
 */
function template_redirect() {
	$query_var = get_query_var( QUERY_VAR );

	if ( empty( $query_var ) ) {
		return;
	}

	if ( $query_var === 'kalutara-all' ) {
		require_once __DIR__ . '/templates/pattern-library-app.php';
	} elseif ( $query_var === 'kalutara-iframe' ) {
		add_filter( 'show_admin_bar', '__return_false' );
		remove_theme_support( 'admin-bar' );
		require_once __DIR__ . '/templates/pattern-library.php';
	} else {
		add_filter( 'show_admin_bar', '__return_false' );
		remove_theme_support( 'admin-bar' );
		require_once __DIR__ . '/templates/pattern-library-single.php';
	}

	exit;
}
