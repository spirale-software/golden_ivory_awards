<?php namespace G_I_A\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

include_once __DIR__ . '/../../domain/Actualite.php';

class ActualiteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('titre', 'text')
                ->add('descriptif', 'textarea')
                ->add('fileName', FileType::class, array('required' => false));
    }
}
