<?php

namespace Itsallagile\APIBundle\Form;

use Itsallagile\APIBundle\Form\ApiForm;
use Itsallagile\CoreBundle\Document\Ticket;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for tickets in the API
 */
class TicketType extends ApiForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('type')
            ->add('created', 'hidden', array('mapped' => false))
            ->add('modified', 'hidden', array('mapped' => false))
            ->add('id', 'hidden', array('mapped' => false));

        $builder->add(
            'status',
            'choice',
            array(
                'choices'   => Ticket::getStatuses(),
                'required'  => false
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Itsallagile\CoreBundle\Document\Ticket',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
