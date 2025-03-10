<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/preparation/preparation.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des demandes</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-check-circle-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des demandes finalisées</span>
    </div>
    <?php
        $date = date('Y-m',time());
        $n = 0;
        $produit = (isset($_POST['produit']) and !empty($_POST['produit']))? htmlspecialchars($_POST['produit']) : '';
        $dateStart = (isset($_POST['dateStart']) and !empty($_POST['dateStart']))? htmlspecialchars($_POST['dateStart']): '';
        $dateEnd = (isset($_POST['dateEnd']) and !empty($_POST['dateEnd']))? htmlspecialchars($_POST['dateEnd']): '';

        if (isset($_POST['dateStart']) and isset($_POST['dateEnd']) and isset($_POST['produit']) ) {
            
            if(!empty($dateStart) and !empty($dateEnd) and !empty($produit)){
                $condition = ' AND b.designation LIKE "%'.htmlspecialchars($produit).'%" AND d.date >= "'.$dateStart.'" AND d.date <= "'.$dateEnd.'"';
            }else if(empty($produit) and empty($dateStart) and empty($dateStart)){
                $condition = 'WHERE d.date LIKE "%'.date('Y-m').'%"';
            }else if (empty($produit)) {
                $condition = ' AND d.date >= "'.$dateStart.'" AND d.date <= "'.$dateEnd.'"';
            }else if (empty($dateStart)) {
                $condition = ' AND d.date >= "'.date('Y-m-d').'" AND d.date <= "'.$dateEnd.'"';
            }else if (empty($dateEnd)) {
                $condition = ' AND d.date >= "'.$dateStart.'" AND d.date <= "'.date('Y-m-d').'"';
            }
        }else{
            $condition = 'AND d.date LIKE "%'.date('Y').'%"';
        }
    ?>
    <form action="../views/home.php?link=a8d1e2f803842632444a86582653072b3f044e62&link_up=3352d32225bbc9f830f184b95bb7008982f6ac56" method="post">
        <div class="row mt-3 mb-3">
            <div class="col-md-3">
                <input class="form-control" type="text" name="produit" id="" value="<?=$produit?>">
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="dateStart" id="" value="<?=$dateStart?>">
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
            </div>
            <div class="col-md-3">
                <input class="btn btn-secondary w-100" type="submit" name="rechercher" id="rechercher" value="Rechercher">
            </div>
        </div>
    </form>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Demandes finalisées</legend>
                <table id="listdatabyid" class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Biens/produit
                    </th>
                    <th>
                        Preparation
                    </th>
                    <th>
                        Agent demandeur
                    </th>
                    <th>
                        Service
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bddemande = new BdDemande();
                        $demandes = $bddemande->getDemandeAllDescFinalise($condition);
                        foreach ($demandes as $demande) {
                            if ($demande['qualiteDemandeur'] == "other") {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $demande['dId'] ?></td>
                                    <td><?= $demande['date'] ?></td>
                                    <td><?= $demande['bDesignation'] . " / " . $demande['gDesignation'] ?></td>
                                    <td>
                                        <?php
                                        $bdpreparation = new BdPreparation();
                                        $preparations = $bdpreparation->getPreparationById($demande['preparation_id']);
                                        foreach ($preparations as $preparation) {
                                            echo $preparation['dateHeure'] . " / " . $preparation['typerepas'];
                                        }
                                        ?>
                                    </td>
                                    <td><?= $demande['nom'] . " " . $demande['postnom'] . " " . $demande['prenom'] ?></td>
                                    <td><?= $demande['sDesignation'] ?></td>
                                    <td><?= $demande['dQuantite'] ?></td>
                                    <td>
                                        <?php
                                        if ($demande['dEtat'] == 0) {
                                            ?>
                                            <h4 style="color: forestgreen;">Encours</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Finalisée</h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                       <tr>
                            <td style="font-size: 20px;">
                                <span><?= $n ?></span>
                            </td>
                            <td><span>Nombre:</span></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                       </tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

