<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 08/01/2018
 * Time: 17:33
 */

require __DIR__ . '/vendor/autoload.php';
/*
$ants = [];
for($i = 0; $i < 10; $i++) {
    $ants[] = \AntsProject\Entities\Ant\AntBuilder::createInstance('brown');
}

echo $ants[0]->getLifePoints();
echo $ants[1]->getLifePoints();
$ants[0]->attack($ants[1]);
echo $ants[1]->getLifePoints();
*/

$app = new \App\Application();
$app->initialise();