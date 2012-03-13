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
     * @Method({"GET"})
     */
    public function createAction()
    {
        //TODO
    }

    /**
     * @Route("/delete/{id}")
     * @Method({"GET"})
     * @param int $id
     */
    public function deleteAction($id)
    {
        //TODO
    }

    /**
     * @Route("/edit/{id}")
     * @Method({"GET"})
     * @Template()
     * @param int $id
     */
    public function editAction($id)
    {
        //TODO
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
        //TODO
    }

    /**
     * @Route("/update/{id}")
     * @Method({"POST"})
     * @param int $id
     */
    public function updateAction($id)
    {
        //TODO
    }
}
