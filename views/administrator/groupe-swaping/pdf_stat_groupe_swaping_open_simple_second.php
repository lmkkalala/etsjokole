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
include '../../../models/groupe-swaping/groupeSwaping.php';
include '../../../models/swaping/swaping.php';
include '../../../models/service/service.php';
include '../../../models/affectation-groupe/affectationGroupe.php';
include '../../../models/fonction/fonction.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');

$interval_date = "-";
$choix_service = "-";
$choix_departement = "-";
if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
    $interval_date = "" . $_GET['use_date1'] . " " . " to " . $_GET['use_date2'];
} else {
    
}
if (isset($_GET['use_service'])) {
    $bdservice = new BdService();
    $services = $bdservice->getServiceById($_GET['use_service']);
    foreach ($services as $service) {
        $designation_service_choosen = $service['designation'];
    }
    if (isset($designation_service_choosen)) {
        $choix_service = " | Refectoire :" . $designation_service_choosen;
    } else {
        $choix_service = " | Refectoire : All";
    }
}
if (isset($_GET['use_departement'])) {
    $bdfonction = new BdFonction();
    $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
    foreach ($fonctions as $fonction) {
        $designation_fonction_choosen = $fonction['designation'];
    }
    if (isset($designation_fonction_choosen)) {
        $choix_departement = " | Departement :" . $designation_fonction_choosen;
    } else {
        $choix_departement = " | Departement : All";
    }
}

$pdf->SetTitle("Report_" . $interval_date . "" . $choix_departement . "" . $choix_service);
$titre_document = $interval_date . "" . $choix_departement . "" . $choix_service;
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, utf8_decode("Swap Report"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(15);
$n = 0;

$pdf->SetFont('Times', 'B', 12);
$pdf->SetWidths(array(8, 70, 35, 25, 25, 25));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('No.'), decode('Department'), decode('Restaurant'), decode("For Breakfast"), decode('For Lunch'), decode('For Dinner')));
$pdf->SetFont('Times', '', 12);

$n = 0;
$cumul_nombre_breakfast = 0;
$cumul_nombre_lunch = 0;
$cumul_nombre_dinner = 0;
$cumule_recette_totale = 0;
$bdgroupeswaping = new BdGroupeSwaping();
$array_recette_all = [];
$array_recette_categorie = [];
$array_recette_departement = [];
$array_recette_par_restaurant = [];
$array_recette_par_typerepas = [];

$cumule_recette_groupe_swaping = 0;
$n++;

$bdfonction = new BdFonction();
if ((isset($_GET['use_departement'])) && ($_GET['use_departement'] != 0)) {
    $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
} else {
    $fonctions = $bdfonction->getFonctionAllActiveDesc();
}

