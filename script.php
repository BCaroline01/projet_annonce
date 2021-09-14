<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=thegoodcorner;charset=utf8', 'root');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

if($req = $db->query("DELETE FROM `ads` WHERE DATEDIFF(NOW(), `date`) > 2 AND `status` = 0")){
    echo 'ok';
}else{
    echo 'pas ok';
}