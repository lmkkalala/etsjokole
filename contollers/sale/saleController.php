<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/sale/Sale.php';
include '../../models/lineSale/LineSale.php';
include '../../models/production/production.php';

?>
<?php

function securise($donnee)
{
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);

    return $donnee;
}

if (isset($_POST['bt_valider_sale'])) {
    $saleId = securise($_POST['tb_saleId']);
    $customerId = securise($_POST['tb_customerId']);
    $tb_date = securise($_POST['tb_date']);

    if ($saleId != '' && $saleId > 0 && $customerId != 0) {
        $bdSale = new BdSale();
        if ($bdSale->addSale($saleId, $customerId, $tb_date)) {
            $error = 'succes';
        } else {
            $error = 'already_exist';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?reponse='.sha1($error).'&link_up='.sha1('home_service_sale').'&use_customer='.($customerId).'&use_sale='.($saleId));
}

if (isset($_POST['bt_delete_lineSale'])) {
    $saleId = securise($_POST['tb_saleId']);
    $customerId = securise($_POST['tb_customerId']);
    $lineSaleId = securise($_POST['tb_lineSaleId']);

    if ($lineSaleId!="") {
        $bdLineSale = new BdLineSale();
        if ($bdLineSale->deleteLineSale($lineSaleId)) {
            $error = 'succes';
        } else {
            $error = 'already_exist';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?reponse='.sha1($error).'&link_up='.sha1('home_service_sale').'&use_customer='.($customerId).'&use_sale='.($saleId));
}

if (isset($_POST['bt_enregistrer'])) {
    $saleId = securise($_POST['tb_saleId']);
    $customerId = securise($_POST['tb_customerId']);
    $productionId = securise($_POST['cb_production']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);
    $tauxTVA = securise($_POST['tb_tauxTVA']);

    $bdLineSale = new BdLineSale();
    $bdProduction = new BdProduction();

    $productions=$bdProduction->getProductionById($productionId);

    $reste=0;
    $lineSales=$bdLineSale->getlineSaleByProductionId($productionId);
    $cumulQuantiteLS=0;
    foreach ($lineSales as $lineSale) {
        $cumulQuantiteLS=$cumulQuantiteLS+$lineSale['quantite'];
    }
    $reste=($productions[0]['quantite']-$cumulQuantiteLS);

    if ($saleId != '' && $customerId != 0 && $quantite > 0 && $prix != '' && $prix > 0 && $tauxTVA != '') {
        if ($reste>=$quantite) {
            if ($bdLineSale->addLineSale($quantite, $prix, $tauxTVA, $saleId, $productionId)) {
                $error = 'succes';
            } else {
                $error = 'traitement_error';
            }
        } else {
            $error = 'quantite_error';
        }
        
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?reponse='.sha1($error).'&link_up='.sha1('home_service_sale').'&use_customer='.($customerId).'&use_sale='.($saleId).'#selectProduct');
    die;   
}



if (isset($_POST['bt_select_customer'])) {
    $customerId = $_POST['cb_customer'];
    header('Location:../../views/home.php?link='.sha1('service_sale_add').'&use_customer='.($customerId).'&link_up='.sha1('home_service_sale'));
}

if (isset($_POST['bt_reset_sale'])) {
    $customerId = $_POST['tb_customerId'];
    header('Location:../../views/home.php?link='.sha1('service_sale_add').'&use_customer='.($customerId).'&link_up='.sha1('home_service_sale'));
}

if (isset($_POST['bt_select_customer_list'])) {
    $customerId = $_POST['cb_customer'];
    header('Location:../../views/home.php?link='.sha1('service_sale_liste_all').'&use_customer='.($customerId).'&link_up='.sha1('home_service_sale'));
    die;
}

if (isset($_POST['bt_select_customer_dates_list'])) {
    $customerId = $_POST['cb_customer'];
    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    header('Location:../../views/home.php?link='.sha1('service_sale_liste_all').'&use_customer='.($customerId).'&use_date1='.($date1).'&use_date2='.($date2).'&link_up='.sha1('home_service_sale'));
    die;
}

?>

