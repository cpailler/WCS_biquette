<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 18/06/18
 * Time: 16:39
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;

class VeloPointsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('publicationDate')
            ->add('note')
            ->add('userRated')
            ->add('reviewAuthor');
    }

}