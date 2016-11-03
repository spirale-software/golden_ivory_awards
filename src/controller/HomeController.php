<?php namespace G_I_A\Controller;
use Silex\Application;

include_once __DIR__.'/../form/type/categorieType.php';

class HomeController {
    
    public function contact_action(Application $app) {
        
        return $app['twig']->render('contact.html.twig');
        
    }
    
    /**
     * allow to show detail about a nomine. 
     * 
     * @param Application $app
     * @param int $id : represent the id of the given nomine.
     * 
     * return nomine_detail.html.twig
     */
    public function nomine_detail_action(Application $app, $id) {

        $_nomine = $app['dao.nomine']->find_nomine_by_ID($id);
        $nomine = array_shift($_nomine);
        $categories = $app['dao.categorie']->findAll();

        $libelle_categorie = $this->find_libelle_by_ID(
                $categories, $nomine->getCategorieID());
        $nomine->setLibelleCategorie($libelle_categorie);

        return $app['twig']->render('nomine_detail.html.twig', array(
                    'nomine' => $nomine,
                    'title' => 'Detail'));
    }

    
     /**
     * Show all nomines who discuss a given honnor.
     * 
     * @param Application $app
     * @param integer $id
     * 
     * @return nomine_honneur.html.twig
     */
    public function nomine_honneur_action(Application $app, $id) {
        
        $nomines = $app['dao.nomine']->find_nomine_by_categorie($id);
        
        return $app['twig']->render('nomine_all.html.twig', array(
                    'title' => 'nomines',
                    'nomines' => $nomines));   
    }
    
    /**
     * 
     * @param Application $app
     * 
     * @return index.html.twig
     */
    public function index_action(Application $app) {
        
        
        return $app['twig']->render('index.html.twig');
    }
     
    /**
     * Show all nomine who are in the DB.
     * 
     * @param Application $app, Request $request
     *  
     * @return all_nomines.html.twig
     */
    public function all_nomines_action(Application $app) {

        $nomines = $app['dao.nomine']->find_all_nomine();
        $categories = $app['dao.categorie']->findAll();

        foreach ($nomines as $nomine) {

            $libelle = $this->find_libelle_by_ID(
                    $categories, $nomine->getCategorieID());

            $nomine->setLibelleCategorie($libelle);
        }

        return $app['twig']->render('nomine_all.html.twig', array(
                    'nomines' => $nomines,
                    'title' => 'Nominés'));
    }
    
    /**
     * Show all honneur
     * @param Application $app
     * 
     * @return honneur.html.twig
     */
    public function honneur_action(Application $app) {
        
        
        $honneurs = $app['dao.prix']->find_all();
        $categories = $app['dao.categorie']->findAll();
        
        foreach ($honneurs as  $honneur) { 
           
            $libelle = $this->find_libelle_by_ID(
                    $categories, $honneur->getCategorieID());
                       
            $honneur->setLibelleCategorie($libelle);
        }
        
        return $app['twig']->render('honneur.html.twig', array(
                    'title' => 'Honneur',
                    'honneurs' => $honneurs));
    }
    
    /**
     * Show all honneur
     * @param Application $app
     * 
     * @return honneur.html.twig
     */
    public function partenaire_action(Application $app) {
        
        return $app['twig']->render('partenaire.html.twig', array(
                    'title' => 'Partenaire'));
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

