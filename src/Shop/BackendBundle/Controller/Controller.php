<?php

namespace Shop\BackendBundle\Controller;

use Shop\CommonBundle\Controller\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * @return \Shop\CommonBundle\Entity\User
     */
    protected function getCurrentUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }
}
