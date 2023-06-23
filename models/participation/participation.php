<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class BdParticipation
{
    public function __construct()
    {
    }

    public function addParticipation($preparationId, $productionId, $portionPreparation)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('INSERT INTO participation(dateEnreg,portionPreparation,preparationId,productionId) VALUES(?,?,?,?)');
            $query->execute([date('Y-m-d'), $portionPreparation, $preparationId, $productionId]);
            $query->closeCursor();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateParticipation($participationId, $portionPreparation)
    {
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare('UPDATE participation SET portionPreparation=? WHERE id=?');
            $query->execute([$portionPreparation, $participationId]);
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

    public function getParticipationAllDesc()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT PT.id,PT.active,PT.dateEnreg,PT.portionPreparation,PR.dateHeure AS dateHeurePR,PR.typerepas,PD.dateHeure as pdDateHeure,PD.quantite,N.designation FROM participation PT INNER JOIN productionnourriture PD ON(PT.productionId=PD.id) INNER JOIN (preparation PR INNER JOIN nourriture N ON(PR.nourriture_id=N.id)) ON(PT.preparationId=PR.id) ORDER BY PT.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getParticipationByMutationDesc($affectationId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PT.id,PT.active,PT.dateEnreg as ptDate,PT.portionPreparation,PR.id as prId,PR.dateHeure AS prDateHeure,PR.typerepas,PD.dateHeure as pdDateHeure,PD.quantite,N.designation FROM participation PT INNER JOIN (productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id)) ON(PT.productionId=PD.id) INNER JOIN preparation PR ON(PT.preparationId=PR.id) WHERE PR.mutation_id='{$affectationId}' ORDER BY PT.id DESC");

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getParticipationByPreparationIdByProductionId($preparationId,$productionId)
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query("SELECT PT.id,PT.active,PT.dateEnreg as ptDate,PT.portionPreparation,PR.id as prId,PR.dateHeure AS prDateHeure,PR.typerepas,PD.dateHeure as pdDateHeure,PD.quantite,N.designation FROM participation PT INNER JOIN (productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id)) ON(PT.productionId=PD.id) INNER JOIN preparation PR ON(PT.preparationId=PR.id) WHERE PT.preparationId='{$preparationId}' AND PT.productionId='{$productionId}' ORDER BY PT.id DESC");

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

    public function getProductionAllSecond()
    {
        $bd = Connexion::connecter();
        $reponse = $bd->query('SELECT PD.id,PD.active,PD.dateHeure AS dateHeurePD,PD.quantite,N.designation FROM productionnourriture PD INNER JOIN nourriture N ON(PD.nourriture_id=N.id) ORDER BY PD.id DESC');

        return $reponse->fetchAll();
        $reponse->closeCursor();
    }
}
?>

