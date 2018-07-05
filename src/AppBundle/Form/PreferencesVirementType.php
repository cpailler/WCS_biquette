<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 29/06/18
 * Time: 10:34
 */

namespace AppBundle\Form;
use AppBundle\Entity\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PreferencesVirementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('owner_account', TextType::class,array(
                'label' => 'Titulaire du compte'
            ))

            ->add('adresse', TextType::class,array(
                'label' => 'Adresse du titulaire (n° et voie)'
            ))

            ->add('postal_code', NumberType::class,array(
                'label' => 'Code postal'
            ))

            ->add('pays', TextType::class,array(
                'label' => 'Pays de domiciliation bancaire'
            ))

            ->add('iban', TextType::class,array(
        'label' => 'IBAN (Lettres incluses)'
             ))

            ->add('bic', TextType::class,array(
                'label' => 'BIC ou SWIFT'
            ))

            ->add('submit', SubmitType::class,array(
                'label' => 'Enregistrer'
            ));

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BankAccount'
        ));
    }

    public function getBlockPrefix()
    {
        return null;
    }
}