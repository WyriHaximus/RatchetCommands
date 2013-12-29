RatchetCommands
===============

[![Build Status](https://travis-ci.org/WyriHaximus/RatchetCommands.png)](https://travis-ci.org/WyriHaximus/RatchetCommands)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/Ratchet-Commands/v/stable.png)](https://packagist.org/packages/WyriHaximus/Ratchet-Commands)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/Ratchet-Commands/downloads.png)](https://packagist.org/packages/WyriHaximus/Ratchet-Commands)
[![Coverage Status](https://coveralls.io/repos/WyriHaximus/RatchetCommands/badge.png)](https://coveralls.io/r/WyriHaximus/RatchetCommands)
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/WyriHaximus/ratchetcommands/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

RatchetCommands lets your application communicate messages to the Ratchet server instance.

## Getting started ##

#### 1. Requirements ####

This plugin depends on the following plugin and libraries and are pulled in by composer later on:

- [Ratchet](https://github.com/WyriHaximus/Ratchet)

#### 2. Composer ####

Make sure you have [composer](http://getcomposer.org/) installed and configured with the autoloader registering during bootstrap as described [here](http://ceeram.github.io/blog/2013/02/22/using-composer-with-cakephp-2-dot-x/). Make sure you have a composer.json and add the following to your required section.

```json
"wyrihaximus/ratchet-commands": "dev-master"
```

When you've set everything up, run `composer install`.

#### 3. Setup the plugin ####

Make sure you load `RatchetCommands` in your bootstrap and the `Ratchet` plugin is setup properly.

#### 4. Building a command ####

Filename: `Lib/MessageQueue/Command/BroadcastCommand.php`

```php
class BroadcastCommand extends RatchetMessageQueueCommand {

	public function serialize() {
		return serialize(array(
			'data' => $this->data,
		));
	}

	public function unserialize($commandString) {
		$commandString = unserialize($commandString);
		$this->setData($commandString['data']);
	}

	public function setData($data) {
		$this->data = $data;
	}

	public function getData() {
		return $this->data;
	}

	// Send a broadcast on the channel `channel` with the data sent with the command
	// (This runs in the Ratchet instance.)
	public function execute($eventSubject) {
		$topics = $eventSubject->getTopics();
		if (isset($topics['channel'])) {
			$topics['channel']->broadcast($this->getData());
		}

		return true;
	}

	// Handle the response
	// (This runs in the application.)
	public function response($response) {
		if ($response) {
			// Handle success
		} else {
			// Handle failure
		}
	}
}
```

Besure to App::uses the command in your bootstrap so the Ratchet instance knows where to load it from.

#### 5. Sending the message ####

```php
App::uses('TransportProxy', 'RatchetCommands.Lib/MessageQueue/Transports');
$command = new BroadcastCommand();
$command->setData([
	'time' => time(),
]);
TransportProxy::instance()->queueMessage($command);
```

## Plugin License ##

(The MIT License)

Copyright © 2012 - 2013 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the ‘Software’), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED ‘AS IS’, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
