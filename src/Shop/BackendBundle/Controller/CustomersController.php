<?php

namespace Shop\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\CustomerRepository;
use Shop\CommonBundle\Entity\Customer;

/**
 * @Route("/customers", name="customers", service="shop.backend.controller.customers")
 */
class CustomersController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Repository\CustomerRepository
     */
    private $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'customers' => $this->customerRepository->findAll()
        );
    }

    /**
     * @Route("/show/{id}")
     * @Method({"GET"})
     * @Template()
     */
    public function showAction($id)
    {
        return array(
            'customer' => $this->customerRepository->find($id)
        );
    }
}
