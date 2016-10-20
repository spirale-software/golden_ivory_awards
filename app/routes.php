<?php

include_once __DIR__.'/../src/controller/AdminController.php';
include_once __DIR__.'/../src/controller/HomeController.php';

// index
$app->get('/', 
        'G_I_A\Controller\HomeController::index_action')
        ->bind('home');

// admin_board
$app->get('/admin/admin_board', 
        'G_I_A\Controller\AdminController::admin_board_action')
        ->bind('admin_board');

// categorie_admin_board
$app->get('/admin/categorie_admin_board', 
        'G_I_A\Controller\AdminController::categorie_admin_board_action')
        ->bind('categorie_admin_board');

// return all categories
$app->get('/all_categories', 
        'G_I_A\Controller\AdminController::get_all_articles_action')
        ->bind('all_categories');

// Add a new categorie
$app->match('/categorie/add',
        'G_I_A\Controller\AdminController::add_categorie_action')
        ->bind('categorie_add');

// Add a new Nomine
$app->match('/nomine/add', 
        'G_I_A\Controller\AdminController::add_nomine_action')
        ->bind('nomine_add');

// login
$app->match('/login', 
        'G_I_A\Controller\AdminController::login_action')
        ->bind('login');
