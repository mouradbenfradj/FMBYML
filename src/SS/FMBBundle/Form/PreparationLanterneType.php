<?php

namespace SS\FMBBundle\Form;

use Doctrine\ORM\EntityRepository;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Repository\LanterneRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreparationLanterneType extends AbstractType
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
                'required' => true,
                'class' => 'SS\FMBBundle\Entity\Parc',
                'label' => 'parc',
            )
        );
        $builder->add(
            'lanterne',
            'entity',
            array(
                'required' => true,
                'class' => 'SS\FMBBundle\Entity\Lanterne',
                'label' => 'lanterne',

            )
        );
        $builder->add(
            'stock',
            'entity',
            array(
                'required' => true,
                'class' => 'SS\FMBBundle\Entity\Stocks',
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
        return 'ss_fmbbundle_preparationlanterne';
    }

}