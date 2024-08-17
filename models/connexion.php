<?php
error_reporting(E_ALL & ~E_NOTICE);


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Connexion {

    public static function connecter() {
        // DB remote host: 185.98.131.158
        // DB password remote: zC7!NBzCHYHN4Ne
        // DB user remote: etsjo1985259_1demjf
        try {
            $bd = new PDO('mysql:host=localhost;dbname=etsjo1985259_1demjf', 'root', '');
            $bd->exec("set names utf8");
            return $bd;
            
        } catch (PDOException $e) {
            echo "
            <div class='container'>
                <div class='row'>
                    <div class='col-12'>
                        <h1>Ets JOKOLE DIEU EST GRAND</h1>
                        <h2>Nous avons rencontrés un problème lié à la base de données.</h2>
                        <h3>
                            Système en maintenance. Veuillez reessayer après quelques minutes
                            <br>
                            <h4>Merci.</h4> 
                        </h3>
                    </div>
                </div>
            </div>
            ";
            die;
        }
        
    }

}

function dateFrench($myDate)
{
    $items_date = explode('-', $myDate);
    return $items_date[2] . "/" . $items_date[1] . "/" . $items_date[0];
}

function dateFrenchWithTime($myDateTime)
{
    $items_global=explode(' ', $myDateTime);
    $items_date = explode('-', $items_global[0]);
    return $items_date[2] . "/" . $items_date[1] . "/" . $items_date[0]." ".$items_global[1];
}

?>
