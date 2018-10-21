<?php

namespace TickTackToe\server;


class Room
{
    private $player;
    private $id;
    private $playerCount;

    private $maxPlayerLimit = 2;

    /**
     * Room constructor.
     * @param $roomId
     *
     * @return void
     */
    public function __construct($roomId)
    {
        $this->id = $roomId;
    }

    /**
     * Join room and count player.
     *
     * @param $player
     *
     * @return void
     */
    public function join($player): void
    {
        $this->playerCount++;
        $this->player = $player;
    }

    /**
     * Returns and player resource id.
     *
     * @return mixed
     */
    public function getPlayer(): int
    {
        return $this->player;
    }

    /**
     * Returns the room id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return the current connected players.
     *
     * @return mixed
     */
    public function getPlayerCount(): int
    {
        return $this->playerCount;
    }


    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->getPlayerCount() < $this->maxPlayerLimit) {
            return true;
        }

        return false;
    }

}