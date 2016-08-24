<?php

namespace SS\FMBBundle\Form;

use Doctrine\ORM\EntityRepository;
use SS\FMBBundle\Entity\Parc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class PreparationLanterneType extends AbstractType
{

    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'date', array('data' => new \DateTime(),));
        $builder->add('document', new DocumentsType());
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    protected function addElements(FormInterface $form, Parc $parc = null)
    {
        $dt = $form->get('date');
        $do = $form->get('document');
        $form->remove('date');
        $form->remove('document');
        $form->add('Parc', 'entity', array(
                'data' => $parc,
                'class' => 'SSFMBBundle:Parc',
                'mapped' => false)
        );
        // Cities are empty, unless we actually supplied a province
        $stocks = array();
        $lanternes = array();
        if ($parc) {
            // Fetch the cities from specified province
            $repo = $this->em->getRepository('SSFMBBundle:Stocks');
            $repo2 = $this->em->getRepository('SSFMBBundle:Lanterne');
            $stocks = $repo->findByRefAdrStock($parc);
            $lanternes = $repo2->findByParc($parc);
        }
        // Add the city element
        $form->add('libStock', 'entity', array(
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Stocks',
            'choices' => $stocks,
        ));
        $form->add('nomLanterne', 'entity', array(
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Lanterne',
            'choices' => $lanternes,
        ));
        $form->add($dt);
        $form->add($do);

    }

    function onPreSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $data = $event->getData();
        $parc = $data ? $data->getParc() : null;
        $this->addElements($form, $parc);
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        // Note that the data is not yet hydrated into the entity.
        $parc = $this->em->getRepository('SSFMBBundle:Parc')->find($data['Parc']);

        $this->addElements($form, $parc);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_preparationlanterne';
    }
}