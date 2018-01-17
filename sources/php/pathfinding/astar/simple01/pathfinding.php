<?php
/**
http://theclemsweb.free.fr/script.php?url=path.php
*/

$resolu = FALSE;
$largeur = 10;
$hauteur = 10;
$depart = 0;
$arrivee = 99;
$x_arr = $arrivee % $largeur;
$y_arr = floor( $arrivee / $largeur);
$cout_f_glob = array();
$cout_h_glob = array();
$cout_g_glob = array();
$cout_g_glob[$depart] = 0;
$parent= array();
 
$murs = $_SESSION['murs'];
 
$coordonnees = array();
$liste_ouverte = array();
$liste_fermee = array();
 
function voisines($case){
   global $largeur, $hauteur;
   
   if($case == 0){
      $voisines = array($case+1 => 100, $case+$largeur+1 => 141, $case+$largeur => 100);
   }
   elseif($case == $largeur-1){ //en haut a droite
      $voisines = array($case+$largeur => 100, $case+$largeur-1 => 141, $case-1 =>  100);
   }
   elseif($case == ($hauteur - 1)* $largeur){ //en bas a gauche
      $voisines = array($case+1 => 100, $case-$largeur => 100, $case-$largeur+1 => 141);
   }
   elseif($case == $hauteur * $largeur - 1){ //en bas a droite
      $voisines = array($case-1 =>  100, $case-$largeur-1 => 141, $case-$largeur => 100);
   }
   elseif($case < $largeur){ //la ligne du haut
      $voisines = array($case+1 => 100, $case+$largeur+1 => 141, $case+$largeur => 100, $case+$largeur-1 => 141, $case-1 =>  100);
   }
   elseif($case % $largeur == 0){ //la colonne de gauche
      $voisines = array($case+1 => 100, $case+$largeur+1 => 141, $case+$largeur => 100, $case-$largeur => 100, $case-$largeur+1 => 141);
   }
   elseif($case % $largeur == $largeur-1){ //la colonne de droite
      $voisines = array($case+$largeur => 100, $case+$largeur-1 => 141, $case-1 =>  100, $case-$largeur-1 => 141, $case-$largeur => 100);
   }
   elseif($case > ($hauteur-1) * $largeur){ //la ligne du bas
      $voisines = array($case+1 => 100, $case-1 =>  100, $case-$largeur-1 => 141, $case-$largeur => 100, $case-$largeur+1 => 141);
   }
   else{ //tout ce qui n'est pas sur les bords
      $voisines = array($case+1 => 100, $case+$largeur+1 => 141, $case+$largeur => 100, $case+$largeur-1 => 141, $case-1 =>  100, $case-$largeur-1 => 141, $case-$largeur => 100, $case-$largeur+1 => 141);
   }
   return $voisines;
}
 
function cout_h($case){
   global $largeur, $hauteur, $x_arr, $y_arr, $cout_h_glob;
   $x = $case % $largeur;
   $y = floor( $case / $largeur);
   $cout_h = 100*sqrt(pow(($x_arr-$x), 2)+pow(($y_arr-$y), 2));
   //$cout_h = 10*(abs($x-$x_arr)+abs($y-$y_arr));
   $cout_h_glob[$case] = $cout_h;
   return $cout_h;
}
 
$liste_ouverte[] = $depart;
$case_courante = $depart;
 
while($case_courante != $arrivee && !empty($liste_ouverte)){
 
   unset($liste_ouverte[$case_courante]);
   unset($cout_f_glob[$case_courante]);
 
   foreach(voisines($case_courante) as $case => $cout_g){
      if(!in_array($case, $murs) && !in_array($case, $liste_fermee)){
         if(!in_array($case, $liste_ouverte)){
            $liste_ouverte[$case] = $case;
            $parent[$case] = $case_courante;
            $cout_g_glob[$case] = $cout_g_glob[$case_courante] + $cout_g;
            $cout_f_glob[$case] = $cout_g_glob[$case] + cout_h($case);
         }
         elseif(in_array($case, $liste_ouverte) && $cout_g_glob[$case] > $cout_g_glob[$case_courante] + $cout_g){
            $cout_g_glob[$case] = $cout_g_glob[$case_courante] + $cout_g;
            $cout_f_glob[$case] = $cout_g_glob[$case] + cout_h($case);
            $liste_ouverte[$case] = $case;
            $parent[$case] = $case_courante;
         }
      }
   }
   asort($cout_f_glob);
   if(!empty($liste_ouverte)){
      $case_courante = key($cout_f_glob);
      $liste_fermee[$case_courante] = $case_courante;
   }
}
 
if($case_courante == $arrivee){
   $resolu = TRUE;
   $chemin = '';
   while($case_courante != $depart){
      $chemin = $case_courante.' => '.$chemin;
      $case_courante = $parent[$case_courante];
      $chemin_array[] = $case_courante;
   }
}