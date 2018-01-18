<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 18/01/2018
 * Time: 17:33
 */

namespace App\Event;

/**
 * Class Event
 * @package App\Event
 */
abstract class Event
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var bool Indique si plus aucun listener ne doit être alerté ensuite
     */
    private $propagationStopped = false;
    
    /**
     * Event constructor.
     * @param $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }
    
    /**
     * @return string $name Nom de l'événement
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Indique si d'autres listeners peuvent être alerté ensuite.
     *
     * @see Event::stopPropagation()
     *
     * @return bool Indique si la propagation a été stoppée pour cet événement
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }
    
    /**
     * Stoppe la propagation de l'événement pour les prochains listeners de cet événement.
     *
     * Si plusieurs listeners sont connectés au même événement,
     * aucun des listeners restant ne sera alerté
     * dès que l'un d'entre eux aura fait appel à stopPropagation().
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }
}
