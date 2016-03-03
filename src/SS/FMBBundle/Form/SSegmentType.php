<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SSegmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSSegment')
            ->add(
                'segment',
                'entity',
                array(
                    'class' => 'SSFMBBundle:Segment',
                    'property' => 'nomSegment',
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
                'data_class' => 'SS\FMBBundle\Entity\SSegment',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_ssegment';
    }
}
