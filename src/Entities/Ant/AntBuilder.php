<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 09/01/2018
 * Time: 16:58
 */

namespace AntsProject\Entities\Ant;

/**
 * Class AntBuilder
 * @package AntsProject\Entities\Ant
 */
class AntBuilder
{
    /**
     * @param $family
     * @param string $type
     * @return Ant
     */
    public static function createInstance($family, $type = 'normal')
    {
        $ant = new Ant();
        $ant->setFamily($family);
        $ant->setType($type);
        return $ant;
    }
}