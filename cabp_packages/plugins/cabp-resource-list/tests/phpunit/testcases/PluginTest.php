<?php

namespace PluginTest\Cabp;

use \Cabp\ResourceList\CABP_Resource_List_Activator;
//use \Plugin\Stuff\SomeClass;
use \Brain\Monkey\Functions;

class ResourceList extends \PluginTestCase {
	public function testActivate() {
		( new CABP_Resource_List_Activator() )::activate();

		// We expect flush_rewrite_rules to be called once
		$expectation = Functions\expect( 'flush_rewrite_rules' )
			->once()
			->andReturnFirstArg();

		var_dump($expectation);
	}
}
