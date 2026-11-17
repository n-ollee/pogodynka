<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['-40', -40],
            ['37', 98.6],
            ['20.5', 68.9],
            ['-17.5', 0.5],
            ['12.2', 53.96],
            ['-0.5', 31.1],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, float $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());
    }
}
