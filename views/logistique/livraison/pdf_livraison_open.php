<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

require '../../../web/fpdf181/fpdf.php';

include("../../../models/pdf-generator/pdfclass.php");

include '../../../models/connexion.php';
include '../../../models/livraison/livraison.php';
include '../../../models/demande/demande.php';
include '../../../models/unite/unite.php';
include '../../../models/service/service.php';
include '../../../models/preparation/preparation.php';
include '../../../models/ravitaillement/ravitaillement.php';
include '../../../models/biens/biens.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');


$titre = "";

if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
    $titre = $titre . "Date 1 : " . $_GET['use_date1'] . " " . " / Date 2 :" . $_GET['use_date2'];
} else {
    $titre = $titre . "Choose interval";
}


if (isset($_GET['use_service'])) {
    $bdservice = new BdService();
    $services = $bdservice->getServiceById($_GET['use_service']);
    foreach ($services as $service) {
        $designation_service_choosen = $service['designation'];
    }
    if (isset($designation_service_choosen)) {
        $titre = $titre . " | Service :" . $designation_service_choosen;
    } else {
        $titre = $titre . " | Service : - ";
    }
}
if (isset($_GET['use_biens'])) {
    $bdbiens = new BdBiens();
    $biens = $bdbiens->getBiensById($_GET['use_biens']);
    foreach ($biens as $bien) {
        $designation_biens_choosen = $bien['bDesignation'] . " / " . $bien['gDesignation'];
    }
    if (isset($designation_biens_choosen)) {
        $titre = $titre . " | Item :" . $designation_biens_choosen;
    } else {
        $titre = $titre . " | Item : - ";
    }
}
if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
    $titre = $titre . " | Activity : " . $_GET['use_typerepas'];
} else {
    $titre = $titre . " | Activity : All";
}



$pdf->SetFont('Arial', 'B', 8);
$titre_document = "Delivery_Report : " . $titre;
$pdf->SetTitle($titre_document);
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(15);
$n = 0;

$pdf->SetFont('Times', 'B', 8);
$pdf->SetWidths(array(8, 23, 55, 30, 15, 20, 15, 25));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('#'), decode('Date'), decode('Requisition'), decode('Activity'), decode('Qty'), decode('Unit price'), decode('Cost'), decode('Resp.')));
$pdf->SetFont('Times', '', 8);


$n = 0;
$bdlivraison = new BdLivraison();
if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
    if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
        if ((isset($_GET['use_date1']))) {
            if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
                $livraisons = $bdlivraison->getLivraisonDescByIdServiceBetween2DatesByTyperepasByIdBiens($_GET['use_service'], $_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas'], $_GET['use_biens']);
            } else {
                $livraisons = $bdlivraison->getLivraisonAllBetween2DatesByTyperepasByIdBiens($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas'], $_GET['use_biens']);
            }
        } else {
            $livraisons = $bdlivraison->getLivraisonById(0);
        }
    } else {
        if ((isset($_GET['use_date1']))) {
            if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
                $livraisons = $bdlivraison->getLivraisonDescByIdServiceBetween2DatesByTyperepas($_GET['use_service'], $_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas']);
            } else {
                $livraisons = $bdlivraison->getLivraisonAllBetween2DatesByTyperepas($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas']);
            }
        } else {
            $livraisons = $bdlivraison->getLivraisonById(0);
        }
    }
} else {
    if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
        if ((isset($_GET['use_date1']))) {
            if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
                $livraisons = $bdlivraison->getLivraisonDescByIdServiceBetween2DatesByIdBiens($_GET['use_service'], $_GET['use_date1'], $_GET['use_date2'], $_GET['use_biens']);
            } else {
                $livraisons = $bdlivraison->getLivraisonAllBetween2DatesByIdBiens($_GET['use_date1'], $_GET['use_date2'], $_GET['use_biens']);
            }
        } else {
            $livraisons = $bdlivraison->getLivraisonById(0);
        }
    } else {
        if ((isset($_GET['use_date1']))) {
            if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
                $livraisons = $bdlivraison->getLivraisonDescByIdServiceBetween2Dates($_GET['use_service'], $_GET['use_date1'], $_GET['use_date2']);
            } else {
                $livraisons = $bdlivraison->getLivraisonAllBetween2Dates($_GET['use_date1'], $_GET['use_date2']);
            }
        } else {
            $livraisons = $bdlivraison->getLivraisonById(0);
        }
    }
}

