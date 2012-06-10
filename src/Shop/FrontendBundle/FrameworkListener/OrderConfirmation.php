<?php

namespace Shop\FrontendBundle\FrameworkListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Shop\CommonBundle\Entity\Order;

class OrderConfirmation
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if($args->getEntity() instanceof Order) {
            $this->sendConfirmationEmail($args->getEntity());
        }
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return string
     */
    private function renderView($view, $parameters = array())
    {
        return $this->container->get('templating')->render($view, $parameters);
    }

    /**
     * @param Order $order
     */
    private function sendConfirmationEmail(Order $order)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->translate('orderConfirmation.subject'))
            ->setFrom('noreply@example.com')
            ->setTo($order->getCustomer()->getEmail())
            ->setBody($this->renderView('ShopFrontendBundle:Mails:orderConfirmation.html.twig', array('order' => $order)))
        ;

        $this->container->get('mailer')->send($message);
    }

    /**
     * @param string $key
     * @param array $arguments
     * @param string $domain
     * @param null|string $locale
     * @return string
     */
    private function translate($key, $arguments = array(), $domain = 'messages', $locale = null)
    {
        return $this->container->get('translator')->trans($key, $arguments, $domain, $locale);
    }
}
