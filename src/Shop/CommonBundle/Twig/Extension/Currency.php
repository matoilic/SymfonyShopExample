<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class Currency extends \Twig_Extension
{
    /**
     * @param mixed $value
     * @return string
     */
    public function format($value) {
        return ($value % 1 < 0.001) ? "CHF $value.–" : "CHF $value";
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'currency' => new \Twig_Filter_Method($this, 'format', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shop_currency';
    }
}
