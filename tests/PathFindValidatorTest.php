<?php

namespace Tests;

use Faker\Factory;
use PathFind\Contracts\PathFindValidatorContract;
use PathFind\Validation\PathFindValidator;

class PathFindValidatorTest extends TestCase
{
    private PathFindValidatorContract $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new PathFindValidator();
        $this->faker = Factory::create();
    }

    /** @test */
    public function canValidateCell()
    {
        $num = $this->faker->randomDigit;
        $this->assertTrue($this->validator->validateCell($num, $num, $num + 1, $num + 1));
        $num = $this->faker->randomDigit;
        $this->assertFalse($this->validator->validateCell($num, $num, $num - 1, $num - 1));
        $this->assertFalse($this->validator->validateCell(-1, 1, 4, 4));
        $this->assertFalse($this->validator->validateCell(1, -1, 4, 4));
        $num = $this->faker->randomDigit;
        $this->assertTrue($this->validator->validateCell(0, 0, $num, $num));
    }

    /** @test */
    public function canValidateCoordinates(): void
    {
        $this->assertTrue($this->validator->validateCoordinates([1, 1], $this->maps()['ExampleMap']));
        $this->assertTrue($this->validator->validateCoordinates([4, 4], $this->maps()['ExampleMap']));
        $this->assertFalse($this->validator->validateCoordinates([4, 5], $this->maps()['ExampleMap']));
        $this->assertFalse($this->validator->validateCoordinates([5, 4], $this->maps()['ExampleMap']));
    }

    /** @test */
    public function canValidateMap(): void
    {
        $this->assertTrue($this->validator->validateMap($this->maps()['ExampleMap']));
        $this->assertTrue($this->validator->validateMap($this->maps()['NoPathMap']));
        $this->assertTrue($this->validator->validateMap($this->maps()['HardMap']));
        $this->assertFalse($this->validator->validateMap($this->maps()['ExceptionMap']));
    }
}
