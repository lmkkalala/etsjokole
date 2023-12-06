<!-- <script type="text/javascript" src="../web/jquery/jquery-min.js"></script> -->
<script type="text/javascript" src="../web/jquery/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../web/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../web/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="../web/bootstrap/js/bootstrap5.min.js"></script>
<script type="text/javascript" src="../web/datatable/jquery.dataTables.min.js"></script>
    <?php
        $page = '';

            if (isset($_GET['link_up'])) {
                if ($_GET['link_up'] == sha1('home_logistique_caisse')) {
                    $page = 'home_caisse';
                }elseif ($_GET['link_up'] == sha1('home_logistique_dette')) {
                    $page = 'home_dette';
                }elseif ($_GET['link_up'] == sha1('home_logistique_depense')) {
                    $page = 'home_depense';
                }elseif ($_GET['link_up'] == sha1('home_logistique_bordereau_expedition')) {
                    $page = 'home_bordereau_expedition';
                }elseif ($_GET['link_up'] == sha1('home_logistique_transport')) {
                    $page = 'home_logistique_transport';
                }elseif ($_GET['link_up'] == sha1('home_facture_client')) {
                    $page = 'home_facture_client';
                }elseif ($_GET['link_up'] == sha1('home_facture')) {
                    $page = 'home_facture';
                }elseif ($_GET['link_up'] == sha1('home_logistique_purchase')) {
                    $page = 'home_purchase';
                }
            }
    ?>

