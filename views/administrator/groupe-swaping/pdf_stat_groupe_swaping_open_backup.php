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
$pdf->Cell(190, 10, utf8_decode("Income Financial Report"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(15);
$n = 0;

$pdf->SetFont('Times', 'B', 12);
$pdf->SetWidths(array(8, 35, 45, 35, 15, 15, 15, 15));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('No.'), decode('Category'), decode('Department'), decode('Restaurant'), decode('Breakfast'), decode('Lunch'), decode('Dinner'), decode("Total")));
$pdf->SetFont('Times', '', 12);

$n = 0;
$cumule_recette_totale = 0;
$bdgroupeswaping = new BdGroupeSwaping();
$array_recette_all = [];
$array_recette_categorie = [];
$array_recette_departement = [];
$array_recette_par_restaurant = [];
$array_recette_par_typerepas = [];
$groupeswapings = $bdgroupeswaping->getGroupeSwapingAllDesc();
foreach ($groupeswapings as $groupeswaping) {
    $cumule_recette_groupe_swaping = 0;
    $n++;

    $bdfonction = new BdFonction();
    if ((isset($_GET['use_departement'])) && ($_GET['use_departement'] != 0)) {
        $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
    } else {
        $fonctions = $bdfonction->getFonctionAllActiveDesc();
    }

    foreach ($fonctions as $fonction) {
        $cumule_recette_departement = 0;

        $bdservice = new BdService();
        if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
            $services = $bdservice->getServiceById($_GET['use_service']);
        } else {
            $services = $bdservice->getServiceAllDesc();
        }
        foreach ($services as $service) {
            $cumule_recette_service = 0;
            $nombre_breakfast = 0;
            $nombre_lunch = 0;
            $nombre_dinner = 0;

            $bdswaping = new BdSwaping();
            $current_date = (date('Y-m-d'));
            $swapings = $bdswaping->getSwapingByGroupeSwaping($groupeswaping['id']);
            $cumul_recette = 0;
            $cumul_breakfast = 0;
            $cumul_lunch = 0;
            $cumul_dinner = 0;
            $nombre_personne_breakfast = 0;
            $nombre_personne_lunch = 0;
            $nombre_personne_dinner = 0;
            foreach ($swapings as $swaping) {

                if ($swaping['fId'] == $fonction['id']) {
                    if (($swaping['sService_id'] == $service['id']) && (isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
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
                            } else if ($type_repas == "lunch") {

                                $nombre_personne_lunch++;
                                $cumul_lunch = $cumul_lunch + $swaping['prixchoosen'];
                            } else if ($type_repas == "dinner") {

                                $nombre_personne_dinner++;
                                $cumul_dinner = $cumul_dinner + $swaping['prixchoosen'];
                            }
                            $cumul_recette = $cumul_recette + $swaping['prixchoosen'];
                        }
                    }
                }
            }

            $cumule_recette_service = $cumule_recette_service + $cumul_breakfast + $cumul_lunch + $cumul_dinner;
            $array_recette_par_typerepas = [];
            array_push($array_recette_par_typerepas, [$cumul_breakfast, $nombre_personne_breakfast]);
            array_push($array_recette_par_typerepas, [$cumul_lunch, $nombre_personne_lunch]);
            array_push($array_recette_par_typerepas, [$cumul_dinner, $nombre_personne_dinner]);

            array_push($array_recette_par_restaurant, $array_recette_par_typerepas);
            $array_recette_par_typerepas = [];
            $cumule_recette_departement = $cumule_recette_departement + $cumule_recette_service;
        }

        array_push($array_recette_departement, $array_recette_par_restaurant);
        $array_recette_par_restaurant = [];
        $cumule_recette_groupe_swaping = $cumule_recette_groupe_swaping + $cumule_recette_departement;
    }

    array_push($array_recette_categorie, $array_recette_departement);
    $array_recette_departement = [];
    $cumule_recette_totale = $cumule_recette_totale + $cumule_recette_groupe_swaping;
}

$array_groupeswaping = [];
$bdgroupeswaping = new BdGroupeSwaping();
$groupeswapings = $bdgroupeswaping->getGroupeSwapingAllDesc();
foreach ($groupeswapings as $groupeswaping) {
    array_push($array_groupeswaping, $groupeswaping['designation']);
}

