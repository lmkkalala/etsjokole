<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

require '../../../web/fpdf181/fpdf.php';

include("../../../models/pdf-generator/pdfclassHR.php");

include '../../../models/connexionM.php';

include '../../../models/livrepaie/LivrePaie.php';
include '../../../models/promotion/Promotion.php';
include '../../../models/chargeconf/ChargeConf.php';
include '../../../models/compte/Compte.php';
include '../../../models/conf-salaire/ConfSalaire.php';
include '../../../models/conf-imposition/ConfImposition.php';
include '../../../models/pdf-generator/Numbers/Words.php';
include '../../../models/bulletin/Bulletin.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$bdpromotion = new BdPromotion();
$promotions = $bdpromotion->getPromotionById($_GET['use_affectationservice']);
foreach ($promotions as $promotion) {
    if (1) {
//        $pdf->Ln(5);
//        $pdf->SetFont('Arial', 'B', 11);
//        $pdf->Cell(190, 10, utf8_decode('Grand total Out value : ' . ($cumul_total_sortie . " USD")), 0, 0, '');
//        $pdf->Ln(8);
//
//        $pdf->SetFont('Arial', 'B', 11);
//        $pdf->Cell(190, 10, utf8_decode('Grand total actual value : ' . ($cumul_total_reste . " USD")), 0, 0, '');
//        $pdf->Ln(8);
//
//        $pdf->SetFont('Arial', 'B', 11);
//        $pdf->Cell(190, 10, utf8_decode('Grand total Input value : ' . ($cumul_total . " USD")), 0, 0, '');
//        $pdf->Ln(5);

        $etatcivil = "";
        $idchargeconf = 0;
        $bdchargeconf = new BdChargeConf();
        $chargeconfs = $bdchargeconf->getChargeConfByEmploye($promotion['eId']);
        foreach ($chargeconfs as $chargeconf) {
            if ($chargeconf['ccActive']) {

                $etatcivil = $chargeconf['etatCivil'] . "  / Nbre enfant: " . $chargeconf['nombreEnfant'] . "  / Personne en charge: " . $chargeconf['nombreFemme'];

                $idchargeconf = $chargeconf['ccId'];
                $nombre_enfant = $chargeconf['nombreEnfant'];
            }
        }

        ;

        ;
    }
}

$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(30, 70, 40, 40, 40));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('Matricule'), decode('Identité'), decode('Catégorie'), decode('Service')));
$pdf->SetFont('Times', '', 11);
$titre = $promotion['matricule'] . "-" . $promotion['nom'] . " " . $promotion['postnom'] . " " . $promotion['prenom'];
$matricule = $promotion['matricule'];
$identite = $promotion['nom'] . " " . $promotion['postnom'] . " " . $promotion['prenom'];

$pdf->Row(array(decode($promotion['matricule']), decode($promotion['nom'] . " " . $promotion['postnom'] . " " . $promotion['prenom'] . " / Sexe: " . $promotion['sexe']), decode($promotion['ctDesignation']), decode($promotion['sDesignation'])));

$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(30, 70, 40, 40, 40));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('Fonction'), decode('Etat civil'), decode('Date engagement'), decode('Type de contrat')));
$pdf->SetFont('Times', '', 11);
$pdf->Row(array(decode($promotion['fDesignation']), decode($etatcivil), decode($promotion['dateRecrutement']), decode($promotion['tcDesignation'])));

$bdcompte = new BdCompte();
$comptes = $bdcompte->getCompteById($_GET['use_compte']);
foreach ($comptes as $compte) {
    if ($compte['coActive']) {
        if (1) {
            $info_compte = "Compte : ".$compte['etablissement'] . " / Numero : " . $compte['coNumero'];
        }
    }
}

$pdf->Ln(3);
$pdf->SetWidths(array(180));
$pdf->Row(array(decode($info_compte)));

