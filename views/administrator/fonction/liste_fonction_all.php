<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/fonction/fonction.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-pencil" style="color: red; font-size: 30px;margin-right: 5px;"></span><span class="h3">Department</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Departments</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdfonction=new BdFonction();
                        $fonctions=$bdfonction->getFonctionAllDesc();
                        foreach ($fonctions as $fonction) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $fonction['id'] ?></td>
                                <td><?= $fonction['designation'] ?></td>
                                <td>
                                    <?php
                                    if ($fonction['active'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">Actif</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Inactif</h4>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

