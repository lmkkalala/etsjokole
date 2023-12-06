<!DOCTYPE html>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

if (!isset($_SESSION['identite'])) {
    header('Location:../index.php?reponse='.sha1($reponse));
    die;
}

if (isset($_GET['mutationID'])) {
    header('Location:../contollers/transition/transition.php?mutationID='.$_GET['mutationID']);
    die();
}

?>
<html lang="fr">
    <head>
        <?php
            include 'meta/metatop.php';
        ?>
        <title>
            Ets JOKOLE DIEU EST GRAND
        </title>
    </head>
    <body style="margin: 0;">
        <div class="container-fluid">
            <?php

            if (isset($_GET['link_up'])) {
                if ($_GET['link_up'] == sha1('home_admin_agent')) {
                    include 'administrator/agent/home_agent.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_service')) {
                    include 'administrator/service/home_service.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_entreprise')) {
                    include 'administrator/entreprise/home_entreprise.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_affectation_service')) {
                    include 'administrator/affectation-Service/home_affectation_service.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_utilisateur')) {
                    include 'administrator/utilisateur/home_utilisateur.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_acceuil')) {
                    include 'administrator/acceuil/home_acceuil.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_fournisseur')) {
                    include 'logistique/fournisseur/home_fournisseur.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_categorie')) {
                    include 'logistique/categorie/home_categorie.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_biens')) {
                    include 'logistique/biens/home_biens.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_attribution_biens')) {
                    include 'logistique/attribution-biens/home_attribution_biens.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_ravitaillement')) {
                    include 'logistique/ravitaillement/home_ravitaillement.php';
                } elseif ($_GET['link_up'] == sha1('home_service_acceuil')) {
                    include 'service/acceuil/home_acceuil.php';
                } elseif ($_GET['link_up'] == sha1('home_service_demande')) {
                    include 'service/demande/home_demande.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_demande')) {
                    include 'logistique/demande/home_demande.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_livraison')) {
                    include 'logistique/livraison/home_livraison.php';
                } elseif ($_GET['link_up'] == sha1('home_service_reception')) {
                    include 'service/reception/home_reception.php';
                } elseif ($_GET['link_up'] == sha1('home_service_distribution')) {
                    include 'service/distribution/home_distribution.php';
                } elseif ($_GET['link_up'] == sha1('home_service_recuperation')) {
                    include 'service/recuperation/home_recuperation.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_acceuil')) {
                    include 'logistique/acceuil/home_acceuil.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_recuperation')) {
                    include 'logistique/recuperation/home_recuperation.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_fonction')) {
                    include 'administrator/fonction/home_fonction.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_unite')) {
                    include 'logistique/unite/home_unite.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_inventaire')) {
                    include 'logistique/inventaire/home_inventaire.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_groupe_swaping')) {
                    include 'administrator/groupe-swaping/home_groupe_swaping.php';
                } elseif ($_GET['link_up'] == sha1('home_service_nourriture')) {
                    include 'service/nourriture/home_nourriture.php';
                } elseif ($_GET['link_up'] == sha1('home_service_preparation')) {
                    include 'service/preparation/home_preparation.php';
                } elseif ($_GET['link_up'] == sha1('home_service_production')) {
                    include 'service/production/home_production.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_affectation_groupe')) {
                    include 'administrator/affectation-groupe/home_affectation_groupe.php';
                } elseif ($_GET['link_up'] == sha1('home_service_swaping')) {
                    include 'service/swaping/home_swaping.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_serviceM')) {
                    include 'administrator/serviceM/home_service.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_fonctionM')) {
                    include 'administrator/fonctionM/home_fonction.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_offreemploie')) {
                    include 'administrator/offre-emploie/home_offreemploie.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_candidat')) {
                    include 'administrator/candidat/home_candidat.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_candidature')) {
                    include 'administrator/candidature/home_candidature.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_employe')) {
                    include 'administrator/employe/home_employe.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_compte')) {
                    include 'administrator/compte/home_compte.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_categorieM')) {
                    include 'administrator/categorieM/home_categorie.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_typecontrat')) {
                    include 'administrator/type-contrat/home_typecontrat.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_chargeconf')) {
                    include 'administrator/chargeconf/home_chargeconf.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_promotion')) {
                    include 'administrator/promotion/home_promotion.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_composantesalaire')) {
                    include 'administrator/composante-salaire/home_composantesalaire.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_composanteimposition')) {
                    include 'administrator/composante-imposition/home_composanteimposition.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_livrepaie')) {
                    include 'administrator/livrepaie/home_livrepaie.php';
                } elseif ($_GET['link_up'] == sha1('home_admin_bulletin')) {
                    include 'administrator/bulletin/home_bulletin.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_sales')) {
                    include 'logistique/sales/home_sales.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_purchase')) {
                    include 'logistique/purchase/home_purchase.php';
                } elseif ($_GET['link_up'] == sha1('home_service_requisition')) {
                    include 'service/requisition/home_requisition.php';
                } elseif ($_GET['link_up'] == sha1('home_service_productionglobal')) {
                    include 'service/productionglobal/home_productionglobal.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_taux')) {
                    include 'logistique/taux/home_taux.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_addsin')) {
                    include 'logistique/addsin/home_addsin.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_costing')) {
                    include 'logistique/costing/home_costing.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_amortissement')) {
                    include 'logistique/amortissement/home_amortissement.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_dotation')) {
                    include 'logistique/dotation/home_dotation.php';
                } elseif ($_GET['link_up'] == sha1('home_service_participation')) {
                    include 'service/participation/home_participation.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_customer')) {
                    include 'logistique/customer/home_customer.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_sale')) {
                    include 'logistique/sale/home_sale.php';
                } elseif ($_GET['link_up'] == sha1('home_logistique_caisse')) {
                    include 'logistique/caisse/home_caisse.php';
                }elseif ($_GET['link_up'] == sha1('home_logistique_dette')) {
                    include 'logistique/dette/home_dette.php';
                }elseif ($_GET['link_up'] == sha1('home_logistique_depense')) {
                    include 'logistique/depense/home_depense.php';
                }elseif ($_GET['link_up'] == sha1('home_logistique_bordereau_expedition')) {
                    include 'logistique/bordereau_expedition/home_bordereau_expedition.php';
                }elseif ($_GET['link_up'] == sha1('home_logistique_transport')) {
                    include 'logistique/logistique_transport/home_logistique_transport.php';
                }elseif ($_GET['link_up'] == sha1('home_facture_client')) {
                    include 'logistique/facture_client/home_facture_client.php';
                }elseif ($_GET['link_up'] == sha1('home_facture')) {
                    include 'service/facture/home_facture.php';
                } elseif ($_GET['link_up'] == sha1('home_service_sale')) {
                    include 'service/sale/home_sale.php';
                }
            }else{
            ?>
                <div class="row">
                    <div class="col-12 text-center mt-5">
                        <h1>BIENVENU</h1>
                        <p>Ets JOKOLE DIEU EST GRAND</p>
                        <p class="text-lowercase">CECI EST LA PLATFORM OFFICIEL DE L'ETABLISSEMENT JOKOLE, IL SEMBLE QUE VOUS ETE PERDUS POUR RETOURNER CLICK SUR LA TOUCHE DIRECTION RETOUR DE VOTRE NAVIGATEUR.</p>
                    </div>
                </div>
            <?php
            }
            ?>
            <div style="margin-bottom:10%;"></div>
            <div class="d-none d-md-block"> 
                <div class="fixed-bottom" style="height: auto; background-color: #000e1f;">
                    <div class="row mb-2">
                        <div class="col-md-4 text-start mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="color: #fff;"><i class="fa fa-copyright mx-2" style="color: #fff; font-size: 20px;"></i> Designed by <b>Rifin Ashuza K. and <a class="text-decoration-none text-white" href="https://lucienkalala.github.io/PersonalPage"> LMK</a></b></span> 
                                </div>
                                <div class="col-md-12">
                                    <!-- <span class="fw-bolder mx-2" style="color: #fff;"><i class="fa fa-envelope-open fw-bolder"></i> rifinashuza.kuderha@gmail.com</span> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 text-end mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="fa fa-shield" style="color: #fff; font-size: 20px;"></span>
                                    <span style="color: #fff;font-size: 15px;">
                                        <span>
                                            <!-- Powered by <b>UIG</b>
                                            Web : <b>www.uig.com</b> -->
                                            <!-- Email : <b>info@uig.com</b> -->
                                            Email : <b>contact@etsjokole.com</b>
                                            Téléphone : <b><a href="tel:+243 972 090 805" class="text-decoration-none text-white">+243 972 090 805</a></b>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
<?php
    include 'meta/metabottom_home.php';
?>

