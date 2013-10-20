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

class TransportProxy implements RatchetMessageQueueTransportInterface {

/**
 * Singleton self reference trick
 * @var TransportProxy
 */
	protected static $_generalMessageQueueProxy = null;

/**
 *
 * @var RatchetMessageQueueTransportInterface
 */
	private $__transport;

/**
 * Construct the proxy
 *
 * @param array $serverConfiguration
 */
	public function __construct($serverConfiguration) {
		list($plugin, $transporter) = pluginSplit(Configure::read('RatchetCommands.Queue.transporter'), true);
		App::uses($transporter, $plugin . 'Lib/MessageQueue/Transports');
		$this->__transport = new $transporter($serverConfiguration);
	}

/**
 * Singleton constructor
 *
 * @return TransportProxy
 */
	public static function instance() {
		if (empty(self::$_generalMessageQueueProxy)) {
			self::$_generalMessageQueueProxy = new TransportProxy(Configure::read('RatchetCommands.Queue.configuration'));
		}

		return self::$_generalMessageQueueProxy;
	}

/**
 * {@inheritdoc}
 */
	public function queueMessage(RatchetMessageQueueCommand $command) {
		$this->__transport->queueMessage($command);
	}

/**
 * Return the used transporter
 *
 * @return RatchetMessageQueueTransportInterface
 */
	public function getTransport() {
		return $this->__transport;
	}
}
