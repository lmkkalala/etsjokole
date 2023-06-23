<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdProduction
{
    public function __construct()
    {
    }

    public function addProduction($idnourriture, $dateheure, $quantite,$prixUnitaireVente,$serviceId)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('INSERT INTO productionnourriture(dateHeure,quantite,prixunitaire,nourriture_id,serviceId) VALUES(?,?,?,?,?)');
            $query->execute([$dateheure, $quantite,$prixUnitaireVente, $idnourriture,$serviceId]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateCategorie($idcategorie, $designation)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE groupebiens SET designation=? WHERE id=?');
            $query->execute([$designation, $idcategorie]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function activeProduction($idproduction)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE productionnourriture SET active=? WHERE id=?');
            $query->execute([1, $idproduction]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function desactiveProduction($idproduction)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE productionnourriture SET active=? WHERE id=?');
            $query->execute([0, $idproduction]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getCategorieAll()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM groupebiens');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getCategorieByName($val)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM groupebiens AS g WHERE g.designation LIKE '%{$val}%'");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getCategorieAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT * FROM groupebiens ORDER BY id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getCategorieById($idcategorie)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT * FROM groupebiens WHERE id='{$idcategorie}'");

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

    public function getProductionAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,PR.dateHeure AS dateHeurePR,N.designation FROM productionnourriture PD INNER JOIN preparation PR ON(PD.preparation_id=PR.id) INNER JOIN nourriture N ON(PD.nourriture_id=N.id) ORDER BY PD.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function updateQuantiteProduction($idproduction, $quantite)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE productionnourriture SET quantite=? WHERE id=?');
            $query->execute([$quantite, $idproduction]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getProductionByMutationDesc($idaffectationservice)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) ORDER BY PD.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionByNourritureId($nourritureId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE N.id='{$nourritureId}' ORDER BY PD.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionByNourritureIdByServiceId($nourritureId,$serviceId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE N.id='{$nourritureId}' AND PD.serviceId='{$serviceId}' ORDER BY PD.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionByNourritureIdByServiceIdByDate1ByDate2($nourritureId,$serviceId,$date1,$date2)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE N.id='{$nourritureId}' AND PD.serviceId='{$serviceId}' AND PD.dateHeure>='{$date1}' AND PD.dateHeure<='{$date2}' ORDER BY PD.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionByServiceId($serviceId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE PD.serviceId='{$serviceId}' ORDER BY PD.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionAllSecond()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT PD.id,PD.serviceId,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,PD.prixunitaire as prixUnitaireVente,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) ORDER BY PD.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getProductionById($productionId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) WHERE PD.id='{$productionId}' ORDER BY PD.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
}
?>

