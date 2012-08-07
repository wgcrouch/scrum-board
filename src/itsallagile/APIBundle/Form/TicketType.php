<?php

namespace itsallagile\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('type')
            ->add('status')
            ->add('story')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'itsallagile\CoreBundle\Entity\Ticket',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'ticket';
    }
}


