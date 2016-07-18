<?php
namespace AppBundle\Form;

use AppBundle\Entity\Space\Location;
use AppBundle\Entity\Space\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

class UserProfileType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo','sonata_media_type',[
                'provider' => 'sonata.media.provider.image',
                'context' => 'default',
                'required' => false,
                'label' => 'Image',
            ])
            ->add('firstName', TextType::class)
            ->add('lastName',TextType::class)
            ->add('gender', ChoiceType::class,[
                'choices'=>['Male'=>'MALE','Female'=>'FEMALE'],
                 'placeholder' => 'Select Gender',
                'empty_data'  => null
            ])
            ->add('birthday', DateType::class,['format' => 'MM/dd/yyyy', 'widget' => 'single_text'])
            ->add('state',EntityType::class,[
                'class'=>'AppBundle\Entity\Core\State',
                'choice_label'=>'name',
                'placeholder' => 'Select State',
                'empty_data'  => null
            ])
            ->add('city',EntityType::class,[
                'class'=>'AppBundle\Entity\Core\City',
                'choice_label'=>'name',
                'placeholder' => 'Select City',
                'empty_data'  => null
            ])
            ->add('email',EmailType::class)
            ->add('aboutUser',TextareaType::class)
            ->add('phone',NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Core\User'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_core_user_profile';
    }
}
