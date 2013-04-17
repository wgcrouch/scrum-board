<?php
namespace Itsallagile\APIBundle\Form;

use Itsallagile\APIBundle\Form\ApiForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Itsallagile\CoreBundle\Document\Team;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TeamType extends ApiForm
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Itsallagile\CoreBundle\Document\Team',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
