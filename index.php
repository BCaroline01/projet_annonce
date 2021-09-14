<?php
require_once __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
require_once __DIR__ . '/vendor/autoload.php';

$router = new AltoRouter();
$router->setBasePath('/annonces');

// Liste des annonces validées paginées
$router->map('GET', '/', 'ControllerAds#allAds');

// Liste des annonces par catégorie
$router->map('POST', '/search', 'ControllerAds#typeSelect');

// Liste des annonces par catégorie
$router->map('GET', '/search', 'ControllerAds#typeSelect');

// Suppression
$router->map('GET', '/delete', 'ControllerAds#delete', 'delete');

// Appel votre annonces a été supprimé
$router->map('GET', '/deleteOK', 'ControllerAds#delete', 'deleteOK');

// Appel vue formulaire
$router->map('GET', '/insertview', 'ControllerAds#viewInsertAds');

// Vue d'une seule annonces
$router->map('GET', '/ads', 'ControllerAds#idSelect', 'article');

// Appel formulaire de modification
$router->map('GET', '/viewUpdate', 'ControllerAds#viewUpdate', 'viewUpdate');

// Modification
$router->map('POST', '/updateFunction', 'ControllerAds#update', 'update');

// Envoie mail de validation et Insertion d'annonces
$router->map('POST', '/sendValidate', 'ControllerUsers#insertUser#ControllerAds#insertAds#ControllerAds#sendLinkValidate', 'send');

// Update du status annonces
$router->map('GET', '/updateStatus', 'ControllerAds#UpdateValidate', 'updateSatus');

// Fonction telechargé un pdf
$router->map('GET', '/pdf[i:id]', 'ControllerAds#idpdf');

$match = $router->match();

if ($match) {
    $count = count(explode('#', $match['target']));

    if ($count == 6) {
        list($controller, $action, $controller2, $action2, $controller3, $action3) = explode('#', $match['target']);
        $obj = new $controller();
        $obj2 = new $controller2();
        $obj3 = new $controller3();
        callControl($obj, $action, $match);
        callControl($obj2, $action2, $match);
        callControl($obj3, $action3, $match);
    } elseif ($count == 4) {
        list($controller, $action, $controller2, $action2) = explode('#', $match['target']);
        $obj = new $controller();
        $obj2 = new $controller2();
        callControl($obj, $action, $match);
        callControl($obj2, $action2, $match);
    } else {
        list($controller, $action) = explode('#', $match['target']);
        $obj = new $controller();
        callControl($obj, $action, $match);
    }
}

function callControl($obj, $action, $match)
{
    if (is_callable(array($obj, $action))) {
        call_user_func_array(array($obj, $action), array($match['params']));
    }
}
