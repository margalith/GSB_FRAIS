<?php
$mois = getMois(date('d/m/Y')); //retourne aaaa.mm qd on rentre la date, en supprimant la valeur du jour
$moisPrecedent= getMoisPrecedent($mois);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$fichesCL = $pdo->ficheDuMoisCloturees($moisPrecedent);
$pdo = PdoGsb::getPdoGsb();
$lesVisiteurs = $pdo->getLesVisiteurs($pdo);
$lesMois = getLesDouzeDerniersMois($mois);
switch ($action) {
case 'valider':
    if ($fichesCL){
        include 'vues/v_listesVisiteursMois.php';
    }else{
     $pdo->clotureFicheFrais($moisPrecedent); //cr en cl
       include 'vues/v_listesVisiteursMois.php';
   }
   break;
case 'ValideVM':
   $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
   $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
   $moisASelectionner = $leMois;   
   $visiteurASelectionner = $leVisiteur; 
   include 'vues/v_listesVisiteursMois.php';
   break;
default;
}


