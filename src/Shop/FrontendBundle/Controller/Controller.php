<?php

namespace Shop\FrontendBundle\Controller;

use Shop\CommonBundle\Controller\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * @return \Shop\CommonBundle\Entity\Customer
     */
    public function getCustomer()
    {
        /** @var \Symfony\Component\Security\Core\SecurityContext $context */
        $context = $this->get('security.context');
        return $context->getToken()->getUser();
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        /** @var \Symfony\Component\Security\Core\SecurityContext $context */
        $context = $this->get('security.context');
        return $context->getToken()->isAuthenticated();
    }
}
