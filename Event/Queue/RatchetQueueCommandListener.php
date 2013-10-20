<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('CakeEventListener', 'Event');

abstract class RatchetQueueCommandListener implements CakeEventListener {

/**
 * The main eventloop
 *
 * @var \React\EventLoop\LoopInterface
 */
	protected $_loop;

/**
 * Returns the event all classes extending this abstract class will listen on
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Rachet.WampServer.construct' => 'construct',
		);
	}

}
