<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdCustomer
{
    public function __construct()
    {
    }

    public function addCustomer($identite, $telephone, $email, $siteweb, $addedbyID = null)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('INSERT INTO customer(identite,telephone,email,siteweb,addedbyID) VALUES(?,?,?,?,?)');
            $query->execute([$identite, $telephone, $email, $siteweb, $addedbyID]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateCustomer($id, $identite, $telephone, $email, $siteweb)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE customer SET identite=?, telephone=?, email=?, siteweb=? WHERE id=?');
            $query->execute([$identite, $telephone, $email, $siteweb, $id]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function activeAddsIn($idAddsIn)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE customer SET active=? WHERE id=?');
            $query->execute([1, $idAddsIn]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function desactiveAddsIn($idAddsIn)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE customer SET active=? WHERE id=?');
            $query->execute([0, $idAddsIn]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getCustomerAll()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM customer ORDER BY id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getCustomerById($customerId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM customer WHERE id='{$customerId}' ORDER BY id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getCustomerAllActive($connectedUserID = null)
    {
        $bd = Connexion::connecter();
        if ($connectedUserID != null ) {
            $reponse = $bd->query("SELECT * FROM customer WHERE addedbyID='{$connectedUserID}' ORDER BY id DESC");
        }else{
            $reponse = $bd->query('SELECT * FROM customer WHERE active=1 ORDER BY id DESC');
        }
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    function deleteCustomer($id) {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM customer WHERE id=?");
            $query->execute([$id]);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getAddsInById($addsinId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM addsin WHERE id='{$addsinId}' ORDER BY id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAddsInActive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM addsin WHERE active=1 ORDER BY id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getBiensByName($val)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.designation LIKE '%{$val}%' OR g.designation LIKE '%{$val}%' OR b.marque LIKE '%{$val}%'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) ORDER BY a.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getBiensById($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT b.id AS bId,b.designation AS bDesignation,b.marque,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAgentAllDescActive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='1' ORDER BY id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAgentAllDescDesactive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM agent WHERE active='0' ORDER BY id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensByIdFournisseur($idfournisseur)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensAllDescEncours()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE etat='0' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensByIdBiensEncours($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,g.designation AS gDesignation,b.technique_gestion,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE b.id='{$idbiens}' AND etat='0' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getAttributionBiensByIdFournisseurEncours($idfournisseur)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE f.id='{$idfournisseur}' AND etat='0' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function finaliseAttribution($idattribution)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE attribution SET etat=? WHERE id=?');
            $query->execute([1, $idattribution]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getAttributionBiensById($idattribution)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite_minimale,a.etat,b.designation AS bDesignation,b.technique_gestion,b.quantite,a.delai_livraison,g.designation AS gDesignation,f.designation AS fDesignation,f.domaine,a.active,g.id AS gId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fournisseur f ON(a.fournisseur_id=f.id) WHERE a.id='{$idattribution}' ORDER BY a.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeAllDescEncours()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.etat='0' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) ORDER BY d.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeAllDescFinalise()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.etat='1' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeDescByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeDescByIdBiensEncours($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' AND d.etat='0' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeDescByIdService($idservice)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getDemandeDescByIdServiceEncours($idservice)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND d.etat='0' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function finaliseDemande($iddemande)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE demande SET etat=? WHERE id=?');
            $query->execute([1, $iddemande]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getDemandeById($iddemande)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.id='{$iddemande}' ORDER BY d.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
}
?>

