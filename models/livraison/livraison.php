<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdLivraison
{
    public function __construct()
    {
    }

    public function addLivraison($date, $quantite, $iddemande, $idaffectation)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('INSERT INTO distrubution(date,quantite,quantite_actuelle,demande_id,mutation_id) VALUES(?,?,?,?,?)');
            $query->execute([$date, $quantite, $quantite, $iddemande, $idaffectation]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateDateLivraison($idlivraison, $newdate)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET date=? WHERE id=?');
            $query->execute([$newdate, $idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function activeBiens($idbiens)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE biens SET active=? WHERE id=?');
            $query->execute([1, $idbiens]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deleteLivraison($idlivraison)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('DELETE FROM distrubution WHERE id=?');
            $query->execute([$idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateLivraisonQuantiteActuelle($idlivraison, $new_actuelle_quantite)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET quantite_actuelle=? WHERE id=?');
            $query->execute([$new_actuelle_quantite, $idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getAttributionBiensAll()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT a.id AS aId,a.date,a.delai_livraison,a.quantite,b.designation AS bDesignation,g.designation AS gDesignation,f.designation AS fDesignation,a.active,c.id AS cId,b.id AS bId,f.id AS fId FROM attribution a INNER JOIN (biens b INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)) ON(a.biens_id=b.id) INNER JOIN fourniseur f ON(a.fournisseur_id=f.id)');

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

    public function recupereLivraison($idlivraison)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET etat=? WHERE id=?');
            $query->execute([1, $idlivraison]);
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

    public function getLivraisonAll()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.quantite_actuelle AS lQuantiteActuelle,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.preparation_id as preparationId,d.etat AS dEtat,d.mutation_id AS dIdmutation,l.panier,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) ORDER BY l.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
    
    public function getLivraisonByPreparationId($preparationId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.quantite_actuelle AS lQuantiteActuelle,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.preparation_id as preparationId,d.etat AS dEtat,d.mutation_id AS dIdmutation,l.panier,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation,b.id AS bId  FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.preparation_id='{$preparationId}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllDescByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,l.panier,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllAscByIdBiensInferieurEgaleDate1($idbiens, $date1)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,l.panier,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' AND l.date<='{$date1}' ORDER BY l.id ASC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllAscByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,l.panier,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ORDER BY l.id ASC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonDescByIdService($idservice)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.quantite_actuelle,l.demande_id AS lidDemande,l.mutation_id AS lidMutation,ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation,d.preparation_id FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonWithQuantitePositive()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,b.prixunitaire,b.codebarre,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.quantite_actuelle>'0' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonWithQuantitePositiveByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.quantite_actuelle>'0' AND b.id='{$idbiens}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonWithQuantiteByIdBiens($idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonWithQuantiteByIdBiensWhere($idbiens, $and = '')
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE b.id='{$idbiens}' ".$and." ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonById($idlivraison)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.demande_id,l.panier,l.etat,l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.id='{$idlivraison}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonByDemande($demandeId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.prix as lPrix,l.demande_id,l.panier,l.etat,l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE d.id='{$demandeId}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function diminueQuantiteLivraison($idlivraison, $newquantite)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET quantite_actuelle=? WHERE id=?');
            $query->execute([$newquantite, $idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function augmenteQuantiteLivraison($idlivraison, $newquantite)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET quantite_actuelle=? WHERE id=?');
            $query->execute([$newquantite, $idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function setPanier($idlivraison, $panier)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE distrubution SET panier=? WHERE id=?');
            $query->execute([$panier, $idlivraison]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getLivraisonMax()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT MAX(l.id) AS lId FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id)');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonMaxSecond()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT MAX(id) AS lId FROM distrubution');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonByIdByIdMutation($idlivraison, $idmutation)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN service sl ON(ml.service_id=sl.id) INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE ml.id='{$idmutation}' AND l.id='{$idlivraison}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonByIdByIdService($idlivraison)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.demande_id,l.panier,l.quantite_actuelle,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.etat AS lEtat,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN service sl ON(ml.service_id=sl.id) INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.id='{$idlivraison}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonDescByIdServiceBetween2Dates($idservice, $date1, $date2)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT d.preparation_id,l.panier,l.etat,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND l.date>='{$date1}' AND l.date<='{$date2}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllBetween2Dates($date1, $date2)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,l.etat,d.preparation_id,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.date>='{$date1}' AND l.date<='{$date2}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonDescByIdServiceBetween2DatesByTyperepas($idservice, $date1, $date2, $typerepas)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT d.preparation_id,l.panier,l.etat,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN preparation p ON(d.preparation_id=p.id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND l.date>='{$date1}' AND l.date<='{$date2}' AND p.typerepas='{$typerepas}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllBetween2DatesByTyperepas($date1, $date2, $typerepas)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,l.etat,d.preparation_id,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN preparation p ON(d.preparation_id=p.id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.date>='{$date1}' AND l.date<='{$date2}' AND p.typerepas='{$typerepas}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonDescByIdServiceBetween2DatesByTyperepasByIdBiens($idservice, $date1, $date2, $typerepas, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT d.preparation_id,l.panier,l.etat,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN preparation p ON(d.preparation_id=p.id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND l.date>='{$date1}' AND l.date<='{$date2}' AND p.typerepas='{$typerepas}' AND b.id='{$idbiens}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllBetween2DatesByTyperepasByIdBiens($date1, $date2, $typerepas, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,l.etat,d.preparation_id,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN preparation p ON(d.preparation_id=p.id) INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.date>='{$date1}' AND l.date<='{$date2}' AND p.typerepas='{$typerepas}' AND b.id='{$idbiens}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonDescByIdServiceBetween2DatesByIdBiens($idservice, $date1, $date2, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT d.preparation_id,l.panier,l.etat,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id AS dIdmutation,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE s.id='{$idservice}' AND l.date>='{$date1}' AND l.date<='{$date2}' AND b.id='{$idbiens}' ORDER BY l.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getLivraisonAllBetween2DatesByIdBiens($date1, $date2, $idbiens)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT l.panier,l.etat,d.preparation_id,agl.nom AS lNom, agl.postnom AS lPostnom,agl.prenom AS lPrenom,l.id AS lId,l.date AS lDate,l.quantite AS lQuantite,l.demande_id AS lidDemande,l.mutation_id AS lidMutation, ag.id AS agId,ag.nom,ag.postnom,ag.prenom,s.id AS sId,s.designation AS sDesignation,d.id AS dId,d.date,d.quantite AS dQuantite,d.etat AS dEtat,d.mutation_id,b.id AS bId,b.designation AS bDesignation,b.marque,b.technique_gestion,b.quantite,b.stock_max,b.stock_min,b.stock_critique,b.type_perissable,b.active,g.id AS gID,g.designation AS gDesignation FROM biens b INNER JOIN (demande d INNER JOIN (mutation m INNER JOIN agent ag ON(m.agent_id=ag.id) INNER JOIN service s ON(m.service_id=s.id)) ON(d.mutation_id=m.id) INNER JOIN (distrubution l INNER JOIN (mutation ml INNER JOIN agent agl ON(ml.agent_id=agl.id)) ON(l.mutation_id=ml.id)) ON(d.id=l.demande_id)) ON(b.id=d.biens_id) INNER JOIN groupebiens g ON(b.groupeBiens_id=g.id) WHERE l.date>='{$date1}' AND l.date<='{$date2}' AND b.id='{$idbiens}'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
}
?>

