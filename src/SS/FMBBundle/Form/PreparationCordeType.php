<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;

class PreparationCordeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'parc',
            'entity',
            array(
                'class' => 'SSFMBBundle:Parc',
                'label' => 'parc',
            )
        );
        $builder->add(
            'stock',
            'entity',
            array(
                'class' => 'SSFMBBundle:Stocks',
                'label' => 'stock',
            )
        );
        $builder->add(
            'date',
            'date',
            array(
                'data' => new \DateTime(),
            )
        );
        $builder->add(
            'document',
            new DocumentsType()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_preparationcorde';
    }
}