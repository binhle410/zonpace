<?php

namespace AppBundle\Services\Core;

use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\Core\Template;

class EmailSender
{

    private $mailer;
    private $twig;
    private $container;

    function __construct($mailer, $twig, Container $container)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->container = $container;
    }

    public function sendEmailContact($emailTo,$booking)
    {
        $em = $this->container->get('doctrine')->getManager();

        $content = $this->container->get('templating')->render('AppBundle:User/HostControl:_receipt-template.html.twig', ['booking'  => $booking]);
        $message = \Swift_Message::newInstance()
                ->setSubject('Receipt Booking From ZONPAGE')
                ->setFrom('noreply@zonpage.com')
                ->setTo($emailTo)
                ->setContentType("text/html")
                ->setBody($content);
        $mailer = $this->mailer;
        if (!$mailer->send($message)) {

        }
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->container->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
    }


}
