<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ets JOKOLE DIEU EST GRAND</title>
</head>
<link rel="stylesheet" href="../../web/fa/css/font-awesome.min.css">
<link rel="stylesheet" href="../../web/bootstrap/css/bootstrap5.min.css">
<link href="../../media/pictures-system/Vague_Blanche.jpg" rel="icon">

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-5 mt-4 d-flex justify-content-left">
                    <h3 class="text-center">Ets JOKOLE DIEU EST GRAND</h3>
                </div>
                <div class="col-md-4 mt-4 d-flex justify-content-left">
                    <h4 class="border-bottom border-secondary border-2 text-center">SUIVI LOCAL DU STOCK</h4>
                </div>
                <div class="col-md-3 mt-4">
                    <p class="text-end h5 bg-secondary text-white p-1 text-center w-100 rounded-1"> Le <?=date('d-m-Y',time())?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mt-1">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#add_article"> AJOUTER ARTICLE</button>
                </div>
                <div class="col-md-3 mt-1">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#save_facture"> ENREGISTRER FACTURE</button>
                </div>

                <div class="col-md-2 mt-1">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#les_factures"> LES FACTURES</button>
                </div>
                <div class="col-md-2 mt-1">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#depot"> Voir DEPOTS</button>
                </div>
                <div class="col-md-2 mt-1">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#appro_depot"> Approvision DEPOTS</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-md-3 mb-2 mt-2">
                    <select name="OptionDepotList" id="OptionDepotList" class="form-control bg-secondary text-white">
                        <option value="">VOIR TOUT</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 mt-2">
                    <input type="text" placeholder="Saisisser l'article" class="form-control" id="articleFilter" name="articleFilter">
                </div>
            </div>
            <div class="col-md-12 mt-2 table-responsive">
                <table id="ListArticle" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Produit/Emballage</th>
                            <th>QteStock/Prix Vente $</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1</td>
                            <td>Farine Sacs</td>
                            <td>200 20 $</td>
                            <td>
                                <button type="button" class="btn btn-secondary mt-1"><i class="fa fa-pencil-square-o"></i></button>
                                <button type="button" class="btn btn-danger mt-1"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<div class="modal fade" id="depot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">AJOUTER DEPOT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary" id="show-form">Formulaire Depot <i class="fa fa-arrow-down"></i></button>
            </div>
            <div class="col-md-12" id="formDepotList">
                <form action="" method="post" id="formDepot">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <input type="text" class="form-control" name="depot" id="depot" placeholder="Depot" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="text" class="form-control" name="gerant" id="gerant" placeholder="Gerant" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="hidden"name="depotEnregistrer" id="depotEnregistrer">
                            <button type="submit" class="btn btn-secondary" value="">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 table-responsive">
                <table id="ListDepot" class="table table-bordered">
                        <tr>
                            <th>N°</th>
                            <th>Depot</th>
                            <th>Gerant</th>
                            <th>Operation</th>
                        </tr>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Depot BKV 1</td>
                            <td>Yousouph</td>
                            <td>
                                <button type="button" class="btn btn-secondary mt-1"><i class="fa fa-pencil-square-o"></i></button>
                                <button type="button" class="btn btn-danger mt-1"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
    </div>
    </div>
