<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdSwaping {

    public function __construct() {
        
    }

    function addSwaping($idaffectationgroupe,$idaffectationservice,$typerepas,$prixchoosen,$idservice) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO swaping(dateHeure,affectationGroupe_id,mutation_id,typerepas,prixchoosen,service_id) VALUES(?,?,?,?,?,?)");
            $query->execute([(date('Y-m-d H:i')),$idaffectationgroupe,$idaffectationservice,$typerepas,$prixchoosen,$idservice]);
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
    
    function getSwapingToday() {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT * FROM swaping WHERE dateHeure LIKE '%{$today}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getSwapingTodayByAffectationGroupe($idaffectationgroupe) {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT * FROM swaping WHERE dateHeure LIKE '%{$today}%' AND affectationGroupe_id='{$idaffectationgroupe}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getSwapingAllByDate($my_date) {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT * FROM swaping WHERE dateHeure LIKE '%{$my_date}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getSwapingAllByDateByAffectationGroupe($my_date,$idgroupeswaping) {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT S.dateHeure,AG.service_id,A.nom,A.postnom,A.prenom FROM swaping S INNER JOIN (affectationgroupe AG INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN agent A ON(AG.agent_id=A.id)) ON(S.affectationGroupe_id=AG.id) WHERE dateHeure LIKE '%{$my_date}%' AND GS.id='{$idgroupeswaping}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getSwapingByGroupeSwaping($idgroupeswaping) {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT AG.id AS agId,S.service_id AS sService_id,S.dateHeure,AG.service_id,A.nom,A.postnom,A.prenom,F.id AS fId,S.prixchoosen FROM swaping S INNER JOIN (affectationgroupe AG INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN fonction F ON(AG.fonction_id=F.id)) ON(S.affectationGroupe_id=AG.id) WHERE GS.id='{$idgroupeswaping}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getSwapingByAffectationGroupe($idaffectationgroupe) {
        $bd = Connexion::connecter();
        $today=(date('Y-m-d'));
        $reponse = $bd->query("SELECT AG.id AS agId,S.service_id AS sService_id,S.dateHeure,AG.service_id,A.nom,A.postnom,A.prenom,F.id AS fId,S.prixchoosen FROM swaping S INNER JOIN (affectationgroupe AG INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN fonction F ON(AG.fonction_id=F.id)) ON(S.affectationGroupe_id=AG.id) WHERE AG.id='{$idaffectationgroupe}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

