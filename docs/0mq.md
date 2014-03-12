0MQ
===

The `ZMQTransport` uses [0MQ](http://zeromq.org/) to send messages to the Ratchet websocket service. 

## Requirements ##

0MQ requires an extra PHP extension to work, details to install it can be found [here](http://zeromq.org/bindings:php).

## Configuration ##

Configuration 0MQ as a transport is simple, first `RatchetCommands.Queue.transporter` has  to be `RatchetCommands.ZMQTransport` and second `RatchetCommands.Queue.configuration.server` has  to be `tcp://127.0.0.1:13001`. (Where `127.0.0.1` is the IP to listen on and `13001` the  port.) In cause of a multi server setup be sure to configure the network correctly so this IP and port can be reached.