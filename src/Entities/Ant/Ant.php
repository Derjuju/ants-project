<?php

namespace AntsProject\Entities\Ant;

use AntsProject\Entities\LifeEntityTrait;
use AntsProject\Entities\LivingEntityInterface;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 16:43
 * Copyright: © Cora 2018
 */
class Ant implements LivingEntityInterface
{
    use LifeEntityTrait;
    
    /** @var  int $id */
    private $id;
    /** @var  string $family */
    protected $family;
    /** @var  string $type */
    protected $type;
    
    
    public function __construct()
    {
        $this->family = null;
        $this->type = 'normal';
        $this->setLifePoints(10);
    }
}