$bdlivrepaie = new BdLivrePaie();
$livrepaies = $bdlivrepaie->getLivrePaieById($_GET['use_livrepaie']);
foreach ($livrepaies as $livrepaie) {
    if ($livrepaie['active']) {
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(0, 102, 204);
        $pdf->Cell(190, 10, utf8_decode("Bulletin de paie : " . $livrepaie['mois'] . " " . $livrepaie['annee']), 0, 0, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(15);
        $titre = "Bulletin de paie : " . $livrepaie['mois'] . " " . $livrepaie['annee'] . "-" . $titre;
        $libelle_mois_annee = $livrepaie['mois'] . " " . $livrepaie['annee'];
    }
}

$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(15, 40, 18, 18, 18, 35, 35));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('Code'), decode('Libelle du mouvement'), decode('Temps'), decode('Unité'), decode('Taux'), decode('Montant à payer'), decode('Montant à retenir')));
$pdf->SetFont('Times', '', 11);


$chaine_composantesalaire_selectionnee = "";
$bdconfsalaire = new BdConfSalaire();
$cumul_nature_salaire = 0;
$cumul_nature_retention = 0;
$impot_CNSS = 0;
$impot_IPR = 0;
$brut_imposable = 0;
$item_retenir = 0;
$items_composantesalaire = explode('/', $_GET['use_chaine_composantesalaire']);
foreach ($items_composantesalaire as $item_composantesalaire) {
    if ($item_composantesalaire != "") {
        $items_contenue = explode('-', $item_composantesalaire);
        $id_confsalaire_item = $items_contenue[0];
        $chaine_composantesalaire_selectionnee = $chaine_composantesalaire_selectionnee . $id_confsalaire_item . "-";
        $quantite_item = $items_contenue[1];
        $confsalaires = $bdconfsalaire->getConfSalaireById($id_confsalaire_item);
        foreach ($confsalaires as $confsalaire) {
            if ($confsalaire['active']) {
                $v1 = $confsalaire['code'];
                $v2 = $confsalaire['designation'];
                $v3 = $quantite_item;
                $v4 = $confsalaire['unite'];
                if ($confsalaire['designation'] == "CNSS" || $confsalaire['designation'] == "Impot") {
                    $v5 = "0.00";
                } else {
                    $v5 = $confsalaire['taux'];
                }
                if ($confsalaire['nature'] == "salaire") {
                    $v6 = ($confsalaire['taux'] * $quantite_item);
                    $v7 = 0;
                } else if ($confsalaire['nature'] == "retention") {
//                    $v6 = 0;
//                    $v7 = ($confsalaire['taux'] * $quantite_item);
                    if ($confsalaire['designation'] == "CNSS") {
                        $v6 = 0;
                        $v7 = ($confsalaire['taux'] * $quantite_item * $brut_imposable);

                        $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item * $brut_imposable);
                    } else if ($confsalaire['designation'] == "Impot") {
                        $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                        $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                        $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));

                        $v6 = 0;
                        $v7 = ($impot_IPR);

                        $item_retenir = $item_retenir + ($impot_IPR);
                    } else {

                        $v6 = 0;
                        $v7 = ($confsalaire['taux'] * $quantite_item);

                        $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item);
                    }
                }

                if ($confsalaire['designation'] == "CNSS") {
                    $impot_CNSS = ($confsalaire['taux'] * $quantite_item);
                }
                if ($confsalaire['designation'] == "Impot") {
                    $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                    $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                    $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));
                }
                if ($confsalaire['designation'] == "Salaire de base") {
                    $brut_imposable = ($confsalaire['taux'] * $quantite_item);
                }
                if ($confsalaire['nature'] == "salaire") {
                    if ($confsalaire['type'] == "positif") {
                        $cumul_nature_salaire = $cumul_nature_salaire + ($confsalaire['taux'] * $quantite_item);
                    } else if ($confsalaire['type'] == "negatif") {
                        $cumul_nature_salaire = $cumul_nature_salaire - ($confsalaire['taux'] * $quantite_item);
                    }
                }
                if (($confsalaire['nature'] == "retention") && ($confsalaire['designation'] != "CNSS")) {
                    $cumul_nature_retention = $cumul_nature_retention + ($confsalaire['taux'] * $quantite_item);
                }

                $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v5), decode($v6), decode($v7)));
            }
        }
    }
}

