<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 18/01/2018
 * Time: 16:12
 */

namespace App;

use AntsProject\Map\Map;

/**
 * Class ConfigGame
 * @package App
 */
class ConfigGame
{
    private $niveau = 1;
    private $nbreJoueurs = 2;
    
    /**
     * ConfigGame constructor.
     */
    public function __construct() {
        
    }
    
    /**
     * @param int $niveau
     */
    public function setNiveau(int $niveau) {
        // intégrité de la valeur de niveau
        if ($niveau < 1) $niveau = 1;
        if ($niveau > 2) $niveau = 2;
        $this->niveau = $niveau;
    }
    
    /**
     * @param int $nbreJoueurs
     */
    public function setNbreJoueurs(int $nbreJoueurs) {
        // intégrité de la valeur de nbreJoueurs
        if ($nbreJoueurs < 2) $nbreJoueurs = 2;
        if ($nbreJoueurs > 4) $nbreJoueurs = 4;
        $this->nbreJoueurs = $nbreJoueurs;
    }
    
    /**
     * @return Map
     */
    public function generateMap() {
        $map = new Map(25,21,0,0);
        $map->initialiseMapNiveau($this->niveau,$this->nbreJoueurs);
        return $map;
    }
}