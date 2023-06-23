<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdCategorie {

    public function __construct() {
        
    }

    function addCategorie($designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO groupebiens(designation) VALUES(?)");
            $query->execute([$designation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateCategorie($idcategorie, $designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupebiens SET designation=? WHERE id=?");
            $query->execute([$designation, $idcategorie]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeCategorie($idcategorie) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupebiens SET active=? WHERE id=?");
            $query->execute([1, $idcategorie]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveCategorie($idcategorie) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE groupebiens SET active=? WHERE id=?");
            $query->execute([0, $idcategorie]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getCategorieAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM groupebiens');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getCategorieByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM groupebiens AS g WHERE g.designation LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getCategorieAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM groupebiens ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getCategorieById($idcategorie) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM groupebiens WHERE id='{$idcategorie}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentAllDescDesactive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

