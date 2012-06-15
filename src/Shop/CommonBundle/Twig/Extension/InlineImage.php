<?php

namespace Shop\CommonBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class InlineImage extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'inline_image' => new \Twig_Filter_Method($this, 'readImage')
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shop_filter_inline_image';
    }

    /**
     * @param string $path
     * @return string
     */
    public function readImage($path)
    {
        $absPath = $this->kernel->getRootDir() . '/../web/' . $path;

        return 'data:image/jpeg;base64,' . base64_encode(file_get_contents($absPath));
    }
}
