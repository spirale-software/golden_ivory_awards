<?php namespace G_I_A\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', 'text')
            ->add('email', 'text')
            ->add('message', 'textarea');
    }

    public function getName()
    {
        return 'contact';
    }
}
