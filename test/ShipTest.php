<?php

use Aql\Ship;

class ShipTest extends \PHPUnit_Framework_TestCase
{
    public function testHasFullHealthAtConstruction()
    {
        $ship = new Ship(15, 0);
        $this->assertEquals(100, $ship->getHealth());
    }
}