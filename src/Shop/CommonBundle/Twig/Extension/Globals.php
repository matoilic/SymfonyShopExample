<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session;
use Shop\CommonBundle\Repository\CategoryRepository;
use Shop\CommonBundle\Presenter\PresenterFactory;

class Globals extends \Twig_Extension
{
    /**
     * @var array
     */
    private $categories;

    /**
     * @var \Symfony\Component\HttpFoundation\Session
     */
    private $session;

    public function __construct(Session $session, CategoryRepository $categoryRepository, PresenterFactory $presenterFactory)
    {
        $this->session = $session;
        $this->categories = $presenterFactory->present($categoryRepository->findAll());
    }

    public function getGlobals()
    {
        return array(
            'locale' => $this->session->getLocale(),
            'locales' => array('de', 'en'),
            'categories' => $this->categories
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shop_common_globals';
    }
}