$array_fonction = [];
$bdfonction = new BdFonction();
if ((isset($_GET['use_departement'])) && ($_GET['use_departement'] != 0)) {
    $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
} else {
    $fonctions = $bdfonction->getFonctionAllActiveDesc();
}
foreach ($fonctions as $fonction) {
    array_push($array_fonction, $fonction['designation']);
}

$array_service = [];
$bdservice = new BdService();
if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
    $services = $bdservice->getServiceById($_GET['use_service']);
} else {
    $services = $bdservice->getServiceAllDescActive();
}
foreach ($services as $service) {
    array_push($array_service, $service['designation']);
}

$pdf->SetFont('Times', '', 12);
$pdf->SetTextColor(0, 0, 0);
$n_categorie = 0;
$cumul_v1_categorie = 0;
$cumul_v2_categorie = 0;
$cumul_v3_categorie = 0;
$cumul_categorie = 0;
$cumul_hashtag_v1_categorie = 0;
$cumul_hashtag_v2_categorie = 0;
$cumul_hashtag_v3_categorie = 0;
foreach ($array_recette_categorie as $categories) {
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Row(array(decode($n_categorie + 1), decode($array_groupeswaping[$n_categorie]), decode(" "), decode(" "), decode(" "), decode(" "), decode(" "), decode(" ")));
    $pdf->SetFont('Times', '', 12);
    $n_categorie++;
    $n_departement = 0;
    $cumul_departement = 0;
    $cumul_v1_departement = 0;
    $cumul_v2_departement = 0;
    $cumul_v3_departement = 0;
    $cumul_hashtag_v1_departement = 0;
    $cumul_hashtag_v2_departement = 0;
    $cumul_hashtag_v3_departement = 0;
    foreach ($categories as $departements) {
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Row(array(decode(" "), decode(" "), decode($array_fonction[$n_departement]), decode(" "), decode(" "), decode(" "), decode(" "), decode(" ")));
        $pdf->SetFont('Times', '', 12);
        $n_departement++;
        $n_restaurant = 0;
        $cumul_v1 = 0;
        $cumul_v2 = 0;
        $cumul_v3 = 0;
        $cumul_hashtag_v1 = 0;
        $cumul_hashtag_v2 = 0;
        $cumul_hashtag_v3 = 0;
        foreach ($departements as $restaurants) {

            $v1 = $restaurants[0][0];
            $cumul_v1 = $cumul_v1 + $restaurants[0][0];
            $v2 = $restaurants[1][0];
            $cumul_v2 = $cumul_v2 + $restaurants[1][0];
            $v3 = $restaurants[2][0];
            $cumul_v3 = $cumul_v3 + $restaurants[2][0];
            $somme_restaurant = ($v1 + $v2 + $v3);
            $cumul_hashtag_v1 = $cumul_hashtag_v1 + $restaurants[0][1];
            $cumul_hashtag_v2 = $cumul_hashtag_v2 + $restaurants[1][1];
            $cumul_hashtag_v3 = $cumul_hashtag_v3 + $restaurants[2][1];
            if ($somme_restaurant != 0) {
                $somme_restaurant = $somme_restaurant . " USD";
            } else {
                $somme_restaurant = "";
            }
            if ($v1 != 0) {
                $v1 = "#:" . $restaurants[0][1] . " / " . $v1 . " USD";
            }
            if ($v2 != 0) {
                $v2 = "#:" . $restaurants[1][1] . " / " . $v2 . " USD";
            }
            if ($v3 != 0) {
                $v3 = "#:" . $restaurants[2][1] . " / " . $v3 . " USD";
            }
            $pdf->Row(array(decode(" "), decode(" "), decode(" "), decode($array_service[$n_restaurant]), decode($v1), decode($v2), decode($v3), decode(($somme_restaurant))));
            $n_restaurant++;
        }

        $somme_cumul_v = ($cumul_v1 + $cumul_v2 + $cumul_v3);
        $cumul_departement = $cumul_departement + $somme_cumul_v;
        if ($somme_cumul_v != 0) {
            $somme_cumul_v = $somme_cumul_v . " USD";
        } else {
            $somme_cumul_v = 0;
        }

        $cumul_v1_departement = $cumul_v1_departement + $cumul_v1;
        $cumul_v2_departement = $cumul_v2_departement + $cumul_v2;
        $cumul_v3_departement = $cumul_v3_departement + $cumul_v3;

        $cumul_hashtag_v1_departement = $cumul_hashtag_v1_departement + $cumul_hashtag_v1;
        $cumul_hashtag_v2_departement = $cumul_hashtag_v2_departement + $cumul_hashtag_v2;
        $cumul_hashtag_v3_departement = $cumul_hashtag_v3_departement + $cumul_hashtag_v3;

        if ($cumul_v1 != 0) {
            $cumul_v1 = "#:" . $cumul_hashtag_v1 . " / " . $cumul_v1 . " USD";
        }
        if ($cumul_v2 != 0) {
            $cumul_v2 = "#:" . $cumul_hashtag_v2 . " / " . $cumul_v2 . " USD";
        }
        if ($cumul_v3 != 0) {
            $cumul_v3 = "#:" . $cumul_hashtag_v3 . " / " . $cumul_v3 . " USD";
        }
        $pdf->SetTextColor(255, 165, 0);
        $pdf->Row(array(decode(" "), decode(" "), decode(" "), decode("Total : "), decode($cumul_v1), decode($cumul_v2), decode($cumul_v3), decode(($somme_cumul_v))));
        $pdf->SetTextColor(0, 0, 0);
    }

    $cumul_v1_categorie = $cumul_v1_categorie + $cumul_v1_departement;
    $cumul_v2_categorie = $cumul_v2_categorie + $cumul_v2_departement;
    $cumul_v3_categorie = $cumul_v3_categorie + $cumul_v3_departement;

    if ($cumul_v1_departement != 0) {
        $cumul_v1_departement = "#:" . $cumul_hashtag_v1_departement . " / " . $cumul_v1_departement . " USD";
    }
    if ($cumul_v2_departement != 0) {
        $cumul_v2_departement = "#:" . $cumul_hashtag_v2_departement . " / " . $cumul_v2_departement . " USD";
    }
    if ($cumul_v3_departement != 0) {
        $cumul_v3_departement = "#:" . $cumul_hashtag_v3_departement . " / " . $cumul_v3_departement . " USD";
    }
    if ($cumul_departement != 0) {
        $cumul_departement = $cumul_departement . " USD";
    } else {
        $cumul_departement = 0;
    }
    $cumul_hashtag_v1_categorie = $cumul_hashtag_v1_categorie + $cumul_hashtag_v1_departement;
    $cumul_hashtag_v2_categorie = $cumul_hashtag_v2_categorie + $cumul_hashtag_v2_departement;
    $cumul_hashtag_v3_categorie = $cumul_hashtag_v3_categorie + $cumul_hashtag_v3_departement;
    
    $pdf->SetTextColor(138, 43, 226);
    $pdf->Row(array(decode(" "), decode(" "), decode("Total : " . ($cumul_departement)), decode(" "), decode($cumul_v1_departement), decode($cumul_v2_departement), decode($cumul_v3_departement), decode(" ")));
    $pdf->SetTextColor(0, 0, 0);
}
$cumul_categorie = ($cumul_v1_categorie + $cumul_v2_categorie + $cumul_v3_categorie);
if ($cumul_v1_categorie != 0) {
    $cumul_v1_categorie = "#:".$cumul_hashtag_v1_categorie." / ".$cumul_v1_categorie . " USD";
}
if ($cumul_v2_categorie != 0) {
    $cumul_v2_categorie = "#:".$cumul_hashtag_v2_categorie." / ".$cumul_v2_categorie . " USD";
}
if ($cumul_v3_categorie != 0) {
    $cumul_v3_categorie = "#:".$cumul_hashtag_v3_categorie." / ".$cumul_v3_categorie . " USD";
}

if ($cumul_categorie != 0) {
    $cumul_categorie = $cumul_categorie . " USD";
}
$pdf->SetTextColor(0, 0, 0);
$pdf->SetTextColor(250, 0, 0);
$pdf->Row(array(decode(" "), decode("Total : " . $cumul_categorie), decode(" "), decode(" "), decode($cumul_v1_categorie), decode($cumul_v2_categorie), decode($cumul_v3_categorie), decode(" ")));
$pdf->SetTextColor(0, 0, 0);
$pdf->Output("Income_Report_" . $titre_document . ".pdf", 'I');
?>