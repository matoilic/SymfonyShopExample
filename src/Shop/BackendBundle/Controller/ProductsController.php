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
        $form = $this->createForm(new ProductType());
        $form->bindRequest($request);

        if($form->isValid()) {
            $product = $form->getData();
            $this->productRepository->persistImmediately($product);
            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('product.created', array('%name%' => $product->getName())),
                'html' => $this->renderView(
                    'ShopBackendBundle:Products:productRow.html.twig',
                    array('product' => $product)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Products:form.html.twig',
                array(
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_products_create')
                )
            )
        ));
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $product = $this->productRepository->find($id);
        if($product === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $this->productRepository->remove($product);

        return $this->jsonResponse(array(
            'success' => true,
            'message' => $this->translate('product.deleted', array('%name%' => $product->getName())),
            'recordId' => $product->getid()
        ));
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
        $product = $this->productRepository->find($id);
        if($product === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new ProductType(), $product);

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_products_update', array('id' => $product->getId())),
            'product' => $product
        );
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

    /**
     * @Route("/update/{id}")
     * @Method({"POST"})
     * @param int $id
     *
     */
    public function updateAction($id, Request $request)
    {
        $product = $this->productRepository->find($id);
        if($product === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new ProductType(), $product);
        $form->bindRequest($request);

        if($form->isValid()) {
            $product = $form->getData();
            $this->productRepository->persist($product);
            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('product.updated', array('%name%' => $product->getName())),
                'recordId' => $product->getId(),
                'html' => $this->renderView(
                    'ShopBackendBundle:Products:productRow.html.twig',
                    array('product' => $product)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Products:form.html.twig',
                array(
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_products_update', array('id' => $product->getId()))
                )
            )
        ));
    }
}
