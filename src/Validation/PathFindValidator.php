<?php

namespace PathFind\Validation;

use PathFind\Contracts\PathFindContract;
use PathFind\Contracts\PathFindValidatorContract;

class PathFindValidator implements PathFindValidatorContract
{
    public function validateMap(array $map): bool
    {
        $i = 0;
        foreach ($map as $row) {
            /* this checks the row contains values */
            if (!is_array($row)) {
                return false;
            }

            /* this checks the rows all have the same amount of columns */
            if (isset($columns) && $columns !== count($row)) {
                return false;
            } else {
                $columns = count($row);
            }

            /* this checks every value is a boolean */
            foreach ($row as $item) {
                if (!in_array($item, [PathFindContract::WALL, PathFindContract::SPACE])) {
                    return false;
                }
            }

            ++$i;
        }

        return true;
    }

    public function validateCoordinates(array $coordinates, array $map): bool
    {
        $rows = count($map);
        $columns = count($map[0]);

        if (2 !== count($coordinates)) {
            return false;
        }
        if (!is_numeric($coordinates[0]) || !is_numeric($coordinates[1])) {
            return false;
        }

        if (!($coordinates[0] >= 0 && $coordinates[0] < $columns)) {
            return false;
        }

        if (!($coordinates[1] >= 0 && $coordinates[1] < $rows)) {
            return false;
        }

        return true;
    }

    public function validateCell($x, $y, $rows, $cols): bool
    {
        return $x >= 0 && $x < $rows && $y >= 0 && $y < $cols;
    }
}
