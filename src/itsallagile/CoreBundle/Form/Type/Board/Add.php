<?php
namespace itsallagile\CoreBundle\Form\Type\Board;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\Extension\Core\Type\RepeatedType,
    Symfony\Component\Form\FormBuilder;

class Add extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('slug');
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'itsallagile\CoreBundle\Entity\Board');
    }

    public function getName()
    {
        return 'board';
    }
}