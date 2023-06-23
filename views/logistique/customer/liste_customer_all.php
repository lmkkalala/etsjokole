<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/customer/Customer.php';
if (isset($_GET['reponse']) and !empty($_GET['reponse']) and $_GET['reponse'] == sha1('succes')) {
    echo 
    '<script>
        alert("Opération effectue avec success.")
    </script>';
}else if(isset($_GET['reponse']) and !empty($_GET['reponse'])){
    if ($_GET['reponse'] == sha1('traitement_error') or $_GET['reponse'] == sha1('remplissage_error')) {
        echo 
        '<script>
            alert("Opération echec.")
        </script>'; 
    }
    
}
?>
<div class="panel">
    <div class="panel panel-heading">
        
        <span class="fa fa-user" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Customer</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List of customer</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Identité
                        </th>
                        <th>
                            N° de téléphone
                        </th>
                        <th>
                            Adresse mail
                        </th>
                        <th>
                            Website URL
                        </th>
                        <th>
                            Modifier
                        </th>
                        <th>
                            Sit.
                        </th>
                        <th>
                            Status
                        </th>
                        
                        <th>
                            Supprimer
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdCustomer = new BdCustomer();
                        $customers = $bdCustomer->getCustomerAll();
                        foreach ($customers as $customer) {
                            // if (1) {
                                ++$n; ?>
                            <tr>
                            <form method="post" action="../contollers/customer/customerController.php?id=<?= $customer['id']; ?>">
                                <td><?= $customer['id']; ?></td>
                                <td><input class="form-control" type="text" name="identite_<?= $customer['id']; ?>" id="" value="<?= $customer['identite']; ?>"></td>
                                <td><input class="form-control" type="text" name="telephone_<?= $customer['id']; ?>" id="" value="<?= $customer['telephone']; ?>"></td>
                                <td><input class="form-control" type="text" name="email_<?= $customer['id']; ?>" id="" value="<?= $customer['email']; ?>"></td>
                                <td><input class="form-control" type="text" name="siteweb_<?= $customer['id']; ?>" id="" value="<?= $customer['siteweb']; ?>"></td>
                                <td>
                                    <!-- <input type="hidden" name="tb_customerId" value=""> -->
                                    <button type="submit" name="bt_update" class="btn btn-info">
                                        <span class="fa fa-pencil" style="color: white; font-size: 15px;margin-right: 5px;"></span>
                                    </button>
                                </td>
                            </form>
                                <td>
                                    <?php
                                    if ($customer['active'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">Enabled</h4>
                                    <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Disabled</h4>
                                    <?php
                                    } ?>
                                </td>
                                <td>
                                    <form method="post" action="../contollers/customer/customerController.php">
                                        <input type="hidden" name="tb_customerId" value="<?= $customer['id']; ?>">
                                        <?php
                                        if ($customer['active'] == '1') {
                                            ?>
                                            <input type="hidden" name="tb_operation" value="desactive">
                                            <button type="submit" name="bt_active" class="btn btn-danger">
                                                <span class="fa fa-lock" style="color: white; font-size: 15px;margin-right: 5px;"></span>
                                            </button>
                                        <?php
                                        } elseif ($customer['active'] == '0') {
                                            ?>
                                            <input type="hidden" name="tb_operation" value="active">
                                            <button type="submit" name="bt_active" class="btn btn-success">
                                                <span class="fa fa-unlock" style="color: white; font-size: 15px;margin-right: 5px;"></span>
                                            </button>
                                        <?php
                                        } ?>
                                    </form>
                                </td>
                                
                                <td>
                                    <form method="post" action="../contollers/customer/customerController.php">
                                        <input type="hidden" name="tb_customerId" value="<?= $customer['id']; ?>">
                                        <button type="submit" name="bt_delete_customer" class="btn btn-danger" disabled>
                                            <span class="fa fa-trash" style="color: white; font-size: 15px;margin-right: 5px;"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                           // }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <td style="font-size: 20px;">
                            <span>Number:</span><span><?= $n; ?></span>
                        </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>