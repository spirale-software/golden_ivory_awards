<?php

include_once __DIR__.'/../src/controller/AdminController.php';
include_once __DIR__.'/../src/controller/HomeController.php';


/***************************** public Routes **********************************/
 
/* index */
$app->get('/', 
        'G_I_A\Controller\HomeController::index_action')
        ->bind('home');

/* Listed all Nomine */
$app->match('/all', 
        'G_I_A\Controller\HomeController::all_nomines_action')
        ->bind('public_nomine_all');

/* Listed all Honnors */
$app->match('/honneur', 
        'G_I_A\Controller\HomeController::honneur_action')
        ->bind('honneur');

/* Listed all Nomines according to the honnor */
$app->match('/nomines/honneur/{id}', 
        'G_I_A\Controller\HomeController::nomine_honneur_action')
        ->bind('nomine_honneur');

/* Show detail about a given nomine */
$app->match('/nomine/detail/{id}', 
        'G_I_A\Controller\HomeController::nomine_detail_action')
        ->bind('public_nomine_detail');

/* Listed all Partenaires */
$app->match('/partenaires', 
        'G_I_A\Controller\HomeController::partenaire_action')
        ->bind('partenaires');

/*************************** Admin Routes *************************************/
 
        /******************  Nomine ******************************/         

/* Admin home page */
$app->match('/admin/accueil', 
        'G_I_A\Controller\AdminController::all_nomines_action')
        ->bind('nomine_all');

/*  Add a new nomine */
$app->match('/admin/nomine/add', 
        'G_I_A\Controller\AdminController::add_nomine_action')
        ->bind('nomine_add');

/* Show detail of a given nomine */
$app->match('/admin/nomine/detail/{id}', 
        'G_I_A\Controller\AdminController::detail_nomine_action')
        ->bind('nomine_detail');

/* Edit information about given nomine */
$app->match('/admin/nomine/edit/{id}', 
        'G_I_A\Controller\AdminController::edit_nomine_action')
        ->bind('nomine_edit');

/* Delete nomine with a given id. */
$app->match('/admin/nomine/delete/{id}', 
        'G_I_A\Controller\AdminController::delete_nomine_action')
        ->bind('nomine_delete');


        /******************  Categorie ******************************/

/* return all categories */
$app->get('/admin/categorie/all', 
        'G_I_A\Controller\AdminController::all_categorie_action')
        ->bind('all_categories');

/* Add a new categorie */
$app->match('/admin/categorie/add',
        'G_I_A\Controller\AdminController::add_categorie_action')
        ->bind('categorie_add');

/* Edit an given categorie */
$app->match('/admin/categorie/edit/{id}', 
        'G_I_A\Controller\AdminController::edit_categorie_action')
        ->bind('categorie_edit');

        /******************  Login && Contact ******************************/

/* login */
$app->match('/login', 
        'G_I_A\Controller\AdminController::login_action')
        ->bind('login');

/* Contact */
$app->match('/contact', 
        'G_I_A\Controller\HomeController::contact_action')
        ->bind('contact');

  /******************  Honneur ******************************/

/* return all honneur */
$app->get('/admin/honneur/all', 
        'G_I_A\Controller\AdminController::all_honneur_action')
        ->bind('all_honneurs');

/* return all honneur */
$app->match('/admin/honneur/add', 
        'G_I_A\Controller\AdminController::add_honneur_action')
        ->bind('honneur_add');

/* Delete a given honneur */
$app->match('/admin/honneur/delete/{id}', 
        'G_I_A\Controller\AdminController::delete_honneur_action')
        ->bind('honneur_delete');