</div>
</div>
<div class="modal fade" id="appro_depot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Approvision DEPOT</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="post" id="approvionDepot">
                        <div class="row mt-2">
                            <div class="col-md-3 mt-1">
                                <select class="form-control" id="OptionDepot" name="OptionDepot" required>
                                    <option value="">SELECTIONNER</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-1">
                                <select class="form-control" id="article" name="article" required>
                                    <option value="">SELECTIONNER</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-1">
                                <input type="text" id="quantiteStocker" name="quantiteStocker" class="form-control" placeholder="Quantite" required>
                            </div>
                            <div class="col-md-3 mt-1">
                                <input type="date" id="dateAppro" name="dateAppro" class="form-control" placeholder="Date" required>
                            </div>
                            <div class="col-md-3 mt-2">
                                <input type="hidden"name="approvisionEnregistrer" id="approvisionEnregistrer">
                                <input type="submit" value="Enregistrer" class="btn btn-secondary w-100" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 table-responsive">
                    <table id="ListApprovision" class="table table-bordered">
                            <tr>
                                <th>N°</th>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Quantite</th>
                                <th>Depot</th>
                                <th>Operation</th>
                            </tr>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>10/10/2023</td>
                                <td>Farine</td>
                                <td>20</td>
                                <td>Yousouph</td>
                                <td>
                                    <button type="button" class="btn btn-secondary mt-1"><i class="fa fa-pencil-square-o"></i></button>
                                    <button type="button" class="btn btn-danger mt-1"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="add_article" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">ENREGISTRER ARTICLE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
            <form action="" method="post" id="add_article_form">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <input type="text" class="form-control" name="article" id="article" placeholder="Article" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <input type="text" class="form-control" name="quantite" id="quantite" placeholder="Quantite" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <input type="text" class="form-control" name="emballage" id="emballage" placeholder="Emballage" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <input type="text" class="form-control" name="prix" id="prix" placeholder="Prix" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <input type="hidden"name="produitEnregistrer" id="produitEnregistrer">
                        <button type="submit" class="btn btn-secondary" value="">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
    </div>
    </div>
</div>
</div>

<div class="modal fade" id="les_factures" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">LES FACTURES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="FilterFacture">
                    <div class="row">
                        <div class="col-md-3 mt-1">
                            <label for="">Selectionner Depot De</label>
                            <select class="form-control" id="OptionDepotDe" name="OptionDepotDe" required>
                                <option value="">SELECTIONNER</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Facture Ecrit Par</label>
                            <select class="form-control" id="FactureDefiltre" name="FactureDefiltre">
                                <option value="">SELECTIONNER</option>
                                <option value="Facturier_1">Facturier 1</option>
                                <option value="Facturier_2">Facturier 2</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Date Debut</label>
                            <input type="date" id="dateStart" name="dateStart" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="">Date Fin</label>
                            <input type="date" id="dateEnd" name="dateEnd" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary mt-2 w-100">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        <div class="col-md-12 table-responsive">
            <table id="ListVenteAll" class="display table" style="width:100%">
                <!-- <thead>
                    <tr>
                    <th class="small">Date</th>
                    <th class="small">Facture</th>
                    <th class="small">Contenu</th>
                    <th class="small">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <td>Le 10/10/2023</td>
                    <td>00001</td>
                    <td>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Farine</td>
                                    <td>2</td>
                                    <td>Sacs</td>
                                    <td>10$</td>
                                </tr>
                                <tr>
                                    <td>Total </td>
                                    <td></td>
                                    <td></td>
                                    <td>30$</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td><button type="button" class="btn btn-danger mt-1"><i class="fa fa-trash-o"></i></button></td>
                </tbody> -->
            </table>
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
    </div>
    </div>
</div>
</div>

