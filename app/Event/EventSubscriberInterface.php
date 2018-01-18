<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 18/01/2018
 * Time: 17:36
 */

namespace App\Event;

interface EventSubscriberInterface
{
    /**
     * Fonction retournant la liste des événements à écouter et la méthode interne à associer
     * @return array event name et function souscrite qui recevra l'Event
     *
     * [
     *      'error_log' => 'logErrorIntoFile'
     * ]
     *
     */
    public static function getSubscribedEvents();
}