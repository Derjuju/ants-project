<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 06/03/2017
 * Time: 17:09
 */

namespace App\Event;

/**
 * Class EventDispatcherAwareTrait
 * @package App\Event
 */
trait EventDispatcherAwareTrait
{
    private $eventDispatcher;
    
    /**
     * @param EventManager $eventDispatcher
     */
    public function setEventDispatcher(EventManager $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * @return EventManager
     */
    public function getEventDispatcher()
    {
        // si aucun EventManager défini alors on en retourne un nouveau
        // pour accepter les diffusions mais en silence pour ne pas les propager
        if (null == $this->eventDispatcher) {
            $this->eventDispatcher = new EventManager();
        }
        return $this->eventDispatcher;
    }
}
