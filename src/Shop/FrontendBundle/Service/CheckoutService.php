<?php

namespace Shop\FrontendBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityManager;
use Shop\FrontendBundle\Service\CartService;
use Shop\CommonBundle\Repository\OrderRepository;
use Shop\CommonBundle\Repository\ProductRepository;
use Shop\CommonBundle\Entity\Order;
use Shop\CommonBundle\Entity\OrderItem;
use Shop\CommonBundle\Entity\Address;
use Shop\CommonBundle\Entity\Customer;

class CheckoutService
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Shop\CommonBundle\Repository\OrderRepository
     */
    private $orderRepository;

    /**
     * @var \Shop\CommonBundle\Repository\ProductRepository
     */
    private $productRepository;

    /**
     * @param ContainerInterface $container
     * @param EntityManager $entityManager
     * @param CartService $cartService
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productsRepository
     */
    public function __construct(ContainerInterface $container, EntityManager $entityManager, CartService $cartService, OrderRepository $orderRepository, ProductRepository $productsRepository)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->cartService = $cartService;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productsRepository;
    }

    /**
     * @param Customer $customer
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @param string $paymentType
     * @param string $shippingType
     * @return null|\Shop\CommonBundle\Entity\Order
     * @throws \Exception
     */
    public function checkout(Customer $customer, Address $billingAddress, Address $shippingAddress, $paymentType, $shippingType)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {
            $paymentPeriod = $this->container->getParameter('payment_period');
            $dueDate = new \DateTime();
            $dueDate->add(new \DateInterval('P' . $paymentPeriod . 'D'));

            $order = new Order();
            $order->setPaymentDue($dueDate);
            $order->setBillingAddress($billingAddress);
            $order->setShippingAddress($shippingAddress);
            $order->setCustomer($customer);
            $order->setPaymentType($paymentType);

            if($order->getPaymentType() == Order::PAY_CASH_ON_DELIVERY) {
                $order->setPaymentFee($this->container->getParameter('cash_on_delivery_fee'));
            } else {
                $order->setPaymentFee(0);
            }

            $order->setShippingType($shippingType);

            if($order->getShippingType() == Order::SHIP_ECONOMY) {
                $order->setShippingFee($this->container->getParameter('economy_shipment_fee'));
            } else {
                $order->setShippingFee($this->container->getParameter('priority_shipment_fee'));
            }

            /** @var \Shop\CommonBundle\Entity\CartItem $cartItem */
            foreach($this->cartService->getItems() as $cartItem) {
                $orderItem = new OrderItem();
                $product = $cartItem->getProduct();
                $orderItem->setProduct($product);
                $orderItem->setQuantity($cartItem->getQuantity());
                $orderItem->setUnitPrice($cartItem->getProduct()->getPrice());
                $orderItem->setOrder($order);
                $order->addItem($orderItem);

                $product->addTotalRevenue($orderItem->getTotalAmount());
                $product->addTotalSales($orderItem->getQuantity());
                $this->productRepository->persist($product);
            }

            $this->orderRepository->persist($order);

            $this->entityManager->flush();

            $this->entityManager->getConnection()->commit();

            return $order;
        } catch(\Exception $e) {
            $this->entityManager->getConnection()->rollback();
            throw $e;
        }

        return null;
    }
}