<div class="modal fade" id="save_facture" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">ENREGISTRER FACTURE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="validate_n_facture">
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <input type="date" id="selected_date" name="selected_date" class="form-control" value="<?=date('Y-m-d')?>">
                        </div>
                        <div class="col-md-3 mt-2">
                            <input type="hidden" id="validate_n_facture_btn" name="validate_n_facture_btn">
                            <button type="submit" class="btn btn-secondary w-100">N° Facture</button>
                        </div>
                        <div class="col-md-3 mt-2">
                            <button type="button" id="reset" class="btn btn-secondary w-100">Vider Page</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <form action="" method="post" id="add_vente">
                    <div class="row mt-2">
                        <div class="col-md-3 mt-1">
                            <input type="hidden" id="dateVente" name="dateVente" class="form-control" value="<?=date('Y-m-d',time())?>">
                            <input type="text" id="nFacture" name="nFacture" class="form-control" placeholder="N° SYSTEME" readonly required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <input type="text" id="numero_surFacture" name="numero_surFacture" class="form-control" placeholder="N° Sur Facture" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <select class="form-control" id="articleFacturer" name="articleFacturer" required>
                                <option value="">SELECTIONNER PRODUIT</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <select class="form-control" id="OptionDepotVente" name="OptionDepotVente" required>
                                <option value="">SELECTIONNER DEPOT</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <select class="form-control" id="FactureDe" name="FactureDe" required>
                                <option value="">SELECTIONNER FACTURE DE</option>
                                <option value="Facturier_1">Facturier 1</option>
                                <option value="Facturier_2">Facturier 2</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-1">
                            <input type="text" id="quantiteFacturer" step="0.00" name="quantiteFacturer" class="form-control" placeholder="Quantite" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <input type="text" id="prixUnitaire" step="0.00" name="prixUnitaire" class="form-control" placeholder="Prix Unitaire" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <input type="text" id="prixFacturer" step="0.00" name="prixFacturer" class="form-control" placeholder="Prix Total" required>
                        </div>
                        <div class="col-md-3 mt-2">
                            <input type="submit" value="Enregistrer" class="btn btn-secondary w-100" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 table-responsive">
                <table class="display table" id="ListVente">
                    <!-- <thead>
                        <tr>
                        <th class="small">Date</th>
                        <th class="small">Facture</th>
                        <th class="small">Contenu</th>
                        <th class="small">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>Le 10/10/2023</td>
                        <td>00001</td>
                        <td>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Farine</td>
                                        <td>2</td>
                                        <td>Sacs</td>
                                        <td>10$</td>
                                    </tr>
                                    <tr>
                                        <td>Total </td>
                                        <td></td>
                                        <td></td>
                                        <td>30$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td><button type="button" class="btn btn-danger mt-1"><i class="fa fa-trash-o"></i></button></td>
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
    </div>
    </div>
</div>
</div>

<script type="text/javascript" src="../../web/bootstrap/js/bootstrap5.min.js"></script>
<script type="text/javascript" src="../../web/jquery/jquery-3.5.1.js"></script>

<script>
$('#reset').on('click',function(){
    $('#add_vente')[0].reset();
    $('#ListVente').html('');
})

$('#show-form').on('click',function(){
    $('#formDepotList').toggle();
})    

$('#prixUnitaire, #quantiteFacturer').on('change',function(){
    let prixUnitaire = $('#prixUnitaire').val();
    let quantiteFacturer = $('#quantiteFacturer').val();

    let prixTotal = prixUnitaire * quantiteFacturer;
    $('#prixFacturer').val(prixTotal);
});

function deleteThis(val,table,venteID = ''){
    if (confirm('Voulez-vous continuer?') == false) {
        return;
    }else{
        let code = prompt('Entrer Le code de validation','');
        let codeVal = "adminPassLMK@";

        if(code != codeVal){
            alert("Vous avez saisie un mot de passe incorrect.");
            return;
        }
    }

    var form = {
        'id':val,
        'to':table,
        'venteID':venteID
    };
    
    $.ajax({
        type:'POST',
        url: '<?=("/contollers/MoreControllers/control.php?Local=".sha1('delete'))?>',
        data:form,
        dataType:'json',
        beforeSend:function(){
            $('button').prop('disabled',true);
        },	
        success: function(data){
                if(data.status == 'success'){
                    let val = $('#articleFacturer').val();
                    if (val == '') {
                        ListTable();
                    } else {
                        ListTable(data.idVente);
                        //$('#articleFacturer').val('')
                        // $('#quantiteFacturer').val('')
                        // $('#prixFacturer').val('') 
                        // $('#prixUnitaire').val('');
                    }
                }
            alert(data.msg);
            $('button').prop('disabled',false);
        }
    });
}

function updateThis(val,table){
    if (confirm('Voulez-vous continuer?') == false) {
        return;
    }else{
        let code = prompt('Entrer Le code de validation','');
        if(code != 'adminPassLMK@'){
            alert("Vous avez saisie un mot de passe incorrect.");
            return;
        }
    }

    var form = {
        'articleUpdate_': $('#articleUpdate_'+val+'').val(),
        'quantiteUpdate_': $('#quantiteUpdate_'+val+'').val(),
        'emballageUpdate_': $('#emballageUpdate_'+val+'').val(),
        'prixUpdate_': $('#prixUpdate_'+val+'').val(),
        'id':val,
        'table':table
    };

    $.ajax({
    type:'POST',
    url: '<?=("/contollers/MoreControllers/control.php?Local=".sha1('update'))?>',
    data:form,
    dataType:'json',
    beforeSend:function(){
        $('button').prop('disabled',true);
    },	
    success: function(data){
            if(data.status == 'success'){
                alert(data.msg);
            }else{
                alert(data.msg);
            }
            $('button').prop('disabled',false);
        }
    })

}

