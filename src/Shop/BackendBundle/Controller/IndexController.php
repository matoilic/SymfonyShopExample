<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/", name="index")
 */
class IndexController extends Controller
{
    /**
     * @Route("")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return new \Symfony\Component\HttpFoundation\RedirectResponse(
            $this->route('shop_backend_orders_index')
        );
    }
}
