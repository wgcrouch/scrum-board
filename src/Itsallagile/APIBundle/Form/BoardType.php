<?php
namespace Itsallagile\APIBundle\Form;

use Itsallagile\APIBundle\Form\ApiForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Itsallagile\CoreBundle\Document\Board;
use Doctrine\ODM\MongoDB\DocumentRepository;

class BoardType extends ApiForm
{
    protected $user = null;

    public function __construct(\Itsallagile\CoreBundle\Document\User $user)
    {
        $this->user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('slug');
        
        $user = $this->user;
        $builder->add(
            'team',
            'document',
            array(
                'class' => 'ItsallagileCoreBundle:Team',
                'property' => 'name',
                'query_builder' => function (DocumentRepository $dr) use ($user) {
                    return $dr->getFindAllByUserQueryBuilder($user);
                }
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Itsallagile\CoreBundle\Document\Board',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