function ListTable(val = '',produit = ''){
    if (val != '') {
        val = '&id='+val+'';
    }

    $.ajax({
        type:'GET',
        url:"../../contollers/MoreControllers/control.php?Local=start"+val,
        dataType:'json',
        success: function(data){
            if (data.htmlArticle.article != '') {
            $('#ListArticle').html(data.htmlArticle.article);
            }

            if (data.htmlArticle.ListDepot != '') {
            $('#ListDepot').html(data.htmlArticle.ListDepot);
            }

            if (data.htmlArticle.ListApprovision != '') {
                $('#ListApprovision').html(data.htmlArticle.ListApprovision);
            }

            if (produit == '') {
                if (data.htmlArticle.OptionArticle != '') {
                    $('#articleFacturer').html(data.htmlArticle.OptionArticle);
                }
            }

            if (data.htmlArticle.OptionArticle != '') {
                $('#article').html(data.htmlArticle.OptionArticle);
            }

            if (data.htmlArticle.OptionDepot != '') {
                $('#OptionDepotDe').html(data.htmlArticle.OptionDepot);
            }

            if (data.htmlArticle.OptionDepot != '') {
                $('#OptionDepot').html(data.htmlArticle.OptionDepot);
            }

            if (data.htmlArticle.OptionDepot != '') {
                $('#OptionDepotVente').html(data.htmlArticle.OptionDepot);
            }

            if (data.htmlArticle.OptionDepot != '') {
                $('#OptionDepotList').html(data.htmlArticle.OptionDepot);
            }
        
            if(data.htmlArticle.vente != '' && data.htmlArticle.id == '' || data.htmlArticle.id == null){
                $('#ListVenteAll').html(data.htmlArticle.vente);
            } 
            
            if(data.htmlArticle.vente != '' && data.htmlArticle.id != '' && data.htmlArticle.id != null){
                $('#ListVente').html(data.htmlArticle.vente);
            }
        },
    });
}

$('document').ready(function(){
    ListTable();
    $('#formDepotList').hide();
});

$('#validate_n_facture').on('submit',function(){
    event.preventDefault();
    let form = new FormData($('#validate_n_facture')[0]);
    $.ajax({
        type:'POST',
        url:"../../contollers/MoreControllers/control.php?Local",
        data:form,
        dataType:'json',
        processData: false, 
        contentType: false,
        beforeSend:function(){
            $('button').prop('disabled',true);
        },	
        success: function(data){
            $('button').prop('disabled',false);
            
            if(data.htmlFactureNumber != ''){
                $('#nFacture').val(data.htmlFactureNumber.nFacture);
                $('#dateVente').val(data.htmlFactureNumber.dateVente);
                $('#articleFacturer').val('');
                $('#quantiteFacturer').val('');
                $('#prixFacturer').val('');
                $('#prixUnitaire').val('');
                $('#ListVente').html('');
            }
        },
    });
});

$('#add_article_form').on('submit',function(){
    if (confirm('Voulez-vous continuer?') == false) {
        return
    }else{
        let code = prompt('Entrer Le code de validation','');
        if(code != 'adminPassLMK@'){
            alert("Vous avez saisie un mot de passe incorrect.")
            return
        }
    }
    event.preventDefault();
    let form = new FormData($('#add_article_form')[0]);
    $.ajax({
        type:'POST',
        url:"../../contollers/MoreControllers/control.php?Local",
        data:form,
        dataType:'json',
        processData: false, 
        contentType: false,
        beforeSend:function(){
            $('button').prop('disabled',true);
        },	
        success: function(data){

            $('button').prop('disabled',false)
            if (data.htmlArticleAdd.status == 'success') {
                $('#add_article_form')[0].reset();
                if (data.htmlArticleAdd.article != '') {
                    $('#ListArticle').html(data.htmlArticleAdd.article)
                }
                ListTable();
            }
            
            alert(data.htmlArticleAdd.sms);
        },
    });
});

