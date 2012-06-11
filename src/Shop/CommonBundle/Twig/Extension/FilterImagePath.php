<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class FilterImagePath extends \Twig_Extension
{
    /**
     * @param string $value
     * @return string
     */
    public function filterImagePath($value) {
        return str_replace(array('/app_dev.php/', '/app.php/'), '', urldecode($value));
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'filter_image_path' => new \Twig_Filter_Method($this, 'filterImagePath')
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shop_filter_image_path';
    }
}
