<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\ProductRepository;

/**
 * @Route("/products", name="products", service="shop.frontend.controller.products")
 */
class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param \Shop\CommonBundle\Repository\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/show/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($id)
    {
        $product = $this->productRepository->find($id);

        if($product === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return array(
            'product' => $this->presenterFactory->present($product)
        );
    }
}
