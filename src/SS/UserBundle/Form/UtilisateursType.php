<?php

namespace SS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateursType extends AbstractType
{

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'SS\UserBundle\Entity\Utilisateurs',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_userbundle_utilisateurs';
    }
}
