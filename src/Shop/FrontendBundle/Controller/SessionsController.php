<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Shop\CommonBundle\Form\SessionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route("/sessions", name="sessions")
 * @CsrfProtected()
 */
class SessionsController extends Controller
{
    /**
     * @Route("/create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $errorMessage = $this->translate($error->getMessage(), array(), 'system_messages');

        return $this->jsonResponse(array(
            'success' => false,
            'message' => $errorMessage
        ));
    }

    /**
     * @Route("/destroy")
     * @NotCsrfProtected()
     */
    public function destroyAction()
    {

    }

    /**
     * @Route("/new")
     * @Method({"GET"})
     * @NotCsrfProtected()
     */
    public function newAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            return $this->createAction($request);
        }

        $form = $this->createForm(new SessionType());

        $params = array(
            'form' => $form->createView(),
            'error' => false,
            'last_username' => ''
        );

        return $this->render(
            'ShopFrontendBundle:Sessions:new.html.twig',
            $params
        );
    }

    /**
     * @Route("/created")
     * @NotCsrfProtected()
     */
    public function createdAction()
    {
        return $this->jsonResponse(array(
            'success' => true,
            'redirect' => $this->route('shop_backend_products_index')
        ));
    }
}
