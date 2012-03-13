<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Entity\ProductRepository;
use Shop\CommonBundle\Form\ProductType;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/products", name="products", service="shop.backend.controller.products")
 * @CsrfProtected()
 */
class ProductsController extends Controller
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
     * @Route("/create")
     * @Method({"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        //TODO implement
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        //TODO implement
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     * @NotCsrfProtected()
     * @return array
     */
    public function indexAction()
    {
        $products = $this->productRepository->findAll();
        return array('products' => $products);
    }

    /**
     * @Route("/edit/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     */
    public function editAction($id)
    {
        //TODO implement
    }

    /**
     * @Route("/new")
     * @Method({"GET"})
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new ProductType());

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_products_create'),
        );
    }
}
