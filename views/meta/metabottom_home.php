<!-- <script type="text/javascript" src="../web/jquery/jquery-min.js"></script> -->
<script type="text/javascript" src="/web/jquery/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../web/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../web/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="/web/bootstrap/js/bootstrap5.min.js"></script>
<script type="text/javascript" src="/web/datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript">
        function list(val = '', modal = '') {
            if(val != '' && modal == ''){
                event.preventDefault();
                let form = new FormData($('#'+val+'')[0]);
                $.ajax({
                    type:'POST',
                    url:'<?=("/contollers/MoreControllers/control.php?code=".sha1('loadDataList'))?>',
                    data:form,
                    dataType:'json',
                    processData: false, 
                    contentType: false,
                    beforeSend:function(){
                        $('button').prop('disabled',true);
                    },	
                    success: function(data){
                        $('button').prop('disabled',false);
                        
                        $('#list_dette_page').html(data.htmlDettePage)
                        $('#list_depense_page').html(data.htmlDepensePage)
                        $('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                        $('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                        $('#dollars').html(data.htmlCaissePage.dollars)
                        $('#fc').html(data.htmlCaissePage.fc)
                        $('#frw').html(data.htmlCaissePage.frw)
                        $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                        $('#type_depense_list').html(data.htmlConducteurPage.listTypeDepense)
                        $('#list_bordereau').html(data.htmlConducteurPage.listBordereau)
                        $('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                        $('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                        if(data.selectedDataCourse != ''){
                            $('#depense_course_conducteur_id').html(data.selectedData.selectedDataCourse)
                            $('#course_transport_id').html(data.selectedData.selectedDataDetails)
                        }
                        $('#list_facture_page').html(data.factureData)
                    },
                });
            }else{
                if(modal != ''){
                    modalID = modal;
                }else{
                    modalID = '';
                }
                $.ajax({
                    type:'POST',
                    url:'<?=("/contollers/MoreControllers/control.php?code=".sha1('loadDataList'))."&modal="?>'+modalID+'',
                    dataType:'json',	
                    success: function(data){
                        $('#list_dette_page').html(data.htmlDettePage)
                        $('#list_depense_page').html(data.htmlDepensePage)
                        $('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                        $('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                        $('#dollars').html(data.htmlCaissePage.dollars)
                        $('#fc').html(data.htmlCaissePage.fc)
                        $('#frw').html(data.htmlCaissePage.frw)
                        $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                        $('#type_depense_list').html(data.htmlConducteurPage.listTypeDepense)
                        $('#list_bordereau').html(data.htmlConducteurPage.listBordereau)
                        $('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                        $('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                        if(data.selectedDataCourse != ''){
                            $('#depense_course_conducteur_id').html(data.selectedData.selectedDataCourse)
                            $('#course_transport_id').html(data.selectedData.selectedDataDetails)
                        }
                        $('#list_facture_page').html(data.factureData)
                    },
                });
            }
        }

        $('#add_depense').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            if(id != undefined){
                list('depense_course_form',id);
            }else{
                list('depense_course_form','undefined');
            }
        });

        function operation(val,toDo,table = null){
                if (confirm('Voulez vous continuer cette operation?') == false) {
                    return;
                }

                if (toDo =='update') {
                    if(table == null) {
                        var form = new FormData($('#'+val+'')[0]);
                        $.ajax({
                        type:'POST',
                        url: '<?=("/contollers/MoreControllers/control.php?request=".sha1('update'))?>',
                        data:form,
                        dataType:'json',
                        processData: false, 
                        contentType: false,
                        beforeSend:function(){
                            $('button').prop('disabled',true);
                        },	
                        success: function(data){
                                 $('button').prop('disabled',false);
                                 list();
                                // $('#list_dette_page').html(data.htmlDettePage)
                                // $('#list_depense_page').html(data.htmlDepensePage)
                                // $('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                                // $('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                                // $('#dollars').html(data.htmlCaissePage.dollars)
                                // $('#fc').html(data.htmlCaissePage.fc)
                                // $('#frw').html(data.htmlCaissePage.frw)
                                // $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                                // $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                                // $('#type_depense_list').html(data.htmlConducteurPage.listTypeDepense)
                                // $('#list_bordereau').html(data.htmlConducteurPage.listBordereau)
                                // $('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                                // $('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                                // $('#list_facture_page').html(data.factureData)
                            }
                        })
                    }else{
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
                                $('button').prop('disabled',false);
                                list();
                                // $('#list_dette_page').html(data.htmlDettePage)
                                // $('#list_depense_page').html(data.htmlDepensePage)
                                // $('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                                // $('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                                // $('#dollars').html(data.htmlCaissePage.dollars)
                                // $('#fc').html(data.htmlCaissePage.fc)
                                // $('#frw').html(data.htmlCaissePage.frw)
                                // $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                                // $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                                // $('#type_depense_list').html(data.htmlConducteurPage.listTypeDepense)
                                // $('#list_bordereau').html(data.htmlConducteurPage.listBordereau)
                                // $('#list_transport_page').html(data.htmlConducteurPage.listCourse)
                                // $('#list_depense_course').html(data.htmlConducteurPage.lisDepenseCourse)
                                // $('#list_facture_page').html(data.factureData)
                            }
                        })
                    }
                }else if(toDo == 'delete'){
                    var form = {'id':val,'to':table};
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
                            list();
                        }else{
                            alert(data.msg)
                        }
                        $('button').prop('disabled',false);
                    }
                })
            }
        }

    function updateThis(id,table = null){
        if (table != null) {
            operation(''+id+'','update',''+table+'');
        }else{
            operation('bordereau_form_update_'+id+'','update');
        }
        
        //console.log($('#bordereau_update_date'+id+'').val())
    }

    function deleteThis(id,table){
        operation(''+id+'','delete',''+table+'');
    }

    $(document).ready(function () {
        $('#champ_depot, #champ_retrait, #depotParDiv, #creditParDiv').hide();
        $('#caisse_list_entre').DataTable();
        $('#caisse_list_sortie').DataTable();
        $('#driver_list').DataTable();
        $('#transport_list').DataTable();
        $('#depense_list').DataTable();
        $('#dette_list').DataTable();
        $('#list_update_command_admin').DataTable();
        $('#vehicule_list').DataTable();
        $('#spend_list_transport').DataTable();
        //$('#depense_list, #dette_list, #list_update_command_admin,#vehicule_list,#spend_list_transport').DataTable();
        

        $('#toggle_menu').on('click',function(){
            $('#menu2-a').toggle();
        });
        $('#entete1-logo').on('click',function(){
            $('#menu2-a').toggle();
        });
        $('#entete1-logo').on('click',function(){
            $('#menu2-a').hide();
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

        $('#menu2-a').show();

        $('#FilterForm').on('submit',function(event){
            list('FilterForm');
        });
        
        $('#FilterFormOther').on('submit',function(event){
            list('FilterFormOther');
        });

        // function to see the data in a table
        list();

        // add call function controller
        $('#new_depense,#operation_caisse,#add_dette_form,#add_driver_form,#add_vehicule_form,#bordereau_expedition_form,#type_depense_form,#add_course_form,#depense_course_form,#add_facture_form').on('submit',function(event){
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
                        list();
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
                                break;
                            case 'operation_new_facture':
                                $('#add_facture_form')[0].reset();
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
</script>

<script type="text/javascript">
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




