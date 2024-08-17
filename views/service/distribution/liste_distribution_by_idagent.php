<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_POST['FilterVenteAgent'])) {
 $date_start = htmlspecialchars($_POST['date_start']);
 $date_end = htmlspecialchars($_POST['date_end']);
}else{
    $date_start = '';
    $date_end = '';
}
?>
<form action="/views/home.php?link=31f029825f5c4ecdbe0ff06c6e40bf207c13fd2a&use=<?=$_GET['use']?>&link_up=b8fec8b66f449e4d9eeb889da36e634bacc76b62" method="post">
    <div class="row mb-2">
        <div class="col-md-5">
            
            <input class="form-control" type="date" name="date_start" value="<?=$date_start?>">
        </div>
        <div class="col-md-5">
            <input class="form-control" type="date" name="date_end" value="<?=$date_end?>">
        </div>
        <div class="col-md-2">
            <input type="hidden" name="FilterVenteAgent">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </div>
</form>

<table id="listdatabyid" class="table table-bordered table-responsive-lg">
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
    if (isset($_POST['FilterVenteAgent'])) {
        $distributions = $bddistribution->getDistributionBeetwen2Dates($date_start,$date_end);
    }else{
        // $distributions = $bddistribution->getDistributionAllDesc();
        $distributions = $bddistribution->getDistributionAllDescCurrentMounth(date('Y-m',time()));
    }
    
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
<tr>
<th style="font-size: 20px;">
    <span>Nombre:</span><span><?= $n ?></span>
</th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
</tfoot>
</table>

