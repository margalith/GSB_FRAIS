<?php

$mois = getMois(date('d/m/Y')); //retourne aaaa.mm qd on rentre la date, en supprimant la valeur du jour
$moisPrecedent = getMoisPrecedent($mois);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$fichesCL = $pdo->ficheDuMoisCloturees($moisPrecedent);
$pdo = PdoGsb::getPdoGsb();

switch ($action) {
    case 'valider':

        $lesVisiteurs = $pdo->getLesVisiteurs($pdo);
        $lesMois = getLesDouzeDerniersMois($mois);
        $lesClesM = array_keys($lesMois);
        $moisASelectionner = $lesClesM[0];
        $lesClesV = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesClesV[0];

        if ($fichesCL) {
            include 'vues/v_listesVisiteursMois.php';
        } else {
            $pdo->clotureFiches($moisPrecedent); //cr en cl
            include 'vues/v_listesVisiteursMois.php'; //afficher listemois et listevisiteur
        }
        break;
    case 'validerVM':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getLesVisiteurs($pdo);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner = $leMois;
        $visiteurASelectionner = $leVisiteur;

        //affiche les info des fiches de frais du visiteur et mois selectionnes
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
        $infosFiche = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);

        if (!is_array($infosFiche)) { //si la fiche n'a pas d info, c est qu elle n existe pas dc erreur
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            include 'vues/v_listesVisiteursMois.php';

        } else {
            
            $moisAAfficher = substr($leMois, 4, 2);
            $anneeAAfficher = substr($leMois, 0, 4);
            include 'vues/v_afficheFrais.php';
        }
        break;

    case 'validerMajFrais':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getLesVisiteurs($pdo);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner = $leMois;
        $visiteurASelectionner = $leVisiteur;
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);

        $numMois = substr($leMois, 4, 2);
        $numAnnee = substr($leMois, 0, 4);

        //Maj des Frais Forfait
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        if (lesQteFraisValides($lesFrais)) {
            
            $pdo->majFraisForfait($leVisiteur, $leMois, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
            
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
       
        //Maj des Frais Hors forfait
        $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);

        valideInfosFrais($dateFrais, $libelle, $montant);
        if (nbErreurs() != 0) {
            include 'vues/v_erreurs.php';
        } else {
            $pdo->majFraisHorsForfait(
                $leVisiteur,
                $leMois,
                $libelle,
                $dateFrais,
                $montant
            );
        }
        include 'vues/v_afficheFrais';
        
        break;
    default;
}


