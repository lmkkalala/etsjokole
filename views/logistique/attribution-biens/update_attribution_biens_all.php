<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/biens/biens.php';
include '../models/fournisseur/fournisseur.php';
$dateStart = '';
$dateEnd = '';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-edit" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Orders</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                    $date = date('Y-m',time());
                    $n = 0;
                    $bdattributionbiens = new BdAttributionBiens();
                    if (isset($_POST['dateStart']) and isset($_POST['dateEnd'])) {
                        if(!empty($_POST['dateStart']) and !empty($_POST['dateEnd'])){
                            $dateStart = htmlspecialchars($_POST['dateStart']);
                            $dateEnd = htmlspecialchars($_POST['dateEnd']);
                            $attributions = $bdattributionbiens->getAttributionBiensAllDesc($dateStart,$dateEnd);
                        }else{
                            $attributions = $bdattributionbiens->getAttributionBiensAllDesc($date);
                        }
                    }else{
                        $attributions = $bdattributionbiens->getAttributionBiensAllDesc($date);
                    }
                ?>
                <form action="../views/home.php?link=c70b0a92cc831c4da9cc276d3c52b00cc6c2eee1&link_up=1f920fef6c620c4660a748aae5dd44da9e74ba9b" method="post">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control" type="date" name="dateStart" id="" value="<?=$dateStart?>">
                        </div>
                        <div class="col-4">
                            <input class="form-control" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
                        </div>
                        <div class="col-4">
                            <input class="btn btn-info" type="submit" name="rechercher" id="rechercher" value="Rechercher">
                        </div>
                    </div>
                </form>
                <table id="list_update_command_logistique" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                        <th style="width: 10px;">N°</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Biens/produits</th>
                        <th>Fournisseur</th>
                        <th>Quantité / Prix</th>
                        <!-- <th></th> -->
                        <th>Délai de livraison</th>
                        <th>Opération</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($attributions as $attribution) {
                            $n++;
                        ?>
                        <form class="form-horizontal" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $attribution['aId'] ?></td>
                                    <td>
                                        <b>
                                            <?php
                                            if ($attribution['etat']) {
                                                echo 'Finalisée';
                                            } else {
                                                echo 'En cours';
                                            }
                                            ?>
                                        </b>
                                    </td>
                                    <td><input class="form-control" style="width: 100px;" type="date" name="tb_date" value="<?= $attribution['date'] ?>"></td>
                                    <td>
                                        <select class="form-control" name="cb_biens">
                                            <?php
                                            $bdbiens = new BdBiens();
                                            $biens = $bdbiens->getBiensAllDesc();
                                            foreach ($biens as $bien) {
                                                if ($attribution['bId'] == $bien['bId']) {
                                                    ?>
                                                    <option value="<?= $bien['bId'] ?>" selected><?= $bien['bDesignation'] . " : " . $bien['gDesignation'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " : " . $bien['gDesignation'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select2" name="cb_fournisseur">
                                            <?php
                                            $bdfournisseur = new BdFournisseur();
                                            $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
                                            foreach ($fournisseurs as $fournisseur) {
                                                if ($attribution['fId'] == $fournisseur['id']) {
                                                    ?>
                                                    <option value="<?= $fournisseur['id'] ?>" selected><?= $fournisseur['designation'] . " : " . $fournisseur['domaine'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['designation'] . " : " . $fournisseur['domaine'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" name="tb_quantite" value="<?= $attribution['quantite_minimale'] ?>">
                                    <!-- </td>
                                    <td> -->
                                        <input class="form-control mt-1" type="text" name="tb_prix" value="<?= $attribution['aPrixUnitaire'] ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" name="tb_delai" value="<?= $attribution['delai_livraison'] ?>">
                                    </td>
                                    <input type = "hidden" name = "tb_idattribution" value ="<?= $attribution['aId'] ?>">
                                    <td>
                                        <button type="submit" class="btn btn-primary" name="bt_modifier">
                                            <span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span>Modifier
                                        </button>
                                    </td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

