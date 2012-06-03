<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Shop\CommonBundle\Form\SessionType;
use Shop\FrontendBundle\Service\CartService;

/**
 * @Route("/checkout", name="checkout", service="shop.frontend.controller.checkout")
 * @CsrfProtected
 */
class CheckoutController extends Controller
{
    /**
     * @var \Shop\FrontendBundle\Service\CartService
     */
    private $cartService;

    /**
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/finalize")
     * @Method({"GET"})
     * @Template()
     * @return array
     */
    public function finalizeAction()
    {

    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     * @NotCsrfProtected
     * @return array
     */
    public function indexAction()
    {
        if($this->isAuthenticated()) {
            return new RedirectResponse($this->route('shop_frontend_checkout_overview'));
        }

        return array(
            'form' => $this->createForm(new SessionType())->createView()
        );
    }

    /**
     * @Route("/overview")
     * @Method({"GET"})
     * @Template()
     * @NotCsrfProtected
     * @return array
     */
    public function overviewAction()
    {
        if($this->cartService->getIsCartEmpty()) {
            $this->get('session')->setFlash('error', $this->translate('checkout.error.cartEmpty'));
            return new RedirectResponse($this->route('shop_frontend_index_index'));
        }

        return array(
            'cashOnDeliveryFee' => $this->container->getParameter('cash_on_delivery_fee'),
            'priorityShipmentFee' => $this->container->getParameter('priority_shipment_fee'),
            'economyShipmentFee' => $this->container->getParameter('economy_shipment_fee'),
            'cartItems' => $this->presenterFactory->present($this->cartService->getItems()),
            'cart' => $this->cartService
        );
    }
}
