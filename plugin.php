<?php
/**
 * Kalutara Pattern Library plugin for WordPress
 *
 * @package   kalutara
 * @copyright 2019 Human Made
 * @license   GPL v2 or later
 *
 * Plugin Name: Kalutara
 * Plugin URI: https://github.com/humanmade/kalutara
 * Description: A pattern library plugin for WordPress themes.
 * Version: 0.1.0
 * Author: Human Made
 * Author URI: https://humanmade.com
 * Text Domain: hm-kalutara
 * Domain Path: /languages
 * Requires PHP: 7.0
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace Kalutara;

defined( 'ABSPATH' ) || die();

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/inc/data.php';
require_once __DIR__ . '/inc/rewrites.php';
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/parser.php';

Rewrites\setup();
