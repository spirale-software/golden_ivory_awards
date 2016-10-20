<?php

namespace G_I_A\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__ . '/../form/type/categorieType.php';
include_once __DIR__ . '/../form/type/nomineType.php';
include_once __DIR__ . '/../domain/Nomine.php';

class AdminController {

    public function getCategories(Application $app) {
        return $app['dao.categorie']->findAll();
    }

    public function get_all_articles_action(Application $app) {

        $categories = $app['dao.categorie']->findAll();
        return $app['twig']->render('all_categories.html.twig', array(
                    'categories' => $categories));
    }

    public function add_categorie_action(Application $app, Request $request) {

        $categorie = new \G_I_A\Domain\Categorie();
        $categorieForm = $app['form.factory']->create(
                new \G_I_A\Form\Type\CategorieType, $categorie);
        $categorieForm->handleRequest($request);
        if ($categorieForm->isSubmitted() && $categorieForm->isValid()) {
            $app['dao.categorie']->save($categorie);
            $app['session']->getFlashBag()->add(
                    'success', 'La categorie a été bien crée.');
        }
        return $app['twig']->render('categorie_form.html.twig', array(
                    'title' => 'New article',
                    'categorieForm' => $categorieForm->createView()));
    }

    public function add_nomine_action(Application $app, Request $request) {

        $nomine = new \G_I_A\Domain\Nomine();
        $nomineForm = $app['form.factory']->create(
                new \G_I_A\Form\Type\NomineType, $nomine);
        $nomineForm->handleRequest($request);

        if ($nomineForm->isSubmitted() && $nomineForm->isValid()) {
            $app['dao.nomine']->save($nomine);
            $app['session']->getFlashBag()->add(
                    'success', 'Le nomine a été bien crée.');
        }

        return $app['twig']->render('nomine_form.html.twig', array(
                    'title' => 'New Nomine',
                    'nomineForm' => $nomineForm->createView()));
    }

    public function login_action(Application $app, Request $request) {

         if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
             $app->redirect('admin_board');
         }
         return $app['twig']->render('login_form.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
          )); 
    }

    public function admin_board_action(Application $app) {

        return $app['twig']->render('admin_board.html.twig');
    }
    
    public function categorie_admin_board_action(Application $app) {

        $categories = $app['dao.categorie']->findAll();
        return $app['twig']->render('categories_admin_board.html.twig', array(
                    'categories' => $categories));
    }

}
