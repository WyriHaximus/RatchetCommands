<?php
/**
 * All RatchetCommands plugin tests
 */
class AllRatchetCommandsTest extends CakeTestCase {

/**
 * Suite define the tests for this plugin
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All RatchetCommands test');

		$path = CakePlugin::path('RatchetCommands') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
