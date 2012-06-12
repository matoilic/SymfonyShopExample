<?php

namespace Shop\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\OrderRepository;
use Shop\CommonBundle\Entity\Order;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;

/**
 * @Route("/orders", name="orders", service="shop.backend.controller.orders")
 * @CsrfProtected()
 */
class OrdersController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Repository\OrderRepository
     */
    private $orderRepository;

    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @NotCsrfProtected()
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'orders' => $this->presenterFactory->present($this->orderRepository->findAll())
        );
    }

    /**
     * @Route("/markpaid/{id}")
     * @Method({"POST"})
     */
    public function markPaidAction($id, Request $request)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($id);
        $order->setIsPaid($request->get('status', 0) == 1);
        $this->orderRepository->persist($order);

        return $this->jsonResponse(array(
            'html' => $this->renderView('ShopBackendBundle:Orders:orderRow.html.twig', array('order' => $order)),
            'order' => $order->getId()
        ));
    }

    /**
     * @Route("/markshipped/{id}")
     * @Method({"POST"})
     */
    public function markShippedAction($id, Request $request)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($id);
        $order->setIsShipped($request->get('status', 0) == 1);
        $this->orderRepository->persist($order);

        return $this->jsonResponse(array(
            'html' => $this->renderView('ShopBackendBundle:Orders:orderRow.html.twig', array('order' => $order)),
            'order' => $order->getId()
        ));
    }

    /**
     * @Route("/show/{id}")
     * @Method({"GET"})
     * @NotCsrfProtected()
     * @Template()
     * @param int $id
     */
    public function showAction($id)
    {
        return array(
            'order' => $this->presenterFactory->present($this->orderRepository->find($id))
        );
    }
}
