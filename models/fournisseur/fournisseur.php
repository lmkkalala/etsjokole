<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdFournisseur {

    public function __construct() {
        
    }

    function addFournisseur($designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO fournisseur(designation,domaine,adresse,ville,province,pays,telephone,email) VALUES(?,?,?,?,?,?,?,?)");
            $query->execute([$designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateFournisseur($idfournisseur, $designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fournisseur SET designation=?,domaine=?,adresse=?,ville=?,province=?,pays=?,telephone=?,email=? WHERE id=?");
            $query->execute([$designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email, $idfournisseur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeFournisseur($idfournisseur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fournisseur SET active=? WHERE id=?");
            $query->execute([1, $idfournisseur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveFournisseur($idfournisseur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE fournisseur SET active=? WHERE id=?");
            $query->execute([0, $idfournisseur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getFournisseurAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM fournisseur');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getFournisseurByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM fournisseur WHERE designation LIKE '%{$val}%' OR domaine LIKE '{$val}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getFournisseurAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM fournisseur ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getFournisseurById($idfournisseur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM fournisseur WHERE id='{$idfournisseur}'");
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

