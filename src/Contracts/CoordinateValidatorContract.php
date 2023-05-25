<?php

namespace PathFind\Contracts;

interface CoordinateValidatorContract
{
    public function validateCoordinates(array $coordinates, int $rows, int $columns): bool;

    public function validateCoordinate(int $coordinate, int $limit): bool;
}
