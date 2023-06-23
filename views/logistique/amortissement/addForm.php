<form class="form-horizontal" method="POST" action="../contollers/amortissement/amortissementController.php">

    <div class="form-group-lg" style="background-color: #d3d3d3; padding: 5px; color: whitesmoke;">

        <table class="table">

            <tr>

                <td>

                    <div class="input-group-lg">

                        <label for="date">Date de debut</label>

                        <input class="form-control" id="date" type="date" name="tb_dateDebut" value="<?= $date_acquisition ?>">

                    </div>

                </td>

                <td>

                    <div class="input-group-lg">

                        <label for="prixAcquisition">Prix d'acquisition (USD)</label>

                        <input class="form-control" id="prixAcquisition" type="text" name="tb_prixAcquisition" value="<?= $prix_unitaire ?>">

                    </div>

                </td>

                <td>

                    <div class="input-group-lg">

                        <label for="duree">Time (Year)</label>

                        <input class="form-control" id="duree" type="text" name="tb_duree" placeholder="years">

                    </div>

                </td>

            </tr>

        </table>



        <fieldset>

            <legend></legend>

            <div class="input-group-lg">
<?php
    if (isset($_GET['use_unite'])) {
?>
                <input type="hidden" name="tb_idunite" value="<?=$_GET['use_unite'] ?>">
<?php
    }else{
?>
                <input type="hidden" name="tb_idunite" value="">

<?php
    }
?>
                <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">

                <input class="btn btn-danger" type="reset" value="Cancel">

            </div>

        </fieldset>

    </div>

</form>