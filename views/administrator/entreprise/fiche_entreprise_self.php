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
        <span class="glyphicon glyphicon-file" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche de l'entreprise (Institution)</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Informations</legend>
                <?php
                $bdentreprise = new BdEntreprise();
                $entreprises = $bdentreprise->getEntreprise();
                foreach ($entreprises as $entreprise) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td>
                                <table class="table table-bordered table-responsive-lg table-striped">
                                    <tr>
                                        <td><b>Désignation</b></td>
                                        <td><?= $entreprise['designation'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sigle</b></td>
                                        <td><?= $entreprise['sigle'] ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table table-bordered table-responsive-lg table-striped">
                                    <tr>
                                        <td><img width="80px" height="80px" src="../media/pictures-entreprise/<?= $entreprise['url_logo'] ?>"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>

