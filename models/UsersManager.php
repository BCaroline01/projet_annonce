<?php
class UsersManager extends Model
{

    // Fonction ajout d'utilisateur
    public function addUsers($insert)
    {
            $db = $this->getDb();
            $req = $db->prepare('INSERT INTO `ads`(`idUsers`) SELECT `idUsers` FROM `users` WHERE `idUsers` = :idUsers');
            $req->bindValue(':idUsers', $insert->getidUsers());
            $req->execute();
            
            $reqins = $db->prepare('INSERT INTO `users`(`mail`) VALUES (:mail)');
            $reqins->bindValue(':mail', $insert->getMail());
            $reqins->execute();
    }
}
