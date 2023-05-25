<?php

namespace PathFind;

use PathFind\Contracts\PathFindContract;
use PathFind\Contracts\PathFindValidatorContract;
use PathFind\Exceptions\InvalidCoordinateException;
use PathFind\Exceptions\InvalidMapException;
use PathFind\Exceptions\InvalidPathException;
use PathFind\Validation\PathFindValidator;

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

    private PathFindValidatorContract $validator;

    public function __construct()
    {
        $this->validator = new PathFindValidator();
    }

    /**
     * @throws InvalidCoordinateException
     * @throws InvalidMapException
     * @throws InvalidPathException
     */
    public function pathFind(array $map, array $coordinatesFrom, array $coordinatesTo): int
    {
        if (!$this->validator->validateMap($map)) {
            throw new InvalidMapException('Invalid Map');
        }

        $this->setMap($map);

        if (!($this->validator->validateCoordinates($coordinatesFrom, $this->map)
            && $this->validator->validateCoordinates($coordinatesTo, $this->map))) {
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
                    $this->validator->validateCell($newRow, $newColumn, $this->rows, $this->cols)
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