$pdf->Ln(5);

$pdf->SetFont('Times', '', 11);
$pdf->SetWidths(array(30, 30, 30, 30, 30, 30));


$vA = "Brut imposable :" . $brut_imposable . " USD";
$vB = "Net imposable : " . (($brut_imposable) - ($impot_CNSS * $brut_imposable)) . " USD";
$vC = "Total Brut :" . ($cumul_nature_salaire) . " USD";
$vD = "Total à retenir :" . ($item_retenir) . " USD";
$vE = "Net à payer : " . (($cumul_nature_salaire) - ($item_retenir)) . " USD";
$pdf->SetTextColor(0, 204, 0);
$pdf->Row(array(decode($vC), decode($vA), decode($vB), decode($vD), decode($vE), decode("")));
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', '', 11);

$net_a_payer = (($cumul_nature_salaire) - ($item_retenir));
$net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetWidths(array(180));
$items_datecreation = explode('-', $_GET['use_datecreation']);
$pdf->Row(array(decode("Fait à Bukavu, le " . $items_datecreation[2] . "/" . $items_datecreation[1] . "/" . $items_datecreation[0])));

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetWidths(array(120));
$pdf->Row(array(decode("Cotisations patron")));
$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(40, 40, 40));

$pdf->Row(array(decode("Libelle"), decode("Pourcentage"), decode("Valeur")));

$bdconfimposition = new BdConfImposition();
$cumul_contribution = 0;
$chaine_composante_imposition = "";
$bdbulletin = new BdBulletin();
$bulletins = $bdbulletin->getBulletinByAffectationServiceByLivrePaie($_GET['use_affectationservice'], $_GET['use_livrepaie']);
foreach ($bulletins as $bulletin) {
    $chaine_composante_imposition = $bulletin['chaineComposanteImposition'];
}
$items_composantesalaire = explode('-', $chaine_composante_imposition);
foreach ($items_composantesalaire as $item_composantesalaire) {
    if ($item_composantesalaire != "") {
        $confimpositions = $bdconfimposition->getConfImpositionById($item_composantesalaire);
        foreach ($confimpositions as $confimposition) {
            if (1) {
//                          
                if (1) {

                    $cumul_contribution = $cumul_contribution + (($confimposition['pourcentage'] / 100) * $brut_imposable);
                    $pdf->SetFont('Times', 'B', 11);
                    $pdf->Row(array(decode($confimposition['designation']), decode($confimposition['pourcentage'] . " % "), decode((($confimposition['pourcentage'] / 100) * $brut_imposable) . " USD ")));
                }
            }
        }
    }
}

$pdf->SetWidths(array(80, 40));
$pdf->SetTextColor(255, 51, 51);
$pdf->Row(array(decode("Total charges : "), decode((($cumul_contribution + $net_a_payer)) . " USD")));
$pdf->SetTextColor(0, 0, 0);

$pdf->Ln(10);
$pdf->SetWidths(array(180));
$pdf->Row(array(decode("Mois de " . $libelle_mois_annee)));
$pdf->SetWidths(array(90, 90));
$bdcompte = new BdCompte();
$comptes = $bdcompte->getCompteById($_GET['use_compte']);
foreach ($comptes as $compte) {
    if ($compte['coActive']) {
        if (1) {
            $info_compte = $compte['etablissement'] . " / Numero : " . $compte['coNumero'];
        }
    }
}
$conv_number = new Numbers_Words();

$pdf->Row(array(decode("Pour acquis: \n " . "Matricule: " . $matricule . " \n " . "Noms: " . $identite), decode("Montant : " . $net_a_payer . " USD \n" . "Montant en toutes lettres : " . ("..............................................................................................................................................................................") . " \n \n " . "Caissier : " . $info_compte . " \n ")));

$pdf->Ln(3);
$pdf->SetWidths(array(90, 90));
$pdf->Row(array(decode("Date & Signature bénéficiaire"), decode("Date & Signature RH")));
$pdf->Row(array(decode("\n \n \n \n \n"), decode("")));
$pdf->SetTitle($titre);

$pdf->Output($titre, 'I');
?>
