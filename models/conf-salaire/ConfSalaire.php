<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class BdConfSalaire {

    public function __construct() {
        
    }

    function addConfSalaire($dateconf,$taux,$composanteSalaireId,$categorieId) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO compsalaireconf(dateConf,taux,composanteSalaireId,categorieId) VALUES(?,?,?,?)");
            $query->execute([$dateconf,$taux,$composanteSalaireId,$categorieId]);
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

    function desactiveConfSalaireByComposanteSalaireByCategorie($idcomposantesalaire,$idcategorie) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE compsalaireconf SET active=? WHERE composanteSalaireId=? AND categorieId=?");
            $query->execute([0, $idcomposantesalaire,$idcategorie]);
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
    
    function getConfSalaireAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT CFS.id,CFS.dateConf,CFS.taux,CFS.active,CS.code,CS.designation,CS.unite,CS.type,CS.nature,CA.designation AS caDesignation FROM compsalaireconf CFS INNER JOIN composantesalaire CS ON(CFS.composanteSalaireId=CS.id) INNER JOIN categorie CA ON(CFS.categorieId=CA.id) ORDER BY CFS.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    
    function getConfSalaireByCategorie($idcategorie) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CFS.id,CFS.dateConf,CFS.taux,CFS.active,CS.defaultQuantite,CS.code,CS.designation,CS.unite,CS.type,CS.nature,CA.designation AS caDesignation FROM compsalaireconf CFS INNER JOIN composantesalaire CS ON(CFS.composanteSalaireId=CS.id) INNER JOIN categorie CA ON(CFS.categorieId=CA.id) WHERE CA.id='{$idcategorie}' ORDER BY CFS.id ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getConfSalaireById($idconfsalaire) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT CFS.id,CFS.dateConf,CFS.taux,CFS.active,CS.defaultQuantite,CS.code,CS.designation,CS.unite,CS.type,CS.nature,CA.designation AS caDesignation FROM compsalaireconf CFS INNER JOIN composantesalaire CS ON(CFS.composanteSalaireId=CS.id) INNER JOIN categorie CA ON(CFS.categorieId=CA.id) WHERE CFS.id='{$idconfsalaire}' ORDER BY CFS.id DESC");
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

