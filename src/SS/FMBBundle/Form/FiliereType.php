<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliereType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'parc',
                'entity',
                array(
                    'class' => 'SSFMBBundle:Parc',
                    'property' => 'nomParc',
                    'read_only' => 'true',
                    'attr' => array('class' => 'hidden'),
                    'label' => false,
                )
            )
            ->add('nomFiliere')
            ->add(
                'segments',
                'collection',
                array(
                    'type' => new SegmentType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'SS\FMBBundle\Entity\Filiere',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_filiere';
    }
}
