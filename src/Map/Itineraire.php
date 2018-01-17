<?php
/**
 * Created by PhpStorm.
 * User: jconseil
 * Date: 17/01/2018
 * Time: 16:06
 */

namespace AntsProject\Map;

class Itineraire
{
    protected $map = array();
    protected $ferme = array();
    protected $ouvert = array();
    private $parents = array();
    private $couts = array();
    private $chemin = array();
    private $caseDepart = NULL;
    private $xDepart = NULL;
    private $yDepart = NULL;
    private $caseFinale = NULL;
    private $xFinal = NULL;
    private $yFinal = NULL;
    
    public function __construct($map, $caseDepart, $caseFinale) {
        $this->map = $map;
        list($this->xDepart, $this->yDepart) = explode(',', $caseDepart);
        list($this->xFinal, $this->yFinal) = explode(',', $caseFinale);
        $this->caseDepart = $caseDepart;
        $this->caseFinale = $caseFinale;
    }
    
    public function casesAdjacentes($case) { // Renvoi la liste des cases adjacentes
        list($x, $y) = explode(',', $case);
        $casesAdjacentes = array();
        if(isset($this->map[$x][$y+1]) && $this->map[$x][$y+1] == Map::CASE_LIBRE)        // X; Y+1
            $casesAdjacentes[] = array($x, $y+1);
        if(isset($this->map[$x][$y-1]) && $this->map[$x][$y-1] == Map::CASE_LIBRE)        // X;    Y-1
            $casesAdjacentes[] = array($x, $y-1);
        if(isset($this->map[$x-1][$y]) && $this->map[$x-1][$y] == Map::CASE_LIBRE)        // X-1;    Y
            $casesAdjacentes[] = array($x-1, $y);
        if(isset($this->map[$x+1][$y]) && $this->map[$x+1][$y] == Map::CASE_LIBRE)        // X+1;    Y
            $casesAdjacentes[] = array($x+1, $y);
        return $casesAdjacentes;
    }
    
    public function getChemin() {
        if(!empty($this->chemin))
            return $this->chemin;
        else
            return FALSE;
    }
    
    public function getOuvert() {
        return $this->ouvert;
    }
    
    public function getFerme() {
        return $this->ferme;
    }
    
    private function coutCase($caseCourrante, $caseParente = NULL) { // Calcul le cout de la case
        $coutAnalyse = array("f" => NULL, "g" => NULL, "h" => NULL);
        list($xCourrant, $yCourrant) = explode(',',$caseCourrante);
        $coutAnalyse["h"] = round(sqrt(pow($xCourrant-$this->xFinal,2)+pow($yCourrant-$this->yFinal,2))); // Distance euclidienne
        if($caseParente !== NULL) {
            list($xParent, $yParent) = explode(',',$caseParente);
            $coutParent = (array_key_exists($caseParente, $this->couts)) ? $this->couts[$caseParente] : NULL;
            $coutAnalyse["g"] = $coutParent["g"]+1;
        } else // En thé||ie appelé seulement pour le calcul de la case départ qui n'a aucun parent
            $coutAnalyse["g"] = 0;
        $coutAnalyse["f"] = $coutAnalyse["h"] + $coutAnalyse["g"]; // Calcul du cout total F
        return $coutAnalyse;
    }
    
    private function analyseCasesAdjacentes($casesAdjacentes, $caseParente) { // Ajoutes à la liste ouverte et analyses les cases adjacentes
        $coutParent = $this->couts[$caseParente]; // On récupère le coût du parent
        foreach ($casesAdjacentes as $coordAnalyse) { // On les analyse une par une
            list($xAnalyse,$yAnalyse) = $coordAnalyse;
            $caseAnalyse = "$xAnalyse,$yAnalyse";
            if(in_array($caseAnalyse, $this->ferme)) // Si la case a déjà été traité
                continue; // On saute une itération
            $this->ouvert[$caseAnalyse] = $caseAnalyse; // On l'ajoutes à la liste ouverte
            $coutAnalyse = $this->coutCase($caseAnalyse, $caseParente); // On calcul son coût
            if(!array_key_exists($caseAnalyse, $this->parents) || $this->couts[$caseAnalyse]["g"] > $coutAnalyse["g"]) { // Si la case n'as pas de parent, où que le parent actuel est plus rapide
                $this->parents[$caseAnalyse] = $caseParente;
                $this->couts[$caseAnalyse] = $coutAnalyse;
            }
            if($caseAnalyse == $this->caseFinale)
                break;
        }
        return TRUE;
    }
    
    private function plusPetitF() { // Récupère dans la liste ouverte la case possédant le plus petit coût
        $plusPetitF = array("f" => NULL, "coordonnees" => NULL);
        foreach($this->ouvert as $coordonnees) {
            if($plusPetitF["f"] === NULL || $plusPetitF["f"] > $this->couts[$coordonnees]["f"])
                $plusPetitF = array("f" => $this->couts[$coordonnees]["f"], "coordonnees" => $coordonnees);
        }
        return $plusPetitF["coordonnees"];
    }
    
    public function calculerChemin() {
        if($this->map[$this->xDepart][$this->yDepart] == Map::CASE_OBSTACLE || $this->map[$this->xFinal][$this->yFinal] == Map::CASE_OBSTACLE)
            return FALSE;
        
        // Valeurs initiales
        $this->ouvert[$this->caseDepart] = $this->caseDepart; // La case de départ est mise dans la liste ouverte
        $coutCaseDepart = $this->coutCase($this->caseDepart); // On calcule son coût
        $this->couts[$this->caseDepart] = $coutCaseDepart;
        $caseCourrante = $this->caseDepart; // Case courrante
        $coutCourrant = $coutCaseDepart;
        $while = 0;
        while ($caseCourrante != $this->caseFinale) {
            if (empty($this->ouvert)) // Si la liste ouverte est vide, al||s échec dans la recherche du chemin
                return FALSE;
            list($xCourrant, $yCourrant) = explode(",", $caseCourrante); // On sépares les coordonnées de la case courrante
            $this->ferme[$caseCourrante] = $this->ouvert[$caseCourrante]; // On met la case courrante dans la liste fermé
            unset($this->ouvert[$caseCourrante]); // Et on l'enlève de la liste ouverte
            $casesAdjacentes = $this->casesAdjacentes($caseCourrante); // On récupère la liste des cases adjacentes à la case courrante
            $this->analyseCasesAdjacentes($casesAdjacentes, $caseCourrante); // On les analyses
            $caseCourrante = $this->plusPetitF(); // On récupère dans la liste ouverte la case avec le plus faible coût F
        }
        $caseParcouru = $this->caseFinale;
        while($caseParcouru != $this->caseDepart) { // On remonte le tableau $parent pour tracer le chemin;
            array_unshift($this->chemin, $caseParcouru); // On ajoutes la case parcouru au début du tableau
            $caseParcouru = $this->parents[$caseParcouru]; // On remontes jusqu'au parent de la case parcouru
        }
        array_unshift($this->chemin, $this->caseDepart);
        return TRUE;
    }
    public function getMap() {
        return $this->map;
    }
}