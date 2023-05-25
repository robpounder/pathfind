<?php

namespace PathFind\Contracts;

use PathFind\Exceptions\InvalidMapException;

interface PathFindContract
{
    public const WALL = false;
    public const SPACE = true;

    /**
     * @return int
     *
     * Happy Path Method for finding the fastest path on the fly providing a map
     */
    public function pathFind(array $map, array $coordinatesFrom, array $coordinatesTo): int;

    /**
     * @throws invalidMapException
     *
     * Sets the map for processing
     */
    public function setMap(array $map): void;

    /**
     * @return int
     *
     * Returns the distance between the 2 coordinates while avoiding walls
     */
    public function pathDistance(array $coordinatesFrom, array $coordinatesTo): int;
}
