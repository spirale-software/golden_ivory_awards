<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

include_once __DIR__.'/../src/dao/CategorieDAO.php';
include_once __DIR__.'/../src/dao/NomineDAO.php';
include_once __DIR__.'/../src/dao/UtilisateurDAO.php';

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/', 
            'anonymous' => true, 
            'logout' => true,
            'form' => array(
                'login_path' => '/login', 
                'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new G_I_A\DAO\UtilisateurDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array('ROLE_ADMIN' => array('ROLE_USER')),
    'security.access_rule' => array(array('^/admin', 'ROLE_ADMIN'))
));


// Register services
$app['dao.categorie'] = $app->share(function ($app) {
return new G_I_A\DAO\CategorieDAO($app['db']);
});
$app['dao.nomine'] = $app->share(function ($app) {
return new G_I_A\DAO\NomineDAO($app['db']);
});  
$app['dao.utilisateur'] = $app->share(function ($app) {
return new G_I_A\DAO\UtilisateurDAO($app['db']);
});  

//Globals variables
global $categorieDAO;
$categorieDAO = new G_I_A\DAO\CategorieDAO($app['db']);

