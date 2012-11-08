<?php

namespace itsallagile\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for tickets in the API
 */
class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('type')
            ->add('parent')
            ->add('id', 'hidden', array('mapped' => false));

        $builder->add(
            'status',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:Status',
                'property' => 'name'
            )
        );

        $builder->add(
            'story',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:Story',
                'property' => 'content'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'itsallagile\CoreBundle\Entity\Ticket',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
