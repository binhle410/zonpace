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

    public function sendEmailContact($emailTo,$booking,$path)
    {
        $em = $this->container->get('doctrine')->getManager();

        $message = \Swift_Message::newInstance()
                ->setSubject('Receipt Booking From ZONPAGE')
                ->setFrom('noreply@zonpage.com')
                ->setTo($emailTo)
                ->setContentType("text/html")
                ->setBody('Hi,<br>Here is your receipt.')
                ->attach(\Swift_Attachment::fromPath($path));
        $mailer = $this->mailer;
        if (!$mailer->send($message)) {

        }
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->container->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
    }
    public function sendEmailOfferPlot($emailTo,$urlBooking)
    {
        $em = $this->container->get('doctrine')->getManager();
        $link = '<a href="'.$urlBooking.'">Click here to booking</a>';
        $message = \Swift_Message::newInstance()
                ->setSubject('Offer for rent space')
                ->setFrom('noreply@zonpage.com')
                ->setTo($emailTo)
                ->setContentType("text/html")
                ->setBody('Hi,<br>Here link below for you booking this space '.$link);
        $mailer = $this->mailer;
        if (!$mailer->send($message)) {

        }
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->container->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
    }


}
