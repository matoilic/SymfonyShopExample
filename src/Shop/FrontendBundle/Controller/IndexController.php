<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Entity\ProductRepository;

/**
 * @Route("/", name="index", service="shop.frontend.controller.index")
 */
class IndexController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Entity\ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $products = $this->productRepository->findAllPublished();
        return array('products' => $products);
    }
}
