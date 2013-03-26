<?php 

namespace itsallagile\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use FOS\UserBundle\Model\UserManagerInterface;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $roles = $this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles');
        $formMapper
            ->add('username')
            ->add('email')
            ->add('fullName')
            ->add('enabled')
            ->add('plainPassword', 'text', array('required' => false))
            ->add('roles','choice',array('choices'=>$this->refactorRoles($roles),'multiple'=>true ));
    }


    private function refactorRoles($originRoles)
    {
        $roles = array();

        foreach ($originRoles as $parent => $children) {
            $roles[$parent] = $parent;
            foreach ($children as $key => $value) {
                $roles[$value] = $value;
            }
        }
        return $roles;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('fullName')
            ->add('locked')
            ->add('enabled');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')            
            ->add('email')
            ->add('fullName')
            ->add('enabled', null, array('editable' => true))
            ->add('locked', null, array('editable' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}