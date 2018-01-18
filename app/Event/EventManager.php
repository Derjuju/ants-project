<?php

namespace App\Event;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 06/03/2017
 * Time: 16:42
 */

/**
 * Class EventManager
 * @package App\Event
 */
class EventManager
{
    private $listeners = array();
    
    /**
     * Ajoute une entrée pour un événement à écouter
     * @param $event la clé de l'événement à écouter
     * @param $callback la fonction à associer au traitement de cet événement
     */
    public function listen($event, $callback)
    {
        $this->listeners[$event][] = $callback;
    }
    
    /**
     * Diffuse un événement vers la liste des écouteurs et lance la méthode associée le cas échéant
     * Stoppe la propagation si un écouteur l'a décidé après avoir géré un événement
     * @param $event
     * @param Event $param
     */
    public function dispatch($event, Event $param)
    {
        if (isset($this->listeners[$event])) {
            foreach ($this->listeners[$event] as $listener) {
                if ($param->isPropagationStopped()) {
                    break; // on stoppe la propagation
                }
                call_user_func_array($listener, array($param));
            }
        }
    }
    
    /**
     * Ajoute l'ensemble des événements écoutés par un écouteur d'événements
     * @param EventSubscriberInterface $sub
     */
    public function addSubscriber(EventSubscriberInterface $sub)
    {
        $listeners = $sub->getSubscribedEvents();
        
        foreach ($listeners as $event => $listener) {
            // Ajoute la fonction souscrite en tant qu'event
            $this->listen($event, array($sub, $listener));
        }
    }
}
