<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdBiens {

    public function __construct() {
        
    }

    function addBiens($designation, $marque, $quantite, $stockmax, $stockmin, $stockcritique, $typeperissable,$techniquegestion, $idcategorie,$prixunitaire,$codebarre) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO biens(designation,marque,quantite,stock_max,stock_min,stock_critique,type_perissable,technique_gestion,groupeBiens_id,prixunitaire,codebarre) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $query->execute([$designation, $marque, $quantite, $stockmax, $stockmin, $stockcritique, $typeperissable,$techniquegestion, $idcategorie,$prixunitaire,$codebarre]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateBiens($idbiens, $designation, $marque, $quantite, $stockmax, $stockmin, $stockcritique, $typeperissable,$techniquegestion, $idcategorie,$prixunitaire,$codebarre) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE biens SET designation=?,marque=?,quantite=?,stock_max=?,stock_min=?,stock_critique=?,type_perissable=?,technique_gestion=?,groupeBiens_id=?,prixunitaire=?,codebarre=? WHERE id=?");
            $query->execute([$designation, $marque, $quantite, $stockmax, $stockmin, $stockcritique, $typeperissable,$techniquegestion, $idcategorie,$prixunitaire,$codebarre,$idbiens]);
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

    function getBiensAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT b.prixunitaire AS bPv ,b.id AS bId,b.designation AS bDesignation,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.prixunitaire AS bPv ,b.id AS bId,b.designation AS bDesignation,b.codebarre,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT b.prixunitaire AS bPv ,b.id AS bId,b.prixunitaire,b.codebarre,b.designation AS bDesignation,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,b.prixunitaire,g.id AS gId,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) ORDER BY b.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getBiensById($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.prixunitaire AS bPv, b.id AS bId,b.prixunitaire,b.designation AS bDesignation,b.codebarre,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}'");
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
    
    function getBiensByCategorie($idcategorie) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.codebarre,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gId,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.groupeBiens_id='{$idcategorie}' ORDER BY b.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function augmenteQuantiteBiens($idbiens,$newquantite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE biens SET quantite=? WHERE id=?");
            $query->execute([$newquantite, $idbiens]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function getBiensByNameActive($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.codebarre,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE (b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%') AND b.active='1'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getBiensAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.codebarre,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.technique_gestion,b.active,g.id AS gId,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.active='1' ORDER BY b.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function diminueQuantiteBiens($idbiens,$newquantite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE biens SET quantite=? WHERE id=?");
            $query->execute([$newquantite, $idbiens]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

}
?>

