<?php

namespace TickTackToe\server;


class Player
{

    private $resourceId;
    private $playerChar;

    public function __construct($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    public function getPlayerChar() {
        return $this->playerChar;
    }

    public function setPlayerChar(string $playerChar) {
        $this->playerChar = $playerChar;
    }

}