<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class CsrfMeta extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface
     */
    private $csrfProvider;

    public function __construct(CsrfProviderInterface $csrfProvider)
    {
        $this->csrfProvider = $csrfProvider;
    }

    public function csrfMeta()
    {
        $meta = '<meta name="csrf-field" content="_token">' . "\n";
        $meta .= '<meta name="csrf-token" content="' . $this->csrfProvider->generateCsrfToken('unknown') . '">';

        return $meta;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'csrf_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'csrf_meta' => new \Twig_Function_Method($this, 'csrfMeta', array('is_safe' => array('all')))
        );
    }
}
