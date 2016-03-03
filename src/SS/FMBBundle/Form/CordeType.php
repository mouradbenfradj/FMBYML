<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CordeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etatCorde')
            ->add('placeCorde')
            ->add('quantiter')
            ->add(
                'ssegment',
                'entity',
                array(
                    'class' => 'SSFMBBundle:SSegment',
                    'property' => 'nomSSegment',
                    'multiple' => false,
                )
            );;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'SS\FMBBundle\Entity\Corde',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_corde';
    }
}
