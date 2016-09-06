<?php

use Pirates\DamageCalculator;
use Pirates\Ship;

class DamageCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Ship|PHPUnit_Framework_MockObject_MockObject
     */
    protected $attacker;

    /**
     * @var Ship|PHPUnit_Framework_MockObject_MockObject
     */
    protected $defender;

    public function setUp()
    {
        $this->defender = $this->createMock(Ship::class);
        $this->attacker = $this->createMock(Ship::class);
    }

    /**
     * @expectedExceptionMessage Sunk ship cannot be attacked.
     */
    public function testSunkShipCannotBeAttacked()
    {
        $this->defender->method('getHealth')->willReturn(0);
        $calculator = new DamageCalculator();
        $calculator->battle($this->attacker, $this->defender);
    }

    /**
     * @dataProvider attackProvider
     */
    public function testDamageCalculation(
        int $attackPoints,
        int $defencePoints,
        bool $isDirectHit,
        bool $isCritical,
        int $expectedDamage
    ) {
        $calculator = $this->getMockBuilder(DamageCalculator::class)
            ->setMethods(['passesAccuracyCheck', 'passesCriticalCheck'])
            ->getMock();

        $this->attacker->method('getAttackPoints')->willReturn($attackPoints);
        $this->defender->method('getDefencePoints')->willReturn($defencePoints);

        $calculator->method('passesAccuracyCheck')->willReturn($isDirectHit);
        $calculator->method('passesCriticalCheck')->willReturn($isCritical);

        $actualDamage = $calculator->battle($this->attacker, $this->defender);

        $this->assertEquals($expectedDamage, $actualDamage);
    }

    /**
     * @see testDamageCalculation
     */
    public function attackProvider()
    {
        return [
            'A miss yields 0 damage' => [15, 0, false, false, 0],
            'A miss yields 0 damage when critical' => [15, 0, false, true, 0],
            "A hit yields damage equal to the attacker's AP" => [15, 0, true, false, 15],
            "A critical hit yields damage equal to triple that of the attacker's AP" => [15, 0, true, true, 45],
            "Damage is decreased by an amount equal to the defender's DP" => [15, 5, true, false, 10],
            "Damage cannot be decreased to less than 0 by defender's DP" => [15, 20, true, false, 0],
        ];
    }
}
