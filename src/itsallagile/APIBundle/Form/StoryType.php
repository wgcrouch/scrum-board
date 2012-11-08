<?php

namespace itsallagile\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for stories in the API
 */
class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('points')
            ->add('sort')
            //These are not handled
            ->add('id', 'hidden', array('mapped' => false))
            ->add('tickets', 'hidden', array('mapped' => false));

        $builder->add(
            'board',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:Board',
                'property' => 'name'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'itsallagile\CoreBundle\Entity\Story',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
