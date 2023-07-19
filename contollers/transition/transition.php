<?php
session_start();
include '../../models/connexion.php';
include '../../models/affectation-service/affectationService.php';

if (isset($_GET['mutationID'])) {
    $bdaffectation = new BdAffectationService();
    $_SESSION['temp_admin_session'] = 'admin';
    $_SESSION['temp_admin_id'] = $_SESSION['idutilisateur'];
    $affectations = $bdaffectation->getAffectationServiceByIdSecond($_GET['mutationID']);

    foreach ($affectations as $affectation) {
        $identite = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
        $service = $affectation['designation'];
        $grade = $affectation['grade'];
        $idaffectation = $affectation['Id'];
        $idservice = $affectation['Sid'];
        $AgentID = $affectation['Aid'];
    }

    $_SESSION['identite'] = $identite;
    $_SESSION['service'] = $service;
    $_SESSION['grade'] = $grade;
    $_SESSION['idaffectation'] = $idaffectation;
    $_SESSION['idutilisateur'] = $AgentID;
    $_SESSION['idservice'] = $idservice;
    $_SESSION['type'] = 'other';
    
    $reponse = 'Vous étez connected en tant que '.$identite;
    header('Location: ../../views/home.php?link_up=' . sha1("home_service_acceuil") . '&reponse=' . sha1($reponse).'');
}else{
    $bdaffectation = new BdAffectationService();
    $affectations = $bdaffectation->getAffectationServiceByIdSecondUser($_SESSION['temp_admin_id']);
    foreach ($affectations as $affectation) {
        $identite = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
        $service = $affectation['designation'];
        $grade = $affectation['grade'];
        $idaffectation = $affectation['Id'];
        $idservice = $affectation['Sid'];
    }

    $_SESSION['identite'] = $identite;
    $_SESSION['service'] = $service;
    $_SESSION['grade'] = $grade;
    $_SESSION['idaffectation'] = $idaffectation;
    $_SESSION['idutilisateur'] = $_SESSION['temp_admin_id'];
    $_SESSION['idservice'] = $idservice;
    $_SESSION['type'] = 'logistique';

    $reponse = 'Vous étez connected en tant que '.$identite;
    $_SESSION['temp_admin_session'] = '';
    $_SESSION['temp_admin_id'] = '';
    header('Location: ../../views/home.php?link_up=' . sha1("home_logistique_acceuil") . '&reponse=' . sha1($reponse).'');
}