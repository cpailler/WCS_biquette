<?php
namespace AppBundle\Form;

use AppBundle\Entity\Velo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class LocalisationType extends AbstractType
{
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse_velo', TextType::class);
    }
    /**
     * {@inheritdoc} Targeting Review entity
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Velo'
        ));
    }
    /**
     * {@inheritdoc} getName() is now deprecated
     */
    public function getBlockPrefix()
    {
        return 'appbundle_velo';
    }
}