<script type="text/javascript">
    function logout(){
        var form = {'bt_deconnexion':'backCall'};
        $.ajax({
            type:'POST',
            url: '../contollers/logout/logoutController.php',
            data:form,
            dataType:'json',	
            success: function(data){
                if(data.status == 'success'){
                    window.location.href = "../../index.php";
                }
            }
        });
    }
        function list(val = '', modal = '', page = '') {
            if(val != '' && modal == ''){
                event.preventDefault();
                let form = new FormData($('#'+val+'')[0]);
                $.ajax({
                    type:'POST',
                    url:'<?=("/contollers/MoreControllers/control.php?code=".sha1('loadDataList'))?>'+'&page='+'<?=$page?>'+'',
                    data:form,
                    dataType:'json',
                    processData: false, 
                    contentType: false,
                    beforeSend:function(){
                        $('button').prop('disabled',true);
                    },	
                    success: function(data){
                        $('button').prop('disabled',false);
                        
                        if(data.htmlDettePage != ''){
                            //$('#list_dette_page').html(data.htmlDettePage)
                            $('#dette_list').html(data.htmlDettePage)
                        }
                        
                        if(data.htmlDepensePage != ''){
                            //$('#list_depense_page').html(data.htmlDepensePage)
                            $('#depense_list').html(data.htmlDepensePage)
                        }
                        if(data.htmlCaissePage.entre != ''){
                            //$('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                            $('#caisse_list_entre').html(data.htmlCaissePage.entre)
                        }
                        if(data.htmlCaissePage.sortie != ''){
                            //$('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                            $('#caisse_list_sortie').html(data.htmlCaissePage.sortie)
                        }
                        if(data.htmlCaissePage.dollars != ''){
                            $('#dollars').html(data.htmlCaissePage.dollars)
                        }
                        if(data.htmlCaissePage.fc != ''){
                            $('#fc').html(data.htmlCaissePage.fc)
                        }
                        if(data.htmlCaissePage.frw != ''){
                            $('#frw').html(data.htmlCaissePage.frw)
                        }
                        if(data.htmlCaissePage.listBanque != ''){
                            $('#banque_table').html(data.htmlCaissePage.listBanque)
                        }
                        if(data.htmlConducteurPage.listConducteur != ''){
                            $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        }
                        if(data.htmlConducteurPage.listVehicule != ''){
                            $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                        }
                        if(data.htmlConducteurPage.listTypeDepense != ''){
                            $('#depense_type_list').html(data.htmlConducteurPage.listTypeDepense)
                        }
                        if(data.listBordereau != ''){
                            $('#list_bordereau').html(data.listBordereau)
                        }
                        if(data.htmlConducteurPage.listCourse != ''){
                            //$('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                            $('#transport_list').html(data.htmlConducteurPage.listCourse)
                        }
                        if(data.htmlConducteurPage.lisDepenseCourse != ''){
                            //$('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                            $('#spend_list_transport').html(data.htmlConducteurPage.lisDepenseCourse)
                        }
                        if(data.selectedDataCourse != ''){
                            $('#depense_course_conducteur_id').html(data.selectedData.selectedDataCourse)
                            $('#course_transport_id').html(data.selectedData.selectedDataDetails)
                        }
                        if(data.factureData != ''){
                            $('#list_facture_page').html(data.factureData)
                        }

                        if(data.homePurchase.listReceptionPlace != ''){
                            $('#data_list_reception_place').html(data.homePurchase.listReceptionPlace)
                        }

                        if(data.homePurchase.receptionPrincipalList != ''){
                            $('#ListReceptionData').html(data.homePurchase.receptionPrincipalList)
                        }

                        if(data.homePurchase.ListReceptionDataAutrePlace != ''){
                            $('#ListReceptionDataAutrePlace').html(data.homePurchase.ListReceptionDataAutrePlace)
                        }
                    },
                });
            }else{
                modalID = (modal != '') ? modal: '';
                pageName = (page != '') ? page: '';

                $.ajax({
                    type:'POST',
                    url:'<?=("/contollers/MoreControllers/control.php?code=".sha1('loadDataList'))."&modal="?>'+modalID+'&page='+pageName+'',
                    dataType:'json',	
                    success: function(data){
                        if(data.htmlDettePage != ''){
                            //$('#list_dette_page').html(data.htmlDettePage)
                            $('#dette_list').html(data.htmlDettePage)
                        }
                        
                        if(data.htmlDepensePage != ''){
                            //$('#list_depense_page').html(data.htmlDepensePage)
                            $('#depense_list').html(data.htmlDepensePage)
                        }
                        if(data.htmlCaissePage.entre != ''){
                            //$('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                            $('#caisse_list_entre').html(data.htmlCaissePage.entre)
                        }
                        if(data.htmlCaissePage.sortie != ''){
                            //$('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                            $('#caisse_list_sortie').html(data.htmlCaissePage.sortie)
                        }
                        if(data.htmlCaissePage.dollars != ''){
                            $('#dollars').html(data.htmlCaissePage.dollars)
                        }
                        if(data.htmlCaissePage.fc != ''){
                            $('#fc').html(data.htmlCaissePage.fc)
                        }
                        if(data.htmlCaissePage.frw != ''){
                            $('#frw').html(data.htmlCaissePage.frw)
                        }
                        if(data.htmlCaissePage.listBanque != ''){
                            $('#banque_table').html(data.htmlCaissePage.listBanque)
                        }
                        if(data.htmlConducteurPage.listConducteur != ''){
                            $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        }
                        if(data.htmlConducteurPage.listVehicule != ''){
                            $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                        }
                        if(data.htmlConducteurPage.listTypeDepense != ''){
                            $('#depense_type_list').html(data.htmlConducteurPage.listTypeDepense)
                        }
                        if(data.listBordereau != ''){
                            $('#list_bordereau').html(data.listBordereau)
                        }
                        if(data.htmlConducteurPage.listCourse != ''){
                            //$('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                            $('#transport_list').html(data.htmlConducteurPage.listCourse)
                        }
                        if(data.htmlConducteurPage.lisDepenseCourse != ''){
                            //$('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                            $('#spend_list_transport').html(data.htmlConducteurPage.lisDepenseCourse)
                        }
                        if(data.selectedDataCourse != ''){
                            $('#depense_course_conducteur_id').html(data.selectedData.selectedDataCourse)
                            $('#course_transport_id').html(data.selectedData.selectedDataDetails)
                        }
                        if(data.factureData != ''){
                            $('#list_facture_page').html(data.factureData)
                        }

                        if(data.homePurchase.listReceptionPlace != ''){
                            $('#data_list_reception_place').html(data.homePurchase.listReceptionPlace)
                        }

                        if(data.homePurchase.receptionPrincipalList != ''){
                            $('#ListReceptionData').html(data.homePurchase.receptionPrincipalList)
                        }

                        if(data.homePurchase.ListReceptionDataAutrePlace != ''){
                            $('#ListReceptionDataAutrePlace').html(data.homePurchase.ListReceptionDataAutrePlace)
                        }
                    },
                });
            }
        }

        $('#add_depense').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            if(id != undefined){
                list('depense_course_form',id,'depense_modal');
            }else{
                list('depense_course_form','undefined','depense_modal');
            }
        });

        function operation(val,toDo,table = null){
            if (confirm('Voulez vous continuer cette operation?') == false) {
                return;
            }

            if (toDo =='update') {
                if(Number.isInteger(val) == true || typeof val === 'string') {
                    var form = {'id':val,'to':table};
                    $.ajax({
                        type:'POST',
                        url: '<?=("/contollers/MoreControllers/control.php?request=".sha1('update'))?>',
                        data:form,
                        dataType:'json',
                        beforeSend:function(){
                            $('button').prop('disabled',true);
                        },	
                        success: function(data){
                            alert(data.msg);
                                $('button').prop('disabled',false);
                                list('','','<?=$page?>');
                        }
                    });
                }else{
                    $.ajax({
                        type:'POST',
                        url: '<?=("/contollers/MoreControllers/control.php?request=".sha1('update'))?>',
                        data: val,
                        dataType:'json',
                        beforeSend:function(){
                            $('button').prop('disabled',true);
                        },	
                        success: function(data){
                            $('button').prop('disabled',false);
                            alert(data.msg);
                            list('','','<?=$page?>');
                        }
                    });
                }
            }else if(toDo == 'delete'){
                var form = 
                {
                    'id':val,
                    'to':table
                };
                $.ajax({
                    type:'POST',
                    url: '<?=("/contollers/MoreControllers/control.php?request=".sha1('delete'))?>',
                    data:form,
                    dataType:'json',
                    beforeSend:function(){
                        $('button').prop('disabled',true);
                    },	
                    success: function(data){
                        if(data.status == 'success'){
                            alert(data.msg)
                            list('','','<?=$page?>');
                        }else{
                            alert(data.msg)
                        }
                        $('button').prop('disabled',false);
                    }
                });
            }
        }

    function updateThis(id,table = null, toBeDone = ''){

        if (table == 'caisse' && toBeDone == 'formData' ) {
            
        }else if (table == 'vehicule' && toBeDone == 'formData') {
            
        }else if (table == 'typedepense' && toBeDone == 'formData') {
            
        }else if (table == 'coursetransport' && toBeDone == 'formData') {
            var form = {
                'courseTransportDate_': $('#courseTransportDate_'+id+'').val(),
                'courseTransportContenu_': $('#courseTransportContenu_'+id+'').val(),
                'courseTransportDestination_': $('#courseTransportDestination_'+id+'').val(),
                'courseTransportDescription_': $('#courseTransportDescription_'+id+'').val(),
                'courseTransportTonne_': $('#courseTransportTonne_'+id+'').val(),
                'prixCourse_': $('#prixCourse_'+id+'').val(),
                'id':id,
                'table':table
            };
            operation(form,'update',''+table+'');
        }else if(table != null && toBeDone == '') {
            operation(''+id+'','update',''+table+'');
        }
    }

    function deleteThis(id,table){
        operation(''+id+'','delete',''+table+'');
    }

    $('#add_vente').on('submit',function (event) {
        event.preventDefault();
        if($('#tb_idaffectation').val() == '' || $('#tb_use_date').val() == '' || $('#tb_use_identiteClient').val() == '' || $('#tb_use_ventePOS').val() == ''){
            alert("Vous devez d'abord selectionner la date, le numéro de vente et le nom du client.")
        }else{
            if($('#tb_idaffectation').val() == undefined || $('#tb_use_date').val() == undefined || $('#tb_use_typerepas').val() == undefined || $('#tb_use_identiteClient').val() == undefined || $('#tb_use_ventePOS').val() == undefined){
                alert("Vous devez d'abord selectionner la date, le numéro de vente et le nom du client.")
            }else{
                if(confirm('Voulez vous confirmer?') == false) {
                    return;
                }
                let form = new FormData(this);
                $.ajax({
                    type:'POST',
                    url:'<?=("../contollers/distribution/distributionController.php?backCall")?>',
                    data:form,
                    dataType:'json',
                    processData: false, 
                    contentType: false,
                    beforeSend:function(){
                        $('button').prop('disabled',true);
                    },	
                    success: function(data){
                        $('button').prop('disabled',false);
                        if(data.status == 'succes'){
                            alert(data.message);
                            location.href = '';
                            //$('#venteListData').load(location.href+" #venteListData");
                        }

                        $('#Notifier').fadeOut(5000);

                        $('#add_vente')[0].reset();
                    }
                });
            }
        }
    });

    $(document).ready(function () {
        $('#Notifier').fadeOut(5000);
        $('#champ_depot, #champ_retrait, #depotParDiv, #creditParDiv').hide();
        $('#caisse_list_entre, #caisse_list_sortie').DataTable();
        $('#driver_list').DataTable();
        $('#transport_list').DataTable();
        $('#depense_list').DataTable();
        $('#dette_list').DataTable();
        $('#list_update_command_admin').DataTable();
        $('#vehicule_list').DataTable();
        $('#spend_list_transport').DataTable();
        $('#depense_type_list').DataTable();
        $('#list_facture').DataTable();
        $('#list_fournisseur').DataTable();
        $('#list_fournisseur_update').DataTable();
        $('#list_fournisseur_update_activate').DataTable();
        $('#list_attribution_biens_encours_all').DataTable();
        $('#list_attribution_biens_all').DataTable();
        //$('#update_biens_all').DataTable();
        $('#list_biens_all').DataTable();

        $('#toggle_menu').on('click',function(){
            $('#menu2-a').slideToggle("slow");
            $("#menu-gauche").slideToggle("slow");
        });
        
        $('#toggle_menu_F').on('click',function(){
            $('#menu_F').slideToggle("slow");
        });

        $('#entete1-logo').on('click',function(){
            $('#menu2-a').slideToggle("slow");
            $("#menu-gauche").slideToggle("slow");
        });

        $('#operation').on('change',function(){
            let operation = $('#operation').val();
            if(operation == 'Debiter'){
                $('#champ_depot').show();
                $('#depotParDiv').show();
                $('#champ_retrait').hide();
                $('#creditParDiv').hide();
            }else if(operation == 'Crediter'){
                $('#champ_depot').hide();
                $('#champ_retrait').show();
                $('#creditParDiv').show();
                $('#depotParDiv').hide();
            }else{
                $('#champ_depot').hide();
                $('#champ_retrait').hide();
                $('#creditParDiv').hide();
                $('#depotParDiv').hide();
            }
        });

        $('#FilterForm').on('submit',function(event){
            list('FilterForm');
        });
        
        $('#FilterFormOther').on('submit',function(event){
            list('FilterFormOther');
        });

        // function to see the data in a table
        let currentPage = '<?=$page?>';
        
        if( currentPage != ''){
            list('','','<?=$page?>');
        }

        // add call function controller
        $('#new_depense,#operation_caisse,#add_dette_form,#add_driver_form,#add_vehicule_form,#bordereau_expedition_form,#type_depense_form,#add_course_form,#depense_course_form,#add_facture_form,#add_banque_form,#add_lieu_reception_form,#DataFormReception').on('submit',function(event){
            event.preventDefault();
            let form = new FormData(this);
            if(confirm('voulez vous continuer?') == false){
                return;
            }

            if(confirm('VERIFIER ENCORE SI VOUS AVEZ BIEN NOTE.') == false){
                return;
            }

            $.ajax({
                type:'POST',
                url:'<?=("/contollers/MoreControllers/control.php")?>',
                data:form,
                dataType:'json',
                processData: false, 
                contentType: false,
                beforeSend:function(){
                    $('button').prop('disabled',true);
                },	
                success: function(data){
                    $('button').prop('disabled',false);
                    if(data.status == 'success'){
                        list('','','<?=$page?>');
                        switch (data.page) {
                            case 'save_new_depense':
                                $('#new_depense')[0].reset();
                                break;
                            case 'depense_course_btn':
                                $('#depense_course_form')[0].reset();
                                break;
                            case 'bordereau_expedition_btn':
                                $('#bordereau_expedition_form')[0].reset();
                                break;
                            case 'type_depense_btn':
                                $('#type_depense_form')[0].reset();
                                break;
                            case 'add_course_btn':
                                $('#add_course_form')[0].reset();
                                break;
                            case 'add_vehicule_btn':
                                $('#add_vehicule_form')[0].reset();
                                break;
                            case 'add_new_driver':
                                $('#add_driver_form')[0].reset();
                                break;
                            case 'operation_new_dette_page':
                                $('#add_dette_form')[0].reset();
                                break;
                            case 'operation_caisse_new':
                                $('#operation_caisse')[0].reset();
                                $('#operation').val('');
                                $('#champ_depot').hide();
                                $('#champ_retrait').hide();
                                $('#creditParDiv').hide();
                                $('#depotParDiv').hide();
                                break;
                            case 'operation_new_facture':
                                $('#add_facture_form')[0].reset();
                                break;
                            case 'add_banque':
                                $('#add_banque_form')[0].reset();
                                break;
                            case 'add_lieu_reception':
                                $('#add_lieu_reception_form')[0].reset();
                                break;
                        
                            default:
                                break;
                        }
                        alert(data.msg);
                    }else{
                        alert(data.msg);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });

     $(function () {
        $('.select2').select2({
            placeholder:"Choisir une valeur",
            allowClear:true
        });
    });

    $("#numero_order_up").change(function () {
        $("#numero_order_down").val($("#numero_order_up").val());
    });
    
    $("#selectItem_SaleStock_up").change(function () {
        let stItem=$("#selectItem_SaleStock_up :selected").text()
        // alert(stItem)
        let itPuSale=stItem.split("/")
        let puSale=itPuSale[5].split(" ")
        $("#puSaleStock").val(puSale[4]);
        
    });

    $("#cb_livraison").change(function () {
        let stItem=$("#cb_livraison :selected").text()
        // alert(stItem)
        let itPuSale=stItem.split("/")
        let puSale=itPuSale[5].split(" ")
        $("#tb_price").val(puSale[4]);
    });
    
    $("#ajouterRav").toggle();
    
    
    let nAtt=$("#nAtt").val();
    
    for (let j=1;j<=nAtt;j++) {
        $("#ajouterRav".concat(j)).toggle();
    }
    
    for (let k=1;k<=nAtt;k++) {
        $("#ckbControl".concat(k)).change(function () {
            alert("Ravitaillement activé");
            $("#ajouterRav".concat(k)).show();
            $("#ckbControl".concat(k)).hide();
            $("#spSure".concat(k)).hide();
            
        });
        
        // if ($("#ckbControl".concat(k)).is(":checked")) {
        //     alert("Ravitaillement activé");
        //     $("#ajouterRav".concat(k)).show();
        // }
    }
</script>




