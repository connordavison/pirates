<?php

namespace Pirates;

class Ship
{
    protected $health = 100;

    protected $attackPoints;

    protected $defencePoints;

    public function __construct(int $attackPoints, int $defencePoints)
    {
        $this->attackPoints = $attackPoints;
        $this->defencePoints = $defencePoints;
    }

    public function decreaseHealth(int $amount)
    {
        $this->health -= $amount;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function getAttackPoints()
    {
        return $this->attackPoints;
    }

    public function getDefencePoints()
    {
        return $this->defencePoints;
    }

    public function isSunk()
    {
        return $this->health <= 0;
    }
}
