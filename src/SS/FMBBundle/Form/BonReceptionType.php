<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BonReceptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*
               ->add(
                'nLot',
                'entity',
                array(
                    'class' => 'SSFMBBundle:Lot',
                    'property' => 'lot',
                    'multiple' => false,
                )
            )*/
            ->add(
                'article',
                'entity',
                array(
                    'class' => 'SSFMBBundle:Article',
                    'property' => 'nomArticle',
                    'multiple' => false,
                )
            )
            ->add('quantiter')
            ->add('duplication');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'SS\FMBBundle\Entity\BonReception',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_bonreception';
    }
}
