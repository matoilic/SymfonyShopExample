<?php

namespace Shop\CommonBundle\Presenter;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Shop\CommonBundle\Configuration\PresentedBy;

class PresenterFactory
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var array
     */
    private $presenters = array();

    /**
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     * @param \Symfony\Component\HttpFoundation\Session $session
     */
    public function __construct(Reader $annotationReader, Session $session, ContainerInterface $container)
    {
        $this->annotationReader = $annotationReader;
        if(array_key_exists('PATH_INFO', $_SERVER) && strpos($_SERVER['PATH_INFO'], '/en/') > -1) {
            $this->locale = 'en';
        } else {
            $this->locale = 'de';
        }
    }

    /**
     * @param mixed $target
     * @return mixed
     */
    private function getPresenterFor($target)
    {
        if($target instanceof \Doctrine\ORM\Proxy\Proxy) {
            $className = get_parent_class($target);
        } else {
            $className = get_class($target);
        }

        if(array_key_exists($className, $this->presenters)) {
            $presenterClass = $this->presenters[$className];
        } else {
            $class = new \ReflectionClass($className);
            /** @var PresentedBy $annotation */
            $annotation = $this->annotationReader->getClassAnnotation($class, 'Shop\\CommonBundle\\Configuration\\PresentedBy');

            if($annotation === null) {
                return $target;
            }

            $presenterClass = '\\' . $annotation->value;
            $this->presenters[$className] = $presenterClass;
        }

        return new $presenterClass($target, $this->locale, $this);
    }

    /**
     * @param mixed $target
     */
    public function present($target)
    {
        if(!is_array($target)) {
            return $this->getPresenterFor($target);
        }

        $presenters = array();
        foreach($target as $element) {
            $presenters[] = $this->getPresenterFor($element);
        }

        return $presenters;
    }
}
