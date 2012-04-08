<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session;

class Globals extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getGlobals()
    {
        return array(
            'locale' => $this->session->getLocale(),
            'locales' => array('de', 'en')
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
