<?php
// src/AppBundle/Form/LoginType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class LoginType
 * @package AppBundle\Form
 */
class LoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('plainPassword')

            ->add('email',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Adresse email'),
                'required' => true,
                'label' => false
            ))

            ->add('plainPassword', PasswordType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Adresse e-mail ou mot de passe invalide',
                'label' => false,
                'required' => true,

                'options' => array(
                    'attr' => array(
                        'class' => 'password-field',
                        'placeholder' => 'Mot de passe')),
                ))

            ->add('souvenir',CheckboxType::class, array(
                'mapped' => false,
                'required' => false,
                'label' => 'Se souvenir de moi'
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