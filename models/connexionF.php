<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConnexionF {

    public static function connecter() {
        $bd = new PDO('mysql:host=localhost;dbname=sgs_finance', 'root', '');
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bd->exec("set names utf8");
        return $bd;
    }

}

?>
