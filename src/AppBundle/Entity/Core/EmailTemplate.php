<?php

// src/AppBundle/Entity/Core/Site.php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core__template_email")
 */
class EmailTemplate {


    const TYPE_CONTACT = 'CONTACT';
    const TYPE_OFFER_PLOT = 'OFFER_PLOT';
    const TYPE_APPROVE_BOOKING = 'APPROVE_BOOKING';
    const TYPE_INBOX = 'INBOX';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(length=255, name="subject",type="string",nullable=true) */
    private $subject;

    /** @ORM\Column(length=255, name="code",type="string",nullable=true) */
    private $code;

    /** @ORM\Column(length=255, name="param",type="string",nullable=true) */
    private $param;

    /** @ORM\Column(name="body",type="text",nullable=true) */
    private $body;

    /**
     * @return String
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @return String
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    /**
     * @return String
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return String
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @return String
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return String
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param mixed $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }
    

}
