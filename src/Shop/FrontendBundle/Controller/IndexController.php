<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/index", name="index")
 */
class IndexController extends Controller
{
    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
