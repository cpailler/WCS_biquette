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
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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


            ->add('PreregistrationData', HiddenType::class,
                array('block_name' => 'data'))

            ->add('AccessKey', HiddenType::class)

            ->add('returnURL', HiddenType::class)

            ->add('card_type', ChoiceType::class, array(
                'label' => false,
                'required' => true,
                'expanded'=>true,
                'multiple' => false,
                'choices' => array(
                    'VISA' => true,
                    'MAESTRO' => true,
                    'MASTERCARD' => true,
                    'CB' => true
                    ),
                'choice_label' => false
            ))
      

//            ->add('card_owner', TextType::class,array(
//                'label' => false,
//                'required' => false
//            ))

            ->add('card_number', NumberType::class, array(
                'label' => false,
                'constraints'=> array(
                    'maxlength'=>16
                )))

            ->add('card_exp', NumberType::class, array(
                'label' => false,
                'constraints'=> array(
                    'maxlength'=>4

                )))

            ->add('card_cvv', NumberType::class,array(
                'label' => false,
                'constraints'=> array(
                    'maxlength'=>3

                )))

            ->add('checkbox', CheckboxType::class,array(
                'mapped' =>false,
                'label' => false
                ))

            ->add('submit', SubmitType::class);


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