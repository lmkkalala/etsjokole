<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdDistribution {

    public function __construct() {
        
    }

    function addDistribution($date, $quantite, $price, $idlivraison, $idaffectation, $typerepas,$identiteClient,$ventePOSId,$tva,$type) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO affectation(date,nombre,nombre_restant,price,distribution_id,mutation_id,typerepas,identiteClient,venteposId,tva,typePaiement) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $query->execute([$date, $quantite, $quantite, $price, $idlivraison, $idaffectation, $typerepas,$identiteClient,$ventePOSId,$tva,$type]);
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

    function deleteDistribution($distributionId) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM affectation WHERE id=?");
            $query->execute([$distributionId]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getDistributionAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM affectation');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionAllDistinctClient() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT DISTINCT(identiteClient) as distinctIdentiteClient FROM affectation');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM affectation ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionAllDescCurrentMounth($mounth) {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM affectation WHERE date LIKE "%'.$mounth.'%" ORDER BY id DESC Limit 2000');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionBeetwen2Dates($date1, $date2) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE date>='{$date1}' AND date<='{$date2}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionBeetwen2DatesByIdentiteClient($date1, $date2,$identiteClient) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE date>='{$date1}' AND date<='{$date2}' AND identiteClient='{$identiteClient}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionBeetwen2DatesByTypeRepas($date1, $date2, $typerepas) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE date>='{$date1}' AND date<='{$date2}' AND typerepas='{$typerepas}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionBeetwen2DatesByTypeRepasByIdentiteClient($date1, $date2, $typerepas,$identiteClient) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE date>='{$date1}' AND date<='{$date2}' AND typerepas='{$typerepas}' AND identiteClient='{$identiteClient}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionBeetwen2DatesAllsell($date1, $date2, $distribution_id,$mutation_id) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE date>='{$date1}' AND date<='{$date2}' AND distribution_id='{$distribution_id}' AND mutation_id='{$mutation_id}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionByTypeRepas($typerepas) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE typerepas='{$typerepas}' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionByVentePOSId($ventePOSId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE venteposId='{$ventePOSId}' ORDER BY id ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionDescQuantitePositive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE nombre_restant>'0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionById($iddistribution) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE id='{$iddistribution}'");
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

    function diminueQuantiteDistribution($iddistribution, $newquantite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectation SET nombre_restant=? WHERE id=?");
            $query->execute([$newquantite, $iddistribution]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getDistributionMax() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT MAX(id) AS Id FROM affectation");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function setPanier($iddistribution, $panier) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE affectation SET panier=? WHERE id=?");
            $query->execute([$panier, $iddistribution]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getDistributionByIdService($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT d.id AS dId,d.date AS dDate,d.nombre AS dNombre,d.nombre_restant AS dNombrerestant,d.etat AS dEtat,d.panier AS dPanier,d.active AS dActive,d.distribution_id,d.mutation_id FROM affectation d INNER JOIN mutation md ON(d.mutation_id=md.id) WHERE md.service_id='{$idservice}' ORDER BY d.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getDistributionByPreparationId($idpreparation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM affectation WHERE preparation_id='{$idpreparation}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

