<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

include '../models/unite/unite.php';

include '../models/biens/biens.php';

include '../models/amortissement/Amortissement.php';

include '../models/ravitaillement/ravitaillement.php';



?>

<div class="panel">

    <div class="panel panel-heading">

        <span class="fa fa-archive" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>

        <span class="h3">Amortissement</span>

        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>

        <span class="fa fa-bars" style="color: dodgerblue; font-size: 30px;margin-right: 5px;"></span>

        <span class="h4">Les configurations</span>

    </div>

    <div class="panel panel-body">

        <div>

                

                <?php

                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {

                ?>

                    <div class="alert alert-success">

                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Opération effectuée avec succès</span>

                    </div>

                <?php

                }

                ?>

                <?php

                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {

                ?>

                    <div class="alert alert-danger">

                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'activation</span>

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

                <fieldset>

                    <legend>Rechercher :</legend>

                    <form class="form-inline" method="POST" action="../contollers/amortissement/amortissementController.php">

                        <div class="row form-group-lg">

                            <div class="col-6">
                                <select class="form-control select2" name="cb_biens">

                                <option value="0">Choose item</option>

                                <?php

                                $bdbiens = new BdBiens();

                                $biens = $bdbiens->getBiensAllDesc();

                                foreach ($biens as $bien) {

                                    if (1) {

                                        if (1) {

                                ?>

                                <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " / Marque : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>

                                <?php
                                        }

                                    }

                                }
                                ?>

                                </select>
                            </div>

                            <div class="col-6">
                                <button type="submit" class="btn btn-success" name="bt_search_for_biens"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                            </div>

                        </div>

                    </form>

                </fieldset>

                <table class="table table-dark table-striped">

                    <thead class="thead-light">

                        <tr>

                            <th>Item</th>

                            <th>Valeur actuelle</th>

                            <th>Date Set</th>

                            <th>Date debut</th>

                            <th>Prix acquisition (USD)</th>

                            <th>Time</th>

                            <th>...</th>

                            <th>...</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $c = 0;

                        $cumul_costing = 0;

                        $bdAmortissement = new BdAmortissement();

                        if ((isset($_GET['use']) && ($_GET['use']!=0))) {

                            $amortissements = $bdAmortissement->getAmortissementByBiensId($_GET['use']);

                        } else {

                            $amortissements = $bdAmortissement->getAmortissementAll();

                        }

                        

                        foreach ($amortissements as $amortissement) {

                            $c++;



                        ?>

                            <tr>

                                <td>

                                    <?php

                                    $cumul_total_fournisseur = 0;

                                    $cumul_TVA_fournisseur = 0;

                                    $n = 0;

                                    $bdunite = new BdUnite();

                                    $unites = $bdunite->getUniteById($amortissement['uniteId']);

                                    foreach ($unites as $unite) {

                                        if (1) {

                                            $n++;

                                            $chaine_part_ravitaillement_sortie = "";

                                            $chaine_part_ravitaillement_reste = "";

                                            $bdBiens = new BdBiens();

                                            $biens = $bdBiens->getBiensById($unite['biens_id']);

                                            foreach ($biens as $bien) {

                                                $designation_biens = $bien['bDesignation'];

                                            }

                                            $code_unite = $unite['code'];

                                        }

                                    }

                                    echo "Code : " . $code_unite . " / " . $designation_biens;

                                    ?>

                                </td>

                                <td>

                                    <?= $unite['valueActuelle'] . " USD" ?>

                                </td>





                                <?php

                                $prix_unitaire = $unite['valueActuelle'];





                                ?>

                                </td>

                                <td><?= $amortissement['dateSet'] ?></td>

                                <td><?= $amortissement['dateDebut'] ?></td>

                                <td><?= $amortissement['prixAcquisition'] ?></td>

                                <td><?= $amortissement['duree'] ?> years</td>

                                <td>

                                    <form class="form-horizontal" method="post" action="../contollers/amortissement/amortissementController.php">

                                        <input type="hidden" name="tb_idamortissement" value="<?= $amortissement['id'] ?>">

                                        <input type="hidden" name="tb_idunite" value="<?= $amortissement['uniteId'] ?>">

                                        <button type="submit" class="btn btn-danger" name="bt_delete"><span class="fa fa-trash-o"></span> Delete</button>

                                    </form>

                                </td>

                                <td>

                                    <form class="form-horizontal" method="post" action="../contollers/amortissement/amortissementController.php">

                                        <input type="hidden" name="tb_idamortissement" value="<?= $amortissement['id'] ?>">

                                        <input type="hidden" name="tb_idunite" value="<?= $amortissement['uniteId'] ?>">

                                        <button type="submit" class="btn btn-primary" name="bt_for_dotation"><span class="fa fa-bars"></span> Ajouter une dotation</button>

                                    </form>

                                </td>

                            </tr>

                        <?php

                        }



                        ?>



                    </tbody>

                    <tfoot>

                        <tr>

                            <th><strong> # : <?= $c  ?></strong></th>



                        </tr>

                    </tfoot>

                </table>



            </fieldset>

        </div>

    </div>

</div>