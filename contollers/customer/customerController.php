<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/customer/Customer.php';
?>
<?php

function securise($donnee)
{
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);

    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $identite = securise($_POST['tb_identite']);
    $telephone = securise($_POST['tb_telephone']);
    $email = securise($_POST['tb_email']);
    $website = securise($_POST['tb_website']);
    $addedbyID = securise($_POST['tb_addedbyID']);

    if ($identite != '') {
        $bdCustomer = new BdCustomer();
        if ($bdCustomer->addCustomer($identite, $telephone, $email, $website, $addedbyID)) {
            $error = 'succes';
        } else {
            $error = 'traitement_error';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?reponse='.sha1($error).'&link_up='.sha1('home_logistique_customer'));
}

if (isset($_POST['bt_update'])) {
    $id = securise($_GET['id']);

    $identite = securise($_POST['identite_'.$id.'']);
    $telephone = securise($_POST['telephone_'.$id.'']);
    $email = securise($_POST['email_'.$id.'']);
    $siteweb = securise($_POST['siteweb_'.$id.'']);

    $BdCustomer = new BdCustomer();
    if ($BdCustomer->updateCustomer($id, $identite, $telephone, $email, $siteweb)) {
        $reponse = 'succes';
    } else {
        $reponse = 'traitement_error';
    }

    header('Location:../../views/home.php?link_up='.sha1('home_logistique_customer').'&reponse='.sha1($reponse).'&link='.sha1('logistique_customer_update_self'));
}

if (isset($_POST['bt_delete_customer'])) {
    $confirm = 
    '<script>
        confirm("vous voulez supprimer?")
    </script>';
    echo $confirm;
    if ($confirm == true) {
        $tb_customerId = securise($_POST['tb_customerId']);
        $BdCustomer = new BdCustomer();
        if ($BdCustomer->deleteCustomer($tb_customerId)) {
            $reponse = 'succes';
        } else {
            $reponse = 'traitement_error';
        }
    }else{
        $reponse = 'false';
    }
    
    header('Location:../../views/home.php?link_up='.sha1('home_logistique_customer').'&reponse='.sha1($reponse).'&link='.sha1('logistique_customer_update_self'));
}

if (isset($_POST['bt_active'])) {
 
    echo '<script>
        confirm("vous voulez supprimer?")
    </script>';
    
    
    $tb_customerId = securise($_POST['tb_customerId']);
    $operation = securise($_POST['tb_operation']);
    if ($tb_customerId != '' && $operation != '') {
        $BdCustomer = new BdCustomer();
        if ($operation == 'active') {
            if ($BdCustomer->activeAddsIn($tb_customerId)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        } else {
            if ($BdCustomer->desactiveAddsIn($tb_customerId)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        }
    } else {
        $reponse = 'remplissage_error';
    }
    
    header('Location:../../views/home.php?link_up='.sha1('home_logistique_customer').'&reponse='.sha1($reponse).'&link='.sha1('logistique_customer_update_self'));
}

if (isset($_POST['bt_for_update'])) {
    $addsInId = $_POST['tb_idaddsin'];
    header('Location:../../views/home.php?link_up='.sha1('home_logistique_customer').'&use_addsin='.($addsInId).'&link='.sha1('logistique_customer_update_self'));
}

if (isset($_POST['bt_for_statistics'])) {
    $addsInId = $_POST['tb_idaddsin'];
    header('Location:../../views/home.php?link_up='.sha1('home_logistique_customer').'&use_addsin='.($addsInId).'&link='.sha1('logistique_customer_update_self'));
}

?>

