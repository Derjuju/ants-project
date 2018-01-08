<?php

namespace AntsProject\Entities;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 17:25
 * Copyright: © Cora 2018
 */
trait LifeEntityTrait
{
    /** @var  int $lifePoints */
    protected $lifePoints;
    
    /** @var  int $X */
    protected $X;
    /** @var  int $Y */
    protected $Y;
    
    /**
     * @return int
     */
    public function getLifePoints(): int
    {
        return $this->lifePoints;
    }
    
    /**
     * @param int $lifePoints
     * @return mixed
     */
    public function setLifePoints(int $lifePoints)
    {
        $this->lifePoints = $lifePoints;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->X;
    }
    
    /**
     * @param int $X
     * @return LifeEntityTrait
     */
    public function setX(int $X)
    {
        $this->X = $X;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->Y;
    }
    
    /**
     * @param int $Y
     * @return LifeEntityTrait
     */
    public function setY(int $Y)
    {
        $this->Y = $Y;
        return $this;
    }
    
    
    
}