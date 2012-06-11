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
     * @return array
     */
    public function indexAction()
    {
        return array(
            'newest' => $this->presenterFactory->present($this->productRepository->findNewest($this->container->getParameter('newest_products_count'))),
            'featured' => $this->presenterFactory->present($this->productRepository->findFeatured())
        );
    }
}
