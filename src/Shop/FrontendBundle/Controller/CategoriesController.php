<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Repository\ProductRepository;
use Shop\CommonBundle\Repository\CategoryRepository;

/**
 * @Route("/categories", name="categories", service="shop.frontend.controller.categories")
 */
class CategoriesController extends Controller
{
    /**
     * @var \Shop\CommonBundle\Repository\CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var \Shop\CommonBundle\Repository\ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     * @return array
     */
    public function indexAction($id)
    {
        $category = $this->categoryRepository->find($id);

        if($category == null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return array(
            'products' => $this->presenterFactory->present($this->productRepository->findAllPublishedByCategory($id)),
            'category' => $this->presenterFactory->present($category)
        );
    }
}
