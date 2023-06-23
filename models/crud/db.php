<?php

class DB{
    public function __construct()
    {
        
    }
    //private $db = connexion::connecter();

    public function insert(string $table, $field, $prepared, $value){
        $db = connexion::connecter();
        try {
            $query = $db->prepare("INSERT INTO $table $field VALUES($prepared)");
            $query->execute($value);
            $query->closeCursor();
            return TRUE;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function get($table,$order = ''){
        $db = connexion::connecter();
        if($order != ''){
            $reponse = $db->query('SELECT * FROM '.$table.' ORDER BY '.$order.' DESC');
        }else{ 
            $reponse = $db->query('SELECT * FROM '.$table.'');
        }
        
        return $reponse->fetchAll();
        $reponse->closeCursor();
    }

    public function getWhere($table,$field,$value,$order = ''){

        $db = connexion::connecter();
        if ($order != '') {
            $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$value.'" ORDER BY '.$order.' DESC');
        }else{
            $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$value.'"');
        }
        
        return $reponse->fetchAll();
        $reponse->closeCursor();

    }

    public function update(){

    }

    public function delete(){

    }
}