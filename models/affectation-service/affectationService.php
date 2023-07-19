<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdAffectationService {

    public function __construct() {
        
    }

    function addAffectationService($date,$agentid, $serviceid,$fonctionid) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO mutation(date,agent_id,service_id,fonction_id) VALUES(?,?,?,?)");
            $query->execute([$date, $agentid, $serviceid,$fonctionid]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateAffectationService($idaffectation, $date, $agentid, $serviceid,$fonctionid) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE mutation SET date=?,agent_id=?,service_id=?,fonction_id=? WHERE id=?");
            $query->execute([$date, $agentid, $serviceid,$fonctionid, $idaffectation]);
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

    function activeAffectationService($idaffectation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE mutation SET active=? WHERE id=?");
            $query->execute([1, $idaffectation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveAffectationService($idaffectation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE mutation SET active=? WHERE id=?");
            $query->execute([0, $idaffectation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getAffectationServiceAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM mutation');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationServiceAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.fonction_id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) ORDER BY m.id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
//    WARNING "GRANDE MODIFICATION, ICI AFFICHAGE DE TOUS LES SERVICES SANS CONTROLE"
    
    function getAffectationServiceByService($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE s.id<>0 ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getEntrepriseByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAffectationServiceById($idaffectation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM mutation WHERE id='{$idaffectation}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationServiceByIdSecond($idaffectation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE m.id='{$idaffectation}' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAffectationServiceByIdSecondUser($idaffectation) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE a.id='{$idaffectation}' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRowCountEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        $val=$reponse->rowCount();
        return $val;
    }
    
    function getAffectationServiceAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE m.active='1' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationServiceAllDescDesactive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE m.active='0' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getAffectationServiceByIdAgentSecond($idagent) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE a.id='{$idagent}' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }


}
?>

