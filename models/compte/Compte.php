<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdCompte {

    public function __construct() {
        
    }

    function addCompte($datecreation,$etablissement,$numero,$devise,$employeId) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO compte(etablissement,numero,devise,dateCreation,employeId) VALUES(?,?,?,?,?)");
            $query->execute([$etablissement,$numero,$devise,$datecreation,$employeId]);
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
    
    function getCompteAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT CO.id AS coId,CO.dateCreation,CO.etablissement,CO.numero AS coNumero,CO.devise,CO.active AS coActive,E.matricule,E.dateRecrutement,CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM compte CO INNER JOIN (employe E INNER JOIN (candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id)) ON(E.candidatureId=CR.id)) ON(CO.employeId=E.id) ORDER BY CR.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getCompteByEmploye($idemploye) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CO.id AS coId,CO.dateCreation,CO.etablissement,CO.numero AS coNumero,CO.devise,CO.active AS coActive,E.matricule,E.dateRecrutement,CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM compte CO INNER JOIN (employe E INNER JOIN (candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id)) ON(E.candidatureId=CR.id)) ON(CO.employeId=E.id) WHERE E.id='{$idemploye}' ORDER BY CR.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getCompteById($idcompte) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CO.id AS coId,CO.dateCreation,CO.etablissement,CO.numero AS coNumero,CO.devise,CO.active AS coActive,E.matricule,E.dateRecrutement,CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM compte CO INNER JOIN (employe E INNER JOIN (candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id)) ON(E.candidatureId=CR.id)) ON(CO.employeId=E.id) WHERE CO.id='{$idcompte}' ORDER BY CR.id DESC");
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
    
    function getCompteByNumero($numero) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM compte WHERE numero='{$numero}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

