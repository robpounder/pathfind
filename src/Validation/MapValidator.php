<?php

namespace PathFind\Validation;

use PathFind\Contracts\MapValidatorContract;

class MapValidator implements MapValidatorContract
{
    public function validateMap(array $map, ...$params): bool
    {
        $rows = count($map);
        if (0 === $rows) {
            return false;
        }

        $columns = count($map[0]);
        if (0 === $columns) {
            return false;
        }

        foreach ($map as $row) {
            if (!is_array($row) || count($row) !== $columns) {
                return false;
            }

            foreach ($row as $item) {
                if (!is_bool($item)) {
                    return false;
                }
            }
        }

        return true;
    }
}
