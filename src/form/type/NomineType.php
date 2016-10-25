<?php

namespace G_I_A\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

include_once __DIR__.'/../../domain/Categorie.php';
include_once __DIR__.'/../../dao/CategorieDAO.php';

class NomineType extends AbstractType {
   
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder
                ->add('nom', 'text')
                ->add('categorieID', ChoiceType::class, array(
                    'choices' => $this->getArray($GLOBALS['categorieDAO']->findAll())))
                ->add('descriptif', 'textarea')
                ->add('actualite', 'textarea');
    }
    
    public function getArray($categories){
        
        $array_categories = array();
        foreach ($categories as $categorie) {
            
            $array_categories[$categorie->getId()] = $categorie->getLibelle();
        }
        
       
        
        return $array_categories;
    }

    public function getName() {
        return 'nomine';
    }
    
    /**
     * 
     * @requires: an array of categorie.
     * @effects: 
     * @modifies: Nothing.
     */
    private function get_categorie_as_array()   {
        
        $app2 = $this->getContext()->getConfiguration()->getApplication();
        
        $categorieDAO = new \G_I_A\DAO\CategorieDAO($app['dao.categorie']);
        $categories = $categorieDAO->findAll();
        $array_categorie = array();
        foreach ($categories as $categorie) {
            $array_categorie[$categorie->getId()] = $categorie->getLibelle();
        }
        
        return $array_categorie;
    }

}
