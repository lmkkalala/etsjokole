<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdAttributionBiens {

    public function __construct() {
        
    }

    function addAttributionBiens($date, $delai, $quantite, $prixunitaire, $numeroOrder, $idfournisseur, $idbiens) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO attribution(date,delai_livraison,quantite_minimale,prixunitaire,numeroOrder,biens_id,fournisseur_id) VALUES(?,?,?,?,?,?,?)");
            $query->execute([$date, $delai, $quantite, $prixunitaire, $numeroOrder, $idbiens, $idfournisseur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAttributionBiens($idattribution, $date, $quantite, $delai, $idbiens, $idfournisseur,$prix = '') {
        try {
            $bd = Connexion::connecter();
            if ($prix != '') {
                $query = $bd->prepare("UPDATE attribution SET date=?,quantite_minimale=?,prixunitaire=?,delai_livraison=?,biens_id=?,fournisseur_id=? WHERE id=?");
                $query->execute([$date, $quantite, $prix, $delai, $idbiens, $idfournisseur, $idattribution]);
            }else{
                $query = $bd->prepare("UPDATE attribution SET date=?,quantite_minimale=?,delai_livraison=?,biens_id=?,fournisseur_id=? WHERE id=?");
                $query->execute([$date, $quantite, $delai, $idbiens, $idfournisseur, $idattribution]);
            }
            
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

    function getAttributionBiensAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite,b.designation AS bDesignation,g.designation AS gDesignation,f.designation AS fDesignation,a.active,c.id AS cId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fourniseur f ON(a.fournisseur_id=f.id)');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensAllDesc($dateStart = '', $dateEnd = '') {
        $bd = Connexion::connecter();
        if ($dateStart != '') {
            if ($dateStart != '' and $dateEnd != '') {
                $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.date >= "'.$dateStart.'" and a.date <= "'.$dateEnd.'"  ORDER BY a.id DESC');
            }else{
                $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.date Like "%'.$dateStart.'%" ORDER BY a.id DESC');
            }
        }else{
            $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC');
        }
       
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
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensByNumeroOrder($numeroOrder) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.numeroOrder='{$numeroOrder}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensByIdFournisseurDistinctNumeroOrder($idfournisseur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT DISTINCT(a.numeroOrder) AS numero_order FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensDistinctNumeroOrder() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT DISTINCT(a.numeroOrder) AS numero_order FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getMaxAttributionBiensDistinctNumeroOrder() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT MAX(a.numeroOrder) AS numero_orderMax FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getFetchAttributionBiensDistinctNumeroOrder() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.numeroOrder AS numero_orderFetch FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getMaxDateAttributionBiensDistinctNumeroOrder() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT MAX(a.date) AS lastDate,a.numeroOrder as numero_orderFetchDate FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurByDate($idfournisseur, $date1, $date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND a.date>='{$date1}' AND a.date<='{$date2}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensAllDescEncours($dateStart = '', $dateEnd = '') {
        $bd = Connexion::connecter();
        if ($dateStart != '') {
            if ($dateStart != '' and $dateEnd != '') {
                $reponse = $bd->query('SELECT b.prixunitaire,a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat="0" and a.date >= "'.$dateStart.'" and a.date <= "'.$dateEnd.'"  ORDER BY a.id DESC');
            }else{
                $reponse = $bd->query('SELECT b.prixunitaire,a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat="0" and a.date Like "%'.$dateStart.'%" ORDER BY a.id DESC');
            }
        }else{
            $reponse = $bd->query("SELECT b.prixunitaire,a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat='0' ORDER BY a.id DESC");
        }
        //$reponse = $bd->query("SELECT b.prixunitaire,a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiens($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiensEncours($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,a.numeroOrder,b.designation AS bDesignation,g.designation AS gDesignation,b.technique_gestion,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurEncours($idfournisseur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.numeroOrder,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurEncoursByDate1ByDate2($idfournisseur, $date1, $date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND etat='0' AND a.date>='{$date1}' AND a.date<='{$date2}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensByIdFournisseurByDate1ByDate2Second($idfournisseur, $date1, $date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND a.date>='{$date1}' AND a.date<='{$date2}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensEncoursByNumeroOrder($numeroOrder) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.numeroOrder='{$numeroOrder}' AND etat=0 ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAttributionBiensByNumeroOrderSecond($numeroOrder) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.numeroOrder,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.numeroOrder='{$numeroOrder}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurByDate1ByDate2($idfournisseur, $date1, $date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.prixunitaire AS aPrixUnitaire,a.etat,a.numeroOrder,b.designation AS bDesignation,b.technique_gestion,b.prixunitaire,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND a.date>='{$date1}' AND a.date<='{$date2}' ORDER BY a.id DESC");
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
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,a.prixunitaire AS aPrixUnitaire,b.designation AS bDesignation,b.technique_gestion,b.quantite,a.delai_livraison,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.id='{$idattribution}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function deleteAttributionBiens($idattributionbiens) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM attribution WHERE id=?");
            $query->execute([$idattributionbiens]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

}
?>

