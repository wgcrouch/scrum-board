<?php
namespace Itsallagile\CoreBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class Registration extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fullName', 'text');
        $builder->add('email', 'email');
        $builder->add(
            'password',
            'repeated',
            array(
                'first_name' => 'password',
                'second_name' => 'confirm',
                'type' => 'password'
            )
        );
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Itsallagile\CoreBundle\Document\User');
    }

    public function getName()
    {
        return 'user';
    }
}
