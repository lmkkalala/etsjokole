<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdAgent {

    public function __construct() {
        
    }

    function addAgent($id,$nom, $postnom, $prenom, $sexe, $grade, $codebar, $urlPhoto) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO agent(id,nom,postnom,prenom,sexe,grade,codebar,urlPhoto) VALUES(?,?,?,?,?,?,?,?)");
            $query->execute([$id,$nom, $postnom, $prenom, $sexe, $grade, $codebar, $urlPhoto]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAgent($idagent, $nom, $postnom, $prenom, $sexe, $grade, $codebar,$start_time, $end_time, $daily_sell,$multi_seller_account) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE agent SET nom=?,postnom=?,prenom=?,sexe=?,grade=?,codebar=?,start_time=?,end_time = ?, daily_sell=?,multi_seller_account=? WHERE id=?");
            $query->execute([$nom, $postnom, $prenom, $sexe, $grade, $codebar, $start_time, $end_time, $daily_sell,$multi_seller_account, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function updateAgentWithPhoto($idagent, $nom, $postnom, $prenom, $sexe, $grade, $codebar, $urlPhoto,$start_time, $end_time, $daily_sell,$multi_seller_account) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE agent SET nom=?,postnom=?,prenom=?,sexe=?,grade=?,codebar=?,urlPhoto=?,start_time=?,end_time = ?,daily_sell=?,multi_seller_account=? WHERE id=?");
            $query->execute([$nom, $postnom, $prenom, $sexe, $grade, $codebar, $urlPhoto, $start_time, $end_time, $daily_sell,$multi_seller_account, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function activeAgent($idagent) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE agent SET active=? WHERE id=?");
            $query->execute([1, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveAgent($idagent) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE agent SET active=? WHERE id=?");
            $query->execute([0, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getAgentAll() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM agent');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentMaxId() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT MAX(id) as recentId FROM agent');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM agent ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

   

    function getAgentById($idagent) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE id='{$idagent}'");
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

    function getAgentAllAlphaActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='1' ORDER BY nom,postnom,prenom ASC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAgentByCodebar($codebar) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE codebar='{$codebar}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

}
?>