$p = 0;
$cumul_nombre_breakfast_total = 0;
$cumul_nombre_lunch_total = 0;
$cumul_nombre_dinner_total = 0;
foreach ($fonctions as $fonction) {
    $cumul_nombre_breakfast_fonction = 0;
    $cumul_nombre_lunch_fonction = 0;
    $cumul_nombre_dinner_fonction = 0;
    if ($fonction['active']) {

        $p++;

        $pdf->Row(array(decode($p), decode($fonction['designation']), decode(" "), decode(" "), decode(" "), decode(" ")));
        $cumule_recette_departement = 0;

        $bdservice = new BdService();
        if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
            $services = $bdservice->getServiceById($_GET['use_service']);
        } else {
            $services = $bdservice->getServiceAllDesc();
        }
        foreach ($services as $service) {
            $cumul_nombre_breakfast_service = 0;
            $cumul_nombre_lunch_service = 0;
            $cumul_nombre_dinner_service = 0;
            $bdaffectationgroupe = new BdAffectationGroupe();
            $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeByIdFonctionByRestaurant($fonction['id'], $service['id']);
            foreach ($affectationgroupes as $affectationgroupe) {
                if (1) {

                    $bdswaping = new BdSwaping();
                    $current_date = (date('Y-m-d'));
                    $swapings = $bdswaping->getSwapingByAffectationGroupe($affectationgroupe['idAG']);
                    $cumul_recette = 0;
                    $cumul_breakfast = 0;
                    $cumul_lunch = 0;
                    $cumul_dinner = 0;
                    $nombre_personne_breakfast = 0;
                    $nombre_personne_lunch = 0;
                    $nombre_personne_dinner = 0;
                    $array_info_swaping_breakfast = [];
                    $array_info_swaping_lunch = [];
                    $array_info_swaping_dinner = [];
                    $nombre_breakfast = 0;
                    $nombre_lunch = 0;
                    $nombre_dinner = 0;
                    foreach ($swapings as $swaping) {
                        if (1) {
                            if ((1) && (isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
                                $etat = "non";
                                $items_date = explode(' ', $swaping['dateHeure']);
                                if ((date_format(date_create($items_date[0]), 'Y-m-d') >= date_format(date_create($_GET['use_date1']), 'Y-m-d')) && (date_format(date_create($items_date[0]), 'Y-m-d') <= date_format(date_create($_GET['use_date2']), 'Y-m-d'))) {
                                    if ($items_date[1] < ('09:00:00')) {
                                        $type_repas = "breakfast";
                                        $nombre_breakfast++;
                                    } else if ($items_date[1] < ('14:00:00')) {
                                        $type_repas = "lunch";
                                        $nombre_lunch++;
                                    } else {
                                        $type_repas = "dinner";
                                        $nombre_dinner++;
                                    }

                                    if ($type_repas == "breakfast") {

                                        $nombre_personne_breakfast++;
                                        $cumul_breakfast = $cumul_breakfast + $swaping['prixchoosen'];
                                        array_push($array_info_swaping_breakfast, ($swaping['dateHeure'] . " / " . $swaping['nom'] . " " . $swaping['postnom'] . " " . $swaping['prenom']));
                                    } else if ($type_repas == "lunch") {

                                        $nombre_personne_lunch++;
                                        $cumul_lunch = $cumul_lunch + $swaping['prixchoosen'];
                                        array_push($array_info_swaping_lunch, ($swaping['dateHeure'] . " / " . $swaping['nom'] . " " . $swaping['postnom'] . " " . $swaping['prenom']));
                                    } else if ($type_repas == "dinner") {

                                        $nombre_personne_dinner++;
                                        $cumul_dinner = $cumul_dinner + $swaping['prixchoosen'];
                                        array_push($array_info_swaping_dinner, ($swaping['dateHeure'] . " / " . $swaping['nom'] . " " . $swaping['postnom'] . " " . $swaping['prenom']));
                                    }

                                    $cumul_recette = $cumul_recette + $swaping['prixchoosen'];
                                }
                            }
                        }
                    }



                    if ($nombre_breakfast != 0 || $nombre_lunch != 0 || $nombre_dinner != 0) {
//                        $pdf->Row(array(decode(" "), decode(" "), decode(" "), decode($affectationgroupe['codebar']." / ".$affectationgroupe['nom'] . " " . $affectationgroupe['postnom'] . " " . $affectationgroupe['prenom']), decode($nombre_breakfast), decode($nombre_lunch), decode($nombre_dinner)));
                    }
                }
                $cumul_nombre_breakfast_service = $cumul_nombre_breakfast_service + $nombre_breakfast;
                $cumul_nombre_lunch_service = $cumul_nombre_lunch_service + $nombre_lunch;
                $cumul_nombre_dinner_service = $cumul_nombre_dinner_service + $nombre_dinner;
            }


            $pdf->Row(array(decode(" "), decode(" "), decode($service['designation']), decode($cumul_nombre_breakfast_service), decode($cumul_nombre_lunch_service), decode($cumul_nombre_dinner_service)));


            $cumul_nombre_breakfast_fonction = $cumul_nombre_breakfast_fonction + $cumul_nombre_breakfast_service;
            $cumul_nombre_lunch_fonction = $cumul_nombre_lunch_fonction + $cumul_nombre_lunch_service;
            $cumul_nombre_dinner_fonction = $cumul_nombre_dinner_fonction + $cumul_nombre_dinner_service;
        }

        $cumul_nombre_breakfast_total = $cumul_nombre_breakfast_total + $cumul_nombre_breakfast_fonction;
        $cumul_nombre_lunch_total = $cumul_nombre_lunch_total + $cumul_nombre_lunch_fonction;
        $cumul_nombre_dinner_total = $cumul_nombre_dinner_total + $cumul_nombre_dinner_fonction;

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Row(array(decode(" "), decode(" "), decode("Total 1"), decode($cumul_nombre_breakfast_fonction), decode($cumul_nombre_lunch_fonction), decode($cumul_nombre_dinner_fonction)));
        $pdf->SetFont('Times', '', 12);

        array_push($array_recette_departement, $array_recette_par_restaurant);
        $array_recette_par_restaurant = [];
        $cumule_recette_groupe_swaping = $cumule_recette_groupe_swaping + $cumule_recette_departement;
    }
}




$pdf->Ln(5);
$pdf->SetTextColor(208, 35, 35);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Row(array(decode(" "), decode("Total"), decode(" "), decode($cumul_nombre_breakfast_total), decode($cumul_nombre_lunch_total), decode($cumul_nombre_dinner_total)));
$pdf->SetFont('Times', '', 14);
$pdf->SetTextColor(0, 0, 0);

$pdf->Output("Income_Report_" . $titre_document . ".pdf", 'I');
?>