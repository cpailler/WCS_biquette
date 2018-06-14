<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class EnregistrementType extends AbstractType
{
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

            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne concordent pas.',

                'options' => array(
                    'attr' => array(
                        'class' => 'password-field')),

                'required' => true,

                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Créez un mot de passe')),

                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Confirmez le mot de passe')
                )))

            ->add('conditions',CheckboxType::class, array(
                'mapped' => false,
                'label' => 'En vous inscrivant vous acceptez les Conditions générales d’utilisation, les conditions de l’assurance, les modalités pratiques de Mangopay, et la politique de confidentialité de Bikerr.'
                ));


    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}