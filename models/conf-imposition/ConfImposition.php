<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdConfImposition {

    public function __construct() {
        
    }

    function addConfImposition($dateconf,$pourcentage,$composanteImpositionId,$categorieId) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO compimpotconf(dateConf,pourcentage,composanteimpositionId,categorieId) VALUES(?,?,?,?)");
            $query->execute([$dateconf,$pourcentage,$composanteImpositionId,$categorieId]);
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

    function desactiveConfImpositionByComposanteImpositionByCategorie($idcomposanteimposition,$idcategorie) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE compimpotconf SET active=? WHERE composanteImpositionId=? AND categorieId=?");
            $query->execute([0, $idcomposanteimposition,$idcategorie]);
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
    
    function getConfimpositionAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT CFI.id,CFI.dateConf,CFI.pourcentage,CFI.active,CI.designation,CI.unite,CI.type,CA.designation AS caDesignation FROM compimpotconf CFI INNER JOIN composanteimposition CI ON(CFI.composanteImpositionId=CI.id) INNER JOIN categorie CA ON(CFI.categorieId=CA.id) ORDER BY CFI.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getConfImpositionByCategorie($idcategorie) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CFI.id,CFI.dateConf,CFI.pourcentage,CFI.active,CI.designation,CI.unite,CI.type,CA.designation AS caDesignation FROM compimpotconf CFI INNER JOIN composanteimposition CI ON(CFI.composanteImpositionId=CI.id) INNER JOIN categorie CA ON(CFI.categorieId=CA.id) WHERE CA.id='{$idcategorie}' ORDER BY CFI.id ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getConfImpositionById($id) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CFI.id,CFI.dateConf,CFI.pourcentage,CFI.active,CI.designation,CI.unite,CI.type,CA.designation AS caDesignation FROM compimpotconf CFI INNER JOIN composanteimposition CI ON(CFI.composanteImpositionId=CI.id) INNER JOIN categorie CA ON(CFI.categorieId=CA.id) WHERE CFI.id='{$id}' ORDER BY CFI.id DESC");
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

}
?>

