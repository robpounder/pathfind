<?php

namespace PathFind\Contracts;

interface PathFindValidatorContract
{
    public function validateMap(array $map): bool;

    public function validateCoordinates(array $coordinates, array $map): bool;

    public function validateCell($x, $y, $rows, $cols): bool;
}
