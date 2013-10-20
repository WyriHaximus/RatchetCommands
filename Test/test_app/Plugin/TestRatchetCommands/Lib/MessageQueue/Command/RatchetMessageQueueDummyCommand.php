<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueCommand', 'RatchetCommands.Lib/MessageQueue/Command');

class RatchetMessageQueueDummyCommand extends RatchetMessageQueueCommand {

	protected $_callback;

	public function setCallback($callback) {
		$this->_callback = $callback;
	}

	public function execute($eventSubject) {
		return 1;
	}

	public function response($response) {
		call_user_func($this->_callback, $response);
	}

}
