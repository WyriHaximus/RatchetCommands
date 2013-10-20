<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueCommandInterface', 'RatchetCommands.Lib/MessageQueue/Interfaces');

abstract class RatchetMessageQueueCommand implements RatchetMessageQueueCommandInterface, Serializable {

	protected $_id;

	public function __construct() {
		$this->_id = uniqid('', true);
	}

	public function serialize() {
		return serialize(array(
			'id' => $this->_id,
		));
	}

	public function getId() {
		return $this->_id;
	}

	public function unserialize($commandString) {
		$commandString = unserialize($commandString);
		$this->_id = $commandString['id'];
	}

/**
 * @param $topics
 * @throws Exeception
 */
	public function execute($topics) {
		throw new Exeception('Must override execute method!');
	}

}
