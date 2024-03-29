<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\CategoryRepository;
use Shop\CommonBundle\Form\CategoryType;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/categories", name="categories", service="shop.backend.controller.categories")
 * @CsrfProtected()
 */
class CategoriesController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Repository\CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/create")
     * @Method({"POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request) {
        $form = $this->createForm(new CategoryType());
        $form->bindRequest($request);

        if($form->isValid()) {
            $category = $form->getData();
            $this->categoryRepository->persistImmediately($category);
            $category = $this->presenterFactory->present($category);

            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('category.created', array('%name%' => $category->getName())),
                'html' => $this->renderView(
                    'ShopBackendBundle:Categories:categoryRow.html.twig',
                    array('category' => $category)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Categories:form.html.twig',
                array(
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_categories_create')
                )
            )
        ));
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $category = $this->categoryRepository->find($id);
        if($category === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $this->categoryRepository->remove($category);
        $category = $this->presenterFactory->present($category);

        return $this->jsonResponse(array(
            'success' => true,
            'message' => $this->translate('category.deleted', array('%name%' => $category->getName())),
            'recordId' => $category->getid()
        ));
    }

    /**
     * @Route("/edit/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     */
    public function editAction($id)
    {
        $category = $this->categoryRepository->find($id);
        if($category === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new CategoryType(), $category);
        $category = $this->presenterFactory->present($category);

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_categories_update', array('id' => $category->getId())),
            'category' => $category
        );
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @NotCsrfProtected()
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->presenterFactory->present($this->categoryRepository->findAll());
        return array('categories' => $categories);
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new CategoryType());

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_categories_create'),
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
        $category = $this->categoryRepository->find($id);
        if($category === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new CategoryType(), $category);
        $form->bindRequest($request);

        if($form->isValid()) {
            $category = $form->getData();
            $this->categoryRepository->persistImmediately($category);
            $category = $this->presenterFactory->present($category);

            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('category.updated', array('%name%' => $category->getName())),
                'recordId' => $category->getId(),
                'html' => $this->renderView(
                    'ShopBackendBundle:Categories:categoryRow.html.twig',
                    array('category' => $category)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Categories:form.html.twig',
                array(
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_categories_update', array('id' => $category->getId()))
                )
            )
        ));
    }
}
