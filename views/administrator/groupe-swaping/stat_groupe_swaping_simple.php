<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/groupe-swaping/groupeSwaping.php';
include '../models/swaping/swaping.php';
include '../models/service/service.php';
include '../models/affectation-groupe/affectationGroupe.php';
include '../models/fonction/fonction.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-pencil" style="color: red; font-size: 30px;margin-right: 5px;"></span><span class="h3">Gestion des groupes swaping</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-bar-chart-o" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Statistics</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Categories</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes") ))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Activation effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'activation</span>
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
                <fieldset>
                    <legend>Taper la date consideree :</legend>
                    <form class="form-inline" method="POST" action="../contollers/groupe-swaping/groupeSwapingController.php">
                        <div class="form-group-lg">
                            <input type="date" class="form-control" name="tb_date1" placeholder="First date">
                            <input type="date" class="form-control" name="tb_date2" placeholder="Second date">
                            <select class="form-control select2" name="cb_fonction">
                                <option value="0">Choisir un departement</option>
                                <?php
                                $bdfonction = new BdFonction();
                                $fonctions = $bdfonction->getFonctionAll();
                                foreach ($fonctions as $fonction) {
                                    if (1) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $fonction['id'] ?>"><?= $fonction['designation'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <select class="form-control select2" name="cb_service">
                                <option value="0">Choisir un refectoire</option>
                                <?php
                                $bdservice = new BdService();
                                $services = $bdservice->getServiceAll();
                                foreach ($services as $service) {
                                    if (1) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-success" name="bt_search_for_swaping_simple"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                        </div>
                    </form>
                </fieldset>
                <fieldset>
                    <legend style="color: #c9302c; font-size: 20px;">
                        <?php
                        if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
                            ?>
                            <?= "Date 1 : " . $_GET['use_date1'] . " " . " / Date 2 :" . $_GET['use_date2'] ?>
                            <?php
                        } else {
                            ?>
                            <p style="color: orange;">Choose interval</p>
                            <?php
                        }
                        if (isset($_GET['use_service'])) {
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceById($_GET['use_service']);
                            foreach ($services as $service) {
                                $designation_service_choosen = $service['designation'];
                            }
                            if (isset($designation_service_choosen)) {
                                ?>
                                <span> | Refectoire : <?= $designation_service_choosen ?> </span>
                                <?php
                            } else {
                                ?>
                                <span> | Refectoire : - </span>
                                <?php
                            }
                        }
                        if (isset($_GET['use_departement'])) {
                            $bdfonction = new BdFonction();
                            $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
                            foreach ($fonctions as $fonction) {
                                $designation_fonction_choosen = $fonction['designation'];
                            }
                            if (isset($designation_fonction_choosen)) {
                                ?>
                                <span> | Département : <?= $designation_fonction_choosen ?> | </span>
                                <?php
                            } else {
                                ?>
                                <span> | Département : - | </span>
                                <?php
                            }
                        }
                        ?>
                    </legend>
                </fieldset>
                <fieldset >
                    <?php
                    if ((isset($_GET['use_date1']))) {
                        ?>
                        <a style="font-size: 20px;" href='../views/administrator/groupe-swaping/pdf_stat_groupe_swaping_open_simple.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_departement=' . $_GET['use_departement'] . '&use_service=' . $_GET['use_service'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                        <?php
                        ?>
                        <a style="font-size: 20px;" href='../views/administrator/groupe-swaping/pdf_stat_groupe_swaping_open_with_name_simple.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_departement=' . $_GET['use_departement'] . '&use_service=' . $_GET['use_service'] ?>' class="btn btn-primary pull-right">Print with names in PDF</a>
                        <?php
                    } else {
                        
                    }
                    ?>

                    <legend>

                    </legend>
                </fieldset>
                <br>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Désignation
                    </th>
                    <th>
                        Value
                    </th>
                    <th>
                        Totaux
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $cumule_recette_totale = 0;
                        $bdgroupeswaping = new BdGroupeSwaping();
                        $array_recette_all = [];
                        $array_recette_categorie = [];
                        $array_recette_departement = [];
                        $array_recette_par_restaurant = [];
                        $array_recette_par_typerepas = [];
                        $groupeswapings = $bdgroupeswaping->getGroupeSwapingAllDesc();
                        foreach ($groupeswapings as $groupeswaping) {
                            $cumule_recette_groupe_swaping = 0;
                            $n++;
                            ?>
                            <tr>
                                <td><?= $n ?></td>
                                <td style="font-weight: bold; color: forestgreen;"><?= $groupeswaping['designation'] ?></td>
                                <td>
                                    <?php
                                    $bdfonction = new BdFonction();
                                    if ((isset($_GET['use_departement'])) && ($_GET['use_departement'] != 0)) {
                                        $fonctions = $bdfonction->getFonctionById($_GET['use_departement']);
                                    } else {
                                        $fonctions = $bdfonction->getFonctionAllActiveDesc();
                                    }

                                    foreach ($fonctions as $fonction) {
                                        $cumule_recette_departement = 0;
                                        ?>
                                        <table class="table table-bordered table-hover table-striped">
                                            <tr>
                                                <td style="font-weight: bold; color: blue;">
                                                    <?= $fonction['designation'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $bdservice = new BdService();
                                                    if ((isset($_GET['use_service'])) && ($_GET['use_service'] != 0)) {
                                                        $services = $bdservice->getServiceById($_GET['use_service']);
                                                    } else {
                                                        $services = $bdservice->getServiceAllDesc();
                                                    }
                                                    foreach ($services as $service) {
                                                        $cumule_recette_service = 0;
                                                        $nombre_breakfast = 0;
                                                        $nombre_lunch = 0;
                                                        $nombre_dinner = 0;
                                                        ?>
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <tr>
                                                                <td>
                                                                    <?= $service['designation'] ?>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-bordered table-hover table-striped">
                                                                        <?php
                                                                        $bdswaping = new BdSwaping();
                                                                        $current_date = (date('Y-m-d'));
                                                                        $swapings = $bdswaping->getSwapingByGroupeSwaping($groupeswaping['id']);
                                                                        $cumul_recette = 0;
                                                                        $cumul_breakfast = 0;
                                                                        $cumul_lunch = 0;
                                                                        $cumul_dinner = 0;
                                                                        $nombre_personne_breakfast = 0;
                                                                        $nombre_personne_lunch = 0;
                                                                        $nombre_personne_dinner = 0;
                                                                        foreach ($swapings as $swaping) {
                                                                            if ($swaping['fId'] == $fonction['id']) {
                                                                                if (($swaping['sService_id'] == $service['id']) && (isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
                                                                                    $etat = "non";
                                                                                    $items_date = explode(' ', $swaping['dateHeure']);
                                                                                    if ((date_format(date_create($items_date[0]), 'Y-m-d') >= date_format(date_create($_GET['use_date1']), 'Y-m-d')) && (date_format(date_create($items_date[0]), 'Y-m-d') <= date_format(date_create($_GET['use_date2']), 'Y-m-d'))) {
                                                                                        if ($items_date[1] < ('09:00:00')) {
                                                                                            $type_repas = "breakfast";
                                                                                            $nombre_breakfast++;
                                                                                        } else if ($items_date[1] < ('14:00:00')) {
                                                                                            $type_repas = "lunch";
                                                                                            $nombre_lunch++;
                                                                                        } else {
                                                                                            $type_repas = "dinner";
                                                                                            $nombre_dinner++;
                                                                                        }
                                                                                        ?>
                                                                                        <tr style="background-color: 
                                                                                        <?php
                                                                                        if ($type_repas == "breakfast") {
                                                                                            echo "orange";
                                                                                            $nombre_personne_breakfast++;
                                                                                            $cumul_breakfast = $cumul_breakfast + $swaping['prixchoosen'];
                                                                                        } else if ($type_repas == "lunch") {
                                                                                            echo "forestgreen";
                                                                                            $nombre_personne_lunch++;
                                                                                            $cumul_lunch = $cumul_lunch + $swaping['prixchoosen'];
                                                                                        } else if ($type_repas == "dinner") {
                                                                                            echo "red";
                                                                                            $nombre_personne_dinner++;
                                                                                            $cumul_dinner = $cumul_dinner + $swaping['prixchoosen'];
                                                                                        }
                                                                                        ?>; color: white;
                                                                                            ">
                                                                                            <td>
                                                                                                <?= $swaping['dateHeure'] ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?= $swaping['nom'] . " " . $swaping['postnom'] . " " . $swaping['prenom'] ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?= $type_repas ?>
                                                                                            </td>


                                                                                        </tr>

                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        $cumule_recette_service = $cumule_recette_service + $cumul_breakfast + $cumul_lunch + $cumul_dinner;
                                                                        $array_recette_par_typerepas = [];
                                                                        array_push($array_recette_par_typerepas, $cumul_breakfast);
                                                                        array_push($array_recette_par_typerepas, $cumul_lunch);
                                                                        array_push($array_recette_par_typerepas, $cumul_dinner);
                                                                        ?>
                                                                        <tfoot style="color: #009999; font-weight: bold;">

                                                                        </tfoot>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <td>
                                                                                <?= "Breakfast : " . $nombre_breakfast ?>
                                                                            </td>
                                                                            <td>
                                                                                <?= "Lunch : " . $nombre_lunch ?>
                                                                            </td>
                                                                            <td>
                                                                                <?= "Dinner : " . $nombre_dinner ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>

                                                            </tr>
                                                        </table>
                                                        <?php
                                                        array_push($array_recette_par_restaurant, $array_recette_par_typerepas);
                                                        $array_recette_par_typerepas = [];
                                                        $cumule_recette_departement = $cumule_recette_departement + $cumule_recette_service;
                                                    }
                                                    ?>
                                                </td>

                                            </tr>

                                        </table>
                                        <?php
                                        array_push($array_recette_departement, $array_recette_par_restaurant);
                                        $array_recette_par_restaurant = [];
                                        $cumule_recette_groupe_swaping = $cumule_recette_groupe_swaping + $cumule_recette_departement;
                                    }
                                    ?>
                                </td>


                            </tr>
                            <?php
                            array_push($array_recette_categorie, $array_recette_departement);
                            $array_recette_departement = [];
                            $cumule_recette_totale = $cumule_recette_totale + $cumule_recette_groupe_swaping;
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
            <?php
            ?>

            <?php
            ?>
        </div>
    </div>
</div>

