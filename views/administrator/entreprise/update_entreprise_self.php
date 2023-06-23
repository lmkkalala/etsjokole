<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-equalizer" style="color: red; font-size: 30px;margin-right: 5px;"></span><span class="h3">Configuration</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-pencil" style="color: #d43f3a; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Mise à jour</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les configurations enregistrées</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
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
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("format_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Mauvais format du logo, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("upload_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur du téléchargement du logo, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        Désignation
                    </th>
                    <th>
                        Sigle
                    </th>
                    <th>
                        logo
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdentreprise = new BdEntreprise();
                        $entreprises=$bdentreprise->getEntreprise();
                        foreach ($entreprises as $entreprise) {
                            $n++;
                            ?>
                    	<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="../contollers/entreprise/entrepriseController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><input class="form-control" type="text" name="tb_designation" value="<?= $entreprise['designation'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_sigle" value="<?= $entreprise['sigle'] ?>"></td>
                                    <td>
                                        <label class="control-label">Mettre à jour le logo ?</label>
                                        <input type="radio" name="rb_withfile" class="radio-inline" value="1">Oui
                                        <input type="radio" name="rb_withfile" class="radio-inline" value="0" checked>Non
                                        <input class="form-control" type="file" name="tb_file">
                                    </td>
                                <input type = "hidden" name = "tb_identreprise" value ="<?= $entreprise['id'] ?>">
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button></td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

