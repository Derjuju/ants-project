<?php
namespace App;

use AntsProject\Map\MapToSprite;
use App\Event\EventManager;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 10/01/2018
 * Time: 14:40
 */
class Application
{
    protected $versionIteration;
    /**
     * @var GameEngine
     */
    private $gameEngine;
    
    /**
     * @var EventManager
     */
    protected $eventManager;
    
    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->eventManager = new EventManager();
        $this->registerEventsManagement();
    }
    
    /**
     * @param ConfigGame $configGame
     */
    public function initialise(ConfigGame $configGame)
    {
        $map = $configGame->generateMap();
        $this->gameEngine = new GameEngine($map);
        $this->gameEngine->setEventDispatcher($this->eventManager);
    }
    
    public function processGame()
    {
        $this->gameEngine->start();
    }
    
    /**
     * Enregistrement de tous les écouteurs d'événements
     * dans le gestionnaire d'événéments
     */
    private function registerEventsManagement()
    {
        // SDK Logger
        $this->eventManager->addSubscriber(new EndGameProcessor());
    }
    
    public function export()
    {
        $mapGame = $this->gameEngine->getMap();
        $this->mapToSpriteConverter = new MapToSprite();
        $mapTiles = $this->mapToSpriteConverter->exportSpritesMapping($mapGame);
        var_dump($mapTiles);
    }
}