<?php

/*
* This file is part of Ratchet for CakePHP.
*
** (c) 2012 - 2013 Cees-Jan Kiewiet
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

App::uses('RatchetQueueCommandListener', 'Ratchet.Event/Queue');
App::uses('RatchetMessageQueueModelUpdateCommand', 'Ratchet.Lib/MessageQueue');

class RatchetQueueCommandPredisListener extends RatchetQueueCommandListener {

/**
 * Eventlistener for the Rachet.WampServer.construct event and
 * waits for incoming commands over he message queue
 *
 * @param CakeEvent $event
 */
	public function construct(CakeEvent $event) {
		$this->_loop = $event->data['loop'];

		$client = new Predis\Async\Client(Configure::read('RatchetCommands.Queue.server'), array(
			'eventloop' => $this->_loop,
		));
		debug($this->_loop);
		$client->connect(function ($client) use ($event) {
			debug($event);
			$client->select(Configure::read('RatchetCommands.Queue.server.database'));
			$client->pubsub(Configure::read('RatchetCommands.Queue.key') . ':main', function ($publishedEvent) use ($event) {
				debug($event);
				$command = unserialize($publishedEvent->payload);
				$client = new Predis\Client(Configure::read('RatchetCommands.Queue.server'));
				$client->publish(Configure::read('RatchetCommands.Queue.key') . ':' . md5($command->getId()), serialize($command->execute($event->subject())));
				$client->disconnect();
			});
		});
	}
}
