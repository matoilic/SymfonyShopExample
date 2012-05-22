<?php

namespace Shop\FrontendBundle\Controller;

use Shop\CommonBundle\Controller\Controller as BaseController;

abstract class Controller extends BaseController
{
    private $currentCustomer;

    /**
     * @return \Shop\CommonBundle\Entity\Customer
     */
    public function getCustomer()
    {
        /** @var \Symfony\Component\Security\Core\SecurityContext $context */
        $context = $this->get('security.context');
        if($this->currentCustomer == null && $context->getToken()->getUser() != null) {
            /** @var \Shop\CommonBundle\Repository\CustomerRepository $repo */
            $repo = $this->get('shop.common.repository.customer');
            $this->currentCustomer = $repo->find($context->getToken()->getUser()->getId());
        }

        return $this->currentCustomer;
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
