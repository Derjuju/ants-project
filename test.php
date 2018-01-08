<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 17:33
 * Copyright: © Cora 2018
 */

require __DIR__ . '/vendor/autoload.php';

$ant = new \AntsProject\Entities\Ant\Ant();

echo $ant->getLifePoints();