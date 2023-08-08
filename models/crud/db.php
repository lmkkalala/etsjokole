<?php

class DB{
    public function __construct() {
        ini_set('memory_limit', '2056M');
        set_time_limit(0);  
    }

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

    public function getWhere($table,$field,$value,$order = '', $limit = null){
        $db = connexion::connecter();
        if ($order != '') {
            if ($limit != null) {
                $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$value.'" ORDER BY '.$order.' DESC LIMIT '.$limit.'');
            }else{
                $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$value.'" ORDER BY '.$order.' DESC');
            }
        }else{
            $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$value.'"');
        }
        return $reponse->fetchAll();
        $reponse->closeCursor();

    }

    public function getWhereMultiple($table, $MoreCondition = '',$more = ''){
        if ($more == '') {
            $more == 'ORDER BY date DESC';
        }else{
            $more == $more;
        }
        $db = connexion::connecter();
        $reponse = $db->query('SELECT * FROM '.$table.' WHERE '.$MoreCondition.''.$more.'');
        return $reponse->fetchAll();
        $reponse->closeCursor();

    }

    public function update($table,$field,$condition,$data){
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("UPDATE $table SET $field WHERE $condition");
            $query->execute($data);
            $query->closeCursor();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function delete($table,$field,$value){
        try {
            $bd = Connexion::connecter();
            $query = $bd->prepare("DELETE FROM $table WHERE $field =? ");
            $query->execute([$value]);
            $query->closeCursor();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}