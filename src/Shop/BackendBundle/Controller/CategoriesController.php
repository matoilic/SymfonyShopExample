<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Entity\CategoryRepository;
use Shop\CommonBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/categories", name="categories", service="shop.backend.controller.categories")
 */
class CategoriesController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Entity\CategoryRepository
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
                array('form' => $form->createView(), 'action' => $this->route('shop_backend_categories_create'))
            )
        ));
    }

    /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function deleteAction($id) {
        $category = $this->categoryRepository->find($id);
        $this->categoryRepository->remove($category);

        return $this->jsonResponse(array(
            'success' => true,
            'message' => $this->translate('category.deleted', array('%name%' => $category->getName())),
            'categoryId' => $category->getid()
        ));
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     * @param int $id
     */
    public function editAction($id) {
        $category = $this->categoryRepository->find($id);
        $form = $this->createForm(new CategoryType(), $category);

        return array(
            'form' => $form->createView(),
            'category' => $category
        );
    }

    /**
     * @Route("")
     * @Template()
     */
    public function indexAction() {
        $categories = $this->categoryRepository->findAll();
        return array('categories' => $categories, 'message' => 'Hello World.');
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction() {
        $form = $this->createForm(new CategoryType());

        return array('form' => $form->createView());
    }

    /**
     * @Route("/update/{id}")
     * @param int $id
     *
     */
    public function updateAction($id, Request $request) {
        $category = $this->categoryRepository->find($id);
        $form = $this->createForm(new CategoryType(), $category);
        $form->bindRequest($request);

        if($form->isValid()) {
            $category = $form->getData();
            $this->categoryRepository->persistImmediately($category);
            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('category.updated', array('%name%' => $category->getName())),
                'categoryId' => $category->getId(),
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
                    'action' => $this->route('shop_backend_categories_update', array('id' => $category->getId()))
                )
            )
        ));
    }
}
