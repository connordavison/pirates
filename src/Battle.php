<?php

namespace Pirates;

class Battle
{
    /**
     * At the end of every turn, the defender becomes the attacker, and the
     * attacker becomes the defender.
     */
    protected $attacker;
    protected $defender;

    protected $turn = 0;

    protected $calculator;

    public function __construct(Ship $playerOne, Ship $playerTwo, DamageCalculator $calculator)
    {
        $this->attacker = $playerOne;
        $this->defender = $playerTwo;
        $this->calculator = $calculator;
    }

    public function run()
    {
        if ($this->defender->isSunk()) {
            throw new \RuntimeException("Defender is already sunk!");
        }

        $damage = $this->calculator->battle($this->attacker, $this->defender);
        $this->defender->decreaseHealth($damage);

        $swap = $this->attacker;
        $this->attacker = $this->defender;
        $this->defender = $swap;
    }

    public function getTurnAttacker()
    {
        return $this->attacker;
    }

    public function getTurnDefender()
    {
        return $this->defender;
    }

    public function getTurn()
    {
        return $this->turn;
    }
}
