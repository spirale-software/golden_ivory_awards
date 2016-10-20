<?php namespace G_I_A\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__.'/../form/type/categorieType.php';

class HomeController {
    
    public function index_action(Application $app) {
        
        return $app['twig']->render('index.html.twig');
    }
     
}

