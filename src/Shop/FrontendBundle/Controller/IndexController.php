<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\ProductRepository;

/**
 * @Route("/", name="index", service="shop.frontend.controller.index")
 */
class IndexController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Repository\ProductRepository
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
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $products = $this->presenterFactory->present($this->productRepository->findAllPublished());
        return array('products' => $products);
    }
}
