<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdPromotion {

    public function __construct() {
        
    }

    function addPromotion($dateaffectation,$employeId,$serviceId,$fonctionId,$categorieId,$typeContratId) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO affectationservice(dateAffectation,employeId,serviceId,fonctionId,categorieId,typeContratId) VALUES(?,?,?,?,?,?)");
            $query->execute([$dateaffectation,$employeId,$serviceId,$fonctionId,$categorieId,$typeContratId]);
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

    function desactivePromotionByEmploye($idemploye) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE affectationservice SET active=? WHERE employeId=?");
            $query->execute([0, $idemploye]);
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
    
    function getPromotionAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT S.designation AS sDesignation,F.designation AS fDesignation,CT.designation AS ctDesignation,TC.designation AS tcDesignation,AF.id AS afId,AF.dateAffectation,AF.active AS afActive,E.matricule,E.dateRecrutement,CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM affectationservice AF INNER JOIN (employe E INNER JOIN (candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id)) ON(E.candidatureId=CR.id)) ON(AF.employeId=E.id) INNER JOIN service S ON(AF.serviceId=S.id) INNER JOIN fonction F ON(AF.fonctionId=F.id) INNER JOIN categorie CT ON(AF.categorieId=CT.id) INNER JOIN typecontrat TC ON(AF.typeContratId=TC.id) ORDER BY AF.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getPromotionById($idpromotion) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT S.designation AS sDesignation,F.designation AS fDesignation,CT.designation AS ctDesignation,CT.id AS ctId,TC.designation AS tcDesignation,AF.id AS afId,AF.dateAffectation,AF.active AS afActive,E.id AS eId,E.matricule,E.dateRecrutement,CR.id,CR.dateSoumission,CR.etatAcceptation,CR.active,CR.etatAcceptation,C.nom,C.postnom,C.prenom,C.sexe,O.numero,O.libelle,O.dateLancement,O.dateCloture FROM affectationservice AF INNER JOIN (employe E INNER JOIN (candidature CR INNER JOIN candidat C ON(CR.candidatId=C.id) INNER JOIN offreemploie O ON(CR.offreEmploieId=O.id)) ON(E.candidatureId=CR.id)) ON(AF.employeId=E.id) INNER JOIN service S ON(AF.serviceId=S.id) INNER JOIN fonction F ON(AF.fonctionId=F.id) INNER JOIN categorie CT ON(AF.categorieId=CT.id) INNER JOIN typecontrat TC ON(AF.typeContratId=TC.id) WHERE AF.id='{$idpromotion}' ORDER BY AF.id DESC");
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
    
    function getPromotionByEmployeByServiceByFonctionByCategorieByTypeContrat($employeId,$serviceId,$fonctionId,$categorieId,$typeContratId) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM affectationservice WHERE employeId='{$employeId}' AND serviceId='{$serviceId}' AND fonctionId='{$fonctionId}' AND categorieId='{$categorieId}' AND typeContratId='{$typeContratId}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

