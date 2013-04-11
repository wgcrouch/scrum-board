<?php

namespace Itsallagile\APIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Itsallagile\CoreBundle\Document\Story;
use Itsallagile\APIBundle\Form\PartialUpdateSubscriber;

/**
 * Form for stories in the API
 */
abstract class ApiForm extends AbstractType
{
    protected $isUpdateForm = false;
    
    public function __construct($isUpdate = false)
    {
        $this->isUpdateForm = (bool)$isUpdate;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->isUpdateForm) {
            $subscriber = new PartialUpdateSubscriber($builder->getFormFactory());
            $builder->addEventSubscriber($subscriber);
        }
    }
}
