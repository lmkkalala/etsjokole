<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdEntreprise {

    public function __construct() {
        
    }

    function addEntreprise($designation, $sigle, $url_logo) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO entreprise(designation,sigle,url_logo) VALUES(?,?,?)");
            $query->execute([$designation, $sigle, $url_logo]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateEntrepriseWithFile($identreprise, $designation, $sigle, $url_logo) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE entreprise SET designation=?,sigle=?,url_logo=? WHERE id=?");
            $query->execute([$designation, $sigle, $url_logo, $identreprise]);
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

    function activeAgent($idagent) {
        try {
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
            $query = $bd->prepare("UPDATE agent SET active=? WHERE id=?");
            $query->execute([0, $idagent]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function getEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getEntrepriseByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getEntrepriseById($identreprise) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM entreprise WHERE id='{$identreprise}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getRowCountEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        $val=$reponse->rowCount();
        return $val;
    }


}
?>

