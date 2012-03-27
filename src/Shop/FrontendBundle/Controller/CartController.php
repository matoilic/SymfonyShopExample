<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Shop\FrontendBundle\Service\CartService;
use Shop\CommonBundle\Entity\ProductRepository;

/**
 * @Route("/cart", name="cart", service="shop.frontend.controller.cart")
 */
class CartController extends Controller
{
    /**
     * @var \Shop\FrontendBundle\Service\CartService
     */
    private $cartService;

    /**
     * @var \Shop\CommonBundle\Entity\ProductRepository
     */
    private $productRepository;

    public function __construct(CartService $cartService, ProductRepository $productRepository)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/add-product/{id}")
     * @Method({"POST"})
     * @param int $id
     * @param int $quantity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProductAction($id, Request $request)
    {
        $product = $this->productRepository->findPublished($id);
        $quantity = (int)$request->get('quantity', 1);
        if($quantity < 1) $quantity = 1;

        if($product != null) {
            $this->cartService->addToCart($product, $quantity);
            //TODO return updated cart
            return $this->jsonResponse(array(
                'success' => true
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'message' => $this->translate('controller.cart.productNotFound')
        ));
    }

    /**
     * @Route("/remove-product/{id}")
     * @Method({"POST"})
     * @param int $id
     */
    public function removeProductAction($id)
    {
        $product = $this->productRepository->findPublished($id);
        if($product != null) {
            $this->cartService->removeFromCart($product);
        }
        //TODO return updated cart
        return $this->jsonResponse(array(
            'success' => true,
            'message' => $this->translate('controller.cart.productRemoved', array('%name%', $product->getName()))
        ));
    }
}
