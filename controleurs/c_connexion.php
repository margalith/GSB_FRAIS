<?php


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $visiteur = $pdo->getInfosVisiteur($login, $mdp);
    $comptable = $pdo->getInfosComptable($login, $mdp);
    if (!is_array($visiteur ) && !is_array($comptable) ){
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    } else {
        if (is_array ($visiteur )){
            $id = $visiteur['id'];
            $nom = $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            $statut = $statut ['statut'];
        } else{
            $id = $comptable ['id'];
            $nom = $comptable['nom'];
            $prenom = $comptable['prenom'];
            $statut = $statut ['statut'];
            
        }
        connecter($id, $nom, $prenom,$statut);
        header('Location : index.php');
    }
 
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
