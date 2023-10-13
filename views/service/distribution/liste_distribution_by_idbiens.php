<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$link = "service_distribution_fiche_biens_distribution_self";
include("select_service.php");

if (isset($_GET['use_date1'])) {
    echo "<p style='margin: 10px;font-size: 20px;font-weight:bold'>".$_GET['use_date1']." to ".$_GET['use_date2']."</p>";
}
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
        Agent preneur
    </th>
    <th>
        Quantité
    </th>
    <th>
        Quantité non récuperée
    </th>
    <th>
        PU Vente (USD)
    </th>
    <th>
        Valeur Vente (USD)
    </th>
    
</thead>
<tbody>
    <?php
    $n = 0;
    if (isset($_GET['use'])) {
        $use = $_GET['use'];
    } else {
        $use = 0;
    }
    
    $cumulValeur=0;
    $cumulQty=0;
    
    $bddistribution = new BdDistribution();
    if (isset($_GET['use_date1']) && ($_GET['use_date1']!="" && $_GET['use_date2']!="")) {
        $distributions = $bddistribution->getDistributionBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
    } else {
        $distributions = $bddistribution->getDistributionById(0);
    }
    
    foreach ($distributions as $distribution) {
        if (isset($_GET['use_date1']) &&  ($_GET['use_date1']<=$distribution['date'] && $_GET['use_date2']>=$distribution['date'])) {
        $affiche_bon = false;
//                            $bdmutation=new BdAffectationService();
//                            $affectations=$bdaffectation->getAffectationServiceByService($idservice);
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
            $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
        
            
        }
        if ((isset($infolivraison)) && ($livraison['bId'] == $_GET['use2']) && ($affiche_bon) && (isset($_GET['use_date1']) &&  ($_GET['use_date1']<=$distribution['date'] && $_GET['use_date2']>=$distribution['date']))) {
            $n++;
            ?>
            <tr>
                <td><?= $distribution['id'] ?></td>
                <td><?= $distribution['date'] ?></td>
                <td><?= $infolivraison ?></td>
                
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
                <td><?= $distribution['price'] ?></td>
                <td style="color: forestgreen; font-weight:bold;"><?= ($distribution['nombre_restant']*$distribution['price']) ?></td>
                
            </tr>
            <?php
            $cumulValeur=$cumulValeur+($distribution['nombre_restant']*$distribution['price']);
            $cumulQty=$cumulQty+($distribution['nombre_restant']);
        }
        
    }
    
    }
    ?>
</tbody>
<tfoot>
<td style="font-size: 20px;">
    <span>Nombre:</span><span><?= $n ?></span>
</td>
<td style="font-size: 20px; color: forestgreen; font-weight:bold;">
    <span>Valeur total (USD): </span><span><?= $cumulValeur ?></span>
</td>
<td style="font-size: 20px; color: orange; font-weight:bold;">
    <span>Qte: </span><span><?= $cumulQty ?></span>
</td>
<td style="font-size: 20px; color: dodgerblue; font-weight:bold;">
    <?php
        $cmPrix=0;
        $nRav=-1;
        $meanPrice=0;
        $ravitaillements=[];
        
        if ((isset($_GET['use_date1'])) && (isset($_GET['use2']))) {
            $bdRavitaillement=new BdRavitaillement();
            $ravitaillements=$bdRavitaillement->getRavitaillementBetweenInfDate2ByIdBiens($_GET['use_date1'],$_GET['use2']);
        }
        
        
        foreach($ravitaillements as $ravitaillement) {
            $cmPrix=($cmPrix+$ravitaillement['prix']);
            $nRav++;
        }
        
        if ($nRav != 0) {
            $meanPrice=round(($cmPrix/$nRav),3);
        }

        $valeurEntree=($meanPrice*$cumulQty);

    ?>
    <span>
        <p><?= "Prix moyen: ".$meanPrice ?> USD</p>
        <p><?= " Valeur entrée: ".$valeurEntree ?> USD</p>
    </span>
</td>
<td style="font-size: 20px; color: darkred; font-weight:bold;">
    
    <span>
        <p><?= " Marge: ".($cumulValeur-$valeurEntree) ?> USD</p>
    </span>
</td>
</tfoot>
</table>

