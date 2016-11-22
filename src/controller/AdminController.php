<?php

namespace G_I_A\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__ . '/../form/type/categorieType.php';
include_once __DIR__ . '/../form/type/HonneurType.php';
include_once __DIR__ . '/../form/type/NomineType.php';
include_once __DIR__ . '/../form/type/ActualiteType.php';
include_once __DIR__ . '/../domain/Nomine.php';
include_once __DIR__ . '/../domain/Honneur.php';

class AdminController {

    /**
     * Add a new honneur(prix) in the DB
     * 
     * @param Application $app
     * @param Request $request
     * 
     * @return  admin_honneur_form.html.twig
     */
    public function add_honneur_action(Application $app, Request $request) {

        $honneur = new \G_I_A\Domain\Honneur();
        $honneur_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\HonneurType(), $honneur);

        $honneur_form->handleRequest($request);

        if ($honneur_form->isSubmitted() && $honneur_form->isValid()) {

            $fileName = $this->savePhoto($honneur);

            $honneur->setFileName($fileName);

            $app['dao.honneur']->save($honneur);

            $app['session']->getFlashBag()->add(
                    'success', "L'honneur a été bien crée.");
        }

        return $app['twig']->render('admin_honneur_form.html.twig', array(
                    'title' => 'New Honneur',
                    'honneur_form' => $honneur_form->createView(),
                    'active' => 5));
    }

    /**
     * Show all honneur(prix) which are in the DB
     * 
     * @param Application $app
     * 
     * @return admin_honneur_all.html.twig
     */
    public function all_honneur_action(Application $app) {

        $honneurs = $app['dao.honneur']->find_all();

        foreach ($honneurs as $honneur) {

            $fileName = $app['dao.image']->find_by_honneur($honneur->getId());
            $honneur->setFileName($fileName);
        }

        return $app['twig']->render('admin_honneur_all.html.twig', array(
                    'honneurs' => $honneurs,
                    'title' => 'Honneurs',
                    'active' => 6));
    }

    public function add_actualite_action(Application $app, Request $request) {

        $actualite = new \G_I_A\Domain\Actualite();
        $actualite_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\ActualiteType(), $actualite);

        $actualite_form->handleRequest($request);

        if ($actualite_form->isSubmitted() && $actualite_form->isValid()) {
            
            /*Enregistrer la photo dans le fichier 'image'*/
            $fileName = $this->savePhoto($actualite);
            
            $actualite->setFileName($fileName);
            
            $app['dao.actualite']->save($actualite);

            $app['session']->getFlashBag()->add(
                    'success', 'L\'article a été bien enregistré');
        }

        return $app['twig']->render('admin_actualite_form.html.twig', array(
                    'actualite_form' => $actualite_form->createView(),
                    'title' => 'Nouvelle actualite',
                    'active' => 7));
    }

    /* A voir si c'est vraiment necessaire    */

    public function all_actualite_action(Application $app, Request $request) {

        $actualites = $app['dao.actualite']->find_all();

        return $app['twig']->render('admin_actualite.html.twig', array(
                    'actualites' => $actualites,
                    'title' => 'Toutes les actualite',
                    'active' => 8));
    }

    /**
     * Delete a given honneur. 
     * 
     * @param Application $app
     * @param integer $id
     * 
     * @return this->all_honneur_action()
     */
    public function delete_honneur_action(Application $app, $id) {

        $app['dao.honneur']->delete(intval($id));

        return $this->all_honneur_action($app);
    }

    /**
     * Edit a given honneur
     * 
     * @param Application $app
     * @param Request $request
     * @param integer $id
     * 
     * @return admin_honneur_edit.html.twig
     */
    public function edit_honneur_action(Application $app, Request $request, $id) {
        
    }

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
        //$categories = $app['dao.categorie']->find_all();

        /* foreach ($nomines as $nomine) {

          $libelle_categorie = $this->find_libelle_by_ID(
          $categories, $nomine->getCategorieID());

          $nomine->setLibelleCategorie($libelle_categorie);
          } */

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

        return $app['twig']->render('admin_nomine_detail.html.twig', array(
                    'title' => '',
                    'nomine' => $nomine,
                    'active' => 0));
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

        $old_fileName = $nomine->getFileName();
        $nomine->setFileName(NULL);

        $nomine_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\NomineType(), $nomine);
        $nomine_form->handleRequest($request);

        if ($nomine_form->isSubmitted() && $nomine_form->isValid()) {

            if (is_null($nomine->getFileName())) {
                $nomine->setFileName($old_fileName);
            } else {
                $new_fileName = $this->savePhoto($nomine);
                $nomine->setFileName($new_fileName);

                // Suppression de l'ancienne photo
                $fileName = __DIR__ . '/../../images/' . $old_fileName;
                unlink($fileName);
            }

            $app['dao.nomine']->edit($nomine);

            $app['session']->getFlashBag()->add(
                    'success', 'Le nominé a été bien modifié');
        }
        $nomine_form_view = $nomine_form->createView();

        return $app['twig']->render('admin_nomine_edit.html.twig', array(
                    'title' => '',
                    'nomine_form' => $nomine_form_view,
                    'active' => 0));
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

            // Enregistrer la photo du nomine.
            $fileName = $this->savePhoto($nomine);
            $nomine->setFileName($fileName);

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

    /*     * *************************** Categorie ************************************* */

    /**
     * Show all the categories which are present in the DB.
     * 
     * @param Application $app
     * 
     * @return admin_categorie_all.html.twig
     */
    public function all_categorie_action(Application $app) {

        $categories = $app['dao.categorie']->find_all();
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
        $categorie_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\CategorieType, $categorie);
        $categorie_form->handleRequest($request);
        if ($categorie_form->isSubmitted() && $categorie_form->isValid()) {
            $app['dao.categorie']->save($categorie);
            $app['session']->getFlashBag()->add(
                    'success', 'La categorie a été bien crée.');
        }
        return $app['twig']->render('admin_categorie_form.html.twig', array(
                    'title' => 'New article',
                    'categorie_form' => $categorie_form->createView(),
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

        return $app['twig']->render('login_form.html.twig', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' =>
                    $app['session']->get('_security.last_username'),
        ));
    }

    /**
     * 
     * @param type $object
     * @return string
     */
    private function savePhoto($object) {

        $file = $object->getFileName();
        $id_photo = uniqid();
        $fileName = $id_photo . '.' . $file->guessExtension();
        $directory = __DIR__ . '/../../images/';
        $file->move($directory, $fileName);

        return $fileName;
    }

}
