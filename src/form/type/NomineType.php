<?php namespace G_I_A\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

include_once __DIR__ . '/../../domain/Categorie.php';
include_once __DIR__ . '/../../dao/CategorieDAO.php';

class NomineType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('nom', 'text')
                ->add('categorieID', ChoiceType::class, array(
                    'choices' => $this->getArray($GLOBALS['categorieDAO']->find_all())))
                ->add('descriptif', 'textarea')
                ->add('actualite', 'textarea')
                ->add('fileName', FileType::class, array('required' => false));
    }

    public function getArray($categories) {

        $array_categories = array();
        foreach ($categories as $categorie) {

            $array_categories[$categorie->getId()] = $categorie->getLibelle();
        }
        
        return $array_categories;
    }

    public function getName() {
        return 'nomine';
    }

}
