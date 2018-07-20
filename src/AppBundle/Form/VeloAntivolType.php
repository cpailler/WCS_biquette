<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloAntivolType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('antivolKey', ChoiceType::class, array('label' => 'Antivol à clé', 'choices' => array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5)))
            ->add('antivolCode',ChoiceType::class, array('label' => 'Antivol à combinaison', 'choices' => array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5)))
            ->add('bicycode', IntegerType::class, array('label' => 'Numéro Bicycode (si disponible)', 'required' => false));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Velo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_veloAntivol';
    }


}
