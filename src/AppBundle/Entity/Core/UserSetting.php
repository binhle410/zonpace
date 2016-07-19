<?php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @ORM\Table(name="core__user_setting")
 * @ORM\Entity
 */
class UserSetting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->phoneSetting1 =false;
        $this->phoneSetting2 =false;
        $this->phoneSetting3 =false;
        $this->phoneSetting4 =false;
        $this->phoneSetting5 =false;

        $this->emailSetting1 =false;
        $this->emailSetting2 =false;
        $this->emailSetting3 =false;
        $this->emailSetting4 =false;

        $this->loginNotification =false;
    }

    /**
     * @var string
     * @ORM\Column(name="phone_setting1",type="boolean",options={"default":false})
     */
    private $phoneSetting1;
    /**
     * @var string
     * @ORM\Column(name="phone_setting2",type="boolean",options={"default":false})
     */
    private $phoneSetting2;
    /**
     * @var string
     * @ORM\Column(name="phone_setting3",type="boolean",options={"default":false})
     */
    private $phoneSetting3;
    /**
     * @var string
     * @ORM\Column(name="phone_setting4",type="boolean",options={"default":false})
     */
    private $phoneSetting4;
    /**
     * @var string
     * @ORM\Column(name="phone_setting5",type="boolean",options={"default":false})
     */
    private $phoneSetting5;

    /**
     * @var string
     * @ORM\Column(name="email_setting1",type="boolean",options={"default":false})
     */
    private $emailSetting1;
    /**
     * @var string
     * @ORM\Column(name="email_setting2",type="boolean",options={"default":false})
     */
    private $emailSetting2;
    /**
     * @var string
     * @ORM\Column(name="email_setting3",type="boolean",options={"default":false})
     */
    private $emailSetting3;
    /**
     * @var string
     * @ORM\Column(name="email_setting4",type="boolean",options={"default":false})
     */
    private $emailSetting4;

    /**
     * @var string
     * @ORM\Column(name="login_notification",type="boolean",options={"default":false})
     */
    private $loginNotification;




    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPhoneSetting1()
    {
        return $this->phoneSetting1;
    }

    /**
     * @param string $phoneSetting1
     */
    public function setPhoneSetting1($phoneSetting1)
    {
        $this->phoneSetting1 = $phoneSetting1;
    }

    /**
     * @return string
     */
    public function getPhoneSetting2()
    {
        return $this->phoneSetting2;
    }

    /**
     * @param string $phoneSetting2
     */
    public function setPhoneSetting2($phoneSetting2)
    {
        $this->phoneSetting2 = $phoneSetting2;
    }

    /**
     * @return string
     */
    public function getPhoneSetting3()
    {
        return $this->phoneSetting3;
    }

    /**
     * @param string $phoneSetting3
     */
    public function setPhoneSetting3($phoneSetting3)
    {
        $this->phoneSetting3 = $phoneSetting3;
    }

    /**
     * @return string
     */
    public function getPhoneSetting4()
    {
        return $this->phoneSetting4;
    }

    /**
     * @param string $phoneSetting4
     */
    public function setPhoneSetting4($phoneSetting4)
    {
        $this->phoneSetting4 = $phoneSetting4;
    }

    /**
     * @return string
     */
    public function getPhoneSetting5()
    {
        return $this->phoneSetting5;
    }

    /**
     * @param string $phoneSetting5
     */
    public function setPhoneSetting5($phoneSetting5)
    {
        $this->phoneSetting5 = $phoneSetting5;
    }

    /**
     * @return string
     */
    public function getEmailSetting1()
    {
        return $this->emailSetting1;
    }

    /**
     * @param string $emailSetting1
     */
    public function setEmailSetting1($emailSetting1)
    {
        $this->emailSetting1 = $emailSetting1;
    }

    /**
     * @return string
     */
    public function getEmailSetting2()
    {
        return $this->emailSetting2;
    }

    /**
     * @param string $emailSetting2
     */
    public function setEmailSetting2($emailSetting2)
    {
        $this->emailSetting2 = $emailSetting2;
    }

    /**
     * @return string
     */
    public function getEmailSetting3()
    {
        return $this->emailSetting3;
    }

    /**
     * @param string $emailSetting3
     */
    public function setEmailSetting3($emailSetting3)
    {
        $this->emailSetting3 = $emailSetting3;
    }

    /**
     * @return string
     */
    public function getEmailSetting4()
    {
        return $this->emailSetting4;
    }

    /**
     * @param string $emailSetting4
     */
    public function setEmailSetting4($emailSetting4)
    {
        $this->emailSetting4 = $emailSetting4;
    }

    /**
     * @return string
     */
    public function getLoginNotification()
    {
        return $this->loginNotification;
    }

    /**
     * @param string $loginNotification
     */
    public function setLoginNotification($loginNotification)
    {
        $this->loginNotification = $loginNotification;
    }



    
    
    
}

