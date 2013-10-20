<?php

/*
* This file is part of Ratchet for CakePHP.
*
** (c) 2012 - 2013 Cees-Jan Kiewiet
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

App::uses('RatchetMessageQueueTransportInterface', 'RatchetCommands.Lib/MessageQueue/Interfaces');

class PredisTransport implements RatchetMessageQueueTransportInterface {

/**
 * Contains all the server connection configuration
 *
 * @var array
 */
	private $__serverConfiguration;

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
		$this->__serverConfiguration = $serverConfiguration;
		$this->__serverConnection = new Predis\Client($this->__serverConfiguration['server']);
	}

/**
 * {@inheritdoc}
 */
	public function queueMessage(RatchetMessageQueueCommand $command) {
		$client = new Predis\Client($this->__serverConfiguration['server']);
		$pubsub = $client->pubSub();
		$pubsub->subscribe($this->__serverConfiguration['key'] . ':' . md5($command->getId()));
		$pubsub->current();
		$this->__serverConnection->publish($this->__serverConfiguration['key'] . ':main', serialize($command));
		$command->response(unserialize($pubsub->current()->payload));
		$client->disconnect();
	}
}
