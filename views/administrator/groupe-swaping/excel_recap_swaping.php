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
require_once "../../../models/pdf-generator/PHPExcel-1.8/Classes/PHPExcel.php";
require_once '../../../models/pdf-generator/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

include '../../../models/connexion.php';
include '../../../models/groupe-swaping/groupeSwaping.php';
include '../../../models/swaping/swaping.php';
include '../../../models/service/service.php';
include '../../../models/affectation-groupe/affectationGroupe.php';
include '../../../models/fonction/fonction.php';
?>

<?php

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B4', 'MB Multiservices');

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

$titre_document = "SWAP RECAP " . $interval_date . "" . $choix_departement . "" . $choix_service;

$r = 8;

$r++;
$r++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $r, "")
        ->setCellValueByColumnAndRow(2, $r, utf8_decode(utf8_decode("Swap Report")))
        ->setCellValueByColumnAndRow(3, $r, "")
        ->setCellValueByColumnAndRow(4, $r, "")
        ->setCellValueByColumnAndRow(5, $r, "")
        ->setCellValueByColumnAndRow(6, $r, "")
        ->setCellValueByColumnAndRow(7, $r, "")
        ->setCellValueByColumnAndRow(8, $r, "")
        ->setCellValueByColumnAndRow(9, $r, "");


$r++;
$r++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $r, "")
        ->setCellValueByColumnAndRow(2, $r, utf8_decode(utf8_decode($titre_document)))
        ->setCellValueByColumnAndRow(3, $r, "")
        ->setCellValueByColumnAndRow(4, $r, "")
        ->setCellValueByColumnAndRow(5, $r, "")
        ->setCellValueByColumnAndRow(6, $r, "")
        ->setCellValueByColumnAndRow(7, $r, "")
        ->setCellValueByColumnAndRow(8, $r, "")
        ->setCellValueByColumnAndRow(9, $r, "");

$n = 0;

//foreach ($theads as $thead) {

$r++;
$r++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $r, "NO")
        ->setCellValueByColumnAndRow(2, $r, "Departement")
        ->setCellValueByColumnAndRow(3, $r, "Restaurant")
        ->setCellValueByColumnAndRow(4, $r, "For Breakfast")
        ->setCellValueByColumnAndRow(5, $r, "For lunch")
        ->setCellValueByColumnAndRow(6, $r, "For Dinner");

// Instanciation de la classe dérivée


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

        $r++;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $r, $p)
                ->setCellValueByColumnAndRow(2, $r, $fonction['designation'])
                ->setCellValueByColumnAndRow(3, $r, "")
                ->setCellValueByColumnAndRow(4, $r, "")
                ->setCellValueByColumnAndRow(5, $r, "")
                ->setCellValueByColumnAndRow(6, $r, "");

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

            $r++;

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(1, $r, "")
                    ->setCellValueByColumnAndRow(2, $r, "")
                    ->setCellValueByColumnAndRow(3, $r, decode($service['designation']))
                    ->setCellValueByColumnAndRow(4, $r, decode($cumul_nombre_breakfast_service))
                    ->setCellValueByColumnAndRow(5, $r, decode($cumul_nombre_lunch_service))
                    ->setCellValueByColumnAndRow(6, $r, decode($cumul_nombre_dinner_service));

            $cumul_nombre_breakfast_fonction = $cumul_nombre_breakfast_fonction + $cumul_nombre_breakfast_service;
            $cumul_nombre_lunch_fonction = $cumul_nombre_lunch_fonction + $cumul_nombre_lunch_service;
            $cumul_nombre_dinner_fonction = $cumul_nombre_dinner_fonction + $cumul_nombre_dinner_service;
        }

        $cumul_nombre_breakfast_total = $cumul_nombre_breakfast_total + $cumul_nombre_breakfast_fonction;
        $cumul_nombre_lunch_total = $cumul_nombre_lunch_total + $cumul_nombre_lunch_fonction;
        $cumul_nombre_dinner_total = $cumul_nombre_dinner_total + $cumul_nombre_dinner_fonction;

        $r++;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $r, "")
                ->setCellValueByColumnAndRow(2, $r, "")
                ->setCellValueByColumnAndRow(3, $r, decode("Total : "))
                ->setCellValueByColumnAndRow(4, $r, decode($cumul_nombre_breakfast_fonction))
                ->setCellValueByColumnAndRow(5, $r, decode($cumul_nombre_lunch_fonction))
                ->setCellValueByColumnAndRow(6, $r, decode($cumul_nombre_dinner_fonction));


        array_push($array_recette_departement, $array_recette_par_restaurant);
        $array_recette_par_restaurant = [];
        $cumule_recette_groupe_swaping = $cumule_recette_groupe_swaping + $cumule_recette_departement;
    }
}

$r++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $r, "")
        ->setCellValueByColumnAndRow(2, $r, decode("Total : "))
        ->setCellValueByColumnAndRow(3, $r, "")
        ->setCellValueByColumnAndRow(4, $r, decode($cumul_nombre_breakfast_total))
        ->setCellValueByColumnAndRow(5, $r, decode($cumul_nombre_lunch_total))
        ->setCellValueByColumnAndRow(6, $r, decode($cumul_nombre_dinner_total));


$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $titre_document . '".xlsx"');

$objWriter->save('php://output');
exit;
?>