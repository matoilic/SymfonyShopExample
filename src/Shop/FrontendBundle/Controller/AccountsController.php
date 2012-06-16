<?php

namespace Shop\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Shop\CommonBundle\Repository\CustomerRepository;
use Shop\CommonBundle\Entity\Customer;
use Shop\CommonBundle\Configuration\CsrfProtected;
use Shop\CommonBundle\Configuration\NotCsrfProtected;
use Shop\CommonBundle\Form\CustomerType;

/**
 * @Route("/accounts", name="accounts", service="shop.frontend.controller.accounts")
 * @CsrfProtected
 */
class AccountsController extends Controller
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var \Shop\CommonBundle\Repository\CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository, EncoderFactoryInterface $encoderFactory)
    {
        $this->customerRepository = $customerRepository;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Route("/create")
     * @Method({"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CustomerType());
        $form->bindRequest($request);

        if($form->isValid()) {
            /** @var Customer $customer */
            $customer = $form->getData();
            $encoder = $this->encoderFactory->getEncoder($customer);
            $customer->setPassword($encoder->encodePassword($customer->getPlainPassword(), $customer->getSalt()));
            $this->customerRepository->persistImmediately($customer);

            if($request->getSession()->get('afterRegistration') != null) {
                $redirect = $request->getSession()->get('afterRegistration');
            } else {
                $redirect = $this->route('shop_frontend_accounts_success');
            }


            return $this->jsonResponse(array(
                'success' => true,
                'message' => $this->translate('controller.accounts.created'),
                'redirect' => $redirect
            ));
        }

        return $this->jsonResponse(array(
            'success' => false,
            'html' => $this->renderView(
                'ShopBackendBundle:Accounts:form.html.twig',
                array (
                    'form' => $form->createView(),
                    'form_action' => $this->route('shop_backend_accounts_create')
                )
            )
        ));
    }

    /**
     * @Route("/edit")
     * @Method({"GET"})
     * @NotCsrfProtected
     * @Template()
     * @return mixed
     */
    public function editAction()
    {
        if($this->isAuthenticated()) {
            $form = $this->createForm(new CustomerType(), $this->getCustomer());

            return array(
                'form' => $form->createView(),
                'form_action' => $this->route('shop_frontend_accounts_update')
            );
        }

        return $this->redirect($this->route('shop_frontend_index_index'));
    }

    /**
     * @Route("/new")
     * @Method({"GET"})
     * @NotCsrfProtected
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new CustomerType());

        return array(
            'form' => $form->createView(),
            'form_action' => $this->route('shop_frontend_accounts_create')
        );
    }

    /**
     * @Route("/success")
     * @Method({"GET"})
     * @NotCsrfProtected
     * @Template()
     */
    public function successAction()
    {
        return array();
    }

    /**
     * @Route("/summary")
     * @Method({"GET"})
     * @NotCsrfProtected
     * @Template()
     */
    public function summaryAction()
    {
        return array(
            'customer' => $this->getCustomer()
        );
    }

    /**
     * @Route("/update")
     * @Method({"POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request)
    {
        if($this->isAuthenticated()) {
            $form = $this->createForm(new CustomerType(), $this->getCustomer());
            $form->bindRequest($request);

            if($form->isValid()) {
                $customer = $form->getData();
                if(strlen($customer->getPlainPassword()) > 0) {
                    $encoder = $this->encoderFactory->getEncoder($customer);
                    $customer->setPassword($encoder->encodePassword($customer->getPlainPassword(), $customer->getSalt()));
                }
                $this->customerRepository->persist($customer);

                return $this->jsonResponse(array(
                    'success' => true,
                    'message' => $this->translate('controller.accounts.updated'),
                    'html' => $this->renderView(
                        'ShopFrontendBundle:Accounts:form.html.twig',
                        array (
                            'form' => $form->createView(),
                            'form_action' => $this->route('shop_frontend_accounts_update')
                        )
                    )
                ));
            }

            return $this->jsonResponse(array(
                'success' => false,
                'html' => $this->renderView(
                    'ShopFrontendBundle:Accounts:form.html.twig',
                    array (
                        'form' => $form->createView(),
                        'form_action' => $this->route('shop_frontend_accounts_update')
                    )
                )
            ));
        }

        return $this->redirect($this->route('shop_frontend_index_index'), 401);
    }
}
