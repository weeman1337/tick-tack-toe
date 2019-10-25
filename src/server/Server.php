<?php

namespace TickTackToe\server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface
{

    protected $clients;

    private $rooms;

    /**
     * Server constructor.
     * @param Room[] $rooms
     */
    public function __construct(array $rooms)
    {
        $this->clients = new \SplObjectStorage;
        $this->rooms = $rooms;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo 'New connection! (' . $conn->resourceId . ')';
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {

        if ($this->joinRoom($from->resourceId) === false) {
            $from->send('No available rooms');
            return;
        }

        $from->send('Found room!');

        /*foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }*/
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    /**
     * Connect a new user to a room.
     *
     * @param $resourceId
     * @return bool
     */
    private function joinRoom($resourceId): bool
    {
        foreach ($this->rooms as $room) {

            if ($room->findPlayerInRoom($resourceId)) {
                return false;
            }

            echo '[Room][' . $room->getId() . '] Trying to join';

            if ($room->isAvailable()) {
                $room->join($resourceId);
                return true;
            }

            echo '[Room][' . $room->getId() . '] Room is full';

        }

        return false;

    }
}