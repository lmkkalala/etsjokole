<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<legend>Sales list</legend>
    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <td>
                    Info
                </td>
                <td>
                    Article
                </td>
                <td>
                    Quantite
                </td>
                <td>
                    Price (USD)
                </td>
                <td>
                    Value HT (USD)
                </td>
                <td>
                    Value TVA (USD)
                </td>
                <td>
                    Value TTC (USD)
                </td>
                <td>
                    Plus
                </td>
            </tr>
        </thead>
        <tbody>
            <div id="sell_list_data">
                <?php
                $n = 0;
                if (1) {
                    $use = @$_GET['service'];//$_SESSION['idservice'];
                } else {
                    $use = 0;
                }
                
                $bddistribution = new BdDistribution();
                
                if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
                    $distributions = $bddistribution->getDistributionBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
                } else {
                    $distributions = $bddistribution->getDistributionAllDesc();
                }

                if (!(isset($_GET['use_ventePOS']))) {
                    $distributions=[];
                }
                
                $cumul_value = 0;
                $cumul_tva=0;
                $cumul_value_total=0;
                
                foreach ($distributions as $distribution) {

                    if (($distribution['venteposId'] == $_GET['use_ventePOS'])) {

                        $affiche_bon = false;

                        $bdlivraison = new BdLivraison();
                        $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                        foreach ($livraisons as $livraison) {
                            $bddemande = new BdDemande();
                            $demandes = $bddemande->getDemandeById($livraison['demande_id']);
                            foreach ($demandes as $demande) {
                                $bdaffectation = new BdAffectationService();
                                $affectations = $bdaffectation->getAffectationServiceById($demande['mutation_id']);
                                foreach ($affectations as $affectation) {
                                    if ($affectation['service_id'] == $use) {
                                        $affiche_bon = true;
                                    }
                                }
                            }
                            $idaffectation_online = $livraison['dIdmutation'];
                            $infolivraison = $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'];
                        }
                        if (isset($infolivraison) && ($affiche_bon) && ($distribution['nombre_restant'] > 0)) {
                            $n++;
                            ?>
                            <tr>
                                <td>
                                    N° Vente: <?= $distribution['venteposId'] ?> <br>
                                    N°: <?= $distribution['id'] ?> <br>
                                    Date: <?= $distribution['date'].' à '.$distribution['time'] ?> <br>
                                    Noms: <strong style="color: #0080c0;"><?= $distribution['identiteClient'] ?></strong>
                                </td>
                                <td><?= $infolivraison ?></td>
                                <td><?= $distribution['nombre_restant'] ?></td>
                                <td><?= $distribution['price'] ?></td>
                                <td style="color: dodgerblue;">
                                    <?php
                                    echo ($distribution['nombre_restant'] * $distribution['price']);
                                    $cumul_value = $cumul_value + ($distribution['nombre_restant'] * $distribution['price']);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    echo (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                                    $cumul_tva=$cumul_tva+ (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                                    ?>
                                </td>
                                <td style="color: forestgreen; font-weight: 700;">
                                    <?php
                                    echo (($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                    $cumul_value_total=$cumul_value_total+(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                    ?>
                                </td>
                                <td>
                                    <div class="row">
                                        <?php if($distribution['typePaiement'] == 'CASH_A_RETIRER'){ ?>
                                        <div class="col-md-12">
                                            <form class="form-horizontal" method="POST" action="../contollers/distribution/distributionController.php">
                                                <div class="input-group-lg">
                                                    <input class="btn btn-info text-white w-100" type="submit" name="bt_RetirerDistribution" value="Retirer Quantite">
                                                    <input type="hidden" name="quantiteVendu" value="<?= $distribution['nombre_restant'] ?>">
                                                    <input type="hidden" name="typePaiement" value="<?= $distribution['typePaiement'] ?>">
                                                    <input type="hidden" name="distribution_id" value="<?= $distribution['distribution_id'] ?>">
                                                    <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                                    <input type="hidden" name="tb_use_identiteClient" value="<?= $_GET['use_identiteClient'] ?>">
                                                    <input type="hidden" name="tb_use_date" value="<?= $_GET['use_date'] ?>">
                                                    <input type="hidden" name="tb_use_typerepas" value="<?= $_GET['use_typerepas'] ?>">
                                                    <input type="hidden" name="tb_use_ventePOS" value="<?= $_GET['use_ventePOS'] ?>">
                                                    <input type="hidden" name="row_affectationID" value="<?= $distribution['id'] ?>">
                                                </div>
                                            </form>
                                        </div>
                                        <?php } ?>
                                        <div class="col-md-12 mt-2">
                                            <form class="form-horizontal" id="delete_sell_<?= $distribution['id'] ?>" onsubmit="delete_sell(event,<?= $distribution['id'] ?>)" method="POST" action="../contollers/distribution/distributionController.php">
                                                <div class="input-group-lg">
                                                    <button class="btn btn-danger w-100" type="submit"><i class="btn-dange fa fa-trash"></i></button>
                                                    <input class="btn btn-danger w-100" type="hidden" id="bt_delete_lineDistribution" name="bt_delete_lineDistribution">
                                                    <input type="hidden" id="tb_idaffectation" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                                    <input type="hidden" id="tb_distributionId" name="tb_distributionId" value="<?= $distribution['id'] ?>">
                                                    <input type="hidden" id="typePaiement" name="typePaiement" value="<?= $distribution['typePaiement'] ?>">
                                                    <input type="hidden" id="tb_use_date" name="tb_use_date" value="<?= $_GET['use_date'] ?>">
                                                    <input type="hidden" id="tb_use_typerepas" name="tb_use_typerepas" value="<?= $_GET['use_typerepas'] ?>">
                                                    <input type="hidden" id="tb_use_identiteClient" name="tb_use_identiteClient" value="<?= $_GET['use_identiteClient'] ?>">
                                                    <input type="hidden" id="tb_use_ventePOS" name="tb_use_ventePOS" value="<?= $_GET['use_ventePOS'] ?>">
                                                    <input type="hidden" id="row_affectationID" name="row_affectationID" value="<?= $distribution['id'] ?>">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </tbody>
        <tfoot>
            <tr>
                <td><span><?= $n ?></span></td>
                <td><span>Nombre</span></td>
                <td><span> Total  HT : </span></td>
                <td style="font-weight: bold; color: dodgerblue;">
                    <span><?= $cumul_value ?> USD</span>
                </td>
                <td><span> Total TVA : </span></td>
                <td style="font-weight: bold;">
                    <span><?= $cumul_tva ?> USD</span>
                </td>
                <td><span> Total TTC : </span></td>
                <td style="font-weight: bold; color: forestgreen;">
                    <span><?= $cumul_value_total ?> USD</span>
                </td>
            </tr>
        </tfoot>
        
    </table>

