<?php

use Aql\Ship;

class ShipTest extends \PHPUnit_Framework_TestCase
{
    public function testHasFullHealthAtConstruction()
    {
        $ship = new Ship(15, 0);
        $this->assertEquals(100, $ship->getHealth());
    }

    public function testHealthCanDecrease()
    {
        $ship = new Ship(15, 0);
        $ship->decreaseHealth(10);
        $this->assertEquals(90, $ship->getHealth());
    }

    public function testShipSinks()
    {
        $ship = new Ship(15, 0);
        $this->assertFalse($ship->isSunk());

        $ship->decreaseHealth(100);
        $this->assertTrue($ship->isSunk());

        $ship->decreaseHealth(100);
        $this->assertTrue($ship->isSunk());
    }
}