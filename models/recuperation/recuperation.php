<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdRecuperation {

    public function __construct() {
        ini_set('memory_limit', '2056M');
        set_time_limit(0);  
    }

    function addRecuperation($date, $quantite, $iddistribution, $idaffectation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO restitution(date,quantite,distribution_id,mutation_id) VALUES(?,?,?,?)");
            $query->execute([$date, $quantite, $iddistribution, $idaffectation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function addRecuperationData($date, $quantite,$old_quantite, $iddistribution, $idagent,$bienid,$addbyid) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO recuperation(date,quantite_recuperer,quantite_old,agent_id,bien_id,command_id,addedbyID) VALUES(?,?,?,?,?,?,?)");
            $query->execute([$date, $quantite,$old_quantite, $idagent,$bienid,$iddistribution,$addbyid]);
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

    function activeBiens($idbiens) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE biens SET active=? WHERE id=?");
            $query->execute([1, $idbiens]);
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

    function getRecuperationAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM restitution');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRecuperationAllData($date = '', $dateEnd = '') {
        $bd = Connexion::connecter();
        if($date != ''){
            if ($dateEnd != '') {
                $reponse = $bd->query('SELECT *, ag.nom AS snom, ag.postnom AS spostnom, ag.prenom AS sprenom, a.nom as pnom, a.postnom as ppostnom, a.prenom as pprenom FROM recuperation r INNER JOIN distrubution d ON (r.command_id = d.id) INNER JOIN agent a ON (r.addedbyID = a.id) INNER JOIN agent ag ON (r.agent_id = ag.id) INNER JOIN biens b ON (r.bien_id = b.id) WHERE r.date >= "'.$date.'" and r.date <= "'.$dateEnd.'" ORDER BY r.id DESC');
            }else{
                $reponse = $bd->query('SELECT *, ag.nom AS snom, ag.postnom AS spostnom, ag.prenom AS sprenom, a.nom as pnom, a.postnom as ppostnom, a.prenom as pprenom FROM recuperation r INNER JOIN distrubution d ON (r.command_id = d.id) INNER JOIN agent a ON (r.addedbyID = a.id) INNER JOIN agent ag ON (r.agent_id = ag.id) INNER JOIN biens b ON (r.bien_id = b.id) WHERE r.date LIKE "%'.$date.'%" ORDER BY r.id DESC');
            }
        }else{
            $reponse = $bd->query('SELECT *, ag.nom AS snom, ag.postnom AS spostnom, ag.prenom AS sprenom, a.nom as pnom, a.postnom as ppostnom, a.prenom as pprenom FROM recuperation r INNER JOIN distrubution d ON (r.command_id = d.id) INNER JOIN agent a ON (r.addedbyID = a.id) INNER JOIN agent ag ON (r.agent_id = ag.id) INNER JOIN biens b ON (r.bien_id = b.id)  WHERE r.date LIKE "%'.date('Y-m').'%" ORDER BY r.id DESC');
        }
        
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRecuperationAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM restitution ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRecuperationById($idrecuperation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM restitution WHERE id='{$idrecuperation}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRecuperationMax() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT MAX(id) AS Id FROM restitution");
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
    
    function setPanier($idrecuperation,$panier) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE restitution SET panier=? WHERE id=?");
            $query->execute([$panier, $idrecuperation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

}
?>

