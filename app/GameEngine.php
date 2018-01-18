<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 18/01/2018
 * Time: 17:24
 */

namespace App;

use AntsProject\Map\Map;
use App\Event\EventDispatcherAwareInterface;
use App\Event\EventDispatcherAwareTrait;
use App\Event\GameEvent;

/**
 * Class GameEngine
 * @package App
 */
class GameEngine implements EventDispatcherAwareInterface
{
    use EventDispatcherAwareTrait;
    
    private $map;
    
    /**
     * GameEngine constructor.
     * @param Map $map
     */
    public function __construct(Map $map)
    {
        $this->map = $map;
    }
    
    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map->getMap();
    }
    
    public function start()
    {
        
        $this->finished();
    }
    
    private function finished()
    {
        $event = new GameEvent('fin de la partie');
        $this->getEventDispatcher()->dispatch(GameEvent::GAME_IS_FINISHED, $event);
    }
}