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

    function addService($designation) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("INSERT INTO service(designation) VALUES(?)");
            $query->execute([$designation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateService($idservice, $designation) {
        try {
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE service SET designation=? WHERE id=?");
            $query->execute([$designation,$idservice]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    

    function activeService($idservice) {
        try {
            $bd = ConnexionM::connecter();
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
            $bd = ConnexionM::connecter();
            $query = $bd->prepare("UPDATE service SET active=? WHERE id=?");
            $query->execute([0, $idservice]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getServiceAll() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT * FROM service');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getServiceAllDesc() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query('SELECT * FROM service ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getServiceByName($val) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getServiceById($idservice) {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE id='{$idservice}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getServiceAllDescActive() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getServiceAllDescDesactive() {
        $bd = ConnexionM::connecter();
        $reponse = $bd->query("SELECT * FROM service WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

