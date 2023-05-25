<?php

namespace PathFind;

use PathFind\Contracts\CoordinateValidatorContract;
use PathFind\Contracts\MapValidatorContract;
use PathFind\Contracts\PathFindContract;
use PathFind\Exceptions\InvalidCoordinateException;
use PathFind\Exceptions\InvalidMapException;
use PathFind\Exceptions\InvalidPathException;
use PathFind\Validation\CoordinateValidator;
use PathFind\Validation\MapValidator;

class PathFind implements PathFindContract
{
    private array $map = [];
    public const DIRECTIONS = [
        'UP' => [-1, 0],
        'DOWN' => [1, 0],
        'LEFT' => [0, -1],
        'RIGHT' => [0, 1],
    ];
    private int $rows;
    private int $cols;

    private MapValidatorContract $mapValidator;
    private CoordinateValidatorContract $coordinateValidator;

    public function __construct()
    {
        $this->mapValidator = new MapValidator();
        $this->coordinateValidator = new CoordinateValidator();
    }

    /**
     * @throws InvalidCoordinateException
     * @throws InvalidMapException
     * @throws InvalidPathException
     */
    public function pathFind(array $map, array $coordinatesFrom, array $coordinatesTo): int
    {
        if (!$this->mapValidator->validateMap($map)) {
            throw new InvalidMapException('Invalid Map');
        }

        $this->setMap($map);

        if (!($this->coordinateValidator->validateCoordinates($coordinatesFrom, $this->rows, $this->cols)
            && $this->coordinateValidator->validateCoordinates($coordinatesTo, $this->rows, $this->cols))) {
            throw new InvalidCoordinateException('Invalid Coordinates');
        }

        return $this->pathDistance($coordinatesFrom, $coordinatesTo);
    }

    public function setMap(array $map): void
    {
        $this->map = $map;
        $this->rows = count($this->map);
        $this->cols = count($this->map[0]);
    }

    /**
     * @throws InvalidPathException
     */
    public function pathDistance(array $coordinatesFrom, array $coordinatesTo): int
    {
        $processQueue = [$coordinatesFrom];
        $previous = [];
        $distances = [];

        $previous[$coordinatesFrom[0]][$coordinatesFrom[1]] = 1;
        $distances[$coordinatesFrom[0]][$coordinatesFrom[1]] = 0;

        while (!empty($processQueue)) {
            $current = array_shift($processQueue);
            $currentRow = $current[0];
            $currentColumn = $current[1];

            if ($currentRow === $coordinatesTo[0] && $currentColumn === $coordinatesTo[1]) {
                return $distances[$currentRow][$currentColumn];
            }

            foreach (self::DIRECTIONS as $direction) {
                $newRow = $currentRow + $direction[0];
                $newColumn = $currentColumn + $direction[1];

                if (
                    $this->coordinateValidator->validateCoordinate($newRow, $this->rows)
                    && $this->coordinateValidator->validateCoordinate($newColumn, $this->cols)
                    && isset($this->map[$newRow][$newColumn])
                    && PathFindContract::SPACE === $this->map[$newRow][$newColumn]
                    && !isset($previous[$newRow][$newColumn])
                ) {
                    $distances[$newRow][$newColumn] = $distances[$currentRow][$currentColumn] + 1;
                    $previous[$newRow][$newColumn] = 1;
                    $processQueue[] = [$newRow, $newColumn];
                }
            }
        }

        throw new InvalidPathException('A valid path was not found');
    }
}
