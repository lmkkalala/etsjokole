<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="margin: 20px;">
    <fieldset>
        <form class="form-horizontal" method="post" action="../contollers/preparation/preparationController.php">
            <div class="input-group-lg">
                <label class="control-label">Service / Département / Site :</label>
                <select class="form-control" name="cb_service">
                    <option value="0">Choisir un service</option>
                    <?php
                    $bdservice = new BdService();
                    $services = $bdservice->getServiceAllDesc();
                    foreach ($services as $service) {
                        if ($service['active']) {
                            ?>
                            <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <br>
                <input type="hidden" name="tb_link" value="<?= $link ?>">
                <?php
                if (isset($_GET['use2'])) {
                    ?>
                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use2'] ?>">
                    <?php
                } else {
                    ?>
                    <input type="hidden" name="tb_idbiens" value="<?= 0 ?>">
                    <?php
                }
                ?>
                <input class="btn btn-primary" type="submit" name="bt_search_by_service" value="Choisir">
            </div> 
        </form>
    </fieldset>
    <fieldset style="margin: 20px;">
        <legend>Service / Département / Site : </legend>
        <h3>
            <strong style="color: forestgreen;">
                <?php
                if (isset($_GET['use'])) {
                    $bdservice = new BdService();
                    $services = $bdservice->getServiceById($_GET['use']);
                    foreach ($services as $service) {
                        echo $service['designation'];
                    }
                } else {
                    echo "Aucun choix";
                }
                ?>
            </strong>

        </h3>
    </fieldset>
</div>




