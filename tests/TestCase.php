<?php

namespace Ecavalier\Events\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function tearTown(): void
    {
        \Mockery::close();
    }
}
