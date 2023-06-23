<form class="form-horizontal" method="POST" action="../contollers/costing/costingController.php">
    <div class="form-group-lg" style="background-color: #d3d3d3; padding: 5px; color: whitesmoke;">
        <table class="table">
            <tr>
                <td>
                    <div class="input-group-lg">
                        <label for="date">Date</label>
                        <input class="form-control" id="date" type="date" name="tb_date" value="<?= $date_ravitaillement ?>">
                    </div>
                </td>
                <td>
                    <div class="input-group-lg">
                        <label for="addsin">Adds-in</label>
                        <select id="addsin" class="form-control" name="cb_addsin">
                            <option value="0">Select adds-in</option>
                            <?php
                            $BdAddsIn = new BdAddsIn();
                            $addsIns = $BdAddsIn->getAddsInActive();
                            foreach ($addsIns as $addsIn) {
                            ?>
                                <option value="<?= $addsIn['id'] ?>"><?= $addsIn['designation'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="input-group-lg">
                        <label for="quantite">Quantité</label>
                        <input class="form-control" id="quantite" type="text" name="tb_quantite" value="1" placeholder="quantité">
                    </div>
                </td>
                <td>
                    <div class="input-group-lg">
                        <label for="prix">Prix (USD)</label>
                        <input class="form-control" id="prix" type="text" name="tb_prix" placeholder="prix">
                    </div>
                </td>
            </tr>
        </table>

        <fieldset>
            <legend></legend>
            <div class="input-group-lg">
                <input type="hidden" name="tb_idravitaillement" value="<?= $_GET['use_ravitaillement'] ?>">
                <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                <input class="btn btn-danger" type="reset" value="Cancel">
            </div>
        </fieldset>
    </div>
</form>