<?php
namespace AppBundle\Form;

use AppBundle\Entity\Space\Location;
use AppBundle\Entity\Space\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Date;

class UserSettingType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneSetting1',CheckboxType::class,['required'=>false])
            ->add('phoneSetting2',CheckboxType::class,['required'=>false])
            ->add('phoneSetting3',CheckboxType::class,['required'=>false])
            ->add('phoneSetting4',CheckboxType::class,['required'=>false])
            ->add('phoneSetting5',CheckboxType::class,['required'=>false])

            ->add('emailSetting1',CheckboxType::class,['required'=>false])
            ->add('emailSetting2',CheckboxType::class,['required'=>false])
            ->add('emailSetting3',CheckboxType::class,['required'=>false])
            ->add('emailSetting4',CheckboxType::class,['required'=>false])

            ->add('loginNotification',CheckboxType::class,['required'=>false])

            ->add('phone',TextType::class,['mapped'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Core\UserSetting'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_core_user_setting';
    }
}
