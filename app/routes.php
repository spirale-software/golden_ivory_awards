<?php

include_once __DIR__.'/../src/controller/AdminController.php';
include_once __DIR__.'/../src/controller/HomeController.php';

/**
 ******************** User Routes **********************************************
 */
// index
$app->get('/', 
        'G_I_A\Controller\HomeController::index_action')
        ->bind('home');

// return all categories
$app->get('/all_categories', 
        'G_I_A\Controller\AdminController::all_categorie_action')
        ->bind('all_categories');

// Listed all Nomine
$app->match('/all', 
        'G_I_A\Controller\HomeController::all_nomines_action')
        ->bind('public_nomine_all');

/**
 ********************* Admin Route - Nomine ************************************
 */

// Listed all Nomine
$app->match('/nomine/all', 
        'G_I_A\Controller\AdminController::all_nomines_action')
        ->bind('nomine_all');

// Add a new nomine
$app->match('/nomine/add', 
        'G_I_A\Controller\AdminController::add_nomine_action')
        ->bind('nomine_add');

//Show detail of a given nomine
$app->match('/nomine/detail/{id}', 
        'G_I_A\Controller\AdminController::detail_nomine_action')
        ->bind('nomine_detail');

//Edit information about given nomine
$app->match('/nomine/edit/{id}', 
        'G_I_A\Controller\AdminController::edit_nomine_action')
        ->bind('nomine_edit');

//Edit an given categorie
$app->match('/categorie/edit/{id}', 
        'G_I_A\Controller\AdminController::edit_categorie_action')
        ->bind('categorie_edit');

//Delete nomine with a given id.
$app->match('/nomine/delete/{id}', 
        'G_I_A\Controller\AdminController::delete_nomine_action')
        ->bind('nomine_delete');




// admin_board
$app->get('/admin/admin_board', 
        'G_I_A\Controller\AdminController::admin_board_action')
        ->bind('admin_board');

// categorie_admin_board
$app->get('/admin/categorie_admin_board', 
        'G_I_A\Controller\AdminController::categorie_admin_board_action')
        ->bind('categorie_admin_board');

// Add a new categorie
$app->match('/categorie/add',
        'G_I_A\Controller\AdminController::add_categorie_action')
        ->bind('categorie_add');



// login
$app->match('/login', 
        'G_I_A\Controller\AdminController::login_action')
        ->bind('login');
