<?php

namespace Tests;

use PathFind\Exceptions\InvalidCoordinateException;
use PathFind\Exceptions\InvalidMapException;
use PathFind\Exceptions\InvalidPathException;
use PathFind\PathFind;

class PathFindTest extends TestCase
{
    /** @test */
    public function canFindFastestPathWithSetMap()
    {
        $pathFind = new PathFind();
        $pathFind->setMap($this->maps()['ExampleMap']);
        $result = $pathFind->pathDistance([0, 1], [3, 2]);

        $this->assertEquals(6, $result);
    }

    /** @test */
    public function canFindFastestPathOnRuntime(): void
    {
        $pathFind = new PathFind();
        $result = $pathFind->pathFind($this->maps()['ExampleMap'], [0, 1], [3, 2]);
        $this->assertEquals(6, $result);
    }

    /** @test */
    public function canValidateMap(): void
    {
        $pathFind = new PathFind();
        $this->expectException(InvalidMapException::class);
        $pathFind->pathFind($this->maps()['ExceptionMap'], [0, 1], [0, 4]);
    }

    /** @test */
    public function canValidateNoPath(): void
    {
        $pathFind = new PathFind();
        $pathFind->setMap($this->maps()['NoPathMap']);
        $this->expectException(InvalidPathException::class);
        $pathFind->pathDistance([0, 0], [0, 4]);
    }

    /** @test */
    public function canValidateCoordinates(): void
    {
        $pathFind = new PathFind();
        $this->expectException(InvalidCoordinateException::class);
        $pathFind->pathFind($this->maps()['NoPathMap'], [0, 0], [10, 10]);
    }

    /** @test */
    public function canSolveHardMap(): void
    {
        $pathFind = new PathFind();
        $pathFind->setMap($this->maps()['HardMap']);
        $result = $pathFind->pathDistance([0, 0], [4, 4]);
        $this->assertEquals(16, $result);
    }
}
