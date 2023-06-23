<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdService {

    public function __construct() {
        
    }

    function addService($designation, $entrepriseid,$prixbreakfast,$prixlunch,$prixdinner) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO service(designation,entreprise_id,prixBreakfast,prixLunch,prixDinner) VALUES(?,?,?,?,?)");
            $query->execute([$designation, $entrepriseid,$prixbreakfast,$prixlunch,$prixdinner]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateService($idservice, $designation,$prixbreakfast,$prixlunch,$prixdinner) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE service SET designation=?,prixBreakfast=?,prixLunch=?,prixDinner=? WHERE id=?");
            $query->execute([$designation,$prixbreakfast,$prixlunch,$prixdinner,$idservice]);
            $query->closeCursor();
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

    function activeService($idservice) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE service SET active=? WHERE id=?");
            $query->execute([1, $idservice]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveService($idservice) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE service SET active=? WHERE id=?");
            $query->execute([0, $idservice]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getServiceAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM service');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getServiceAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM service ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getServiceByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getServiceById($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE id='{$idservice}'");
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

}
?>

