<?php
class ControllerUsers
{
    // Fonction d'insert User
    public function insertUser()
    {
        global $router;
        $insert = new Users(array('mail' => $_POST['mail']));
        $manager = new UsersManager();
        $ads = $manager->addUsers($insert);
    }
}