<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdUnite {

    public function __construct() {
        
    }

    function addUnite($code, $dateachat, $dateexpiration, $idbiens,$prix) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO unite(code,date_achat,date_expiration,biens_id,valueActuelle) VALUES(?,?,?,?,?)");
            $query->execute([$code, $dateachat, $dateexpiration, $idbiens,$prix]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateService($idservice, $designation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE service SET designation=? WHERE id=?");
            $query->execute([$designation,$idservice]);
            $query->closeCursor();
            sleep(1);
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function updateEntrepriseWithOutFile($identreprise, $designation, $sigle) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE entreprise SET designation=?,sigle=? WHERE id=?");
            $query->execute([$designation, $sigle, $identreprise]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeUnite($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active=? WHERE id=?");
            $query->execute([1, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveUnite($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active=? WHERE id=?");
            $query->execute([0, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function deleteUniteByName($value) {
        try {
            $bd = Connexion::connecter();
            $value="-".$value."-";
            $query = $bd->prepare("DELETE FROM unite WHERE code LIKE %'{$value}'%");
            $query->execute([0, $value]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    function activeUniteDistribution($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active_distribution=? WHERE id=?");
            $query->execute([1, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    function desactiveUniteDistribution($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active_distribution=? WHERE id=?");
            $query->execute([0, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getUniteAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM unite');
        sleep(2);
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUniteAllLimit($l) {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM unite Limit '.$l.'');
        sleep(2);
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getUniteAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM unite ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUniteByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM unite WHERE unite.code LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUniteByIdBiens($idbiens) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM unite WHERE biens_id='{$idbiens}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUniteById($uniteId) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM unite WHERE id='{$uniteId}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRowCountEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        $val=$reponse->rowCount();
        return $val;
    }

    function getServiceAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getServiceAllDescDesactive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function activePrincipalUnite($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active_principal=? WHERE id=?");
            $query->execute([1, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactivePrincipalUnite($idunite) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET active_principal=? WHERE id=?");
            $query->execute([0, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateUniteValueActuelle($idunite,$valeurActuelle) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE unite SET valueActuelle=? WHERE id=?");
            $query->execute([$valeurActuelle, $idunite]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

}
?>

