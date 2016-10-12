<?php

namespace SS\FMBBundle\Form;

use Doctrine\ORM\EntityManager;
use SS\FMBBundle\Entity\Magasins;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Date;

class PreparationCordeType extends AbstractType
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

    protected function addElements(FormInterface $form, Magasins $parc = null)
    {
        $dt = $form->get('date');
        $do = $form->get('document');
        $form->remove('date');
        $form->remove('document');
        $form->add('Parc', 'entity', array(
                'data' => $parc,
                'class' => 'SSFMBBundle:Magasins',
                'mapped' => false)
        );
        // Cities are empty, unless we actually supplied a province
        $stocks = array();
        $cordes = array();
        if ($parc) {
            // Fetch the cities from specified province
            $repo2 = $this->em->getRepository('SSFMBBundle:Corde');
            $stocks = $parc->getIdStock();
            $cordes = $repo2->findByParc($parc);
        }
        // Add the city element
        $form->add('libStock', 'entity', array(
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Stocks',
            'choices' => array($stocks),
        ));
        $form->add('nomCorde', 'entity', array(
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'property'=>'id',
            'class' => 'SSFMBBundle:Corde',
            'choices' => $cordes,
        ));
        $form->add('quantiterEnStock', 'integer', array(
            'mapped' => false,
            'read_only' => 'true'
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

    function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        // Note that the data is not yet hydrated into the entity.
        $parc = $this->em->getRepository('SSFMBBundle:Magasins')->find($data['Parc']);

        $this->addElements($form, $parc);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_preparationcorde';
    }
}