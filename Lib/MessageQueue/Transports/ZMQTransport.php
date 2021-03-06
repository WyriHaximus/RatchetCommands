<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueTransportInterface', 'RatchetCommands.Lib/MessageQueue/Interfaces');

class ZMQTransport implements RatchetMessageQueueTransportInterface {

/**
 * Contains the server connection
 *
 * @var array
 */
	private $__serverConnection;

/**
 * {@inheritdoc}
 */
	public function __construct($serverConfiguration) {
		$zmq = new ZMQContext(1);
		$this->__serverConnection = $zmq->getSocket(ZMQ::SOCKET_REQ);
		$this->__serverConnection->connect($serverConfiguration['server']);
	}

/**
 * {@inheritdoc}
 */
	public function queueMessage(RatchetMessageQueueCommand $command) {
		$this->__serverConnection->send(serialize($command));
		$command->response(unserialize($this->__serverConnection->recv()));
	}
}
