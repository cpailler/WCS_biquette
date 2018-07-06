<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class OubliMdpType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('plainPassword')

            ->add('email',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Adresse email de connexion'),
                'required' => true,
                'label' => false
            ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\LoginFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_login';
    }
}