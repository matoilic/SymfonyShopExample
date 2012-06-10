<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Shop\CommonBundle\Form\SessionType;
use Shop\FrontendBundle\Service\CartService;
use Shop\FrontendBundle\Service\CheckoutService;
use Shop\FrontendBundle\Form\CheckoutType;

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
     * @var CheckoutService
     */
    private $checkoutService;

    /**
     * @param CartService $cartService
     * @param CheckoutService $checkoutService
     */
    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    /**
     * @Route("/confirmation")
     * @Method({"GET"})
     * @Template()
     * @NotCsrfProtected
     * @return array
     */
    public function confirmationAction()
    {
        return array();
    }

    /**
     * @Route("/finalize")
     * @Method({"POST"})
     * @param Request $request
     * @return array
     */
    public function finalizeAction(Request $request)
    {
        $form = $this->createForm(new CheckoutType());
        $form->bindRequest($request);

        if($form->isValid()) {
            $data = $form->getData();
            $this->checkoutService->checkout($this->getCustomer(), $data['billingAddress'], $data['shippingAddress'], $data['payment'], $data['shipment']);

            return $this->jsonResponse(array(
                'success' => true,
                'redirect' => $this->route('shop_frontend_checkout_confirmation')
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopFrontendBundle:Checkout:form.html.twig',
                $this->generateViewData($form)
            )
        ));
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    protected function generateViewData($form)
    {
        return array(
            'cashOnDeliveryFee' => $this->container->getParameter('cash_on_delivery_fee'),
            'priorityShipmentFee' => $this->container->getParameter('priority_shipment_fee'),
            'economyShipmentFee' => $this->container->getParameter('economy_shipment_fee'),
            'cartItems' => $this->presenterFactory->present($this->cartService->getItems()),
            'cart' => $this->cartService,
            'form' => $form->createView()
        );
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

        $form = $this->createForm(new CheckoutType(), array(
            'billingAddress' => $this->getCustomer()->getAddress(),
            'shippingAddress' => $this->getCustomer()->getAddress()
        ));

        return $this->generateViewData($form);
    }
}
