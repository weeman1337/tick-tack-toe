<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use TickTackToe\server\Server;

require dirname(__DIR__) . '/vendor/autoload.php';

$rooms = [
    new \TickTackToe\server\Room(1),
    new \TickTackToe\server\Room(2),
    new \TickTackToe\server\Room(3),
];


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server($rooms)
        )
    ),
    1337
);

$server->run();