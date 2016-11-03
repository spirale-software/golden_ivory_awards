<?php

namespace G_I_A\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__ . '/../form/type/categorieType.php';
include_once __DIR__ . '/../form/type/PrixType.php';
include_once __DIR__ . '/../form/type/nomineType.php';
include_once __DIR__ . '/../domain/Nomine.php';
include_once __DIR__ . '/../domain/Prix.php';

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

        $prix = new \G_I_A\Domain\Prix();
        $honneur_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\PrixType(), $prix);

        $honneur_form->handleRequest($request);

        if ($honneur_form->isSubmitted() && $honneur_form->isValid()) {

            $fileName = $this->savePhoto($prix);

            $prix->setPhotoID($fileName);

            $app['dao.prix']->save($prix);

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

        $honneurs = $app['dao.prix']->find_all();
        $categories = $app['dao.categorie']->findAll();

        foreach ($honneurs as $honneur) {

            $libelle = $this->find_libelle_by_ID(
                    $categories, $honneur->getCategorieID());


            $honneur->setLibelleCategorie($libelle);
        }

        return $app['twig']->render('admin_honneur_all.html.twig', array(
                    'honneurs' => $honneurs,
                    'title' => 'Honneurs',
                    'active' => 6));
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

        $app['dao.prix']->delete(intval($id));


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

        $photoID = $nomine->getPhotoID();
        $nomine->setPhotoID(NULL);

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

            $this->managePhoto($nomine, $photoID);

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

            $fileName = $this->savePhoto($nomine);

            $nomine->setPhotoID($fileName);

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
        
        $token = $app['security.token_storage']->getToken();
        
        if($token == NULL) {
            echo 'nullllllllllllllll';
        }
            
        
        return $app['twig']->render('login_form.html.twig', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' =>
                    $app['session']->get('_security.last_username'),
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

    /**
     * 
     * @param type $object
     * @return string
     */
    private function savePhoto($object) {

        $file = $object->getPhotoID();
        $id_photo = uniqid();
        $fileName = $id_photo . '.' . $file->guessExtension();
        $directory = __DIR__ . '/../../images/';
        $file->move($directory, $fileName);

        return $fileName;
    }

    /**
     * 
     * @param type $nomine
     * @param type $photoID
     */
    private function managePhoto($nomine, $photoID) {

        if (is_null($nomine->getPhotoID())) {
            $nomine->setPhotoID($photoID);
        } else {
            $fileName = $this->savePhoto($nomine);
            $nomine->setPhotoID($fileName);
        }
    }

}
