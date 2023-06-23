<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- <script type="text/javascript" src="../web/jquery/jquery-min.js"></script> -->
<script type="text/javascript" src="/web/jquery/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../web/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../web/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="/web/bootstrap/js/bootstrap5.min.js"></script>
<script type="text/javascript" src="/web/datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#champ_depot, #champ_retrait, #depotParDiv, #creditParDiv').hide();
        $('#caisse_list_entre, #caisse_list_sortie, #driver_list, #transport_list').DataTable();
        $('#depense_list, #dette_list, #list_update_command_admin,#vehicule_list').DataTable();

        $('#toggle_menu').on('click',function(){
            $('#menu2-a').toggle();
        });
        $('#entete1-logo').mouseover(function(){
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
            }else{
                $('#champ_depot').hide();
                $('#champ_retrait').show();
                $('#creditParDiv').show();
                $('#depotParDiv').hide();
            }
        });

        $('#menu2-a').show();

        function list(val = '') {
            if(val != ''){
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
                        $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                    },
                });
            }else{
                $.ajax({
                    type:'POST',
                    url:'<?=("/contollers/MoreControllers/control.php?code=".sha1('loadDataList'))?>',
                    dataType:'json',	
                    success: function(data){
                        $('#list_dette_page').html(data.htmlDettePage)
                        $('#list_depense_page').html(data.htmlDepensePage)
                        $('#list_caisse_page').html(data.htmlCaissePage)
                        $('#list_caisse_entre_page').html(data.htmlCaissePage.entre)
                        $('#list_caisse_sortie_page').html(data.htmlCaissePage.sortie)
                        $('#driver_list_data').html(data.htmlConducteurPage.listConducteur)
                        $('#vehicule_list_data').html(data.htmlConducteurPage.listVehicule)
                        $('#type_depense_list').html(data.htmlConducteurPage.listTypeDepense)
                        $('#list_bordereau').html(data.htmlConducteurPage.listBordereau)
                    },
                });
            }
        }

        $('#FilterDepenseForm').on('submit',function(event){
            list('FilterDepenseForm');
        });

        // function to see the data in a table
        list();

        // add call function controller
        $('#new_depense,#operation_caisse,#add_dette_form,#add_driver_form,#add_vehicule_form,#bordereau_expedition_form,#type_depense_form').on('submit',function(event){
            event.preventDefault();
            let form = new FormData(this);
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
                        $('#new_depense,#operation_caisse,#add_dette_form,#add_driver_form,#add_vehicule_form,#bordereau_expedition_form,#type_depense_form')[0].reset();
                        alert(data.msg);
                        list();
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




