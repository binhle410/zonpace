<?php

namespace AppBundle\Services\Core;

use AppBundle\Entity\Core\EmailTemplate;
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

    public function prepareMessageContent($template, array $vars, $templateSubject = null, $templateBody = null)
    {
        $keyBody = 'body';
        $keySubject = 'subject';
        if ($template != null) {
            $templateSubject = $template->getSubject();
            $templateBody = $template->getBody();
        }
        $templates = array($keySubject => $templateSubject, $keyBody => $templateBody);
        $env = new \Twig_Environment(new \Twig_Loader_Array($templates));
        $subject = $env->render($keySubject, $vars);
        $content = $env->render($keyBody, $vars);
        return array('subject' => $subject, 'content' => $content);
    }

//    public function sendEmailContact($data)
//    {
//        $em = $this->container->get('doctrine')->getManager();
//        $vars = array(
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'message' => $data['message'],
//        );
//        $temlate = $em->getRepository('AppBundle:Core\EmailTemplate')->findOneBy(array('code' => EmailTemplate::TYPE_CONTACT));
//        $temlatePrepare = $this->prepareMessageContent($temlate, $vars);
//        $emailTo = $this->container->getParameter('email_contact');
//        $message = \Swift_Message::newInstance()
//            ->setSubject($temlatePrepare['subject'])
//            ->setFrom('noreply@magentapulse.com')
//            ->setTo($emailTo)
//            ->setContentType("text/html")
//            ->setBody($temlatePrepare['content']);
//        $mailer = $this->mailer;
//        if (!$mailer->send($message)) {
//
//        }
//        $spool = $mailer->getTransport()->getSpool();
//        $transport = $this->container->get('swiftmailer.transport.real');
//        $spool->flushQueue($transport);
//    }

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
