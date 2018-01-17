<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 17/01/2018
 * Time: 16:12
 * Copyright: © Cora 2018
 */

namespace AntsProject\Map;

class MapToSprite
{
    private $spritesMapping = [
        Map::CASE_LIBRE => [30],
        Map::CASE_OBSTACLE => [31,32,38,39,40],
        Map::CASE_RESSOURCE => [48],
        Map::CASE_PIEGE => [],
        Map::CASE_MAISON_J1 => 49,
        Map::CASE_MAISON_J2 => 50,
        Map::CASE_MAISON_J3 => 51,
        Map::CASE_MAISON_J4 => 52
    ];
    
    private function mapGameToSprite(array $map) {
        foreach($map as $column => $row) {
            foreach($row as $key => $tile) {
                if (! isset($this->spritesMapping[$tile])) {
                    throw new \RuntimeException('Mapping non défini pour la valeur : '.$tile);
                }
                if (is_array($this->spritesMapping[$tile])) {
                    $map[$column][$key] = $this->spritesMapping[$tile][random_int(0,count($this->spritesMapping[$tile])-1)];
                } else {
                    $map[$column][$key] = $this->spritesMapping[$tile];
                }
            }
        }
        return $map;
    }
    
    private function convertToTilesEngine(array $map) {
        $dataForEngine = "";
        
        $yMax = count($map[0]);
        for ($y = 0; $y < $yMax; $y++) {
            foreach($map as $column => $row) {
                $dataForEngine.= $row[$y].',';
            }
        }
        $dataForEngine = substr($dataForEngine,0,-1);
        return [$dataForEngine];
    }
    
    /**
     * @param array $map
     */
    public function exportSpritesMapping(array $map) {
        $map = $this->mapGameToSprite($map);
        $map = $this->convertToTilesEngine($map);
        return $map;
    }
}