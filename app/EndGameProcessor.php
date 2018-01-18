<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 18/01/2018
 * Time: 17:40
 */

namespace App;

use App\Event\Event;
use App\Event\EventSubscriberInterface;

/**
 * Class EndGameProcessor
 * @package App
 */
class EndGameProcessor implements EventSubscriberInterface
{
    private $event;
    /**
     * @return array event name et function souscrite qui recevra l'Event
     *
     * [
     *      'error_log' => 'logErrorIntoFile'
     * ]
     *
     */
    public static function getSubscribedEvents()
    {
        return array(
            'game_is_finished' => 'EndGameManager'
        );
    }
    
    public function EndGameManager(Event $event)
    {
        $this->event = $event;
        $this->displayEndGame();
        $this->publishEndGame();
    }
    
    private function displayEndGame()
    {
        echo date('Y-m-d  H:i.s') . ': ' . $this->event->getName() . "\r\n";
    }
    
    private function publishEndGame()
    {
        
    }
}