<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdRavitaillement
{

    public function __construct()
    {
        
    }

    function addRavitaillement($date, $quantite, $prix, $pourcentageTVA, $dateexpiration, $delai, $type, $idattribution)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO stockage(date,quantite,prix,pourcentageTVA,dateExpiration,delai_realise,type,attribution_id) VALUES(?,?,?,?,?,?,?,?)");
            $query->execute([$date, $quantite, $prix, $pourcentageTVA, $dateexpiration, $delai, $type, $idattribution]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateDateRavitaillement($idravitaillement, $newdate)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE stockage SET date=? WHERE id=?");
            $query->execute([$newdate, $idravitaillement]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function updatePrixRavitaillement($idravitaillement, $prix)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE stockage SET prix=? WHERE id=?");
            $query->execute([$prix, $idravitaillement]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function deleteRavitaillement($idravitaillement)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM stockage WHERE id=?");
            $query->execute([$idravitaillement]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAttributionBiens($idattribution, $date, $quantite, $delai, $idbiens, $idfournisseur)
    {
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

    function activeBiens($idbiens)
    {
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

    function desactiveBiens($idbiens)
    {
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

    function getRavitaillementAll()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM stockage');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensByName($val)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT S.*,AB.fournisseur_id FROM stockage S INNER JOIN attribution AB ON(S.attribution_id=AB.id) ORDER BY S.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementAllDescSummary()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT SUM(s.quantite*s.prix) AS Sum_value ,s.date,SUM((s.pourcentageTVA/100)*(s.quantite*s.prix)) AS Sum_TVA,AB.fournisseur_id FROM stockage S INNER JOIN attribution AB ON(S.attribution_id=AB.id) ORDER BY S.id DESC GROUP BY s.date');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementById($idravitaillement)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM stockage WHERE id='{$idravitaillement}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensById($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentAllDescActive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentAllDescDesactive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseur($idfournisseur)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensAllDescEncours()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdBiensEncours($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,g.designation AS gDesignation,b.technique_gestion,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAttributionBiensByIdFournisseurEncours($idfournisseur)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND etat='0' ORDER BY a.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementAllDescByIdFournisseur($idfournisseur)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT S.* FROM stockage S INNER JOIN (attribution A INNER JOIN fournisseur F ON(A.fournisseur_id=F.id)) ON(S.attribution_id=A.id) WHERE F.id='{$idfournisseur}' ORDER BY S.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdSecond($ravitaillementId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id,s.pourcentageTVA FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE s.id='{$ravitaillementId}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdAttributionBiens($idattributionbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT S.* FROM stockage S INNER JOIN (attribution A INNER JOIN fournisseur F ON(A.fournisseur_id=F.id)) ON(S.attribution_id=A.id) WHERE S.attribution_id='{$idattributionbiens}' ORDER BY S.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementMax()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT MAX(id) AS Id FROM stockage");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementBetween2Dates($date1, $date2)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT S.*,AB.fournisseur_id FROM stockage S INNER JOIN attribution AB ON(S.attribution_id=AB.id) WHERE S.date>='{$date1}' AND S.date<='{$date2}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementBetween2DatesSummary($date1, $date2)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT SUM(s.quantite*s.prix) AS Sum_value ,s.date,SUM((s.pourcentageTVA/100)*(s.quantite*s.prix)) AS Sum_TVA,AB.fournisseur_id FROM stockage S INNER JOIN attribution AB ON(S.attribution_id=AB.id) WHERE S.date>='{$date1}' AND S.date<='{$date2}' GROUP BY s.date");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementBetween2DatesByIdBiens($date1, $date2, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE s.date>='{$date1}' AND s.date<='{$date2}' AND B.id='{$idbiens}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRavitaillementBetweenInfDate2ByIdBiens($date2, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE s.date<='{$date2}' AND B.id='{$idbiens}' ORDER BY s.id DESC LIMIT 5");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementBetween2DatesByIdBiensSummary($date1, $date2, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT SUM(s.quantite*s.prix) AS Sum_value ,s.date,SUM((s.pourcentageTVA/100)*(s.quantite*s.prix)) AS Sum_TVA,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE s.date>='{$date1}' AND s.date<='{$date2}' AND B.id='{$idbiens}' GROUP BY s.date");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE B.id='{$idbiens}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdBiensMore($idbiens,$more = '')
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE B.id='{$idbiens}' ".$more." ");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdBiensInferieurRavId($idbiens,$idravitaillement)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE B.id='{$idbiens}' AND s.id<'{$idravitaillement}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByIdBiensSummary($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT SUM(s.quantite*s.prix) AS Sum_value ,s.date,SUM((s.pourcentageTVA/100)*(s.quantite*s.prix)) AS Sum_TVA,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE B.id='{$idbiens}' GROUP BY s.date");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByNumeroOrder($numeroOrder)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT s.id,s.date,s.quantite,s.prix,s.dateExpiration,s.delai_realise,s.type,s.active,s.attribution_id,AB.fournisseur_id,AB.numeroOrder,s.pourcentageTVA FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE AB.numeroOrder='{$numeroOrder}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRavitaillementByNumeroOrderSummary($numeroOrder)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT SUM(s.quantite*s.prix) AS Sum_value ,s.date,SUM((s.pourcentageTVA/100)*(s.quantite*s.prix)) AS Sum_TVA,AB.fournisseur_id FROM stockage s INNER JOIN (attribution AB INNER JOIN biens B ON(AB.biens_id=B.id)) ON(s.attribution_id=AB.id) WHERE AB.numeroOrder='{$numeroOrder}' GROUP BY s.date");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
}
?>

