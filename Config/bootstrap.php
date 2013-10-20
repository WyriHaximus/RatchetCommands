<?php

/*
* This file is part of Ratchet for CakePHP.
*
** (c) 2012 - 2013 Cees-Jan Kiewiet
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


/**
 * Configuration
 */
Configure::write('RatchetCommands', array(
	'Queue' => array(
		'transporter' => 'RatchetCommands.ZMQTransport',
		'configuration' => array(
			'server' => 'tcp://127.0.0.1:13001',
		),
	),
));

App::uses('CakeEventManager', 'Event');

App::uses('RatchetQueueCommandZmqListener', 'Ratchet.Event/Queue');
CakeEventManager::instance()->attach(new RatchetQueueCommandZmqListener());
