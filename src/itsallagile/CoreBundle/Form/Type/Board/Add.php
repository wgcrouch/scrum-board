<?php
namespace itsallagile\CoreBundle\Form\Type\Board;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class Add extends AbstractType
{

    protected $user = null;

    public function __construct(\itsallagile\CoreBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('slug');

        $userId = $this->user->getUserId();
        $builder->add(
            'team',
            'entity',
            array(
                'class' => 'itsallagileCoreBundle:Team',
                'property' => 'name',
                'query_builder' => function (EntityRepository $er) use ($userId) {
                    return $er->createQueryBuilder('t')
                        ->where(':userId MEMBER OF t.users')
                        ->orderBy('t.name', 'ASC')
                        ->setParameter('userId', $userId);
                }
            )
        );
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
