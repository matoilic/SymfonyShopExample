<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Shop\CommonBundle\Entity\CategoryRepository;

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
     * @Route("/delete/{id}", name="shop_backend_categories_delete")
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
     * @Route("/edit/{id}", name="shop_backend_categories_edit")
     * @Template()
     */
    public function editAction() {
        //TODO implement
    }

    /**
     * @Route("/new", name="shop_backend_categories_new")
     * @Template()
     */
    public function newAction() {
        //TODO implement
    }
}
