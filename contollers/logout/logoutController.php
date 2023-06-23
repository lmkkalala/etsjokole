<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
?>

<?php

if (isset($_POST['bt_deconnexion'])) {
    $_SESSION=[];
    session_destroy();
    $reponse="logout";
        header('Location:../../index.php?reponse=' . sha1($reponse));
        die;
}


?>