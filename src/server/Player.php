<?php

namespace TickTackToe\server;


class Player
{

    private $resourceId;
    private $playerChar;

    /**
     * Player constructor.
     *
     * @param $resourceId
     */
    public function __construct($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    /**
     * Returns the character of the player (x/o)
     *
     * @return string
     */
    public function getPlayerChar(): string {
        return $this->playerChar;
    }

    /**
     * Sets the character for the player
     *
     * @param string $playerChar
     */
    public function setPlayerChar(string $playerChar): void {
        $this->playerChar = $playerChar;
    }

}