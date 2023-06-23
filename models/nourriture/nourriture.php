<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdNourriture {

    public function __construct() {
        
    }

    function addNourriture($designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO nourriture(designation) VALUES(?)");
            $query->execute([$designation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateNourriture($idnourriture, $designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE nourriture SET designation=? WHERE id=?");
            $query->execute([$designation, $idnourriture]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeNourriture($idnourriture) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE nourriture SET active=? WHERE id=?");
            $query->execute([1, $idnourriture]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveNourriture($idnourriture) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE nourriture SET active=? WHERE id=?");
            $query->execute([0, $idnourriture]);
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

    function getNourritureAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM nourriture ORDER BY id DESC');
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
    
    function getNourritureAllActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM nourriture WHERE active='1' ORDER BY designation ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getNourritureById($nourritureId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM nourriture WHERE id='{$nourritureId}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

