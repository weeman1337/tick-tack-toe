<?php

namespace TickTackToe\server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface
{

    protected $clients;
    private $room1;
    private $room2;
    private $room3;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->room1 = new Room(1);
        $this->room2 = new Room(2);
        $this->room3 = new Room(3);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {

        $numRecv = count($this->clients) - 1;
        $data = json_decode($msg);

        $return = '';

        //echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        if (isset($data->roomId)) {
            $from->send('Created room with the id ' . $data->roomId);

        } else {
            $from->send('Please give me a room id!');
        }

        switch ($data->roomId) {
            case 1:
                $return .= $this->joinRoom($this->room1, $from->resourceId);
                break;
            case 2:
                $return .= $this->joinRoom($this->room2, $from->resourceId);
                break;
            case 3:
                $return .= $this->joinRoom($this->room3, $from->resourceId);
                break;
            default:
                $return .= 'Room does not exist.';
        }

        echo $data->roomId;

        $from->send($return);

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
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
     * Checks player count in room and allow or decline a join.
     *
     * @param Room $room
     * @param $resourceId
     * @return string
     */
    private function joinRoom(Room $room, $resourceId): string
    {
        if ($room->getPlayerCount() <= 1) {
            echo "playercount " . $room->getPlayerCount();
            $room->join($resourceId);
            return 'Join to room ' . $room->getId() . ' successfull.';
        } else {
            return 'To much players.';
        }
    }
}