if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
    $list_type_repas = [$_GET['use_typerepas']];
} else {
    $list_type_repas = ['Input','Diesel','Lubricant','Fleet','Plant', 'cleaning', 'non-consomable', 'Office and kitchen equipment', 'Bar', 'Spoilage', 'Transfer', 'Staff meal', 'Back to supplier', 'Back charge to client', 'Fonction','PRO'];
}

$cumulQuantite=0;

$cumul_total_value = 0;
foreach ($list_type_repas as $type_repas) {
    $pdf->SetTextColor(255,0,0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Row(array(decode(""), decode("$type_repas"), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
    $pdf->SetFont('Times', '', 8);
    $pdf->SetTextColor(0,0,0);
    $cumul_total = 0;
    $cumul_value_typerepas = 0;
    $somme_prix_biens = 0;
    
    foreach ($livraisons as $livraison) {
        $cumule_prix=0;
        $value_sale = 0;
        $bdpreparation = new BdPreparation();
        $preparations = $bdpreparation->getPreparationById($livraison['preparation_id']);
        foreach ($preparations as $preparation) {
            $type_repas_livraison = $preparation['typerepas'];
        }
        if ($type_repas_livraison == $type_repas) {
            $chaine_part_ravitaillement = "";
            $n++;
            $v1 = "";
            $v2 = "";
            $v3 = "";
            $v4 = "";
            $v5 = "";
            $v6 = "";
            $v7 = "";
            $v8 = "";

            $v1 = $livraison['lId'];
            $v2 = $livraison['lDate'];
            $v3 = $livraison['dId'] . " " . $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / quantité : " . $livraison['dQuantite'];

            $bdpreparation = new BdPreparation();
            $preparations = $bdpreparation->getPreparationById($livraison['preparation_id']);
            foreach ($preparations as $preparation) {
                $v4 = $preparation['typerepas'] . " / " . $preparation['dateHeure'];
            }

            
            $v5 = "Par lot";

            $somme_prix_biens = 0;
            $s = 0;
            $bdravitaillement = new BdRavitaillement();
            $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($livraison['bId']);
            foreach ($ravitaillements as $ravitaillement) {
                $s++;
                $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
            }
            $average_price = ($somme_prix_biens / $s);
            
            $v6= ($livraison['lQuantite'] * $average_price) . " USD ";
            $value_sale = ($livraison['lQuantite'] * $average_price);
            //                                    ICI ETAT_RECUPERATIOM
            if ($livraison['etat'] == 1) {
                $cumule_prix = 0;
            }

//            $cumul_total = $cumul_total + (($livraison['lQuantite'] * $average_price));
            $v7 = $livraison['lQuantite'];
            $cumulQuantite=$cumulQuantite+$livraison['lQuantite'];
            $v8 = $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'];
            $v9=$average_price;
            $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v7), decode($v9." USD"), decode($v6), decode($v8)));
            $cumul_value_typerepas = $cumul_value_typerepas + ($livraison['lQuantite'] * $average_price);
        }
    }
    
    $pdf->SetTextColor(0,0,255);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Row(array(decode(""), decode("Total activity : " . $cumul_value_typerepas." USD"), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
    $pdf->SetFont('Times', '', 8);
    $pdf->SetTextColor(0,0,0);
    $cumul_total_value = $cumul_total_value + $cumul_value_typerepas;
    
}


$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(190, 10, utf8_decode('Number :' . $n), 0, 0, '');
$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(190, 10, utf8_decode('Quantité :' . ($cumulQuantite)), 0, 0, '');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(190, 10, utf8_decode('Grand Total :' . ($cumul_total_value . " USD")), 0, 0, '');
$pdf->Ln(5);

$pdf->Output($titre_document, 'I');
?>