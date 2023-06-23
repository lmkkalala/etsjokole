<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdPreparation {

    public function __construct() {
        
    }

    function addPreparation($dateheure,$affectationservice_id,$typerepas) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO preparation(dateHeure,mutation_id,typerepas) VALUES(?,?,?)");
            $query->execute([$dateheure,$affectationservice_id,$typerepas]);
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

    function activePreparation($idpreparation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE preparation SET active=? WHERE id=?");
            $query->execute([1, $idpreparation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactivePreparation($idpreparation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE preparation SET active=? WHERE id=?");
            $query->execute([0, $idpreparation]);
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

    function getPreparationAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM preparation ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getPreparationById($idpreparation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM preparation WHERE id='{$idpreparation}'");
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
    
    function getPreparationByAffectationService($idaffectationservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM preparation WHERE mutation_id='{$idaffectationservice}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getPreparationAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM preparation WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

