<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="table table-bordered table-responsive-lg">
    <thead>
    <th>
        N°
    </th>
    <th>
        Date
    </th>
    <th>
        Livraison
    </th>
    <th>
        Les unités
    </th>
    <th>
        Agent preneur
    </th>
    <th>
        Quantité
    </th>
    <th>
        Quantité non récuperée
    </th>
    <th>
        Etat
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bddistribution = new BdDistribution();
    $distributions = $bddistribution->getDistributionAllDesc();
    foreach ($distributions as $distribution) {
        $bdlivraison = new BdLivraison();
        $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
        foreach ($livraisons as $livraison) {
            $idaffectation_online = $livraison['dIdmutation'];
            $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
        }
        $bdaffectation = new BdAffectationService();
        $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
        foreach ($affectations as $affectation) {
            $idagent_prenneur = $affectation['Aid'];
        }
        if (($idaffectation_online == $_SESSION['idaffectation']) && ($idagent_prenneur == $_GET['use'])) {
            $n++;
            ?>
            <tr>
                <td><?= $distribution['id'] ?></td>
                <td><?= $distribution['date'] ?></td>
                <td><?= $infolivraison ?></td>
                <td>
                    <?php
                    $paniers = explode("/", $distribution['panier']);
                    $code = "";
                    $bdunite = new BdUnite();
                    $unites = $bdunite->getUniteAllDesc();
                    foreach ($unites as $unite) {
                        foreach ($paniers as $pan) {
                            if (($pan != "") && ($pan == $unite['id']) && (1)) {
                                $code = $code . " / " . $unite['code'];
                            }
                        }
                    }
                    echo $code;
                    ?>
                </td>
                <td>
                    <?php
                    $bdaffectation = new BdAffectationService();
                    $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
                    foreach ($affectations as $affectation) {
                        echo $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                    }
                    ?>
                </td>
                <td><?= $distribution['nombre'] ?></td>
                <td><?= $distribution['nombre_restant'] ?></td>
                <td>
                    <?php
                    if ($distribution['nombre_restant'] != 0) {
                        ?>
                        <h4 style="color: forestgreen;">Encours</h4>
                        <?php
                    } else {
                        ?>
                        <h4 style="color: red;">récuperée</h4>
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
<td style="font-size: 20px;">
    <span>Nombre:</span><span><?= $n ?></span>
</td>
</tfoot>
</table>

