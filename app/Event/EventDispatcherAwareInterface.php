<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 06/03/2017
 * Time: 17:08
 */

namespace App\Event;

/**
 * Interface EventDispatcherAwareInterface
 * @package App\Event
 */
interface EventDispatcherAwareInterface
{
    /**
     * @param EventManager $eventManager
     * @return mixed
     */
    public function setEventDispatcher(EventManager $eventManager);
    public function getEventDispatcher();
}
