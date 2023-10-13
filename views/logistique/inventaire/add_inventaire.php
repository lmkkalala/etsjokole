<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des inventaires</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouveau inventaire</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
            <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/inventaire/inventaireController.php">
                <div class="row form-group-lg">
                    <div class="col-md-10 input-group-lg">
                        <label class="control-label">Bien/produit :</label>
                        <select class="form-control select2" name="cb_biens">
                            <option value="0">Choisir un biens/produit</option>
                            <?php
                            $bdbiens = new BdBiens();
                            $biens = $bdbiens->getBiensAllDesc();
                            foreach ($biens as $bien) {
                                if ($bien['active']) {
                                    if ($bien['bId'] == $_GET['use']) {
                                        ?>
                            <option value="<?= $bien['bId'] ?>" selected><?= $bien['bDesignation'] . " : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-10 input-group-lg">
                        <label class="control-label">Date :</label>
                        <input class="form-control" type="date" name="tb_date" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-10 input-group-lg">
                        <label class="control-label">Quantité inventoriée : </label>
                        <input class="form-control" type="number" step="0.01" name="tb_quantite" placeholder="Quantité inventoriée">
                    </div>
                    <div class="col-md-10 input-group-lg">
                        <label class="control-label">Commentaire : </label>
                        <textarea class="form-control" name="tb_commentaire" placeholder="Taper votre commentaire ici"></textarea>
                    </div>
                    <div class="col-md-10 mt-1 input-group-lg">
                            <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                            <input class="btn btn-success mt-2" type="submit" name="bt_enregistrer" value="Enregistrer">
                            <input class="btn btn-danger mt-2" type="reset" value="Initialiser">
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

