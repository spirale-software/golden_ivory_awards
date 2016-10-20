<?php namespace G_I_A\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('password', array(
                'type'            => 'password',
                'options'         => array('required' => true),
                'first_options'   => array('label' => 'Password'),
             ));
    }

    public function getName()
    {
        return 'utilisateur';
    }
}
