<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;
use TickTackToe\server\Server;

require dirname(__DIR__) . '/vendor/autoload.php';

define('ENVIRONMENT', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .'.env'));

$rooms = [
    new \TickTackToe\server\Room(1),
    new \TickTackToe\server\Room(2),
    new \TickTackToe\server\Room(3),
];

if (ENVIRONMENT == 'dev') {

    $cloner = new VarCloner();
    $fallbackDumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();
    $dumper = new ServerDumper(
        'tcp://127.0.0.1:9912', $fallbackDumper, [
            'cli'    => new CliContextProvider(),
            'source' => new SourceContextProvider(),
        ]
    );

    VarDumper::setHandler(
        function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        }
    );

}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server($rooms)
        )
    ),
    1337
);

$server->run();