<?php

use DI\Container;
use Cabp\ResourceList\CABP_Resource_List_Loader;
use Cabp\ResourceList\CABP_Resource_List_i18n;
use Cabp\ResourceList\_Public\CABP_Resource_List_Public;
use Cabp\ResourceList\Admin\CABP_Resource_List_Admin;

return [
	'plugin.name' => 'CABP Resource List',
	'plugin.slug' => 'cabp-resource-list',
	'plugin.version' => '1.0',
	CABP_Resource_List_Loader::class => function () {
		return new CABP_Resource_List_Loader();
	},
	CABP_Resource_List_i18n::class => function () {
		return new CABP_Resource_List_i18n();
	},
	CABP_Resource_List_Admin::class => function (Container $container) {
		return new CABP_Resource_List_Admin($container->get('plugin.name'), $container->get('plugin.version'));
	},
	CABP_Resource_List_Public::class => function (Container $container) {
		return new CABP_Resource_List_Public($container->get('plugin.slug'), $container->get('plugin.version'));
	},
];
