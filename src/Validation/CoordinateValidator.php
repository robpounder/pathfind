<?php

namespace PathFind\Validation;

use PathFind\Contracts\CoordinateValidatorContract;

class CoordinateValidator implements CoordinateValidatorContract
{
    public function validateCoordinates(array $coordinates, int $rows, int $columns): bool
    {
        if (2 !== count($coordinates)) {
            return false;
        }

        $x = $coordinates[0];
        $y = $coordinates[1];

        return $this->validateCoordinate($x, $columns) && $this->validateCoordinate($y, $rows);
    }

    public function validateCoordinate(int $coordinate, int $limit): bool
    {
        return $coordinate >= 0 && $coordinate < $limit;
    }
}
