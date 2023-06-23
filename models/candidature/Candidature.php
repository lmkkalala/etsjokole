<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdCandidature {

    public function __construct() {
        
    }

    function addCandidature($datesoumission,$etatacceptation,$offreemploieId,$candidatId) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO candidature(dateSoumission,etatAcceptation,offreEmploieId,candidatId) VALUES(?,?,?,?)");
            $query->execute([$datesoumission,$etatacceptation,$offreemploieId,$candidatId]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateFonction($idfonction, $designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fonction SET designation=? WHERE id=?");
            $query->execute([$designation,$idfonction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function updateEntrepriseWithOutFile($identreprise, $designation, $sigle) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE entreprise SET designation=?,sigle=? WHERE id=?");
            $query->execute([$designation, $sigle, $identreprise]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeFonction($idfonction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fonction SET active=? WHERE id=?");
            $query->execute([1, $idfonction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveFonction($idfonction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fonction SET active=? WHERE id=?");
            $query->execute([0, $idfonction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getFonctionAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM fonction');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getCandidatureAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id) ORDER BY CR.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    

    function getServiceByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getFonctionById($idfonction) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM fonction WHERE id='{$idfonction}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRowCountEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        $val=$reponse->rowCount();
        return $val;
    }

    function getServiceAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getServiceAllDescDesactive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getFonctionAllActiveDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM fonction WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function allowCandidature($idcandidature) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE candidature SET etatAcceptation=? WHERE id=?");
            $query->execute([1, $idcandidature]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function rejectCandidature($idcandidature) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE candidature SET etatAcceptation=? WHERE id=?");
            $query->execute([0, $idcandidature]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getCandidatureByOffreEmploieByCandidat($idoffreemploie,$idcandidat) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM candidature WHERE offreEmploieId='{$idoffreemploie}' AND candidatId='{$idcandidat}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

