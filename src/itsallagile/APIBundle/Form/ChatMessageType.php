<?php

namespace itsallagile\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for chatMessages in the API
 */
class ChatMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('id', 'hidden', array('mapped' => false));

        $builder->add(
            'board',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:Board',
                'property' => 'name'
            )
        );

        $builder->add(
            'user',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:User',
                'property' => 'email'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'itsallagile\CoreBundle\Entity\ChatMessage',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
