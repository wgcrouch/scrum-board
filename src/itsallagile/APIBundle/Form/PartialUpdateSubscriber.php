<?php
namespace itsallagile\APIBundle\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

/**
 * Used to prevent model elements from being removed if they have no values
 * eg. posting to a form with a partial object
 */
class PartialUpdateSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_BIND => 'preBind');
    }

    public function preBind(FormEvent $event)
    {
        $submittedData = $event->getData();
        $form = $event->getForm();

        // We remove every child that has no data to bind, to avoid "overriding" the form default data
        foreach ($form->all() as $name => $child) {
            if (!isset($submittedData[$name])) {
                $form->remove($name);
            }
        }
    }
}
