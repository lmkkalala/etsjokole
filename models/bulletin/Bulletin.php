<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdBulletin {

    public function __construct() {
        
    }

    function addBulletin($datecreation,$idaffectationservice,$idcompte,$idlivrepaie,$idchargeconf,$chainecomposantesalaire,$chainecomposanteimposition) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO bulletinpaie(dateCreation,devise,affectationServiceId,compteId,livrePaieId,chargeConfId,chaineComposanteSalaire,chaineComposanteImposition) VALUES(?,?,?,?,?,?,?,?)");
            $query->execute([$datecreation,("USD"),$idaffectationservice,$idcompte,$idlivrepaie,$idchargeconf,$chainecomposantesalaire,$chainecomposanteimposition]);
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
    
    function desactiveBulleltin($idbulletin) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE bulletinpaie SET active=? WHERE id=?");
            $query->execute([0, $idbulletin]);
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
    
    function getBulletinRecent() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT MAX(id) AS maxId FROM bulletinpaie ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinByAffectationServiceByLivrePaieActive($idaffectatioservice,$idlivrepaie) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie WHERE affectationServiceId='{$idaffectatioservice}' AND livrePaieId='{$idlivrepaie}' AND active=1 ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinByAffectationServiceByLivrePaie($idaffectatioservice,$idlivrepaie) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie WHERE affectationServiceId='{$idaffectatioservice}' AND livrePaieId='{$idlivrepaie}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinAll() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinById($id) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie WHERE id='{$id}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinByAffectationService($idaffectationservice) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie WHERE affectationServiceId='{$idaffectationservice}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBulletinByLivrePaie($idlivrepaie) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM bulletinpaie WHERE livrePaieId='{$idlivrepaie}' ORDER BY id DESC");
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
    
    function getLivrePaieByMoisByAnnee($mois,$annee) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM livrepaie WHERE mois='{$mois}' AND annee='{$annee}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

