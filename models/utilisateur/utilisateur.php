<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdUtilisateur {

    public function __construct() {
        
    }

    function addUtilisateur($nomutilisateur, $motdepasse, $type, $idmutation) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("INSERT INTO utilisateur(nomUtilisateur,motdepasse,type,mutation_id) VALUES(?,?,?,?)");
            $query->execute([$nomutilisateur, sha1($motdepasse), $type, $idmutation]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    function updateUtilisateur($nomutilisateur, $motdepasse, $type, $idaffectation, $idutilisateur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE utilisateur SET nomUtilisateur=?,motdepasse=?,type=?,mutation_id=? WHERE id=?");
            $query->execute([$nomutilisateur, sha1($motdepasse), $type, $idaffectation, $idutilisateur]);
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

    function activeUtilisateur($idutilisateur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE utilisateur SET active=? WHERE id=?");
            $query->execute([1, $idutilisateur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    function desactiveUtilisateur($idutilisateur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE utilisateur SET active=? WHERE id=?");
            $query->execute([0, $idutilisateur]);
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

    function getUtilisateurAllDesc() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM utilisateur ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUtilisateurAllDescWhere($condition) {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM utilisateur '.$condition.' ORDER BY id DESC');
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getUtilisateurAllDescActive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM utilisateur WHERE active='1' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    function getUtilisateurAllDescDesactive() {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM utilisateur WHERE active='0' ORDER BY id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getAffectationServiceByService($idservice) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.nom,a.postnom,a.prenom,a.grade,s.designation,m.date,m.id Id,m.active,a.id Aid,s.id Sid FROM agent a INNER JOIN mutation m ON (a.id=m.agent_id) INNER JOIN service s ON (s.id=m.service_id) WHERE s.id='{$idservice}' ORDER BY m.id DESC");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getEntrepriseByName($val) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE agent.nom LIKE '%{$val}%' OR agent.postnom LIKE '%{$val}%' OR agent.prenom LIKE '%{$val}%'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getUtilisateurById($idutilisateur) {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM utilisateur WHERE id='{$idutilisateur}'");
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function getRowCountEntreprise() {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM entreprise');
        $val = $reponse->rowCount();
        return $val;
    }

    function updateUtilisateurSelf($nomutilisateur, $motdepasse, $idutilisateur) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE utilisateur SET nomUtilisateur=?,motdepasse=? WHERE id=?");
            $query->execute([$nomutilisateur, sha1($motdepasse), $idutilisateur]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

}
?>

