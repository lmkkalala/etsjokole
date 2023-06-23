<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/groupe-swaping/groupeSwaping.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-duplicate" style="color: red; font-size: 30px;margin-right: 5px;"></span><span class="h3">Category</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Categories</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Name
                    </th>
                     <th>
                        Number of meal
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdgroupeswaping=new BdGroupeSwaping();
                        $groupeswapings=$bdgroupeswaping->getGroupeSwapingAllDesc();
                        foreach ($groupeswapings as $groupeswaping) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $groupeswaping['id'] ?></td>
                                <td><?= $groupeswaping['designation'] ?></td>
                                <td><?= $groupeswaping['nombrerepas'] ?></td>
                                <td>
                                    <?php
                                    if ($groupeswaping['active'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">On</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Off</h4>
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

