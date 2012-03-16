<?php

namespace Shop\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class Controller extends BaseController
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;


    /**
     * @param $data the data to encode
     * @return string
     */
    protected function jsonEncode(array $data)
    {
        return json_encode($data, JSON_HEX_TAG);
    }

    /**
     * @param array $data the response data
     * @return Response a response object
     */
    public function jsonResponse(array $data)
    {
        $response = new Response($this->jsonEncode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param $name the name of the route
     * @param array $parameters the parameters for the route
     */
    protected function route($name, $parameters = array())
    {
        return $this->router->generate($name, $parameters);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->translator = $container->get('translator');
        $this->router = $container->get('router');
    }

    protected function translate($key, $arguments = array(), $domain = 'messages', $locale = null)
    {
        return $this->translator->trans($key, $arguments, $domain, $locale);
    }
}
