<?php
$mois =getMois(date('d/m/y'));
$moisPrecedent =getMoisPrecedent($mois);
$action= filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);
$fichesCL = $pdo->ficheDuMoisCloturee($moisPrecedent);
$lesVisiteurs = $pdo->getLesVisiteurs($pdo);
$lesMois = getLesDouzeDerniersMois($mois);
switch ($action){
    case 'valider':
        if($fichesCL){
            include 'vues/v_listesVisiteursMois.php';   
        }else{    
        }
        break;
    default;
        
    
}

