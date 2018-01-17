<?php

namespace AntsProject\Entities\Ant;

use AntsProject\Entities\LivingEntity;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 16:43
 */
class Ant extends LivingEntity
{
    
    /** @var  string $family */
    protected $family;
    /** @var  string $type */
    protected $type;
    
    /**
     * Ant constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->type = 'normal';
        $this->setLifePoints(10);
        $this->setPower(2);
        $this->setDefense(0);
        $this->setSpeed(10);
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getInstanceId();
    }
    
    /**
     * @return string
     */
    public function getFamily(): string
    {
        return $this->family;
    }
    
    /**
     * @param string $family
     * @return Ant
     */
    public function setFamily(string $family)
    {
        $this->family = $family;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     * @return Ant
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function attack($target)
    {
        if ($target instanceof LivingEntity) {
            $damage = $this->getPower() - $target->getDefense();
            if ($damage > 0) {
                $target->looseLife($damage);
            }
        }
    }
}