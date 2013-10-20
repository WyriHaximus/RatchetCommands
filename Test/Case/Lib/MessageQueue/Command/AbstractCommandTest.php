<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('TransportProxy', 'RatchetCommands.Lib/MessageQueue/Transports');
App::uses('CakeRatchetCommandsTestCase', 'RatchetCommands.Test/Case');
App::uses('CakeEvent', 'Event');
App::uses('CakeEventManager', 'Event');

abstract class AbstractCommandTest extends CakeRatchetCommandsTestCase {

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

		Configure::write('RatchetCommands.Queue', array(
			'transporter' => 'TestRatchetCommands.DummyTransport',
			'configuration' => array(
				'server' => 'tcp://127.0.0.1:13001',
			),
		));

		$this->TransportProxy = TransportProxy::instance();
	}

/**
 * {@inheritdoc}
 */
	public function tearDown() {
		unset($this->TransportProxy);
		unset($this->Command);

		CakePlugin::unload('TestRatchetCommands');

		parent::tearDown();
	}

	public function testImplementation() {
		$classImplements = class_implements($this->Command);
		$this->assertTrue(isset($classImplements['RatchetMessageQueueCommandInterface']));
		$this->assertTrue(isset($classImplements['Serializable']));
	}

	public function testExtending() {
		$classImplements = class_parents($this->Command);
		$this->assertTrue(isset($classImplements['RatchetMessageQueueCommand']));
	}

	public function testExecute() {
		$eventSubject = new DummyTransportEventSubjectTestImposer(array(), array());
		$this->TransportProxy->getTransport()->setEventSubject($eventSubject);
		$this->TransportProxy->queueMessage($this->Command);
		return $eventSubject;
	}

}
