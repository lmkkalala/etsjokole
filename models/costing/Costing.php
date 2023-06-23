<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdCosting {

    public function __construct() {
        
    }

    function addCosting($date,$quantite,$prix,$addsinId,$ravitaillementId) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO costing(dateSet,quantite,prix,addsInId,stockageId) VALUES(?,?,?,?,?)");
            $query->execute([$date,$quantite,$prix,$addsinId,$ravitaillementId]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAddsIn($idAddsIn, $designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE addsin SET designation=? WHERE id=?");
            $query->execute([$designation, $idAddsIn]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeAddsIn($idAddsIn) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE addsin SET active=? WHERE id=?");
            $query->execute([1, $idAddsIn]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function deleteCosting($costingId) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM costing WHERE id=?");
            $query->execute([$costingId]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveAddsIn($idAddsIn) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE addsin SET active=? WHERE id=?");
            $query->execute([0, $idAddsIn]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getCostingAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT C.dateSet,C.quantite,C.prix,AD.designation FROM costing C INNER addsin AD ON(C.addsInId=AD.id) INNER JOIN stockage S ON(C.stockageId=S.id) ORDER BY C.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getCostingByRavitaillementId($ravitaillementId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT C.id,C.dateSet,C.quantite,C.prix,AD.designation FROM costing C INNER JOIN addsin AD ON(C.addsInId=AD.id) INNER JOIN stockage S ON(C.stockageId=S.id) WHERE S.id='{$ravitaillementId}' ORDER BY C.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getCostingByAddsInId($addsInId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT C.id,C.dateSet,C.quantite,C.prix,AD.designation,S.id as sId FROM costing C INNER JOIN addsin AD ON(C.addsInId=AD.id) INNER JOIN stockage S ON(C.stockageId=S.id) WHERE AD.id='{$addsInId}' ORDER BY C.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAddsInById($addsinId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM addsin WHERE id='{$addsinId}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAddsInActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM addsin WHERE active=1 ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensById($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}'");
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

    function getAttributionBiensByIdFournisseur($idfournisseur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensAllDescEncours() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiens($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiensEncours($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,g.designation AS gDesignation,b.technique_gestion,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurEncours($idfournisseur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function finaliseAttribution($idattribution) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE attribution SET etat=? WHERE id=?");
            $query->execute([1, $idattribution]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getAttributionBiensById($idattribution) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,b.quantite,a.delai_livraison,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.id='{$idattribution}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeAllDescEncours() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.etat='0' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeAllDescFinalise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.etat='1' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeDescByIdBiens($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeDescByIdBiensEncours($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' AND d.etat='0' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeDescByIdService($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getDemandeDescByIdServiceEncours($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND d.etat='0' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function finaliseDemande($iddemande) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE demande SET etat=? WHERE id=?");
            $query->execute([1, $iddemande]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getDemandeById($iddemande) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.id='{$iddemande}' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

