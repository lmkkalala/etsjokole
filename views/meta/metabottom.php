<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="/web/bootstrap/js/bootstrap5.min.js"></script>
<!-- <script type="text/javascript" src="web/bootstrap/js/bootstrap.min.js"></script> -->
<!-- <script type="text/javascript" src="/web/datatable/jquery.dataTables.min.js"></script> -->
<!-- <script type="text/javascript" src="/web/select2/dist/js/select2.min.js"></script> -->
<!-- <script type="text/javascript" src="/web/jquery/jquery-min.js"></script> -->
<script type="text/javascript" src="/web/jquery/jquery-3.5.1.js"></script>


<script>
    $(document).ready(function(){
        $('#toggle_menu').on('click',function(){
            $('#menu2-a').slideToggle("slow");
            $("#menu-gauche").slideToggle("slow");
        });

        $('#entete1-logo').on('click',function(){
            $('#menu2-a').slideToggle("slow");
            $("#menu-gauche").slideToggle("slow");
        });
    });
</script>
