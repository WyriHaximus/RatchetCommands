<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Configuration
 */
Configure::write('RatchetCommands', [
    'Queue' => [
        'transporter' => 'RatchetCommands.ZMQTransport',
        'configuration' => [
            'server' => 'tcp://127.0.0.1:13001',
        ],
    ],
]);

App::uses('CakeEventManager', 'Event');

App::uses('RatchetQueueCommandZmqListener', 'RatchetCommands.Event/Queue');
CakeEventManager::instance()->attach(new RatchetQueueCommandZmqListener());
