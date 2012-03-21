<?php

namespace Shop\FrontendBundle\Service;

use Symfony\Component\HttpFoundation\Session;

class CartService
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }
}
