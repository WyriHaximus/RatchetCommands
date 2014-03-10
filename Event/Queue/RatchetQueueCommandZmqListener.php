<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetQueueCommandListener', 'RatchetCommands.Event/Queue');
App::uses('RatchetMessageQueueModelUpdateCommand', 'RatchetCommands.Lib/MessageQueue');

class RatchetQueueCommandZmqListener extends RatchetQueueCommandListener {

/**
 * Eventlistener for the Rachet.WampServer.construct event and
 * waits for incoming commands over he message queue
 *
 * @param CakeEvent $event
 */
	public function construct(CakeEvent $event) {
		$this->_loop = $event->data['loop'];

		$context = new \React\ZMQ\Context($this->_loop);
		$socket = $context->getSocket(ZMQ::SOCKET_REP);
		$socket->bind(Configure::read('RatchetCommands.Queue.configuration.server'));
		$socket->on('message', function($message) use ($event, $socket) {
			$command = unserialize($message);
			$socket->send(serialize($command->execute($event->subject())));
		});
	}
}
