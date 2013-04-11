<?php

namespace Itsallagile\APIBundle\Form;

use Itsallagile\APIBundle\Form\ApiForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Itsallagile\CoreBundle\Document\Story;

/**
 * Form for stories in the API
 */
class StoryType extends ApiForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('content')
            ->add('points')
            ->add('sort')
            //These are not handled
            ->add('id', 'hidden', array('mapped' => false))
            ->add('created', 'hidden', array('mapped' => false))
            ->add('tickets', 'hidden', array('mapped' => false));

        $builder->add(
            'status',
            'choice',
            array(
                'choices'   => Story::getStatuses(),
                'required'  => false,
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Itsallagile\CoreBundle\Document\Story',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
