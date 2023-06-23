<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdGroupeSwaping {

    public function __construct() {
        
    }

    function addGroupeSwaping($designation,$nombreRepas) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO groupeswaping(designation,nombrerepas) VALUES(?,?)");
            $query->execute([$designation,$nombreRepas]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateGroupeSwaping($idgroupeswaping, $designation, $nombrerepas) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupeswaping SET designation=?,nombrerepas=? WHERE id=?");
            $query->execute([$designation,$nombrerepas,$idgroupeswaping]);
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

    function activeGroupeSwaping($idgroupeswaping) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupeswaping SET active=? WHERE id=?");
            $query->execute([1, $idgroupeswaping]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveGroupeSwaping($idgroupeswaping) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupeswaping SET active=? WHERE id=?");
            $query->execute([0, $idgroupeswaping]);
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
    
    function getGroupeSwapingAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM groupeswaping ORDER BY id DESC');
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
    
    function getGroupeSwapingById($id) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM groupeswaping WHERE id='{$id}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    

}
?>

