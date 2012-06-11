<?php

namespace Shop\FrontendBundle\FrameworkListener;

use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Shop\CommonBundle\Entity\Order;
use Shop\CommonBundle\Presenter\PresenterFactory;

class OrderConfirmation
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $pdfCacheDir;

    /**
     * @var string
     */
    private $pdfBaseDir;

    /**
     * @var \Shop\CommonBundle\Presenter\PresenterFactory
     */
    private $presenterFactory;

    public function __construct($container, KernelInterface $kernel, PresenterFactory $presenterFactory)
    {
        $this->container = $container;
        $this->pdfCacheDir = $kernel->getCacheDir() . '/pdf/';
        $this->pdfBaseDir = $kernel->getRootDir() . '/../web/';
        $this->presenterFactory = $presenterFactory;

        if(!file_exists($this->pdfCacheDir)) {
            mkdir($this->pdfCacheDir, 0755, true);
        }
    }

    /**
     * @param Order $order
     * @return string
     */
    private function generatePdf(Order $order)
    {
        $html = $this->renderView('ShopFrontendBundle:Pdfs:orderConfirmation.html.twig', array(
            'order' => $this->presenterFactory->present($order)
        ));

        $pdf = new \DOMPDF();
        $pdf->set_base_path($this->pdfBaseDir);
        $pdf->load_html($html);
        $pdf->render();

        $filePath = $this->pdfCacheDir . $order->getOrderId() . '.pdf';
        file_put_contents($filePath, $pdf->output(array("compress" => 0)));

        return $filePath;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if($args->getEntity() instanceof Order) {
            $this->sendConfirmationEmail($args->getEntity());
        }
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return string
     */
    private function renderView($view, $parameters = array())
    {
        return $this->container->get('templating')->render($view, $parameters);
    }

    /**
     * @param Order $order
     */
    private function sendConfirmationEmail(Order $order)
    {
        $pdf = $this->generatePdf($order);

        $message = \Swift_Message::newInstance()
            ->setSubject($this->translate('orderConfirmation.subject'))
            ->setFrom('noreply@example.com')
            ->setTo($order->getCustomer()->getEmail())
            ->setBody($this->renderView('ShopFrontendBundle:Mails:orderConfirmation.html.twig', array(
                'order' => $this->presenterFactory->present($order)
            )))
            ->attach(\Swift_Attachment::fromPath($pdf))
            ->setContentType('text/html')
        ;

        $this->container->get('mailer')->send($message);
    }

    /**
     * @param string $key
     * @param array $arguments
     * @param string $domain
     * @param null|string $locale
     * @return string
     */
    private function translate($key, $arguments = array(), $domain = 'messages', $locale = null)
    {
        return $this->container->get('translator')->trans($key, $arguments, $domain, $locale);
    }
}
