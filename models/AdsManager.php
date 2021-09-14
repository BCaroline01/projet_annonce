<?php
class AdsManager extends Model
{
    // Fonction affichage des annonces        
    public function getListAll()
    {
        // Pagination
        $db = $this->getDb();
        $res = $db->query('SELECT COUNT(idAds) AS nb FROM `ads` WHERE `status` = 1');
        $data = $res->fetch();
        $nb = $data['nb'];
        $nbActu = $nb;
        $pPage = 10;
        $nbPage = ceil($nbActu / $pPage);
        if (isset($_GET["p"]) && $_GET["p"] > 0 && $_GET["p"] <= $nbPage) {
            $cPage = $_GET["p"];
        } else {
            $cPage = 1;
        }
        $depart = ($cPage - 1) * $pPage;
        $ads = [];
        $req = $db->query('SELECT * FROM `ads` WHERE `status` = 1 ORDER BY date DESC LIMIT ' . $depart . ',' . $pPage . '');

        while ($ad = $req->fetch(PDO::FETCH_ASSOC)) {
            $ads[] = new Ads($ad);
        }

        $req->closeCursor();
        return array($ads, $nbPage);
    }

    // Fonction de trie par type
    public function getTypeAll($type)
    {
        // Pagination
        $db = $this->getDb();
        $res = $db->query('SELECT COUNT(idAds) AS nb FROM `ads` WHERE (`type` = "' . $type . '") AND (`status` = 1)');
        $data = $res->fetch();
        $nb = $data['nb'];
        $nbActu = $nb;
        $pPage = 10;
        $nbPage = ceil($nbActu / $pPage);
        if (isset($_GET["p"]) && $_GET["p"] > 0 && $_GET["p"] <= $nbPage) {
            $cPage = $_GET["p"];
        } else {
            $cPage = 1;
        }
        $depart = ($cPage - 1) * $pPage;
        $ads = [];
        $req = $db->prepare('SELECT * FROM `ads` WHERE (`type` = :type) AND (`status` = 1) ORDER BY date DESC LIMIT ' . $depart . ',' . $pPage . '');
        $req->bindValue(':type', $type);
        $req->execute();

        while ($ad = $req->fetch(PDO::FETCH_ASSOC)) {
            $ads[] = new Ads($ad);
        }

        $req->closeCursor();
        return array($ads, $nbPage);
    }

    //Fonction d'affichage unique d'annonce
    public function getListOne($one)
    {
        $db = $this->getDb();
        $ads = [];
        $req = $db->prepare('SELECT * FROM `ads` WHERE `idAds` = :idAds');
        $req->bindValue(':idAds', $one);
        $req->execute();

        while ($ad = $req->fetch(PDO::FETCH_ASSOC)) {
            $ads[] = new Ads($ad);
        }

        $req->closeCursor();
        return $ads;
    }

    //Fonction de renvoie modification
    public function getEdit($one)
    {
        $db = $this->getDb();
        $ads = [];
        $req = $db->prepare('SELECT * FROM `ads` INNER JOIN `users` ON ads.idUsers = users.idUsers WHERE `idUnique` = :idUnique');
        $req->bindValue(':idUnique', $one);
        $req->execute();

        while ($ad = $req->fetch(PDO::FETCH_ASSOC)) {
            $ads[] = new Ads($ad);
            $mail[] = new Users($ad);
        }

        $req->closeCursor();
        return $mail;
    }

    // Fonction d'insertion d'annonces
    public function addAds($insert)
    {
        // Insert image
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $dossier = './medias\\';
            $allowed = array('JPG', 'JPEG', 'PNG', 'GIF', 'JFIF');
            $filename = basename($_FILES['image']['name']);
            $filesize = $_FILES['image']['size'];
            $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
            $file_tmp = $_FILES['image']['tmp_name'];
            $rename = $filename . uniqid(date("Ymd")) . '.' . $ext;
            $file = $dossier . $filename;
            $file_rename = $dossier . $rename;

            // check size 
            if ($filesize > 2000000) {
                echo "Erreur: La taille du fichier est supérieure à la limite autorisée.";
            } else {
                // check the extension
                if (!in_array($ext, $allowed)) {
                    echo "Erreur : Veuillez sélectionner un format de fichier valide.";
                } else {
                    // check if the file already exist
                    if (file_exists("./medias/" . $_FILES["image"]["name"])) {
                        move_uploaded_file($file_tmp, $file_rename);
                        $return_name = $file_rename;
                    } else {
                        move_uploaded_file($file_tmp, $file);
                        $return_name = $dossier . $filename;
                    }
                }
            }
        } else {
            $return_name = './ressources/camera.png';
        }

