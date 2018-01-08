<?php

namespace AntsProject\Entities;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 16:52
 * Copyright: © Cora 2018
 */
interface LivingEntityInterface
{
    /**
     * @return int
     */
    public function getLifePoints():int;
    
    /**
     * @param int $lifePoints
     * @return mixed
     */
    public function setLifePoints(int $lifePoints);
    
    /**
     * @return int
     */
    public function getX(): int;
    /**
     * @param int $X
     * @return mixed
     */
    public function setX(int $X);
    
    /**
     * @return int
     */
    public function getY(): int;
    /**
     * @param int $Y
     * @return mixed
     */
    public function setY(int $Y);
    
}