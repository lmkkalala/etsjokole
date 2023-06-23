<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdOperationF {

    public function __construct() {
        
    }

    function addOperation($libelle,$type,$responsable,$domaine,$montant) {
        try {
            $bd = ConnexionF::connecter();
            $query = $bd->prepare("INSERT INTO operation(dateEnreg,libelle,type,responsable,domaine,montant) VALUES(?,?,?,?,?,?)");
            $query->execute([date('Y-m-d'),$libelle,$type,$responsable,$domaine,$montant]);
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

    function activeProduction($idproduction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE productionnourriture SET active=? WHERE id=?");
            $query->execute([1, $idproduction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveProduction($idproduction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE productionnourriture SET active=? WHERE id=?");
            $query->execute([0, $idproduction]);
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
    
    function getProductionAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,PR.dateHeure AS dateHeurePR,N.designation FROM productionnourriture PD INNER JOIN preparation PR ON(PD.preparation_id=PR.id) INNER JOIN nourriture N ON(PD.nourriture_id=N.id) ORDER BY PD.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function updateQuantiteProduction($idproduction, $quantite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE productionnourriture SET quantite=? WHERE id=?");
            $query->execute([$quantite, $idproduction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getProductionByMutationDesc($idaffectationservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,PR.dateHeure AS dateHeurePR,N.designation FROM productionnourriture PD INNER JOIN preparation PR ON(PD.preparation_id=PR.id) INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE PR.mutation_id='{$idaffectationservice}' ORDER BY PD.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

