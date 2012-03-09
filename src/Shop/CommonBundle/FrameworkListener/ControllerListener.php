<?php

namespace Shop\CommonBundle\FrameworkListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Shop\CommonBundle\Controller\Controller as BaseController;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;

class ControllerListener
{
    /**
     * @var \Doctrine\Common\Annotations\Reader;
     */
    private $annotationReader;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface
     */
    private $csrfProvider;

    public function __construct(CsrfProviderInterface $csrfProvider, Reader $annotationReader, ContainerInterface $container)
    {
        $this->csrfProvider = $csrfProvider;
        $this->annotationReader = $annotationReader;
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        if($controller[0] instanceof \Assetic\Asset\AssetCollection) {
            return;
        }

        $class = new \ReflectionClass(get_class($controller[0]));
        if($this->annotationReader->getClassAnnotation($class, 'Shop\\CommonBundle\\Configuration\\CsrfProtected') === null) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        if($this->annotationReader->getMethodAnnotation($method, 'Shop\\CommonBundle\\Configuration\\NotCsrfProtected') !== null) {
            return;
        }

        $request = $event->getRequest();
        if($request->headers->has('X-Csrf-Token')) {
            $token = $request->headers->get('X-Csrf-Token');
        } else {
            $token = $request->get('_token');
        }

        if(!$this->csrfProvider->isCsrfTokenValid('unknown', $token)) {
            $event->stopPropagation();
            $controller = $this->container->get('shop.common.controller.error');
            $event->setController(array($controller, 'csrfMismatchAction'));
        }
    }
}
