<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Template("ShopBackendBundle:Categories:new.html.twig")
     */
    public function createAction(Request $request) {
        $form = $this->createForm(new CategoryType());
        $form->bindRequest($request);

        if($form->isValid()) {
            $this->categoryRepository->persist($form->getData());
            return $this->redirect($this->generateUrl('shop_backend_categories_index'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction() {
        //TODO implement
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
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction() {
        //TODO implement
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction() {
        $form = $this->createForm(new CategoryType());

        return array('form' => $form->createView());
    }
}
