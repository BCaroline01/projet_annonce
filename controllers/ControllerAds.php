<?php
class ControllerAds
{
    // Fonction affichage des annonces
    public function allAds()
    {
        global $router;
        $manager = new AdsManager();
        $ads = $manager->getListAll();

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('Accueil.twig', ['ads' => $ads]);
    }

    // Fonction de trie par type
    public function typeSelect()
    {
        if (((isset($_POST['type']) || isset($_GET['type'])) === ('Jardinage' || 'Multimedia' || 'Mode' || 'Meubles' || 'Loisirs' || 'Véhicules' || 'Animaux' || 'Services' || 'Divers'))) {
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
            } else {
                $type = $_GET['type'];
            }
            $manager = new AdsManager();
            $ads = $manager->getTypeAll($type);
        } else{
            echo 'entrée incorrecte';
        }

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('ResultatCategorie.twig', ['ads' => $ads, 'type' => $type]);
    }

    //Fonction d'affichage unique d'annonce
    public function idSelect()
    {
        global $router;
        $manager = new AdsManager();
        $ads = $manager->getListOne($_GET['id']);

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('Annonce.twig', ['ads' => $ads]);
    }

    // Fonction affichage formulaire d'insertion
    public function viewInsertAds()
    {
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('Form.twig');
    }

    // Fonction d'insertion d'annonces
    public function insertAds()
    {
        global $router;
        $insert = new Ads(array('title' => $_POST['title'], 'content' => $_POST['content'], 'price' => $_POST['price'], 'type' => $_POST['type'], 'image' => $_FILES['image']));
        $manager = new AdsManager();
        $ads = $manager->addAds($insert);
    }

    // Fonction d'appel du formulaire Update
    public function viewUpdate()
    {
        $manager = new AdsManager();
        $up = $manager->getEdit($_GET['idUnique']);
        $up = $up['0'];
        
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('Update.twig', ['up' => $up]);
    }

    //Fonction d'update Ads
    public function update()
    {
        global $router;

        $up = new Ads(array('idAds' => $_POST['id'], 'title' => $_POST['title'], 'content' => $_POST['content'], 'price' => $_POST['price'], 'type' => $_POST['type'], 'image' => $_FILES['image']));
        $manager = new AdsManager();
        $ads = $manager->updateAds($up);
        
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('MessageUpdate.twig');
    }

    // Fonction de delete Ads
    public function delete()
    {
        global $router;

        $manager = new AdsManager();
        $ads = $manager->deleteAds($_GET['idUnique']);

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->render('viewDelete.twig');
    }

    // Fonction recup idUnique et envoie mail de comfirmation
    public function sendLinkValidate()
    {
        $manager = new AdsManager();
        $idUnique = $manager->IdUnique();
        $idUnique = $idUnique->getIdUnique();

        require_once 'vendor/autoload.php';
        $renderer = new \Qferrer\Mjml\Renderer\BinaryRenderer('./node_modules/.bin/mjml');
        $mjml = '<mjml>
<mj-head>
<mj-preview>Bienvenue sur TheGoodCorner !</mj-preview>
<mj-title>TheGoodCorner | Confirmation de votre e-mail</mj-title>
</mj-head>
<mj-body lang="fr">
    <mj-section background-url="" background-size="">
        <mj-column>
        <mj-image src="https://drive.google.com/uc?id=1M_NElIkUu30e0N0yCWNMTk30gQeQtt6j" alt="" width="150px" />
        <mj-text font-size="24px" font-family="Baskerville Old Face">Bienvenue sur TheGoodCorner !</mj-text>
        <mj-text font-size="17px" font-family="Baskerville Old Face">Vous n\'êtes plus qu\'à un clic de valider votre annonce !</mj-text>
        <mj-text font-size="17px" font-family="Baskerville Old Face">Tout ce que vous avez à faire est de vérifier votre adresse e-mail pour activer votre annonce.</mj-text>
        <mj-button href="http://localhost/annonces/updateStatus?idUnique=' . $idUnique . '" target="_blank" font-size="17px" background-color="#B7673C"> Confirmer mon E-mail </mj-button>
        <mj-text font-size="17px" font-family="Baskerville Old Face">Une fois votre annonce activée, vous reçevrez un e-mail avec des liens pour modifier ou supprimer votre annonce.</mj-text>
        <mj-text font-size="17px" font-family="Baskerville Old Face">Vous recevez cet e-mail car vous avez récemment créé une nouvelle annonce sur TheGoodCorner. Si ce n\'était pas vous, veuillez ignorer cet e-mail.</mj-text>
        <mj-text font-size="17px" font-family="Baskerville Old Face">@ 2021 Copyright | TheGoodCorner | Tout droits réservés.</mj-text>
        </mj-column>
    </mj-section>
</mj-body>
</mjml>';

        $message = $renderer->render($mjml);

        $to = $_POST['mail'];
        $subject = 'TheGoodCorner | Confirmation de votre e-mail';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            header('Location: ./');
            exit;
        } else {
            echo "Echec de l'envoi de l'email.";
        }
    }

    // Fonction de changement de status annonces et envoie mail de suppression et modification
    public function updateValidate()
    {
        $idUnique = $_GET['idUnique'];
        $manager = new AdsManager();
        $ads = $manager->updateStatus($idUnique);

        require_once 'vendor/autoload.php';
        $renderer = new \Qferrer\Mjml\Renderer\BinaryRenderer('./node_modules/.bin/mjml');
        $mjml = '<mjml>
<mj-head>
    <mj-preview>Bienvenue sur TheGoodCorner !</mj-preview>
    <mj-title>TheGoodCorner | Modifier ou supprimer votre annonce</mj-title>
</mj-head>
    <mj-body lang="fr">
        <mj-section background-url="" background-size="">
            <mj-column>
            <mj-image src="https://drive.google.com/uc?id=1M_NElIkUu30e0N0yCWNMTk30gQeQtt6j" alt="" width="150px" />
            <mj-text font-size="24px" font-family="Baskerville Old Face">Votre annonce est en ligne sur TheGoodCorner !</mj-text>
            <mj-text font-size="17px" font-family="Baskerville Old Face">Vous pouvez librement modifier ou supprimer votre annonce en cliquant sur l\'un des liens ci-dessous :</mj-text>
            <mj-text font-size="17px" font-family="Baskerville Old Face" align="center">Pour modifier votre annonce :</mj-text>
            <mj-button href="http://localhost/annonces/viewUpdate?idUnique=' . $idUnique . '" target="_blank" font-size="17px" background-color="#B7673C"> Modifier mon annonce </mj-button>
            <mj-text font-size="17px" font-family="Baskerville Old Face" align="center">Pour supprimer votre annonce :</mj-text>
            <mj-button href="http://localhost/annonces/delete?idUnique=' . $idUnique . '" target="_blank" font-size="17px" background-color="#B7673C"> Supprimer mon annonce </mj-button>
            <mj-text font-size="17px" font-family="Baskerville Old Face" align="center">Merci d\'être passé sur TheGoodCorner !</mj-text>
            <mj-text font-size="17px" font-family="Baskerville Old Face">Vous recevez cet e-mail car vous avez récemment créé une nouvelle annonce sur TheGoodCorner. Si ce n\'était pas vous, veuillez ignorer cet e-mail.</mj-text>
            <mj-text font-size="17px" font-family="Baskerville Old Face">@ 2021 Copyright | TheGoodCorner | Tout droits réservés.</mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>';

        $message = $renderer->render($mjml);

        $to = $ads;
        $subject = 'TheGoodCorner | Modifier ou supprimer votre annonce';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            header('Location: ./');
            exit;
        } else {
            echo "Echec de l'envoi de l'email.";
        }
    }

    public function idpdf($one)
    {
        global $router;
        $manager = new AdsManager();
        $pdf = $manager->getListOne($one['id']);

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        foreach($pdf as $valuepdf){
            $titre = $valuepdf->getTitle();
            $type = $valuepdf->getType();
            $date = $valuepdf->getDate();
            $price = $valuepdf->getPrice();
            $content = $valuepdf->getContent();
            $image = $valuepdf->getImage();
        }

        $html ="
            <!DOCTYPE html>
            <html lang='fr'>
            <style media='print'>
                section.annonce {
                    padding: 10px;
                    text-align: center;
                    font-family: 'Baskerville Old Face';
                    color: #1d2625;
                }
                
                section.annonce  div.container  ul {
                    list-style-type: none;
                }

                section.annonce  div.container  ul  li{
                    margin-top: 10px;
                }

                section.annonce h2{
                    margin-top: 20px;
                    text-align: center;
                }
            
                div.footer {
                    margin-top: 100px;
                    text-align: center;
                }
            </style>
            <body>
                <section class='annonce'>
                    <h1>$titre</h1>
                    <div class='container'>
                        <div class='img-container'><img src='$image'/></div>
                        <div class='preview'>
                            <ul>
                                <li>Date de création : <span>$date</span> </li>
                                <li>Catégorie : <span>$type</span> </li>
                                <li>Prix : <span>$price €</span></li>
                            </ul>
                        </div>
                        <h2>Description</h2>
                        <p>$content</p>
                    </div>
                </section>
                <div class='footer'>
                <img class='logo' width='100px' src='./ressources/logo.png'/>
                <p>&copy; Copyright 2020 : The Good Corner</p>
                </div>
            </body>";

        $mpdf->SetHeader('|TheGoodCorner - Site d\'annonces gratuite|');
        $mpdf->WriteHTML($html);

        $mpdf->Output('TheGoodCorner - '. $titre. ' .pdf','D');
            }
}
