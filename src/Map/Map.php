<?php
namespace AntsProject\Map;

/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 17/01/2018
 * Time: 15:40
 */
class Map
{
    const CASE_LIBRE = 0;
    const CASE_OBSTACLE = 1;
    const CASE_PIEGE = 2;
    const CASE_RESSOURCE = 3;
    
    const CASE_MAISON_J1 = 11;
    const CASE_MAISON_J2 = 12;
    const CASE_MAISON_J3 = 13;
    const CASE_MAISON_J4 = 14;
    
    
    private $map = array();
    private $width = 0;
    private $height = 0;
    private $firstX = 0;
    private $firstY = 0;
    
    private $niveau = 0;
    private $nbreJoueurs = 0;
    
    /**
     * Map constructor.
     * @param $width
     * @param $height
     * @param int $firstX
     * @param int $firstY
     */
    public function __construct(int $width, int $height, int $firstX = 0, int $firstY = 0) { // Génère l'array de la carte
        $this->width = $width;
        $this->height = $height;
        $this->firstX = $firstX;
        $this->firstY = $firstY;
        for($x = 0; $x < $width; $x++) {
            $this->map[$x+$firstX] = array();
            for($y = 0; $y < $height; $y++) {
                $this->map[$x+$firstX][$y+$firstY] = self::CASE_LIBRE;
            }
        }
    }
    
    /**
     * @return array
     */
    public function getMap() {
        return $this->map;
    }
    
    /**
     * @param int $niveau
     * @param int $nbreJoueurs
     */
    public function initialiseMapNiveau($niveau = 1, $nbreJoueurs = 2)
    {
        // intégrité de la valeur de niveau
        if ($niveau < 1) $niveau = 1;
        if ($niveau > 2) $niveau = 2;
        
        // intégrité de la valeur de nbreJoueurs
        if ($nbreJoueurs < 2) $nbreJoueurs = 2;
        if ($nbreJoueurs > 4) $nbreJoueurs = 4;
        
        $this->niveau = $niveau;
        $this->nbreJoueurs = $nbreJoueurs;
        $this->definitMaisonJoueurs();
        $this->definitObstacles();
        $this->definitRessources();
        $this->definitPieges();
    }
    
    private function definitMaisonJoueurs()
    {
        switch($this->niveau) {
            case 1 :    // place les maisons dans les coins
                        $this->map[0+$this->firstX][0+$this->firstY] = self::CASE_MAISON_J1;
                        $this->map[($this->width-1)+$this->firstX][0+$this->firstY] = self::CASE_MAISON_J2;
                        if ($this->nbreJoueurs > 2) {
                            $this->map[($this->width-1)+$this->firstX][($this->height-1)+$this->firstY] = self::CASE_MAISON_J3;
                        }
                        if ($this->nbreJoueurs > 3) {
                            $this->map[0+$this->firstX][($this->height-1)+$this->firstY] = self::CASE_MAISON_J4;
                        }
                        break;
            case 2 :    // place les maisons dans les milieux des bords
                $this->map[(int) round(($this->width-1)/2)+$this->firstX][0+$this->firstY] = self::CASE_MAISON_J1;
                $this->map[($this->width-1)+$this->firstX][(int) round(($this->height-1)/2)+$this->firstY] = self::CASE_MAISON_J2;
                if ($this->nbreJoueurs > 2) {
                    $this->map[(int) round(($this->width-1)/2)+$this->firstX][($this->height-1)+$this->firstY] = self::CASE_MAISON_J3;
                }
                if ($this->nbreJoueurs > 3) {
                    $this->map[0+$this->firstX][(int) round(($this->width-1)/2)+$this->firstY] = self::CASE_MAISON_J4;
                }
                break;
        }
    }
    
    private function definitObstacles()
    {
        switch($this->niveau) {
            case 1 :    // place les maisons dans les coins
                //$this->map[0+$this->firstX][0+$this->firstY] = self::CASE_OBSTACLE;
                break;
            case 2 :    // place les maisons dans les milieux des bords
                //$this->map[(int) round(($this->width-1)/2)+$this->firstX][0+$this->firstY] = self::CASE_OBSTACLE;
                break;
        }
    }
    
    private function definitRessources()
    {
        switch($this->niveau) {
            case 1 :    // place les maisons dans les coins
                $this->map[(int) round(($this->width-1)/2)+$this->firstX][(int) round(($this->height-1)/2)+$this->firstY] = self::CASE_RESSOURCE;
                break;
            case 2 :    // place les maisons dans les milieux des bords
                $this->map[(int) round(($this->width-1)/2)+$this->firstX][(int) round(($this->height-1)/2)+$this->firstY] = self::CASE_RESSOURCE;
                break;
        }
    }
    
    private function definitPieges()
    {
        switch($this->niveau) {
            case 1 :    // place les maisons dans les coins
                //$this->map[0+$this->firstX][0+$this->firstY] = self::CASE_OBSTACLE;
                break;
            case 2 :    // place les maisons dans les milieux des bords
                //$this->map[(int) round(($this->width-1)/2)+$this->firstX][0+$this->firstY] = self::CASE_OBSTACLE;
                break;
        }
    }
}