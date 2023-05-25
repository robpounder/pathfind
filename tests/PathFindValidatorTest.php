<?php

namespace Tests;

use Faker\Factory;
use PathFind\Contracts\CoordinateValidatorContract;
use PathFind\Contracts\MapValidatorContract;
use PathFind\Validation\CoordinateValidator;
use PathFind\Validation\MapValidator;

class PathFindValidatorTest extends TestCase
{
    private MapValidatorContract $mapValidator;
    private CoordinateValidatorContract $coordinateValidator;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapValidator = new MapValidator();
        $this->coordinateValidator = new CoordinateValidator();
        $this->faker = Factory::create();
    }

    /** @test */
    public function canValidateCell()
    {
        $num = $this->faker->randomDigit;
        $this->assertTrue($this->coordinateValidator->validateCoordinate($num,$num + 1));
        $num = $this->faker->randomDigit;
        $this->assertFalse($this->coordinateValidator->validateCoordinate($num, $num - 1));
        $this->assertFalse($this->coordinateValidator->validateCoordinate(-1, 4));
        $num = $this->faker->randomDigit + 1;
        $this->assertTrue($this->coordinateValidator->validateCoordinate(0, $num));
    }

    /** @test */
    public function canValidateCoordinates(): void
    {
        $this->assertTrue($this->coordinateValidator->validateCoordinates([1, 1], count($this->maps()['ExampleMap']), count($this->maps()['ExampleMap'][0])));
        $this->assertTrue($this->coordinateValidator->validateCoordinates([4, 4], count($this->maps()['ExampleMap']), count($this->maps()['ExampleMap'][0])));
        $this->assertFalse($this->coordinateValidator->validateCoordinates([4, 5], count($this->maps()['ExampleMap']), count($this->maps()['ExampleMap'][0])));
        $this->assertFalse($this->coordinateValidator->validateCoordinates([5, 4], count($this->maps()['ExampleMap']), count($this->maps()['ExampleMap'][0])));
    }

    /** @test */
    public function canValidateMap(): void
    {
        $this->assertTrue($this->mapValidator->validateMap($this->maps()['ExampleMap']));
        $this->assertTrue($this->mapValidator->validateMap($this->maps()['NoPathMap']));
        $this->assertTrue($this->mapValidator->validateMap($this->maps()['HardMap']));
        $this->assertFalse($this->mapValidator->validateMap($this->maps()['ExceptionMap']));
    }
}
