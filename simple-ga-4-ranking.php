<?php
/*
Plugin Name: Simple GA 4 Ranking (prefixed namespaces and classnames)
Plugin URI: https://digitalcube.jp
Description: Ranking plugin using data from google analytics.
Author: sect
Author URI: https://github.com/sectsect
Version: 0.0.4
Domain Path: /languages
Text Domain: sga4ranking
Tested up to: 6.2
Requires at least: 5.9
Requires PHP:　7.4

Copyright 2018 - 2022 digitalcube (email : info@digitalcube.jp)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) die();

load_plugin_textdomain(
	'sga4ranking',
	 false,
	 dirname( plugin_basename( __FILE__ ) ) . '/languages'
);

register_activation_hook(
	__FILE__,
	'sga4ranking_activation_hook'
);

function sga4ranking_activation_hook() {
	require_once __DIR__ . '/sga_ranking_migration.php';
	sga_ranking_migration();
}

if ( ! shortcode_exists( 'sga_ranking' ) ) :
	if ( is_readable( __DIR__ . '/vendor-prefixed/autoload.php' ) ) {
		require_once __DIR__ . '/vendor-prefixed/autoload.php';
	}
	require_once 'loader.php';
	if ( false === class_exists( 'digitalcube\SimpleGA4Ranking\Core' ) ) {
		require_once __DIR__  . '/includes/Core.php';
		require_once __DIR__  . '/includes/Analytics.php';
		require_once __DIR__  . '/includes/Admin/OAuth/Admin.php';
		require_once __DIR__  . '/includes/Admin/OAuth/Auth.php';
		require_once __DIR__  . '/includes/Admin/OAuth/View.php';
		require_once __DIR__  . '/includes/Admin/Options/Admin.php';
		require_once __DIR__  . '/includes/Admin/Options/View.php';
	}
	if ( class_exists( 'digitalcube\SimpleGA4Ranking\Core' ) ) {
		$core = new \digitalcube\SimpleGA4Ranking\Core();
		$core->register_hooks();
	}
endif;
