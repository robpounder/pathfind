<?php

namespace PathFind\Contracts;

interface MapValidatorContract
{
    public function validateMap(array $map): bool;
}
