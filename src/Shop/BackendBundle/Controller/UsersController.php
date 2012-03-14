<?php

namespace Shop\BackendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Shop\CommonBundle\Entity\UserRepository;
use Shop\CommonBundle\Form\UserType;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;

/**
 * @Route("/users", name="users", service="shop.backend.controller.users")
 * @CsrfProtected
 */
class UsersController extends Controller
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var \Shop\CommonBundle\Entity\UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, EncoderFactoryInterface $encoderFactory)
    {
        $this->userRepository = $userRepository;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Route("/create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        $form->bindRequest($request);

        if($form->isValid()) {
            $user = $form->getData();

            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));

            $this->userRepository->persistImmediately($user);
            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('user.created', array('%name%' => $user->getName())),
                'html' => $this->renderView(
                    'ShopBackendBundle:Users:userRow.html.twig',
                    array('user' => $user)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Users:form.html.twig',
                array('form' => $form->createView(), 'form_action' => $this->route('shop_backend_users_create'))
            )
        ));
    }

    /**
     * @Route("/delete/{id}")
     * @Method({"GET"})
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = $this->userRepository->find($id);
        if($user === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $this->userRepository->remove($user);

        return $this->jsonResponse(array(
            'success' => true,
            'message' => $this->translate('user.deleted', array('%name%' => $user->getName())),
            'recordId' => $user->getid()
        ));
    }

    /**
     * @Route("/edit/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     */
    public function editAction($id)
    {
        $user = $this->userRepository->find($id);
        if($user === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new UserType(), $user);

        return array(
            'user' => $user,
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_users_update', array('id' => $user->getId()))
        );
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Template()
     * @NotCsrfProtected
     * @return array
     */
    public function indexAction()
    {
        $users = $this->userRepository->findAll();
        return array('users' => $users);
    }

    /**
     * @Route("/new")
     * @Method({"GET"})
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new UserType());

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_backend_users_create')
        );
    }

    /**
     * @Route("/update/{id}")
     * @Method({"POST"})
     * @param int $id
     */
    public function updateAction($id, Request $request)
    {
        $user = $this->userRepository->find($id);
        if($user === null) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $form = $this->createForm(new UserType(), $user);
        $form->bindRequest($request);
        if($form->isValid()) {
            if(strlen($user->getPlainPassword()) > 0)
            {
                $encoder = $this->encoderFactory->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            }

            $this->userRepository->persist($user);

            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('user.updated', array('%name%' => $user->getName())),
                'recordId' => $user->getId(),
                'html' => $this->renderView(
                    'ShopBackendBundle:Users:userRow.html.twig',
                    array('user' => $user)
                )
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Users:form.html.twig',
                array(
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_users_update', array('id' => $user->getId()))
                )
            )
        ));
    }
}
