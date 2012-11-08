<?php
namespace itsallagile\CoreBundle\Form\Type\Board;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class Add extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
