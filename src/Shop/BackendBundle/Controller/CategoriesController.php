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
     * @Route("")
     * @Template()
     */
    public function indexAction() {
        $categories = $this->categoryRepository->findAll();
        return array('categories' => $categories);
    }
}