$('#add_vente').on('submit',function(){
        if (confirm('Voulez-vous continuer?') == false) {
            return
        }
        event.preventDefault();
        let form = new FormData($('#add_vente')[0]);
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local",
            data:form,
            dataType:'json',
            processData: false, 
            contentType: false,
            beforeSend:function(){
                $('button').prop('disabled',true);
            },	
            success: function(data){
                $('button').prop('disabled',false);
                if (data.htmlVente.article != '') {
                $('#ListVente').html(data.htmlVente.article)
                }
                ListTable('','ProduitOff');
                alert(data.htmlVente.sms);
            },
        });
});

$('#FilterFacture').on('submit',function(){
        event.preventDefault();
        let form = new FormData($('#FilterFacture')[0]);
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local=start",
            data:form,
            dataType:'json',
            processData: false, 
            contentType: false,
            beforeSend:function(){
                $('button').prop('disabled',true);
            },	
            success: function(data){
                $('button').prop('disabled',false);
                if (data.htmlArticle.vente != '') {
                $('#ListVenteAll').html(data.htmlArticle.vente);
                }
            },
        });
});

$('#OptionDepotList').on('change',function(){
        event.preventDefault();
        
        let optionID = $('#OptionDepotList').val();
        if (optionID == '') {
            optionID = '';
        }
        let articleFilter = $('#articleFilter').val();
        if(articleFilter == ''){
            articleFilter  = '';
        }
        let form = {'optionID': optionID, 'articleFilter':articleFilter };
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local=start",
            data:form,
            dataType:'json',	
            success: function(data){
                $('#ListArticle').html(data.htmlArticle.article);
            },
        });
});

$('#articleFilter').on('change',function(){
        
        let optionID = $('#OptionDepotList').val();
        if (optionID == '') {
            optionID = '';
        }

        let articleFilter = $('#articleFilter').val();
        if(articleFilter == ''){
            articleFilter  = '';
        }
        let form = {'optionID': optionID, 'articleFilter':articleFilter };
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local=start",
            data:form,
            dataType:'json',	
            success: function(data){
                $('#ListArticle').html(data.htmlArticle.article);
            },
        });
});

$('#formDepot').on('submit',function(){
        if (confirm('Voulez-vous continuer?') == false) {
            return
        }
        event.preventDefault();
        let form = new FormData($('#formDepot')[0]);
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local",
            data:form,
            dataType:'json',
            processData: false, 
            contentType: false,
            beforeSend:function(){
                $('button').prop('disabled',true);
            },	
            success: function(data){
                $('button').prop('disabled',false);
                if (data.html.ListDepot != '') {
                $('#ListDepot').html(data.html.ListDepot)
                $('#formDepot')[0].reset();
                }
            },
        });
});

$('#approvionDepot').on('submit',function(){
        if (confirm('Voulez-vous continuer?') == false) {
            return
        }else{
            let val = $('#OptionDepot').val();
            let code = prompt('Entrer Le code de validation','');
            let codeVal = '';

            switch (val) {
                case '1':
                    codeVal = 'adminPassLiwa';
                    break;
                case '2':
                    codeVal = 'adminPassGloire';
                    break;
                case '3':
                    codeVal = 'adminPassLabane';
                    break;
                default:
                    codeVal = "adminPassLMK@";
                    break;
            }

            if(code != codeVal){
                alert("Vous avez saisie un mot de passe incorrect.");
                return;
            }
        }
        event.preventDefault();
        let form = new FormData($('#approvionDepot')[0]);
        $.ajax({
            type:'POST',
            url:"../../contollers/MoreControllers/control.php?Local",
            data:form,
            dataType:'json',
            processData: false, 
            contentType: false,
            beforeSend:function(){
                $('button').prop('disabled',true);
            },	
            success: function(data){
                $('button').prop('disabled',false);
                if (data.html.ListDepot != '') {
                    $('#ListApprovision').html(data.html.ListApprovision)
                    $('#approvionDepot')[0].reset();
                }
                ListTable();
                alert(data.html.sms);
            },
        });
});
</script>
</html>