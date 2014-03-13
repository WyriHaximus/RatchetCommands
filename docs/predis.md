Predis
======

The `PredisTransport` uses [Predis](https://github.com/nrk/predis/wiki) and [PredisAsync](https://github.com/nrk/predis-async) to send messages to the Ratchet websocket service over [redis](http://redis.io). 

## Requirements ##

Predis requires an extra PHP extension to work, details to install it can be found [here](https://github.com/nrk/phpiredis#installation).

## Configuration ##

Configuration `Predis` as a transport is simple, first `RatchetCommands.Queue.transporter` has  to be `RatchetCommands.PredisTransport` and second `RatchetCommands.Queue.configuration.server` has  to be any config compatible with [new \Predis\Client](https://github.com/nrk/predis/wiki/Connection-Parameters).