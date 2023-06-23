<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdInventaire {

    public function __construct() {
        
    }

    function addInventaire($date, $quantite,$ecart,$commentaire, $idbiens, $idaffectation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO inventaire(date,quantite,ecart,commentaire,biens_id,mutation_id) VALUES(?,?,?,?,?,?)");
            $query->execute([$date, $quantite,$ecart,$commentaire, $idbiens, $idaffectation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAttributionBiens($idattribution, $date, $quantite, $delai, $idbiens, $idfournisseur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE attribution SET date=?,quantite_minimale=?,delai_livraison=?,biens_id=?,fournisseur_id=? WHERE id=?");
            $query->execute([$date, $quantite, $delai, $idbiens, $idfournisseur, $idattribution]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function valideInventaire($idinventaire) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE inventaire SET validation=? WHERE id=?");
            $query->execute([1, $idinventaire]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveBiens($idbiens) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE biens SET active=? WHERE id=?");
            $query->execute([0, $idbiens]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getInventaireAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT i.id AS iId,i.date AS iDate,i.quantite AS iQuantite, i.ecart AS iEcart, i.commentaire,ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN inventaire i ON(b.id=i.biens_id) INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getInventaireAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT i.id AS iId,i.date AS iDate,i.quantite AS iQuantite, i.ecart AS iEcart, i.commentaire,i.validation,ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) INNER JOIN inventaire i ON(b.id=i.biens_id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(i.mutation_id=m.id) ORDER BY i.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getInventaireBeetwen2Dates($date1,$date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT i.id AS iId,i.date AS iDate,i.quantite AS iQuantite, i.ecart AS iEcart, i.commentaire,i.validation,ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) INNER JOIN inventaire i ON(b.id=i.biens_id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(i.mutation_id=m.id) WHERE i.date>='{$date1}' AND i.date<='{$date2}' ORDER BY i.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");
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

