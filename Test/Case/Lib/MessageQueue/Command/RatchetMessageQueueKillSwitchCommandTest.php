<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueKillSwitchCommand', 'RatchetCommands.Lib/MessageQueue/Command');
App::uses('AbstractCommandTest', 'RatchetCommands.Test/Case/Lib/MessageQueue/Command');

class RatchetMessageQueueKillSwitchCommandTestShell {

	public $txt;

	public function out($txt) {
		$this->txt = $txt;
	}

}

class RatchetMessageQueueKillSwitchCommandTest extends AbstractCommandTest {

/**
 * {@inheritdoc}
 */
	public function setUp() {
		parent::setUp();

		$this->Command = new RatchetMessageQueueKillSwitchCommand();
	}

	public function testExecute() {
		$shell = new RatchetMessageQueueKillSwitchCommandTestShell();
		$this->Command->setShell($shell);
		$eventSubject = parent::testExecute();

		$this->assertTrue($eventSubject->getLoop()->addTimerCalled);
		$this->assertTrue($eventSubject->getLoop()->stopCalled);
		$this->assertSame('<success>Server stopping</success>', $shell->txt);
	}

}