        $db = $this->getDb();
        $lastid = $db->lastInsertId();
        date_default_timezone_set('Europe/Paris');
        $date = date("Ymd");
        $uniq = uniqid(date("Ymd"));

        $req = $db->prepare('INSERT INTO `ads`(`title`, `content`, `date`, `price`, `type`, `image`, `idUnique`, `idUsers`) VALUES (:title, :content, :date, :price, :type, :image, :idUnique, :idUsers)');
        $req->bindValue(':title', $insert->getTitle());
        $req->bindValue(':content', $insert->getContent());
        $req->bindValue(':date', $date);
        $req->bindValue(':price', $insert->getPrice());
        $req->bindValue(':type', $insert->getType());
        $req->bindValue(':image', $return_name);
        $req->bindValue(':idUnique', $uniq);
        $req->bindValue(':idUsers', $lastid);
        $req->execute();

        $req->closeCursor();
    }

    //Fonction Update Ads
    public function updateAds($up)
    {

        // Insert image
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $dossier = './medias\\';
            $allowed = array('JPG', 'JPEG', 'PNG', 'GIF', 'JFIF');
            $filename = basename($_FILES['image']['name']);
            $filesize = $_FILES['image']['size'];
            $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
            $file_tmp = $_FILES['image']['tmp_name'];
            $rename = $filename . uniqid(date("Ymd")) . '.' . $ext;
            $file = $dossier . $filename;
            $file_rename = $dossier . $rename;

            // check size 
            if ($filesize > 2000000) {
                echo "Erreur: La taille du fichier est supérieure à la limite autorisée.";
            } else {
                // check the extension
                if (!in_array($ext, $allowed)) {
                    echo "Erreur : Veuillez sélectionner un format de fichier valide.";
                } else {
                    // check if the file already exist
                    if (file_exists("./medias/" . $_FILES["image"]["name"])) {
                        move_uploaded_file($file_tmp, $file_rename);
                        $return_name = $file_rename;
                    } else {
                        move_uploaded_file($file_tmp, $file);
                        $return_name = $dossier . $filename;
                    }
                }
            }
        } else {
            $return_name = './ressources/camera.png';
        }
        $db = $this->getDb();
        $req = $db->prepare('UPDATE `ads` SET `title` = :title, `content`= :content, `price`= :price, `type`= :type, `image`= :image WHERE `idAds` = :idAds');
        $req->bindValue(':idAds', $up->getIdAds(), PDO::PARAM_INT);
        $req->bindValue(':title', $up->getTitle());
        $req->bindValue(':content', $up->getContent());
        $req->bindValue(':price', $up->getPrice());
        $req->bindValue(':type', $up->getType());
        $req->bindValue(':image', $return_name);
        $req->execute();

        $req->closeCursor();
    }

    // Fonction delete Ads
    public function deleteAds($id)
    {
        $db = $this->getDb();
        $req = $db->prepare('DELETE `ads`, `users` FROM `ads` INNER JOIN `users` ON ads.idUsers = users.idUsers WHERE `idUnique` = :idUnique');
        $req->bindValue(':idUnique', $id);
        $req->execute();
    }

    // Fonction recup idUnique
    public function IdUnique()
    {
        $db = $this->getDb();
        $id = [];
        $req = $db->prepare('SELECT `idUnique` FROM `ads` WHERE `idAds` = :idAds');
        $req->bindValue(':idAds', $db->lastInsertId());
        $req->execute();
        while ($idUnique = $req->fetch(PDO::FETCH_ASSOC)) {
            $id[] = new Ads($idUnique);
        }
        $req->closeCursor();
        return $id['0'];
    }

    // Fonction update status
    public function updateStatus($idUnique)
    {
        $db = $this->getDb();
        $req = $db->prepare('UPDATE `ads` SET `status` = 1 WHERE `idUnique` = :idUnique');
        $req->bindValue(':idUnique', $idUnique);
        $req->execute();

        $idUsers = [];
        $requp = $db->prepare('SELECT `idUsers` FROM `ads` WHERE `idUnique` = :idUnique');
        $requp->bindValue(':idUnique', $idUnique);
        $requp->execute();
        while ($idUnique = $requp->fetch(PDO::FETCH_ASSOC)) {
            $idUsers = new Ads($idUnique);
        }
        $idUsers = $idUsers->getIdUsers();


        $mailUsers = [];
        $reqmail = $db->prepare('SELECT `mail` FROM `users` WHERE `idUsers` = :idUsers');
        $reqmail->bindValue(':idUsers', $idUsers);
        $reqmail->execute();
        while ($idUsers = $reqmail->fetch(PDO::FETCH_ASSOC)) {
            $mailUsers = new Users($idUsers);
        }
        $mailUsers = $mailUsers->getMail();
        return $mailUsers;
    }
}
