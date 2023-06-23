<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdAffectationGroupe {

    public function __construct() {
        
    }

    function addAffectationGroupe($idagent,$idgroupeswaping,$idservice,$idfonction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO affectationgroupe(dateHeureAffectation,agent_id,groupeswaping_id,service_id,fonction_id) VALUES(?,?,?,?,?)");
            $query->execute([(date('Y-m-d H:i')),$idagent,$idgroupeswaping,$idservice,$idfonction]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function addAffectationGroupeAllowEveryWhere($idagent,$idgroupeswaping,$idservice,$idfonction) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO affectationgroupe(dateHeureAffectation,agent_id,groupeswaping_id,service_id,fonction_id,alloweverywhere) VALUES(?,?,?,?,?,?)");
            $query->execute([(date('Y-m-d H:i')),$idagent,$idgroupeswaping,$idservice,$idfonction,1]);
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
    
    function desactiveAllByAgent($idagent) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectationgroupe SET active=? WHERE agent_id=?");
            $query->execute([0, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getAffectationGroupeAllActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT AG.id AS idAG,AG.dateHeureAffectation,AG.active,AG.etatBlockage,A.nom,A.postnom,A.prenom,A.datenaiss,GS.designation AS dGroupeSwaping,GS.nombrerepas,S.designation AS dService,F.designation AS dFonction FROM affectationgroupe AG INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN service S ON(AG.service_id=S.id) INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN fonction F ON(AG.fonction_id=F.id) WHERE AG.active='1'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function blockAffectationGroupe($idaffectationgroupe, $dateOuverture) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectationgroupe SET etatBlockage=?,dateHeureBlockage=?,dateOuverture=? WHERE id=?");
            $query->execute([1, (date('Y-m-d H:i')),$dateOuverture,$idaffectationgroupe]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function deblockAffectationGroupe($idaffectationgroupe) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectationgroupe SET etatBlockage=?,dateHeureBlockage=?,dateOuverture=? WHERE id=?");
            $query->execute([0, "","",$idaffectationgroupe]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getAffectationGroupeActiveByAgent($idagent) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectationgroupe WHERE agent_id='{$idagent}' AND active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationGroupeById($idaffectationgroupe) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectationgroupe WHERE id='{$idaffectationgroupe}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationGroupeByIdFonction($idfonction) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT AG.id AS idAG,AG.dateHeureAffectation,AG.active,AG.etatBlockage,A.matricule,A.nom,A.postnom,A.prenom,A.datenaiss,GS.designation AS dGroupeSwaping,GS.nombrerepas,S.designation AS dService,F.designation AS dFonction FROM affectationgroupe AG INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN service S ON(AG.service_id=S.id) INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN fonction F ON(AG.fonction_id=F.id) WHERE F.id='{$idfonction}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationGroupeByIdFonctionByGroupeSwapping($idfonction,$idgroupeswaping) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT AG.id AS idAG,AG.dateHeureAffectation,AG.active,AG.etatBlockage,A.matricule,A.nom,A.postnom,A.prenom,A.datenaiss,GS.designation AS dGroupeSwaping,GS.nombrerepas,S.designation AS dService,F.designation AS dFonction FROM affectationgroupe AG INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN service S ON(AG.service_id=S.id) INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN fonction F ON(AG.fonction_id=F.id) WHERE F.id='{$idfonction}' AND GS.id='{$idgroupeswaping}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationGroupeByIdFonctionByRestaurant($idfonction,$idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT AG.id AS idAG,AG.dateHeureAffectation,AG.active,AG.etatBlockage,A.matricule,A.codebar,A.nom,A.postnom,A.prenom,A.datenaiss,GS.designation AS dGroupeSwaping,GS.nombrerepas,S.designation AS dService,F.designation AS dFonction FROM affectationgroupe AG INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN service S ON(AG.service_id=S.id) INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN fonction F ON(AG.fonction_id=F.id) WHERE F.id='{$idfonction}' AND S.id='{$idservice}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationGroupeAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT AG.id AS idAG,AG.dateHeureAffectation,AG.active,AG.etatBlockage,A.nom,A.postnom,A.prenom,A.datenaiss,GS.designation AS dGroupeSwaping,GS.nombrerepas,S.designation AS dService,F.designation AS dFonction FROM affectationgroupe AG INNER JOIN agent A ON(AG.agent_id=A.id) INNER JOIN service S ON(AG.service_id=S.id) INNER JOIN groupeswaping GS ON(AG.groupeswaping_id=GS.id) INNER JOIN fonction F ON(AG.fonction_id=F.id)");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function blockAffectationGroupeForevermore($idaffectationgroupe, $dateOuverture) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectationgroupe SET active=?,etatBlockage=?,dateHeureBlockage=?,dateOuverture=? WHERE id=?");
            $query->execute([0,1, (date('Y-m-d H:i')),$dateOuverture,$idaffectationgroupe]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    

}
?>

