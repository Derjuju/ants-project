<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 09/01/2018
 * Time: 11:56
 */

namespace AntsProject\Entities;

/**
 * Class LivingEntity
 * @package AntsProject\Entities
 */
abstract class LivingEntity implements LivingEntityInterface
{
    
    protected static $instances = 0;
    private $_instanceId  = null;
    
    
    /** @var  int $lifePoints */
    protected $lifePoints;
    
    /** @var  int $power */
    protected $power;
    /** @var  int $defense */
    protected $defense;
    /** @var  int $speed */
    protected $speed;
    
    /** @var  int $X */
    protected $X;
    /** @var  int $Y */
    protected $Y;
    
    /** @var  int $moveToX */
    protected $moveToX;
    /** @var  int $moveToY */
    protected $moveToY;
    
    /**
     * LivingEntity constructor.
     */
    public function __construct()
    {
        $this->_instanceId = ++self::$instances;
    
        $this->power = 0;
        $this->defense = 0;
        $this->speed = 0;
    }
    
    
    /**
     * @return int|null
     */
    public function getInstanceId()
    {
        return $this->_instanceId;
    }
    
    
    /**
     * @return int
     */
    public function getLifePoints(): int
    {
        return $this->lifePoints;
    }
    
    /**
     * @param int $lifePoints
     * @return LivingEntity
     */
    public function setLifePoints(int $lifePoints)
    {
        $this->lifePoints = $lifePoints;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isAlive():bool
    {
        return $this->lifePoints>0;
    }
    
    public function looseLife(int $damage)
    {
        $this->setLifePoints($this->getLifePoints() - $damage);
    }
    
    /**
     * @param int $X
     * @param int $Y
     * @return mixed
     */
    public function spawn(int $X, int $Y)
    {
        $this->setX($X);
        $this->setY($Y);
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
     * @return LivingEntity
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
     * @return LivingEntity
     */
    public function setY(int $Y)
    {
        $this->Y = $Y;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMoveToX(): int
    {
        return $this->moveToX;
    }
    
    /**
     * @param int $moveToX
     * @return LivingEntity
     */
    public function setMoveToX(int $moveToX)
    {
        $this->moveToX = $moveToX;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMoveToY(): int
    {
        return $this->moveToY;
    }
    
    /**
     * @param int $moveToY
     * @return LivingEntity
     */
    public function setMoveToY(int $moveToY)
    {
        $this->moveToY = $moveToY;
        return $this;
    }
    
    /**
     * @param int $X
     * @param int $Y
     * @return LivingEntity
     */
    public function moveTo(int $X, int $Y)
    {
        $this->moveToX = $X;
        $this->moveToY = $Y;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }
    
    /**
     * @param int $power
     * @return LivingEntity
     */
    public function setPower(int $power)
    {
        $this->power = $power;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getDefense(): int
    {
        return $this->defense;
    }
    
    /**
     * @param int $defense
     * @return LivingEntity
     */
    public function setDefense(int $defense)
    {
        $this->defense = $defense;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }
    
    /**
     * @param int $speed
     * @return LivingEntity
     */
    public function setSpeed(int $speed)
    {
        $this->speed = $speed;
        return $this;
    }
    
    
    
    /**
     * @param $target
     * @return mixed
     */
    abstract public function attack($target);
}