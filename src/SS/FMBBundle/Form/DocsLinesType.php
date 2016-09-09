<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocsLinesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refArticle', 'entity', array('class' => 'SSFMBBundle:Articles', 'label' => 'article'))
            ->add('numeroSerie', 'entity', array('class' => 'SSFMBBundle:StocksArticlesSn', 'label' => 'lot','mapped' => false))
            ->add('qte')
            ->add('nombre', 'number', array('label' => 'nombre', 'mapped' => false));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'SS\FMBBundle\Entity\DocsLines',)
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_docslines';
    }
}
