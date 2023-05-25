<?php

namespace Tests;

use PathFind\Contracts\PathFindContract;
use PHPUnit\Framework\TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function maps()
    {
        $wall = PathFindContract::WALL;
        $space = PathFindContract::SPACE;

        return [
            'ExampleMap' => [
                [$space, $space,  $space, $space, $space],
                [$space, $wall,  $wall, $wall, $space],
                [$space, $space,  $space, $space, $space],
                [$space, $space,  $space, $space, $space],
                [$space, $space,  $space, $space, $space],
            ],
            'ExceptionMap' => [
                [$space, $space, $space, $space, $space],
                [$space, $space, $space, $space],
                [$space, $space, $space, $space, $space],
                [$space, $space, $space, $space, $space],
                [$space, $space, $space, $space],
            ],
            'NoPathMap' => [
                [$space, $space, $wall, $space, $space],
                [$space, $space, $wall, $space, $space],
                [$space, $space, $wall, $space, $space],
                [$space, $space, $wall, $space, $space],
                [$space, $space, $wall, $space, $space],
            ],
            'HardMap' => [
                [$space, $wall, $space, $space, $space],
                [$space, $wall, $space, $wall, $space],
                [$space, $wall, $space, $wall, $space],
                [$space, $wall, $space, $wall, $space],
                [$space, $space, $space, $wall, $space],
            ],
        ];
    }
}
