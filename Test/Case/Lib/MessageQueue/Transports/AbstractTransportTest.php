<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueDummyCommand', 'TestRatchetCommands.Lib/MessageQueue/Command');

abstract class AbstractTransportTest extends CakeTestCase {

/**
 * {@inheritdoc}
 */
	public function setUp() {
		parent::setUp();

		$this->_pluginPath = App::pluginPath('RatchetCommands');
		App::build(array(
			'Plugin' => array($this->_pluginPath . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS )
		));
		CakePlugin::load('TestRatchetCommands');

		$this->loop = React\EventLoop\Factory::create();

		$event = new CakeEvent('Rachet.WampServer.construct', $this, array(
			'loop' => $this->loop,
		));
		CakeEventManager::instance()->dispatch($event);
	}

/**
 * {@inheritdoc}
 */
	public function tearDown() {
		unset($this->Transport);
		CakePlugin::unload('TestRatchetCommands');

		parent::tearDown();
	}

	public function testQueueMessage() {
		$this->markTestSkipped(
			'Test not done yet, needs more work as it is hanging during execution and times out after a minute'
		);
		$this->assertEqual(true, true);
		$command = new RatchetMessageQueueDummyCommand();
		$command->setCallback(array($this, 'dummyCommandAssertResponse'));

		$that = $this;

		$this->loop->addTimer(0.5, function() use ($that, $command) {
			$that->Transport->queueMessage($command);
		});

		$this->loop->addTimer(5, function() use ($that) {
			$that->loop->stop();
		});

		$this->loop->run();
	}

	public function dummyCommandAssertResponse($response) {
		debug($response);
		$this->assertEqual($response, 1);
	}

}
