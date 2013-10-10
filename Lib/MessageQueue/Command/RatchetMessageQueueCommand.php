<?php

/*
 * This file is part of Ratchet for CakePHP.
 *
 ** (c) 2012 - 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueCommandInterface', 'RatchetCommands.Lib/MessageQueue/Interfaces');

abstract class RatchetMessageQueueCommand implements RatchetMessageQueueCommandInterface, Serializable  {
    
    protected $id;
    
    public function __construct() {
        $this->id = uniqid('', true);
    }
    
    public function serialize() {
        return serialize(array(
            'id' => $this->id,
        ));
    }
    public function getId() {
        return $this->id;
    }
    public function unserialize($commandString) {
        $commandString = unserialize($commandString);
        $this->id = $commandString['id'];
    }
    public function execute($topics) {
        throw new Exeception('Must override execute method!');
    }
    
}