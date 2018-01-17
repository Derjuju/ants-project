<?php
namespace App;

use AntsProject\Map\Map;
use AntsProject\Map\MapToSprite;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 10/01/2018
 * Time: 14:40
 */
class Application
{
    protected $versionIteration;
    private $map;
    
    public function __construct()
    {
        
    }
    
    public function initialise()
    {
        $this->map = new Map(25,21,0,0);
        $this->map->initialiseMapNiveau(1,4);
        $mapGame = $this->map->getMap();
        $this->mapToSpriteConverter = new MapToSprite();
        $mapTiles = $this->mapToSpriteConverter->exportSpritesMapping($mapGame);
        
        var_dump(json_encode($mapGame));
        var_dump(json_encode($mapTiles));
    }
}