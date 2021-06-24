<?php

// define test environment
define( 'CABP_RESOURCE_LIST_PHPUNIT', true );

// define fake ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() );
}
// define fake CABP_RESOURCE_LIST_ABSPATH
if ( ! defined( 'CABP_RESOURCE_LIST_ABSPATH' ) ) {
	define( 'CABP_RESOURCE_LIST_ABSPATH', sys_get_temp_dir() . '/wp-content/plugins/cabp-resource-list/' );
}

require_once __DIR__ . '/../../vendor/autoload.php';

// Include the class for PluginTestCase
require_once __DIR__ . '/inc/PluginTestCase.php';
