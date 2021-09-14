<?php
abstract class Model {
    private static $_db;

    // Connexion à la base de donnée
    private static function setDb(){
        try {
            self::$_db = new PDO('mysql:host=localhost;dbname=thegoodcorner;charset=utf8', 'root');
            self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    protected function getDb(){
        if(self::$_db == null){
            self::setDb();
        }

        return self::$_db;
    }
}