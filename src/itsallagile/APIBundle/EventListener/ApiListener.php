<?php
namespace itsallagile\APIBundle\EventListener;

use itsallagile\APIBundle\Controller\ApiController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use itsallagile\APIBundle\Events;

class ApiListener implements EventSubscriberInterface
{
    protected $statsd = null;

    public function __construct($statsd)
    {
        $this->statsd = $statsd;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::TICKET_UPDATE => 'onTicketUpdate',
        );
    }

    public function onTicketUpdate(GenericEvent $event)
    {
        $this->statsd->increment('scrum_board.api.ticket_update');
    }


    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiController) {
            $this->statsd->increment('scrum_board.api.api_calls');
        }
    }
}
