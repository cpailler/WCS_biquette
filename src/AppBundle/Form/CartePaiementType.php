<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 25/06/18
 * Time: 16:08
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

use AppBundle\Entity\CartePaiement;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CartePaiementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('data', HiddenType::class)

            ->add('accessKeyRef', HiddenType::class)

            ->add('returnURL', HiddenType::class)

            ->add('cardNumber', NumberType::class, array(
                'label' => false,
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 16))
                )))

            ->add('cardExpirationDate', NumberType::class, array(
                'label' => false,
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 4))

                )))

            ->add('cardCvx', NumberType::class,array(
                'label' => false,
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 3))

                )))

            ->add('checkbox', CheckboxType::class,array(
                'mapped' =>false,
                'label' => false
            ))

            ->add('submit', SubmitType::class,array(
                'label' => 'effectuer un paiement'));


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CartePaiement'
        ));
    }

    public function getBlockPrefix()
    {
        return null;
    }


}