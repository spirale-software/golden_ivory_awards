<?php namespace G_I_A\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__.'/../form/type/categorieType.php';

class HomeController {
    
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

            $libelle_categorie = $this->find_libelle_by_ID(
                    $categories, $nomine->getCategorieID());

            $nomine->setLibelleCategorie($libelle_categorie);
        }

        return $app['twig']->render('nomine_all.html.twig', array(
                    'nomines' => $nomines,
                    'title' => 'Nominés'));
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

