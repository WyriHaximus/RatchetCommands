<?php

/*
 * This file is part of Ratchet for CakePHP.
 *
 ** (c) 2012 - 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('RatchetMessageQueueCommand', 'RatchetCommands.Lib/MessageQueue/Command');

class RatchetMessageQueueKillSwitchCommand extends RatchetMessageQueueCommand {
    
    public function setShell($shell) {
        $this->shell = $shell;
    }
    
    public function execute($eventSubject) {
        $eventSubject->getLoop()->addTimer(.5, function() use ($eventSubject) {
            $eventSubject->getLoop()->stop();
        });
        
        return true;
    }
    
    public function response($response) {
        if ($response) {
            $this->shell->out('<success>Server stopping</success>');
        } else {
            $this->shell->out('<error>Server not stopping</error>');
        }
    }
}