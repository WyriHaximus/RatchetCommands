<?php

/**
 * This file is part of RatchetCommands for CakePHP.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('PredisTransport', 'RatchetCommands.Lib/MessageQueue/Transports');

class PredisTranportTest extends AbstractTransportTest {

/**
 * {@inheritdoc}
 */
	public function setUp() {
		parent::setUp();

		Configure::write('Ratchet', array(
			'Queue' => array(
				'transporter' => 'Ratchet.PredisTransport',
				'key' => 'test_reddis_opuapugfoyiufgiawe',
				'server' => array(
					'scheme' => 'tcp',
					'host' => '127.0.0.1',
					'port' => 6379,
					'database' => 12,
				),
			),
		));

		$this->Transport = new PredisTransport(Configure::read('RatchetCommands.Queue'));
	}

}
