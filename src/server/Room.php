<?php

namespace TickTackToe\server;


class Room
{
    /** @var Player */
    private $player;
    private $id;
    private $playerCount = 0;
    private $players;

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
    public function join($resourceId): void
    {
        $this->playerCount++;
        $this->player = new Player($resourceId);
        $this->players[$resourceId] = $this->player;

        if ($this->playerCount === 1) {
            $this->player->setPlayerChar('o');
        } else {
            $this->player->setPlayerChar('x');
        }
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
     * @return int
     */
    public function getPlayerCount(): int
    {
        return (int)$this->playerCount;
    }


    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->getPlayerCount() <= $this->maxPlayerLimit) {
            return true;
        }

        return false;
    }

    /**
     * Returns array of player objects.
     *
     * @return array
     */
    public function getPlayersInRoom(): array
    {
        return $this->players;
    }

    /**
     * Searches in the array if the user already are in the room.
     *
     * @param $resourceId
     * @return bool
     */
    public function findPlayerInRoom($resourceId): bool
    {

        if (!empty($this->players[$resourceId])) {
            return true;
        }

        return false;
    }

}