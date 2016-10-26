<?php

namespace G_I_A\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__ . '/../form/type/categorieType.php';
include_once __DIR__ . '/../form/type/nomineType.php';
include_once __DIR__ . '/../domain/Nomine.php';

class AdminController {

    /**
     * Show all nomine who are in the DB.
     * 
     * @param Application $app, 
     * @param Request $request
     *  
     * @return all_nomines.html.twig
     */
    public function all_nomines_action(Application $app) {

        $nomines = $app['dao.nomine']->find_all_nomine();
        $categories = $app['dao.categorie']->findAll();

        foreach ($nomines as $nomine) {

            $libelle_categorie = $this->find_libelle_by_ID(
                    $categories, $nomine->getCategorieID());

            $nomine->setLibelleCategorie($libelle_categorie);
        }

        return $app['twig']->render('admin_nomine_all.html.twig', array(
                    'nomines' => $nomines,
                    'title' => 'Nominés',
                    'active' => 1));
    }

    /**
     * allow to show detail about a nomine. 
     * 
     * @param Application $app
     * @param int $id : represent the id of the given nomine.
     * 
     * return admin_nomine_detail.html.twig
     */
    public function detail_nomine_action(Application $app, $id) {

        $_nomine = $app['dao.nomine']->find_nomine_by_ID($id);
        $nomine = array_shift($_nomine);
        $categories = $app['dao.categorie']->findAll();

        $libelle_categorie = $this->find_libelle_by_ID(
                $categories, $nomine->getCategorieID());
        $nomine->setLibelleCategorie($libelle_categorie);

        return $app['twig']->render('admin_nomine_detail.html.twig', array(
                    'title' => '',
                    'nomine' => $nomine));
    }

    /**
     * allow to edit a given nomine 
     * 
     * @param Application $app
     * @param Request $request
     * @param int $id : represent the id of a given nomine.
     * 
     * return admin_nomine_edit.html.twig
     */
    public function edit_nomine_action(Application $app, Request $request, $id) {

        $_nomine = $app['dao.nomine']->find_nomine_by_ID($id);
        $nomine = array_shift($_nomine);

        $libelle = $app['dao.categorie']->find_libelle(
                $nomine->getCategorieID());
        $nomine->setLibelleCategorie($libelle);

        $nomine_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\NomineType(), $nomine);
        $nomine_form->handleRequest($request);

        if ($nomine_form->isSubmitted() && $nomine_form->isValid()) {

            $libelle = $app['dao.categorie']->find_libelle(
                    $nomine->getCategorieID());

            $nomine->setLibelleCategorie($libelle);

            $app['dao.nomine']->edit($nomine);
            $app['session']->getFlashBag()->add(
                    'success', 'Le nominé a été bien modifié');
        }
        $nomine_form_view = $nomine_form->createView();

        return $app['twig']->render('admin_nomine_edit.html.twig', array(
                    'title' => '',
                    'nomine_form' => $nomine_form_view));
    }
    
    /**
     * Add a new nomine in the DB
     * 
     * @param Application $app
     * @param Request $request
     * 
     * @return admin_nomine_form.html.twig
     */
    public function add_nomine_action(Application $app, Request $request) {

        $nomine = new \G_I_A\Domain\Nomine();
        $nomine_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\NomineType, $nomine);
        $nomine_form->handleRequest($request);

        if ($nomine_form->isSubmitted() && $nomine_form->isValid()) {

            $libelle = $app['dao.categorie']->find_libelle(
                    $nomine->getCategorieID());

            $nomine->setLibelleCategorie($libelle);

            $app['dao.nomine']->save($nomine);
            $app['session']->getFlashBag()->add(
                    'success', 'Le nomine a été bien crée.');
        }

        return $app['twig']->render('admin_nomine_form.html.twig', array(
                    'title' => 'New Nomine',
                    'nomine_form' => $nomine_form->createView(),
                    'active' => 2));
    }
    
     /**
     * allow to delete a given nomine 
     * 
     * @param Application $app
     * @param Request $request
     * @param int $id
     * 
     * return $this->all_nomines_action()
     */
    public function delete_nomine_action(Application $app, $id) {

        $_nomine = $app['dao.nomine']->find_nomine_by_ID($id);
        $nomine = array_shift($_nomine);

        $app['dao.nomine']->delete($nomine);

        return $this->all_nomines_action($app);
    }
    
/***************************** Categorie **************************************/

    /**
     * Show all the categories which are present in the DB.
     * 
     * @param Application $app
     * 
     * @return admin_categorie_all.html.twig
     */
    public function all_categorie_action(Application $app) {

        $categories = $app['dao.categorie']->findAll();
        return $app['twig']->render('admin_categorie_all.html.twig', array(
                    'categories' => $categories,
                    'active' => 4));
    }

    /**
     * Allow to edit a categorie.
     * 
     * @param Application $app
     * @param Request $request
     * @param integer $id : represent id's categorie to edit.
     * 
     * @return admin_categorie_form.html.twig
     */
    function edit_categorie_action(Application $app, Request $request, $id) {
        $libelle = $app['dao.categorie']->find_libelle($id);

        $categorie = new \G_I_A\Domain\Categorie();
        $categorie->setLibelle($libelle['libelle']);
        $categorie->setId($id);
        
        $categorie_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\CategorieType, $categorie);
        
        $categorie_form->handleRequest($request);
        
        if ($categorie_form->isSubmitted() && $categorie_form->isValid()) {
                      
            $app['dao.categorie']->edit($categorie);
            
            $app['session']->getFlashBag()->add(
                    'success', 'La categorie a été bien modifiée.');
        }
        return $app['twig']->render('admin_categorie_form.html.twig', array(
                    'title' => 'New article',
                    'categorie_form' => $categorie_form->createView(),
                    'active' => 0,
                    'action' => 'Modifier'));
    }
    
    /**
     * Add new categorie in the DB.
     * 
     * @param Application $app
     * @param Request $request
     * 
     * @return admin_categorie_form.html.twig
     */
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
        return $app['twig']->render('admin_categorie_form.html.twig', array(
                    'title' => 'New article',
                    'categorieForm' => $categorieForm->createView(),
                    'active' => 3,
                    'action' => 'Ajouter'));
    }

    /**
     * 
     * @param Application $app
     * @param Request $request
     * 
     * @return type
     */
    public function login_action(Application $app, Request $request) {

        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            $app->redirect('admin_board');
        }
        return $app['twig']->render('login_form.html.twig', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' => $app['session']->get('_security.last_username'),
        ));
    }


    /**
     * 
     * @param array $categories
     * @param int $id.
     * 
     * @return string libelle, according to the $id.
     */
    private function find_libelle_by_ID($categories, $id) {

        foreach ($categories as $categorie) {

            if ($categorie->getID() == $id) {
                $libelle = $categorie->getLibelle();
                break;
            }
        }

        return $libelle;
    }

}
